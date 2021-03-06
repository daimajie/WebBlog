<?php

return [
    'adminEmail' => 'git1314@163.com',

    /**
     * 站点配置
     */
    'upperLimit' => [
        'category' => 15,
        'tag' => 32,
    ],

    'member' => [
        'avatar' => '/static/img/avatar.png',
        'passwordResetTokenExpire' => 60 * 10
    ],

    //封面上传小部件的默认底图
    'article' => [
        'cover' => '/static/img/cover.png',
    ],


    'upload' => [
        'upRoot' => "@webroot/static/upload",
        'upUrl' => "@web/static/upload",
        'allowMime' => ['jpg','jpeg','png','gif'],
    ],

    'RBAC' => require __DIR__ . '/rbac.php',
];
