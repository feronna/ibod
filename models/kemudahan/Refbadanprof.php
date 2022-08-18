<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_badanprof".
 *
 * @property int $id
 * @property string $badanprof
 * @property int $isActive
 */
class Refbadanprof extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_badanprof';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['badanprof'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'badanprof' => 'Badanprof',
            'isActive' => 'Is Active',
        ];
    }
}
