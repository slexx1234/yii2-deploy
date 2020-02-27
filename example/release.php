<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
use yii\helpers\Console;

return [
    'tasks'=>[
        /*'clone'=>function($container, $task, $controller){
            $git = $container->get('services.git');
            $git->server = $container->get('servers.local');
            $commit = $git->getRemoteLastCommit();
            $git->cloneTo('/tmp/'.$commit);
        },*/
        'pull'=>function($container, $task, $controller){
            $git = $container->get('git');
            $git->server = $container->get('servers.local');
            Console::output('Latest commit is: '.$git->getRemoteLastCommit());
            $git->reset();
            $git->pull();
        },
        'composer'=>function($container, $task, $controller){
            $composer = $container->get('services.composer');
            $composer->server = $container->get('servers.local');
            $composer->download();
            $composer->install();
        },
        /*'migrate'=>function($container, $task, $controller){
            $yii = $container->get('services.yii');
            $yii->server = $container->get('services.local');
            $yii->migrate();
        },*/
    ],
    'services'=>[
        'git'=>[
            'class'=>\trntv\deploy\service\GitService::className(),
            'repositoryUrl'=>'https://github.com/trntv/yii2-deploy.git',
            'repositoryPath'=>'/tmp/yii2-deploy',
        ],
        'composer'=>[
            'class'=>\trntv\deploy\service\ComposerService::className(),
            'path'=>'/tmp/yii2-deploy',
            'composer'=>'composer.phar',
        ],
        'yii'=>[
            'class'=>\trntv\deploy\service\YiiService::className(),
            'yii'=>'//tmp/yii2-deploy/yii'
        ]
    ]
];
