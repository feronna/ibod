<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_access_type".
 *
 * @property int $id
 * @property string $access_type
 * @property int $access_level
 */
class Refaccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_access_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'access_level'], 'integer'],
            [['access_type'], 'string', 'max' => 50],
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
            'access_type' => 'Access Type',
            'access_level' => 'Access Level',
        ];
    }
    public function getAkses()
    {
        return $this->hasOne(Refaccess::className(), ['access_level' => 'admin_post']);
//        return $this->hasOne(Refaccess::className(), ['admin_post' => 'access_level']);

    }
}
