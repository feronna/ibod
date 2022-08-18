<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_kilanan".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $sebab
 * @property string $cadangan
 * @property string $kilanan_dt
 */
class TblKilanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_kilanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['sebab', 'cadangan'], 'string', 'max' => 300],
            [['kilanan_dt'], 'safe'],
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
            'sebab' => 'Sebab',
            'cadangan' => 'Cadangan',
            'kilanan_dt' => 'Kilanan Dt',
        ];
    }
}
