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
     * Handle Twilio webhooks
     */
    public function webhook(Request $request): JsonResponse
    {
        try {
            // Validate Twilio webhook signature here
            $status = $request->input('MessageStatus');
            $messageSid = $request->input('MessageSid');
            
            // Log status update or update database
            \Log::info("Twilio webhook received", [
                'message_sid' => $messageSid,
                'status' => $status,
                'data' => $request->all()
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error("Twilio webhook error", ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }
}