<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
namespace trntv\deploy\service;

use trntv\deploy\base\Service;
use yii\base\Object;
use yii\di\Instance;
use yii\helpers\Console;

class ComposerService extends Service{
    public $path;
    public $composer;
    public $defaultOptions = [
        '--optimize-autoloader'
    ];
    public function install($dev = true, $options = [])
    {
        Console::output('Installing composer packages...');
        return $this->server->execute('cd :path && :phpBin :composer install --prefer-dist :no-dev :options', [
            ':path'=>$this->path,
            ':phpBin'=>$this->server->phpBin,
            ':composer'=>$this->composer,
            ':no-dev'=>$dev ? null : '--no-dev',
            ':options'=>implode(' ', array_merge(
                $this->defaultOptions,
                $options
            ))
        ]);
    }

    public function update($dev = true, $options = [])
    {
        Console::output('Updating composer packages...');
        return $this->server->execute('cd :path && :phpBin :composer update --prefer-dist :no-dev :options', [
            ':path'=>$this->path,
            ':phpBin'=>$this->server->phpBin,
            ':composer'=>$this->composer,
            ':no-dev'=>$dev ? null : '--no-dev',
            ':options'=>implode(' ', array_merge(
                $this->defaultOptions,
                $options
            ))
        ]);
    }

    public function download(){
        Console::output('Downloading composer...');
        return $this->server->execute('cd :path && :phpBin -r "readfile(\'https://getcomposer.org/installer\');" | :phpBin -- --filename=:composer', [
            ':path'=>$this->path,
            ':phpBin'=>$this->server->phpBin,
            ':composer'=>$this->composer
        ]);
    }
} 