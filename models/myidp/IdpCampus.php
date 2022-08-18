<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "idp.campus".
 *
 * @property int $campus_id
 * @property string $campus_name
 */
class IdpCampus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.campus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campus_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'campus_id' => 'Campus ID',
            'campus_name' => 'Campus Name',
        ];
    }
}
