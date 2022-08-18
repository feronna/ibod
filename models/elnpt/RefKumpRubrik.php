<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_kump_rubrik".
 *
 * @property int $id
 * @property string $kump_rubrik
 */
class RefKumpRubrik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_kump_rubrik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_rubrik'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kump_rubrik' => 'Kump Rubrik',
        ];
    }
}
