<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_tbl_mrkh_bhg".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $bhg_id
 * @property double $markah
 */
class TblMrkhBhg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_tbl_mrkh_bhg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'bhg_id'], 'integer'],
            [['markah'], 'number'],
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
            'bhg_id' => 'Bhg ID',
            'markah' => 'Markah',
        ];
    }

    public function getSum()
    {
        return $this->find()->where(['lpp_id' => $this->lpp_id])->sum('markah');
    }
}
