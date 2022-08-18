<?php

namespace app\models\system_core;

use Yii;
use app\models\Tblrole;
use app\models\Tblpermission;

/**
 * This is the model class for table "system_core.role_perm".
 *
 * @property int $role_id
 * @property int $perm_id
 */
class Tblrolepermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.role_perm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'perm_id'], 'required'],
            [['role_id', 'perm_id'], 'integer'],
            [['role_id', 'perm_id'], 'unique', 'targetAttribute'=>['role_id', 'perm_id'],'message'=>'Permission sudah wujud'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'perm_id' => 'Perm ID',
        ];
    }
    
    public function getRoleName() {
        return $this->hasOne(Tblrole::className(), ['role_id' => 'role_id']);
    }
    
    public function getPermDesc() {
        return $this->hasOne(Tblpermission::className(), ['perm_id' => 'perm_id']);
    }
}
