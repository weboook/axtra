<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class WhatsAppService
{
    protected $twilio;
    protected $whatsappNumber;
    protected $config;

    public function __construct()
    {
        $this->config = config('twilio');
        
        if (!$this->config['sid'] || !$this->config['token']) {
            throw new \Exception('Twilio credentials not configured');
        }

        $this->twilio = new Client($this->config['sid'], $this->config['token']);
        $this->whatsappNumber = $this->config['whatsapp_number'];
    }

    /**
     * Send a simple WhatsApp message
     */
    public function sendMessage(string $phone, string $message): array
    {
        try {
            // Validate phone number format
            $phone = $this->formatPhoneNumber($phone);
            
            // Check rate limits
            if ($this->config['rate_limits']['enabled'] && !$this->checkRateLimit($phone)) {
                throw new \Exception('Rate limit exceeded for this phone number');
            }

            // Send message via Twilio
            $twilioMessage = $this->twilio->messages->create(
                "whatsapp:$phone", // to
                [
                    'from' => $this->whatsappNumber,
                    'body' => $message,
                    'statusCallback' => $this->config['webhook']['url'] ?? null
                ]
            );

            // Log the message if logging is enabled
            if ($this->config['logging']['enabled']) {
                Log::channel($this->config['logging']['channel'])->info('WhatsApp message sent', [
                    'to' => $phone,
                    'message_sid' => $twilioMessage->sid,
                    'status' => $twilioMessage->status,
                    'message_length' => strlen($message)
                ]);
            }

            // Update rate limit counter
            if ($this->config['rate_limits']['enabled']) {
                $this->updateRateLimit($phone);
            }

            return [
                'success' => true,
                'message_sid' => $twilioMessage->sid,
                'status' => $twilioMessage->status,
                'to' => $phone,
                'from' => $this->whatsappNumber,
                'body' => $message,
                'date_created' => $twilioMessage->dateCreated->format('Y-m-d H:i:s'),
                'price' => $twilioMessage->price,
                'price_unit' => $twilioMessage->priceUnit
            ];

        } catch (TwilioException $e) {
            Log::error('Twilio WhatsApp error', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'to' => $phone ?? 'unknown'
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        } catch (\Exception $e) {
            Log::error('WhatsApp service error', [
                'error' => $e->getMessage(),
                'to' => $phone ?? 'unknown'
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send a WhatsApp template message (for approved templates only)
     */
    public function sendTemplate(string $phone, string $templateName, array $parameters = []): array
    {
        try {
            $phone = $this->formatPhoneNumber($phone);
            
            // Check if template exists in config
            if (!isset($this->config['templates'][$templateName])) {
                throw new \Exception("Template '$templateName' not found in configuration");
            }

            $template = $this->config['templates'][$templateName];
            
            // Build template content (this would be replaced with actual template content)
            $content = $this->buildTemplateContent($templateName, $parameters);

            // For now, send as regular message since template approval is complex
            // In production, you'd use Twilio's template API
            return $this->sendMessage($phone, $content);

        } catch (\Exception $e) {
            Log::error('WhatsApp template error', [
                'error' => $e->getMessage(),
                'template' => $templateName,
                'to' => $phone ?? 'unknown'
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send booking confirmation WhatsApp
     */
    public function sendBookingConfirmation(object $booking, string $customerName): array
    {
        $message = $this->buildBookingConfirmationMessage($booking, $customerName);
        
        // Get phone number from booking (guest or user)
        $phone = $booking->user ? $booking->user->phone : ($booking->participant_details['guest_info']['phone'] ?? null);
        
        if (!$phone) {
            return [
                'success' => false,
                'error' => 'No phone number available for this booking'
            ];
        }

        return $this->sendMessage($phone, $message);
    }

    /**
     * Send booking reminder WhatsApp
     */
    public function sendBookingReminder(object $booking, string $customerName, int $hoursUntil): array
    {
        $message = $this->buildBookingReminderMessage($booking, $customerName, $hoursUntil);
        
        $phone = $booking->user ? $booking->user->phone : ($booking->participant_details['guest_info']['phone'] ?? null);
        
        if (!$phone) {
            return [
                'success' => false,
                'error' => 'No phone number available for this booking'
            ];
        }

        return $this->sendMessage($phone, $message);
    }

    /**
     * Get message delivery status
     */
    public function getMessageStatus(string $messageSid): array
    {
        try {
            $message = $this->twilio->messages($messageSid)->fetch();

            return [
                'success' => true,
                'message_sid' => $message->sid,
                'status' => $message->status,
                'error_code' => $message->errorCode,
                'error_message' => $message->errorMessage,
                'date_sent' => $message->dateSent ? $message->dateSent->format('Y-m-d H:i:s') : null,
                'date_updated' => $message->dateUpdated ? $message->dateUpdated->format('Y-m-d H:i:s') : null
            ];

        } catch (TwilioException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Validate Twilio webhook signature
     */
    public function validateWebhook(array $postData, string $signature, string $url): bool
    {
        try {
            return $this->twilio->validateExpressRequest(
                $this->config['token'],
                $signature,
                $url,
                $postData
            );
        } catch (\Exception $e) {
            Log::error('Webhook validation error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Format phone number for WhatsApp (international format)
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add + if not present
        if (!str_starts_with($phone, '+')) {
            // Assume Swiss number if no country code (starts with 0)
            if (str_starts_with($phone, '0')) {
                $phone = '+41' . substr($phone, 1);
            } else if (strlen($phone) === 9) {
                // Swiss mobile number without 0
                $phone = '+41' . $phone;
            } else {
                // Add + to international number
                $phone = '+' . $phone;
            }
        }

        return $phone;
    }

    /**
     * Check rate limits for phone number
     */
    protected function checkRateLimit(string $phone): bool
    {
        $limits = $this->config['rate_limits'];
        $now = Carbon::now();
        
        // Check per minute limit
        $minuteKey = "whatsapp_rate_limit:minute:{$phone}:" . $now->format('Y-m-d-H-i');
        $minuteCount = Cache::get($minuteKey, 0);
        if ($minuteCount >= $limits['messages_per_minute']) {
            return false;
        }

        // Check per hour limit
        $hourKey = "whatsapp_rate_limit:hour:{$phone}:" . $now->format('Y-m-d-H');
        $hourCount = Cache::get($hourKey, 0);
        if ($hourCount >= $limits['messages_per_hour']) {
            return false;
        }

        // Check per day limit
        $dayKey = "whatsapp_rate_limit:day:{$phone}:" . $now->format('Y-m-d');
        $dayCount = Cache::get($dayKey, 0);
        if ($dayCount >= $limits['messages_per_day']) {
            return false;
        }

        return true;
    }

    /**
     * Update rate limit counters
     */
    protected function updateRateLimit(string $phone): void
    {
        $now = Carbon::now();
        
        $minuteKey = "whatsapp_rate_limit:minute:{$phone}:" . $now->format('Y-m-d-H-i');
        $hourKey = "whatsapp_rate_limit:hour:{$phone}:" . $now->format('Y-m-d-H');
        $dayKey = "whatsapp_rate_limit:day:{$phone}:" . $now->format('Y-m-d');
        
        Cache::increment($minuteKey, 1);
        Cache::expire($minuteKey, 60); // 1 minute
        
        Cache::increment($hourKey, 1);
        Cache::expire($hourKey, 3600); // 1 hour
        
        Cache::increment($dayKey, 1);
        Cache::expire($dayKey, 86400); // 1 day
    }

    /**
     * Build template content (placeholder implementation)
     */
    protected function buildTemplateContent(string $templateName, array $parameters): string
    {
        switch ($templateName) {
            case 'booking_confirmation':
                return "Hi {$parameters['customer_name']}! 🎯\n\n" .
                       "Your booking for {$parameters['service_name']} on {$parameters['booking_date']} has been confirmed!\n\n" .
                       "We're excited to see you at Axtra Urban Axe Throwing. Get ready for an amazing experience! 🪓\n\n" .
                       "Need to make changes? Contact us within 48 hours.\n\n" .
                       "Best regards,\nAxtra Team";

            case 'reminder_50_hours':
                return "Hi {$parameters['customer_name']}! 🎯\n\n" .
                       "Just a friendly reminder that your axe throwing session is coming up!\n\n" .
                       "📅 Service: {$parameters['service_name']}\n" .
                       "📅 Date: {$parameters['booking_date']}\n\n" .
                       "Can't wait to see you throw some axes! 🪓\n\n" .
                       "Axtra Team";

            case 'reminder_2_hours':
                return "Hi {$parameters['customer_name']}! 🎯\n\n" .
                       "Your axe throwing session starts in just 2 hours!\n\n" .
                       "📍 Location: Axtra Urban Axe Throwing\n" .
                       "🕐 Time: {$parameters['booking_date']}\n\n" .
                       "See you soon for an epic session! 🪓\n\n" .
                       "Axtra Team";

            case 'welcome':
                return "Welcome to Axtra Urban Axe Throwing, {$parameters['customer_name']}! 🎯\n\n" .
                       "Thanks for joining our community of axe throwing enthusiasts!\n\n" .
                       "Ready to book your first session? Visit our website or reply to this message.\n\n" .
                       "Let's throw some axes! 🪓\n\n" .
                       "Axtra Team";

            default:
                return "Hello! This is a message from Axtra Urban Axe Throwing.";
        }
    }

    /**
     * Build booking confirmation message
     */
    protected function buildBookingConfirmationMessage(object $booking, string $customerName): string
    {
        $date = Carbon::parse($booking->start_time)->format('l, F j, Y \a\t g:i A');
        
        return "Hi {$customerName}! 🎯\n\n" .
               "Your booking has been confirmed!\n\n" .
               "📋 Booking ID: #{$booking->id}\n" .
               "🎯 Service: {$booking->service->name}\n" .
               "📅 Date: {$date}\n" .
               "👥 Participants: {$booking->participants}\n" .
               "💰 Total: CHF " . number_format($booking->total_price, 2) . "\n\n" .
               "Please arrive 30 minutes early. Changes can be made up to 48 hours before your session.\n\n" .
               "Get ready for an amazing axe throwing experience! 🪓\n\n" .
               "Axtra Team";
    }

    /**
     * Build booking reminder message
     */
    protected function buildBookingReminderMessage(object $booking, string $customerName, int $hoursUntil): string
    {
        $date = Carbon::parse($booking->start_time)->format('l, F j, Y \a\t g:i A');
        $hourText = $hoursUntil === 1 ? '1 hour' : "{$hoursUntil} hours";
        
        return "Hi {$customerName}! 🎯\n\n" .
               "Your axe throwing session starts in {$hourText}!\n\n" .
               "📋 Booking: #{$booking->id}\n" .
               "🎯 Service: {$booking->service->name}\n" .
               "📅 When: {$date}\n" .
               "👥 Participants: {$booking->participants}\n\n" .
               "📍 Address: Axtra Urban Axe Throwing\n" .
               "🚗 Please arrive 30 minutes early\n\n" .
               "Ready to throw some axes? See you soon! 🪓\n\n" .
               "Axtra Team";
    }
}