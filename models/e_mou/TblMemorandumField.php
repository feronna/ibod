<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.t_emou02_field".
 *
 * @property int $field_id
 * @property int $id_memorandum
 * @property string $order_no
 * @property int $id_program
 * @property string $field_desc
 */
class TblMemorandumField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.t_emou02_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_memorandum', 'order_no', 'field_desc'], 'required'],
            [['id_memorandum', 'id_program'], 'integer'],
            [['order_no'], 'string', 'max' => 3],
            [['field_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'field_id' => 'Field ID',
            'id_memorandum' => 'Id Memorandum',
            'order_no' => 'Order No',
            'id_program' => 'Id Program',
            'field_desc' => 'Field Desc',
        ];
    }

    public function getProgram()
    {
        return $this->hasOne(RefProgramField::className(), ['program_id' => 'id_program']);
    }
}
