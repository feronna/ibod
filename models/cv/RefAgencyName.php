<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_ref_agency}}".
 *
 * @property int $id
 * @property string $name
 */
class RefAgencyName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.cv_ref_agency}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 300],
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
        ];
    }
}
