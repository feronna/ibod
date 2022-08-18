<?php

namespace app\components;

use yii\base\BaseObject;
use tebazil\runner\ConsoleCommandRunner;

class ElnptFixMarkah extends BaseObject implements \yii\queue\JobInterface
{
    public $tahun;

    public function execute($queue)
    {
        $runner = new ConsoleCommandRunner();
        $runner->run('elnpt/fix-markah-bhg', [$this->tahun]);
    }
}
