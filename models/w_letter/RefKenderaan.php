<?php

namespace app\models\w_letter;

use Yii;

/**
 * This is the model class for table "w_letter.ref_veh".
 *
 * @property int $id
 * @property string $name
 */
class RefKenderaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_ref_veh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
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
