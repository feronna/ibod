<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_bhg_rubrik".
 *
 * @property int $id
 * @property int $rubrik_id
 * @property int $kump_rubrik_id
 * @property double $peratus
 */
class TblBhgRubrik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_bhg_rubrik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rubrik_id', 'kump_rubrik_id'], 'integer'],
            [['peratus'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rubrik_id' => 'Rubrik ID',
            'kump_rubrik_id' => 'Kump Rubrik ID',
            'peratus' => 'Peratus',
        ];
    }
}
