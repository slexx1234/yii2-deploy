<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */
namespace trntv\deploy\service;

use trntv\deploy\base\Service;
use yii\base\Object;
use yii\di\Instance;
use yii\helpers\Console;

class GitService extends Service{
    public $repositoryPath;
    public $repositoryUrl;
    public $remote = 'origin';
    public $branch = 'master';


    public function cloneTo($to = false)
    {
        Console::output("Cloning repository {$this->repositoryUrl}...");
        return $this->server->execute('git clone :repositoryUrl :to', [
            ':repositoryUrl'=>$this->repositoryUrl,
            ':to'=>$to
        ]);
    }

    public function reset(){
        return $this->server->execute('cd :repositoryPath && git reset --hard HEAD', [
            ':repositoryPath'=>$this->repositoryPath
        ]);
    }

    public function pull(){
        Console::output("Updating repository...");
        return $this->server->execute('cd :repositoryPath && git pull :remote :branch', [
            ':repositoryPath'=>$this->repositoryPath,
            ':remote'=>$this->remote,
            ':branch'=>$this->branch
        ]);
    }

    public function getRemoteLastCommit()
    {
        $commit = $this->server->execute('git ls-remote :repositoryUrl :branch | grep refs/heads/master | cut -f 1', [
            ':repositoryUrl'=>$this->repositoryUrl,
            ':branch'=>$this->branch
        ]);
        $commit = trim($commit);
        return $commit;
    }
}