<?php

return [
    /*
    |--------------------------------------------------------------------------
    | KHQR Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for KHQR (Khmer QR) payment system integration
    |
    */

    // Your Bakong Account ID (replace with actual account)
    'bakong_account_id' => env('KHQR_BAKONG_ACCOUNT_ID', 'koksal_misel@aclb'),
    
    // Merchant Information
    'merchant_name' => env('KHQR_MERCHANT_NAME', 'Donation Tracker'),
    'merchant_city' => env('KHQR_MERCHANT_CITY', 'PHNOM PENH'),
    
    // Currency Settings
    'currency' => env('KHQR_CURRENCY', 'USD'), // USD or KHR
    
    // API Settings
    'api_token' => env('KHQR_API_TOKEN', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7ImlkIjoiMjZkMTI0ZDJiYWJkNDZiZSJ9LCJpYXQiOjE3NDcwNzE0OTMsImV4cCI6MTc1NDg0NzQ5M30.Ovuo5hEcg7LMeEn--lUknIYLqoyUD3_meIkfiy0xllc'),
    'is_test_mode' => env('KHQR_TEST_MODE', true), // Default to production mode for real payment verification
    
    // QR Code Settings
    'qr_code_size' => env('KHQR_QR_SIZE', 250),
    'qr_code_margin' => env('KHQR_QR_MARGIN', 2),
]; 