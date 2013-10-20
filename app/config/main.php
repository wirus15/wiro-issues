<?php

/**
 *
 * main.php configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
defined('APP_CONFIG_NAME') or define('APP_CONFIG_NAME', 'main');

return array(
    'aliases' => array(),
    'import' => array(
        'bootstrap.helpers.TbHtml',
    ),
    'preload' => array(
        'bootstrap',
        'config',
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
            'fontAwesomeCss' => true,
        ),
        'clientScript' => array(
            'packages' => require(__DIR__ . '/../lib/vendor/wirus15/yii-wiro/assets/packages.php'),
        ),
        'upload' => array(
            'class' => 'wiro\components\UploadManager',
        ),
        'thumb' => array(
            'class' => 'wiro\components\image\ThumbnailCreator',
        ),
        'less' => array(
            'class' => 'wiro\components\less\LessCompiler',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '.html',
            'rules' => array(
                'login' => '/user/login/login',
                'logout' => '/user/login/logout',
                'page/<id:\w+>' => '/site/page',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login/login'),
        ),
    ),
    'modules' => array(
        'user' => array(
            'class' => 'wiro\modules\users\UserModule',
            //'allowRegistration' => true,
            //'accountActivation' => wiro\modules\users\UserModule::USER_ACTIVATION,
            //'defaultController' => 'user',
        ),
        'pages' => array(
            'class' => 'wiro\modules\pages\PagesModule',
        ),
        'config' => array(
            'class' => 'wiro\modules\config\ConfigModule',
        ),
    ),
    'params' => array(),
);