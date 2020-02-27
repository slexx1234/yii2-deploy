<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
namespace trntv\deploy\base;

use yii\base\Component;

class DeployComponent extends Component{
    public function getController()
    {
        return \Yii::$app->controller;
    }

    public function getIsVerbose()
    {
        return $this->getController()->verbosity;
    }
} 