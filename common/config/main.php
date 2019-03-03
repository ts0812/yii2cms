<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
		//文件缓存组件
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'redis'=>[

            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 2,
        ]
    ],
];
