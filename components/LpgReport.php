<?php
namespace app\components;

use yii\base\BaseObject;
use tebazil\runner\ConsoleCommandRunner;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LpgReport extends BaseObject implements \yii\queue\JobInterface
{
    public $month;
    public $year;
    public $icnooo;
    
    public function execute($queue)
    {
        $runner = new ConsoleCommandRunner();
        $runner->run('saraan/lpg', [$this->month, $this->year, $this->icnooo]);
    }
}