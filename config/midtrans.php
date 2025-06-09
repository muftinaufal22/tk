<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID','G582029932' ),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-vnXg2lhbVoGdElk-'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-gUuLQOrVvdj19cQG4h_ZJeLz'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];

