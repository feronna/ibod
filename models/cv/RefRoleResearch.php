<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.ref_research_role".
 *
 * @property int $id
 * @property string $role
 */
class RefRoleResearch extends \yii\db\ActiveRecord
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
        return 'hrm.cv_ref_role_research';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role','role_bm'], 'string', 'max' => 30],
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
