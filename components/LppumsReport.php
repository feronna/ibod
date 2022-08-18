<?php

namespace app\components;

use yii\base\BaseObject;
use tebazil\runner\ConsoleCommandRunner;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LppumsReport extends BaseObject implements \yii\queue\JobInterface
{
    public $jfpiu;
    public $tahun;
    public $icno;
    public $range;
    public $purata;

    public function execute($queue)
    {
        $runner = new ConsoleCommandRunner();
        $runner->run('lppums/generate-laporan', [$this->jfpiu, $this->tahun, $this->range, $this->purata, $this->icno]);
    }
}
