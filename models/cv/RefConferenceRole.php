<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.ref_conference_role".
 *
 * @property int $id
 * @property string $role
 */
class RefConferenceRole extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_conference_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
        ];
    }
}
