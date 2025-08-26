<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Services\WhatsAppService;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TwilioController extends Controller
{
    protected $notificationService;
    protected $whatsAppService;

    public function __construct(NotificationService $notificationService, WhatsAppService $whatsAppService)
    {
        $this->notificationService = $notificationService;
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Send WhatsApp notification to user
     */
    public function sendWhatsApp(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'template' => 'nullable|string',
            'parameters' => 'nullable|array'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            
            if (!$user->whatsapp_notifications || !$user->phone) {
                return response()->json([
                    'success' => false,
                    'message' => 'User has disabled WhatsApp notifications or no phone number'
                ], 400);
            }

            if ($request->template) {
                $result = $this->whatsAppService->sendTemplate(
                    $user->phone, 
                    $request->template, 
                    $request->parameters ?? []
                );
            } else {
                $result = $this->whatsAppService->sendMessage($user->phone, $request->message);
            }

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp notification sent successfully',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send WhatsApp notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send booking confirmation via WhatsApp
     */
    public function sendBookingConfirmation(Request $request): JsonResponse
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id'
        ]);

        try {
            $booking = Booking::with(['user', 'product', 'timeSlot'])->findOrFail($request->booking_id);
            
            $this->notificationService->sendBookingConfirmation($booking);

            return response()->json([
                'success' => true,
                'message' => 'Booking confirmation sent successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send booking confirmation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send reminder notification
     */
    public function sendReminder(Request $request): JsonResponse
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'hours_before' => 'nullable|integer|min:1|max:72'
        ]);

        try {
            $booking = Booking::with(['user', 'product', 'timeSlot'])->findOrFail($request->booking_id);
            
            $this->notificationService->sendReminder($booking);

            return response()->json([
                'success' => true,
                'message' => 'Reminder notification sent successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reminder notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk send notifications
     */
    public function bulkSend(Request $request): JsonResponse
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'message' => 'required|string|max:1000',
            'template' => 'nullable|string',
            'parameters' => 'nullable|array'
        ]);

        try {
            $users = User::whereIn('id', $request->user_ids)
                         ->where('whatsapp_notifications', true)
                         ->whereNotNull('phone')
                         ->get();

            $sent = 0;
            $failed = 0;

            foreach ($users as $user) {
                try {
                    if ($request->template) {
                        $this->whatsAppService->sendTemplate(
                            $user->phone, 
                            $request->template, 
                            $request->parameters ?? []
                        );
                    } else {
                        $this->whatsAppService->sendMessage($user->phone, $request->message);
                    }
                    $sent++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Bulk notification completed. Sent: {$sent}, Failed: {$failed}",
                'stats' => [
                    'sent' => $sent,
                    'failed' => $failed,
                    'total' => $users->count()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send bulk notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notification status
     */
    public function getStatus(Request $request): JsonResponse
    {
        $request->validate([
            'message_sid' => 'required|string'
        ]);

        try {
            // Implementation depends on Twilio service integration
            return response()->json([
                'success' => true,
                'message' => 'Status retrieved successfully',
                'status' => 'delivered' // This would come from Twilio API
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get notification status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Twilio webhooks for message status updates
     */
    public function webhook(Request $request): JsonResponse
    {
        try {
            // Get webhook signature from headers
            $signature = $request->header('X-Twilio-Signature', '');
            $url = $request->fullUrl();
            
            // Validate webhook signature
            if (!$this->whatsAppService->validateWebhook($request->all(), $signature, $url)) {
                \Log::warning('Invalid Twilio webhook signature', [
                    'url' => $url,
                    'signature' => $signature
                ]);
                return response()->json(['error' => 'Invalid signature'], 401);
            }

            // Extract webhook data
            $messageSid = $request->input('MessageSid');
            $status = $request->input('MessageStatus');
            $errorCode = $request->input('ErrorCode');
            $errorMessage = $request->input('ErrorMessage');
            $from = $request->input('From');
            $to = $request->input('To');
            $body = $request->input('Body');
            
            // Log the webhook for debugging
            \Log::info('Twilio webhook received', [
                'message_sid' => $messageSid,
                'status' => $status,
                'from' => $from,
                'to' => $to,
                'error_code' => $errorCode,
                'error_message' => $errorMessage
            ]);

            // Handle different message statuses
            switch ($status) {
                case 'delivered':
                    // Message successfully delivered
                    \Log::info('WhatsApp message delivered', [
                        'message_sid' => $messageSid,
                        'to' => $to
                    ]);
                    break;
                    
                case 'failed':
                case 'undelivered':
                    // Message failed to deliver
                    \Log::error('WhatsApp message failed', [
                        'message_sid' => $messageSid,
                        'to' => $to,
                        'error_code' => $errorCode,
                        'error_message' => $errorMessage
                    ]);
                    break;
                    
                case 'read':
                    // Message was read by recipient
                    \Log::info('WhatsApp message read', [
                        'message_sid' => $messageSid,
                        'to' => $to
                    ]);
                    break;
                    
                case 'sent':
                    // Message sent to WhatsApp
                    \Log::info('WhatsApp message sent', [
                        'message_sid' => $messageSid,
                        'to' => $to
                    ]);
                    break;
            }

            // Here you could update a message status table in the database
            // Example: MessageStatus::updateOrCreate(['message_sid' => $messageSid], ['status' => $status]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Twilio webhook error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle incoming WhatsApp messages (for replies)
     */
    public function incomingMessage(Request $request): JsonResponse
    {
        try {
            $from = $request->input('From'); // WhatsApp number that sent the message
            $to = $request->input('To'); // Your WhatsApp business number
            $body = $request->input('Body'); // Message content
            $messageSid = $request->input('MessageSid');
            
            \Log::info('Incoming WhatsApp message', [
                'from' => $from,
                'to' => $to,
                'body' => $body,
                'message_sid' => $messageSid
            ]);

            // Here you can implement auto-replies or route messages to support
            // For example, if someone replies "STOP", you could unsubscribe them
            
            $lowerBody = strtolower(trim($body));
            
            if (in_array($lowerBody, ['stop', 'unsubscribe', 'opt out'])) {
                // Handle unsubscribe request
                $this->handleUnsubscribe($from);
                
                // Send confirmation
                $response = "You have been unsubscribed from WhatsApp notifications. Reply START to opt back in.";
                $this->whatsAppService->sendMessage(str_replace('whatsapp:', '', $from), $response);
            }
            elseif (in_array($lowerBody, ['start', 'subscribe', 'opt in'])) {
                // Handle resubscribe request
                $this->handleResubscribe($from);
                
                $response = "Welcome back! You'll now receive WhatsApp notifications from Axtra Urban Axe Throwing.";
                $this->whatsAppService->sendMessage(str_replace('whatsapp:', '', $from), $response);
            }
            elseif (in_array($lowerBody, ['help', 'info'])) {
                // Send help information
                $response = "Hi! This is Axtra Urban Axe Throwing. 🎯\n\n" .
                           "Reply STOP to unsubscribe from notifications\n" .
                           "Reply START to resubscribe\n" .
                           "Visit our website: https://app.axtra.ch\n\n" .
                           "For support, call us or visit our location!";
                
                $this->whatsAppService->sendMessage(str_replace('whatsapp:', '', $from), $response);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Incoming message error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Handle unsubscribe request
     */
    private function handleUnsubscribe(string $whatsappNumber): void
    {
        try {
            $phone = str_replace('whatsapp:', '', $whatsappNumber);
            $phone = str_replace('+', '', $phone);
            
            // Find user by phone and update preferences
            $user = \App\Models\User::where('phone', 'LIKE', "%{$phone}%")->first();
            if ($user) {
                $user->update(['whatsapp_notifications' => false]);
                \Log::info('User unsubscribed from WhatsApp', ['user_id' => $user->id]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Unsubscribe error', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Handle resubscribe request
     */
    private function handleResubscribe(string $whatsappNumber): void
    {
        try {
            $phone = str_replace('whatsapp:', '', $whatsappNumber);
            $phone = str_replace('+', '', $phone);
            
            // Find user by phone and update preferences
            $user = \App\Models\User::where('phone', 'LIKE', "%{$phone}%")->first();
            if ($user) {
                $user->update(['whatsapp_notifications' => true]);
                \Log::info('User resubscribed to WhatsApp', ['user_id' => $user->id]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Resubscribe error', ['error' => $e->getMessage()]);
        }
    }
}