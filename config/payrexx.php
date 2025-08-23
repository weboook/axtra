<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayRexx Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayRexx payment gateway integration
    |
    */

    'base_url' => env('PAYREXX_BASE_URL', 'https://api.payrexx.com/v1.0/'),
    
    'instance_name' => env('PAYREXX_INSTANCE_NAME'),
    
    'api_secret' => env('PAYREXX_API_SECRET'),
    
    'webhook_secret' => env('PAYREXX_WEBHOOK_SECRET'),
    
    'environment' => env('PAYREXX_ENVIRONMENT', 'sandbox'), // 'sandbox' or 'live'
];