<?php

namespace app\models\utilities\epos;

use Yii;

/**
 * This is the model class for table "utilities.pos_ref_akses".
 *
 * @property int $id
 * @property string $access_level
 */
class RefAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.pos_ref_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['access_level'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_level' => 'Access Level',
        ];
    }
}
