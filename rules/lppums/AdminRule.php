<?php

namespace app\rules\lppums;

use Yii;
use yii\rbac\Rule;

class AdminRule extends Rule
{
    public function execute($user, $item, $params)
    {
        $query = \app\models\lppums\TblStafAkses::find()
            ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
            ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
            //                                   ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
            ->one();
        if (!is_null($query)) {

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
