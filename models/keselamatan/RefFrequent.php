<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_frequent".
 *
 * @property int $id
 * @property string $name
 */
class RefFrequent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_frequent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
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
