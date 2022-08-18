<?php
namespace app\components;

use yii\base\BaseObject;
use tebazil\runner\ConsoleCommandRunner;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LppumsApcReport extends BaseObject implements \yii\queue\JobInterface
{
    public $query;
    public $tahun;
    public $icno;
    
    public function execute($queue)
    {
        $runner = new ConsoleCommandRunner();
        $runner->run('lppums/generate-laporan-apc', [$this->query, $this->tahun, $this->icno]);
    }
}