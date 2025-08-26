<?php

namespace App\Services;

use App\Models\User;
use App\Models\Booking;
use App\Notifications\BookingConfirmation;
use App\Notifications\EventReminder50Hours;
use App\Notifications\EventReminder2Hours;
use App\Notifications\ReviewRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotificationService
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Send booking confirmation via email and WhatsApp
     */
    public function sendBookingConfirmation(Booking $booking): array
    {
        $results = [];
        
        try {
            $customerName = $booking->user 
                ? $booking->user->name 
                : $booking->participant_details['guest_info']['name'];

            // Send email notification
            try {
                if ($booking->user) {
                    $booking->user->notify(new BookingConfirmation($booking));
                } else {
                    $guestEmail = $booking->participant_details['guest_info']['email'] ?? null;
                    if ($guestEmail) {
                        \Notification::route('mail', $guestEmail)
                            ->notify(new BookingConfirmation($booking));
                    }
                }
                $results['email'] = ['success' => true, 'message' => 'Email sent successfully'];
            } catch (\Exception $e) {
                $results['email'] = ['success' => false, 'error' => $e->getMessage()];
                Log::error('Email notification failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

            // Send WhatsApp notification
            try {
                $whatsappResult = $this->whatsAppService->sendBookingConfirmation($booking, $customerName);
                $results['whatsapp'] = $whatsappResult;
                
                if ($whatsappResult['success']) {
                    Log::info('WhatsApp booking confirmation sent', [
                        'booking_id' => $booking->id,
                        'message_sid' => $whatsappResult['message_sid'] ?? null
                    ]);
                }
            } catch (\Exception $e) {
                $results['whatsapp'] = ['success' => false, 'error' => $e->getMessage()];
                Log::error('WhatsApp notification failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

        } catch (\Exception $e) {
            Log::error('Booking confirmation failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            $results['error'] = $e->getMessage();
        }

        return $results;
    }

    /**
     * Send booking reminder notifications
     */
    public function sendReminder(Booking $booking, int $hoursUntil = 50): array
    {
        $results = [];
        
        try {
            $customerName = $booking->user 
                ? $booking->user->name 
                : $booking->participant_details['guest_info']['name'];

            // Determine which reminder to send based on hours
            $notificationClass = match($hoursUntil) {
                50 => EventReminder50Hours::class,
                2 => EventReminder2Hours::class,
                default => EventReminder50Hours::class
            };

            // Send email reminder
            try {
                if ($booking->user) {
                    $booking->user->notify(new $notificationClass($booking));
                } else {
                    $guestEmail = $booking->participant_details['guest_info']['email'] ?? null;
                    if ($guestEmail) {
                        \Notification::route('mail', $guestEmail)
                            ->notify(new $notificationClass($booking));
                    }
                }
                $results['email'] = ['success' => true, 'message' => 'Email reminder sent successfully'];
            } catch (\Exception $e) {
                $results['email'] = ['success' => false, 'error' => $e->getMessage()];
                Log::error('Email reminder failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

            // Send WhatsApp reminder
            try {
                $whatsappResult = $this->whatsAppService->sendBookingReminder($booking, $customerName, $hoursUntil);
                $results['whatsapp'] = $whatsappResult;
                
                if ($whatsappResult['success']) {
                    Log::info('WhatsApp reminder sent', [
                        'booking_id' => $booking->id,
                        'hours_until' => $hoursUntil,
                        'message_sid' => $whatsappResult['message_sid'] ?? null
                    ]);
                }
            } catch (\Exception $e) {
                $results['whatsapp'] = ['success' => false, 'error' => $e->getMessage()];
                Log::error('WhatsApp reminder failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

        } catch (\Exception $e) {
            Log::error('Reminder notification failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            $results['error'] = $e->getMessage();
        }

        return $results;
    }

    /**
     * Send review request after booking completion
     */
    public function sendReviewRequest(Booking $booking): array
    {
        $results = [];
        
        try {
            $customerName = $booking->user 
                ? $booking->user->name 
                : $booking->participant_details['guest_info']['name'];

            // Send email review request
            try {
                if ($booking->user) {
                    $booking->user->notify(new ReviewRequest($booking));
                } else {
                    $guestEmail = $booking->participant_details['guest_info']['email'] ?? null;
                    if ($guestEmail) {
                        \Notification::route('mail', $guestEmail)
                            ->notify(new ReviewRequest($booking));
                    }
                }
                $results['email'] = ['success' => true, 'message' => 'Review request email sent'];
            } catch (\Exception $e) {
                $results['email'] = ['success' => false, 'error' => $e->getMessage()];
                Log::error('Review request email failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

            // Send WhatsApp review request
            try {
                $message = "Hi {$customerName}! 🎯\n\n" .
                          "How was your axe throwing experience with us?\n\n" .
                          "We'd love to hear your feedback! Your review helps us improve and helps other axe throwers discover the fun.\n\n" .
                          "⭐ Rate us on Google or leave a review on our website.\n\n" .
                          "Thanks for choosing Axtra! 🪓\n\n" .
                          "Axtra Team";

                $phone = $booking->user ? $booking->user->phone : ($booking->participant_details['guest_info']['phone'] ?? null);
                
                if ($phone) {
                    $whatsappResult = $this->whatsAppService->sendMessage($phone, $message);
                    $results['whatsapp'] = $whatsappResult;
                } else {
                    $results['whatsapp'] = ['success' => false, 'error' => 'No phone number available'];
                }
                
            } catch (\Exception $e) {
                $results['whatsapp'] = ['success' => false, 'error' => $e->getMessage()];
                Log::error('WhatsApp review request failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

        } catch (\Exception $e) {
            Log::error('Review request failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            $results['error'] = $e->getMessage();
        }

        return $results;
    }

    /**
     * Send direct WhatsApp notification to user
     */
    public function sendWhatsAppNotification(User $user, string $message, string $templateName = null, array $parameters = []): array
    {
        try {
            if (!$user->phone) {
                return [
                    'success' => false,
                    'error' => 'User has no phone number'
                ];
            }

            if (!$user->whatsapp_notifications ?? true) {
                return [
                    'success' => false,
                    'error' => 'User has disabled WhatsApp notifications'
                ];
            }

            if ($templateName) {
                $result = $this->whatsAppService->sendTemplate($user->phone, $templateName, $parameters);
            } else {
                $result = $this->whatsAppService->sendMessage($user->phone, $message);
            }

            if ($result['success']) {
                Log::info('Direct WhatsApp notification sent', [
                    'user_id' => $user->id,
                    'template' => $templateName,
                    'message_sid' => $result['message_sid'] ?? null
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Direct WhatsApp notification failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send welcome WhatsApp to new user
     */
    public function sendWelcomeWhatsApp(User $user): array
    {
        try {
            return $this->whatsAppService->sendTemplate($user->phone, 'welcome', [
                'customer_name' => $user->name
            ]);
        } catch (\Exception $e) {
            Log::error('Welcome WhatsApp failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get notification statistics
     */
    public function getNotificationStats(int $days = 30): array
    {
        try {
            $startDate = Carbon::now()->subDays($days);
            
            // This would require a notifications log table to implement properly
            // For now, return placeholder data
            
            return [
                'period_days' => $days,
                'email_sent' => 0, // Would query from notifications log
                'whatsapp_sent' => 0, // Would query from notifications log
                'failed_notifications' => 0, // Would query from failed jobs or logs
                'success_rate' => 100.0
            ];
            
        } catch (\Exception $e) {
            Log::error('Failed to get notification stats', ['error' => $e->getMessage()]);
            
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}