<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_mrkh_det".
 *
 * @property int $id
 * @property int $lpp_id
 * @property double $k1_k2
 * @property double $k3_k4
 * @property double $k5
 * @property double $k6
 */
class TblRingkasanMarkah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_mrkh_det';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['k1_k2', 'k3_k4', 'k5', 'k6', 'sahsiah'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'k1_k2' => 'K 1 K 2',
            'k3_k4' => 'K 3 K 4',
            'k5' => 'K 5',
            'k6' => 'K 6',
            'sahsiah' => 'Sahsiah',
        ];
    }
}
