<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_ref_penyeliaan".
 *
 * @property int $id
 * @property string $penyeliaan_label
 */
class RefPenyeliaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_ref_penyeliaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penyeliaan_label'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penyeliaan_label' => 'Penyeliaan Label',
        ];
    }
}
