<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
namespace trntv\deploy\base;

use yii\base\Object;

class Task extends DeployComponent{
    public $id;
    public $closure;

    public function run($container, $controller){
        return call_user_func($this->closure, $container, $controller, $this);
    }
}