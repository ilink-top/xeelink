<?php
return [
    'token' => [
        "iss" => "http://ilink.top", //签发组织
        "aud" => "http://ilink.top", //签发作者
    ],
    'key' => md5('LibraAdmin'),
    'allowed_algs' => ['HS256'],
    'expire' => 1296000
];