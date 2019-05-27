<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
		//文件缓存组件
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
