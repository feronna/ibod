<?php

namespace app\rules\elnpt;

use Yii;
use yii\rbac\Rule;

class AdminRule extends Rule
{
    public function execute($user, $item, $params)
    {
        $query1 = \app\models\elnpt\testing\TblTestingAccess::find()
            ->where(['icno' => $user, 'access' => [1, 2]])
            ->exists();
        if ($query1) {
            $penilai = Yii::$app->session->get('user.penilai');
            if ($penilai) {
                Yii::$app->session->remove('user.penilai');
            }
            return true;
        } else {
            return false;
        }
    }
}
