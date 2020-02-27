<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace trntv\deploy\task;


class ClosureTask extends BaseTask implements TaskInterface{
    public $closure;
    public function run(){
        return call_user_func($this->closure, $this->server);
    }
} 