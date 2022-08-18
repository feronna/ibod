<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_ref_status".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property string $label
 */
class RefStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['name'], 'string', 'max' => 80],
            [['label'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'label' => 'Label',
        ];
    }
}
