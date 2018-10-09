<?php
return [
    'RBAC_ROLES' => [
        1 => '管理员',
        2 => '作者',
    ],
    'RBAC_AUTHS' => [
        1 => ['*'],
        2 => ['blog/*', 'topic/*', 'zones/*', 'admin/*']
    ],
    'RBAC_PERMISS' => [
        1 => [1],  //管理员id
        2 => [2, 3], //作者id
    ],
];