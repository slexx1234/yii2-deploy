<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace trntv\deploy\base;

use yii\base\Exception;
use yii\base\Object;
use yii\console\Controller;
use yii\helpers\Console;

class Server extends DeployComponent{
    public $connection = false;

    public $phpBin = '/usr/bin/php';
    private $_channel;
    private $_session;
    private $_exec;

    public function getChannel(){
        if(!$this->_channel){
            if(is_array($this->connection) && !isset($this->connection['class'])){
                $this->connection['class'] = Connection::className();
            }
            $this->_channel = \Yii::createObject($this->connection);
        }
        return $this->_channel;
    }

    /**
     * @return \Ssh\Session
     */
    public function getSession(){
        if(!$this->_session){
            $this->_session = $this->getChannel()->getSession();
        }
        return $this->_session;
    }

    protected function getExec(){
        if(!$this->_exec){
            if($this->connection){
                $this->_exec = function($command){
                    return $this->getSession()->getExec()->run($command);
                };
            } else {
                $this->_exec = function($command){
                    return shell_exec($command);
                };
            }
        }
        return $this->_exec;
    }

    public function execute($command, $params = []){
        $command = strtr($command, $params);
        $exec = $this->getExec();
        try{
            if($this->getIsVerbose()){
                Console::output("Executing $command");
            }
            $result = $exec($command);
            if($this->getIsVerbose()){
                Console::output($result);
            }
            return $result;
        } catch(\RuntimeException $e){
            Console::error($e->getMessage());
            return false;
        }
    }
}