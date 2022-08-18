<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_seksyen".
 *
 * @property int $id
 * @property string $seksyen
 * @property int $parent
 * @property int $isActive
 * @property int $campus
 */
class PatrolRefSeksyen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_seksyen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'isActive', 'campus'], 'integer'],
            [['seksyen'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seksyen' => 'Seksyen',
            'parent' => 'Parent',
            'isActive' => 'Is Active',
            'campus' => 'Campus',
        ];
    }
}
