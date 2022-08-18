<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_bhg_kump".
 *
 * @property int $id
 * @property int $bhg_id
 * @property int $kump_rubrik_id
 */
class TblBhgKump extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_bhg_kump';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bhg_id', 'kump_rubrik_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bhg_id' => 'Bhg ID',
            'kump_rubrik_id' => 'Kump Rubrik ID',
        ];
    }
}
