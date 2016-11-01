<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'b2ObPbBFXkUfb7N27O_FLIaNGIKbsy2h',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
             'db' => 'db',
             'sessionTable' => 'session',
        ],
        'cache' => [
//            'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\DbCache',
        ],
        /*'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],*/
        'user' => [
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',

            // Comment this if you don't want to record user logins
            'on afterLogin' => function($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'country',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'product',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                ],
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],

        'paypal'=> [
            'class'        => 'marciocamello\Paypal',
            'clientId'     => 'AR5dI_i7o6zydnMp3sGxD9IdDgmoBcOsrfF_iPmz38hmJ_tqlHYPPgJ_i8IoOtpxZPwIBM8Rn7HDyBmh',
            'clientSecret' => 'EIwR2GBaR_L9ISNFHCNyCLX0Z23tmHoNFxpk6MWFwigGxVAWHO2P3OLpLKVqeCklxllJGSPg0cJW4BRV',
            'isProduction' => false,
            // This is config file for the PayPal system
            'config'       => [
                'http.ConnectionTimeOut' => 30,
                'http.Retry'             => 1,
//                'mode'                   => \marciocamello\Paypal::MODE_SANDBOX, // development (sandbox) or production (live) mode
                'mode'                   => 'sandbox',
                'log.LogEnabled'         => YII_DEBUG ? 1 : 0,
                'log.FileName'           => '@runtime/logs/paypal.log',
//                'log.LogLevel'           => \marciocamello\Paypal::LOG_LEVEL_FINE,
                'log.LogLevel'           => 'FINE',
            ]
        ],
        'cm' => [ // bad abbreviation of "CashMoney"; not sustainable long-term
            'class' => 'app/components/CashMoney', // note: this has to correspond with the newly created folder, else you'd get a ReflectionError

            // Next up, we set the public parameters of the class
            'client_id' => 'AR5dI_i7o6zydnMp3sGxD9IdDgmoBcOsrfF_iPmz38hmJ_tqlHYPPgJ_i8IoOtpxZPwIBM8Rn7HDyBmh',
            'client_secret' => 'EIwR2GBaR_L9ISNFHCNyCLX0Z23tmHoNFxpk6MWFwigGxVAWHO2P3OLpLKVqeCklxllJGSPg0cJW4BRV',
            // You may choose to include other configuration options from PayPal
            // as they have specified in the documentation
        ],

    ],
    'params' => $params,
    'modules'=>[
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',

             'enableRegistration' => true,

            // Here you can set your handler to change layout for any controller or action
            // Tip: you can use this event in any module
            'on beforeAction'=>function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            },
            'on afterRegistration' => function(\webvimark\modules\UserManagement\components\UserAuthEvent $event) {
                // Here you can do your own stuff like assign roles, send emails and so on
                \webvimark\modules\UserManagement\models\User::assignRole($event->user->id, 'User');
            },
        ],
    ],
    'aliases' => [
        '@views' => dirname(__DIR__) . '/views'
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
