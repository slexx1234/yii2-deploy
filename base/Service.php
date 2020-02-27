<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace trntv\deploy\base;


use trntv\deploy\controllers\DeployController;
use yii\base\Object;

/**
 * Class Service
 * @property $server \trntv\deploy\base\Server
 *
 * @package trntv\deploy\service
 */
class Service extends DeployComponent{
    public $_server;

    public function setServer($server)
    {
        $this->_server = $server;
        return $this;
    }

    public function getServer()
    {
        return $this->_server;
    }
} 