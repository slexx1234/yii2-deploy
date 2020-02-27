<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
return [
    'local'=>[
        'class'=>'\trntv\deploy\base\Server',
    ],
    'production'=>[
        'class'=>'\trntv\deploy\base\Server',
        'connection'=>[
            'configuration'=>[
                'class'=>'Ssh\Configuration',
                'host'=>'example.com'
            ],
            'authentication'=>[
                'class'=>'Ssh\Authentication\Password',
                'username'=>'root',
                'password'=>'veryStrongPassword',
            ],
        ]
    ]
];