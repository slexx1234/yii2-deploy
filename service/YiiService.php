<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
namespace trntv\deploy\service;

use trntv\deploy\base\Service;
use yii\base\Object;
use yii\di\Instance;
use yii\helpers\Console;

class YiiService extends Service{
    public $yii;
    public $options = '--interactive=0';
    public $env = 'dev';

    public function migrate($action = 'up')
    {
        Console::output('Applying migrations...');
        return $this->run('migrate', $action,  $this->options);
    }

    public function run($controller, $action, $options = null){
        return $this->server->execute(':env && :phpBin :yii :controller/:action :options', [
            ':phpBin'=>$this->server->phpBin,
            ':yii'=>$this->yii,
            ':controller'=>$controller,
            ':action'=>$action,
            ':options'=>$options.' '.$this->options,
            ':env'=>'export YII_ENV='.$this->env
        ]);
    }
} 