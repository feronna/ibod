<?php

namespace app\models\adu;

use Yii;

/**
 * This is the model class for table "utilities.adu_ref_status".
 *
 * @property int $id
 * @property string $code
 * @property string $detail
 */
class status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.adu_ref_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'detail'], 'required'],
            [['code'], 'string', 'max' => 10],
            [['detail'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'detail' => 'Detail',
        ];
    }
}
