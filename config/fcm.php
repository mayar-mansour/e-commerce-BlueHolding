<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        //'server_key' => env('FCM_SERVER_KEY', 'AAAALurVOHA:APA91bGxmb-cGwZzhOPpk0hWrkpcGlHc5JYSUGuyDANCmGR395cdNafyJjU09Vq0cHMB-Z_lzTG-g7D7wVDmmub5mXyTNkj8OND-BkwNyCvojQ6DAeAU6L4FerZOKBzojB42YfT62sac'),
        'server_key' => env('FCM_SERVER_KEY', 'AAAALurVOHA:APA91bGxmb-cGwZzhOPpk0hWrkpcGlHc5JYSUGuyDANCmGR395cdNafyJjU09Vq0cHMB-Z_lzTG-g7D7wVDmmub5mXyTNkj8OND-BkwNyCvojQ6DAeAU6L4FerZOKBzojB42YfT62sac'),
	'sender_id' => env('FCM_SENDER_ID', '201508337776'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
