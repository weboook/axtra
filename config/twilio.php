<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Twilio Account Configuration
    |--------------------------------------------------------------------------
    |
    | Your Twilio Account SID and Auth Token from twilio.com/console
    |
    */

    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_AUTH_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Twilio Phone Numbers
    |--------------------------------------------------------------------------
    |
    | Your Twilio phone numbers for SMS and WhatsApp
    |
    */

    'phone_number' => env('TWILIO_PHONE_NUMBER'),
    'whatsapp_number' => env('TWILIO_WHATSAPP_NUMBER'),

    /*
    |--------------------------------------------------------------------------
    | Twilio Verify Service
    |--------------------------------------------------------------------------
    |
    | Your Twilio Verify Service SID for phone verification
    |
    */

    'verify_service_sid' => env('TWILIO_VERIFY_SERVICE_SID'),

    /*
    |--------------------------------------------------------------------------
    | Twilio Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Twilio webhooks
    |
    */

    'webhook' => [
        'enabled' => env('TWILIO_WEBHOOK_ENABLED', true),
        'url' => env('APP_URL') . '/api/webhooks/twilio',
    ],

    /*
    |--------------------------------------------------------------------------
    | Message Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for messages
    |
    */

    'message_defaults' => [
        'max_length' => 1600, // WhatsApp message limit
        'retry_attempts' => 3,
        'retry_delay' => 5, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Template Configuration
    |--------------------------------------------------------------------------
    |
    | WhatsApp approved message templates
    |
    */

    'templates' => [
        'booking_confirmation' => [
            'name' => 'booking_confirmation',
            'parameters' => ['customer_name', 'booking_date', 'service_name']
        ],
        'reminder_50_hours' => [
            'name' => 'reminder_50_hours', 
            'parameters' => ['customer_name', 'booking_date', 'service_name']
        ],
        'reminder_2_hours' => [
            'name' => 'reminder_2_hours',
            'parameters' => ['customer_name', 'booking_date', 'service_name']
        ],
        'welcome' => [
            'name' => 'welcome',
            'parameters' => ['customer_name']
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiting configuration for WhatsApp messages
    |
    */

    'rate_limits' => [
        'enabled' => true,
        'messages_per_minute' => 60,
        'messages_per_hour' => 1000,
        'messages_per_day' => 10000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Enable logging of Twilio API calls and responses
    |
    */

    'logging' => [
        'enabled' => env('TWILIO_LOGGING_ENABLED', true),
        'channel' => env('TWILIO_LOG_CHANNEL', 'stack'),
        'level' => env('TWILIO_LOG_LEVEL', 'info'),
    ],

];