<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_aspek_penilaian".
 *
 * @property int $id
 * @property int $bhg_no
 * @property string $aspek
 */
class RefAspekPenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_aspek_penilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bhg_no'], 'integer'],
            [['aspek'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bhg_no' => 'Bhg No',
            'aspek' => 'Aspek',
        ];
    }
}
