<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PayRexxController extends Controller
{
    private $baseUrl;
    private $instanceName;
    private $apiSecret;

    public function __construct()
    {
        $this->baseUrl = config('payrexx.base_url', 'https://api.payrexx.com/v1.0/');
        $this->instanceName = config('payrexx.instance_name');
        $this->apiSecret = config('payrexx.api_secret');
    }

    /**
     * Create PayRexx gateway and redirect to payment
     */
    public function createPayment(Booking $booking)
    {
        try {
            // Prepare payment data
            $paymentData = [
                'instance' => $this->instanceName,
                'amount' => (int)($booking->total_price * 100), // Amount in cents
                'currency' => 'CHF',
                'referenceId' => $booking->id,
                'purpose' => 'Axtra Booking #' . $booking->id,
                'successRedirectUrl' => route('booking.success', $booking->id),
                'failedRedirectUrl' => route('booking.failed', $booking->id),
                'cancelRedirectUrl' => route('booking.cancelled', $booking->id),
                'webhookUrl' => route('payment.webhook'),
                'fields' => [
                    'email' => [
                        'defaultValue' => $booking->user->email ?? $booking->guest_info['email'] ?? '',
                        'readonly' => true
                    ],
                    'forename' => [
                        'defaultValue' => $booking->user->name ?? $booking->guest_info['name'] ?? '',
                        'readonly' => false
                    ],
                ]
            ];

            // Create signature
            $signature = $this->generateSignature($paymentData);
            
            // Make API request to PayRexx
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post($this->baseUrl . 'Gateway/', array_merge($paymentData, [
                'ApiSignature' => $signature
            ]));

            if ($response->successful()) {
                $responseData = $response->json();
                
                if ($responseData['status'] === 'success') {
                    // Update booking with payment reference
                    $booking->update([
                        'payment_reference' => $responseData['data']['hash'],
                    ]);
                    
                    // Redirect to PayRexx payment page
                    return redirect($responseData['data']['link']);
                }
            }

            throw new \Exception('Failed to create PayRexx gateway: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('PayRexx payment creation failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('booking.error')
                ->with('error', 'Payment processing is temporarily unavailable. Please try again later.');
        }
    }

    /**
     * Handle PayRexx webhook
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->all();
            
            // Verify webhook signature
            if (!$this->verifyWebhookSignature($request)) {
                Log::warning('PayRexx webhook signature verification failed');
                return response('Signature verification failed', 400);
            }

            // Process payment status
            $transaction = $payload['transaction'] ?? [];
            $referenceId = $transaction['referenceId'] ?? null;

            if ($referenceId) {
                $booking = Booking::find($referenceId);
                
                if ($booking) {
                    $status = $transaction['status'] ?? '';
                    
                    switch ($status) {
                        case 'confirmed':
                            $booking->update([
                                'status' => 'confirmed',
                                'payment_status' => 'paid',
                            ]);
                            
                            // Send confirmation email, notifications, etc.
                            $this->handleSuccessfulPayment($booking);
                            break;
                            
                        case 'cancelled':
                            $booking->update(['status' => 'cancelled']);
                            break;
                            
                        case 'error':
                            $booking->update(['status' => 'pending']);
                            break;
                    }
                    
                    Log::info('PayRexx webhook processed successfully', [
                        'booking_id' => $booking->id,
                        'status' => $status,
                    ]);
                }
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('PayRexx webhook processing failed', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response('Internal Server Error', 500);
        }
    }

    /**
     * Handle successful payment redirect
     */
    public function success(Booking $booking)
    {
        $layout = auth()->check() ? 'layouts.app' : 'layouts.public';
        return view('booking.success', compact('booking', 'layout'));
    }

    /**
     * Handle failed payment redirect
     */
    public function failed(Booking $booking)
    {
        $layout = auth()->check() ? 'layouts.app' : 'layouts.public';
        return view('booking.failed', compact('booking', 'layout'));
    }

    /**
     * Handle cancelled payment redirect
     */
    public function cancelled(Booking $booking)
    {
        $layout = auth()->check() ? 'layouts.app' : 'layouts.public';
        return view('booking.cancelled', compact('booking', 'layout'));
    }

    /**
     * Handle general payment errors
     */
    public function error()
    {
        $layout = auth()->check() ? 'layouts.app' : 'layouts.public';
        return view('booking.error', compact('layout'));
    }

    /**
     * Generate PayRexx API signature
     */
    private function generateSignature(array $data)
    {
        ksort($data);
        $queryString = http_build_query($data);
        return base64_encode(hash_hmac('sha256', $queryString, $this->apiSecret, true));
    }

    /**
     * Verify webhook signature
     */
    private function verifyWebhookSignature(Request $request)
    {
        $signature = $request->header('Payrexx-Signature');
        $payload = $request->getContent();
        
        $expectedSignature = base64_encode(hash_hmac('sha256', $payload, $this->apiSecret, true));
        
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Handle successful payment processing
     */
    private function handleSuccessfulPayment(Booking $booking)
    {
        // Update coupon usage if applicable
        if ($booking->coupon_id) {
            $booking->coupon->increment('used_count');
        }

        // Create notification
        if ($booking->user_id) {
            $booking->user->notify(new \App\Notifications\BookingConfirmed($booking));
        }

        // Send confirmation email for guests
        if ($booking->is_guest_booking && isset($booking->guest_info['email'])) {
            // Mail::to($booking->guest_info['email'])->send(new BookingConfirmationMail($booking));
        }

        // Additional post-payment processing...
    }
}
