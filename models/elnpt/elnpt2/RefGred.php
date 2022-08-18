<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_gred".
 *
 * @property int $id
 * @property string $kump_gred
 */
class RefGred extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_gred';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_gred'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kump_gred' => 'Kump Gred',
        ];
    }
}
