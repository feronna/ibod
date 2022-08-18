<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.roles".
 *
 * @property int $role_id
 * @property string $role_name
 */
class Tblrole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name','controller_id'], 'required', 'message'=>'Ruang ini adalah mandatori.'],
            [['role_name'], 'string', 'max' => 100],
            [['controller_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
        ];
    }

}
