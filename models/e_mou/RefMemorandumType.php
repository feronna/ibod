<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou04_memorandum_type".
 *
 * @property int $memorandum_type_id
 * @property string $memorandum_type_desc
 * @property string $memorandum_type_long_desc
 */
class RefMemorandumType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou04_memorandum_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memorandum_type_desc', 'memorandum_type_long_desc'], 'required'],
            [['memorandum_type_desc'], 'string', 'max' => 45],
            [['memorandum_type_long_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'memorandum_type_id' => 'Memorandum Type ID',
            'memorandum_type_desc' => 'Memorandum Type Desc',
            'memorandum_type_long_desc' => 'Memorandum Type Long Desc',
        ];
    }
}
