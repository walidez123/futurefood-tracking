<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAF-kr9Aw:APA91bFk2hww-JacAaEK-c11-hLKfc2cx6wo2cTcG-1CwbDuU7rwrY_H8hRCLKSyZe_H7MdIqPDtKVoCDikJYpaRBCH9LkxgCuW06C_ng6bEMFUdZWPjs4jI6UKDow0Mu1bnZX-JCDl'),
        'sender_id' => env('FCM_SENDER_ID', '102696219660'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'server_topic_url' => 'https://iid.googleapis.com/iid/v1/',
        'timeout' => 30.0, // in second
    ],
];
