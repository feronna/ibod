<?php

namespace app\rules;

use Yii;
use yii\rbac\Rule;

class ExampleRule extends Rule
{
    public function execute($user, $item, $params)
    {
        return true;
    }
}
