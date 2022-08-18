<?php

namespace app\rules;

use Yii;
use yii\rbac\Rule;

class AdminRule extends Rule
{
    public function execute($user, $item, $params)
    {
        $query1 = \app\models\system_core\TblUserAccess::find()
            ->where(['icno' => $user, 'access' => 1])
            ->exists();
        if ($query1) {
            return true;
        } else {
            return false;
        }
    }
}
