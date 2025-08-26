<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use App\Models\User;
use Illuminate\Console\Command;

class SendTestWhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone} {--message=Test message from Axtra!} {--template=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test WhatsApp message to verify Twilio integration';

    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        parent::__construct();
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->argument('phone');
        $message = $this->option('message');
        $template = $this->option('template');

        $this->info("Testing WhatsApp integration...");
        $this->info("Phone: {$phone}");

        try {
            // Check if Twilio is configured
            $config = config('twilio');
            if (!$config['sid'] || !$config['token'] || !$config['whatsapp_number']) {
                $this->error('Twilio is not properly configured. Please check your .env file.');
                $this->info('Required variables:');
                $this->info('- TWILIO_SID');
                $this->info('- TWILIO_AUTH_TOKEN');
                $this->info('- TWILIO_WHATSAPP_NUMBER');
                return 1;
            }

            $this->info("Twilio SID: " . substr($config['sid'], 0, 10) . "...");
            $this->info("WhatsApp Number: " . $config['whatsapp_number']);

            // Send message or template
            if ($template) {
                $this->info("Sending template: {$template}");
                $result = $this->whatsAppService->sendTemplate($phone, $template, [
                    'customer_name' => 'Test User',
                    'service_name' => 'Test Service',
                    'booking_date' => now()->format('Y-m-d H:i')
                ]);
            } else {
                $this->info("Sending message: {$message}");
                $result = $this->whatsAppService->sendMessage($phone, $message);
            }

            if ($result['success']) {
                $this->info("✅ WhatsApp message sent successfully!");
                $this->info("Message SID: " . ($result['message_sid'] ?? 'N/A'));
                $this->info("Status: " . ($result['status'] ?? 'N/A'));
                $this->info("Price: " . ($result['price'] ?? 'N/A') . ' ' . ($result['price_unit'] ?? ''));
            } else {
                $this->error("❌ Failed to send WhatsApp message:");
                $this->error($result['error'] ?? 'Unknown error');
                if (isset($result['code'])) {
                    $this->error("Error Code: " . $result['code']);
                }
            }

        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
