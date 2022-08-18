<?php

namespace app\components;

use yii\base\BaseObject;
use tebazil\runner\ConsoleCommandRunner;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dass21Report extends BaseObject implements \yii\queue\JobInterface
{
    public $query;
    public $icno;

    public function execute($queue)
    {
        $runner = new ConsoleCommandRunner();
        $runner->run('dass21/generate-report', [$this->query,  $this->icno]);
    }
}
