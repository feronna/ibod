<?php

namespace app\rules\lppums;

use Yii;
use yii\rbac\Rule;

class GeneralRule extends Rule
{
    public function execute($user, $item, $params)
    {
        return !Yii::$app->user->isGuest;//all staff can masuk
    }
}
