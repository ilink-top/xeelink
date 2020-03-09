<?php
use think\facade\Request;
return [
    'jwt' => [
        'key' => md5('xeelink'),
        'iss' => Request::host(),
        'aud' => Request::host(),
        'expire_time' => 1296000,
    ],
];
