<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'keycrm' => [
        'token' => env('API_TOKEN_KEY_CRM'),
        'url' => 'https://openapi.keycrm.app/v1',
        'source_id' => 1,
        'buyer_field_id' => 'CT_1001',
        'order_field_id' => 'OR_1002',
    ],
];
