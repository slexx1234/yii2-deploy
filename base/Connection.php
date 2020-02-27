<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace trntv\deploy\base;

use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\Object;
use yii\helpers\ArrayHelper;

// todo: errors
class Connection extends Object{
    /**
     * @see Ssh\Configuration or Ssh\SshConfigFileConfiguration
     * @var array
     */
    public $configuration;

    /**
     * @see Ssh\Authentication
     * @var array
     */
    public $authentication;

    private $_session;

    public function init(){
        $this->configuration['class'] = isset($this->configuration['class']) ? $this->configuration['class'] : 'Ssh\Configuration';
        list($configurationClass, $configurationConfig) = $this->normalizeConfiguration($this->configuration);
        $configuration = \Yii::createObject($configurationClass, array_values($configurationConfig));

        $this->authentication['class'] = isset($this->authentication['class']) ? $this->authentication['class'] : 'Ssh\Authentication\None';
        list($authenticationClass, $authenticationConfig) = $this->normalizeConfiguration($this->authentication);
        $authentication = \Yii::createObject($authenticationClass, array_values($authenticationConfig));

        $this->_session = new \Ssh\Session($configuration, $authentication);
    }

    /**
     * @return \Ssh\Session
     */
    public function getSession(){
        return $this->_session;
    }

    protected function normalizeConfiguration($config){
        $class = isset($config['class']) ? $config['class'] : false;
        if(!$class){
            throw new InvalidParamException('Config should have a "class" property');
        }
        unset($config['class']);
        $params = (new \ReflectionClass($class))->getConstructor()->getParameters();
        $params = ArrayHelper::getColumn($params, 'name');
        uksort($config, function($a, $b) use($params){
            return array_search($a, $params) > array_search($b, $params) ? 1 : -1;
        });
        return [$class, $config];
    }
} 