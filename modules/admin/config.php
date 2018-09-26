<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/20
 * Time: 21:26
 */
return [
    'layout' => 'main',
    'modules' => [
        'blog' => [
            'class' => 'app\modules\admin\modules\blog\Module',
        ],
        'topic' => [
            'class' => 'app\modules\admin\modules\topic\Module',
        ],
        'zones' => [
            'class' => 'app\modules\admin\modules\zones\Module',
        ],
        'setting' => [
            'class' => 'app\modules\admin\modules\setting\Module',
        ],
        'member' => [
            'class' => 'app\modules\admin\modules\member\Module',
        ],

    ],
    'components' => [
        // list of component configurations
    ],
    'params' => [
        // list of parameters
    ],
];