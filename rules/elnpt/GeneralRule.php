<?php

namespace app\rules\elnpt;

use Yii;
use yii\rbac\Rule;

class GeneralRule extends Rule
{
    public function execute($user, $item, $params)
    {
        $query = \app\models\elnpt\TblMain::find()
            ->where(['lpp_id' => Yii::$app->request->get('lppid')])
            ->andWhere([
                'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                ['PPK' => Yii::$app->user->identity->ICNO], ['PEER' => Yii::$app->user->identity->ICNO]
            ])
            ->andWhere(['tahun' => 2019])
            ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
            ->exists();

        if ($query) {
            return true;
        } else {
            throw false;
        }
    }
}
