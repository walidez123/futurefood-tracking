<?php

return [
    'client_id' => env('ZID_CLIENT_ID'),
    'client_secrete' => env('ZID_CLIENT_SECRETE'),
    'auth_url' => env('ZID_AUTH_URL', 'https://oauth.zid.sa'),
    'base_url' => env('ZID_BASE_URL', 'https://api.zid.sa'),
];
