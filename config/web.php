<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language' => 'uk',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            //'baseUrl' => '',
            'cookieValidationKey' => '5gNTJRBqQBpu2yux6zL4kR_BdKF5fhaQ',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => ['<action>' => 'site/<action>'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.

//            'messageConfig' => [
//
//            'from' => ['usluga@cek.dp.ua' => 'usluga'],
//
//             ],

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mx.cek.dp.ua',
                'username' => 'usluga@cek.dp.ua',
                'password' => '1Qaz2Wsxcalc',
                'port' => '587',
                'encryption' => 'tls',

                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],

            ],

            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db_gv' => require(__DIR__ . '/db_gv.php'),
        'db_dn' => require(__DIR__ . '/db_dn.php'),
        'db_dnres' => require(__DIR__ . '/db_dnres.php'),
        'db_krg' => require(__DIR__ . '/db_krg.php'),
        'db_pv' => require(__DIR__ . '/db_pv.php'),
        'db_vg' => require(__DIR__ . '/db_vg.php'),
        'db_zv' => require(__DIR__ . '/db_zv.php'),
        'db_in' => require(__DIR__ . '/db_in.php'),
        'db_ap' => require(__DIR__ . '/db_ap.php'),
        'db_mysql_site'   => require(__DIR__ . '/db_mysql_site.php'),
        'db_mysql_site10'   => require(__DIR__ . '/db_mysql_site10.php'),
        'db_trz'   => require(__DIR__ . '/db_trz.php'),
        'db_askoe_test'   => require(__DIR__ . '/db_askoe_test.php'),
        'db_askoe_real'   => require(__DIR__ . '/db_askoe_real.php'),
        'db_pg_call_center'   => require(__DIR__ . '/db_pg_call_center.php'),

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ]
    ],
   // 'pdf' => [
        //'class' => Pdf::classname(),
        //'format' => Pdf::FORMAT_A4,
        //'orientation' => Pdf::ORIENT_PORTRAIT,
        //'destination' => Pdf::DEST_BROWSER,
        // refer settings section for all configuration options
   // ],
    
    'modules' => [

        'images' => [
            'class' => 'circulon\images\Module',
            // be sure, that permissions ok
            // if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 		permissions
            'imagesStorePath' => 'store', //path to origin images
            'imagesCachePath' => 'cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
            //'placeholderPath' => '@webroot/store/placeholder.png', // if you want to get placeholder when image not 		exists, string will be processed by Yii::getAlias
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
