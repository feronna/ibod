<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_ref_roles".
 *
 * @property id $id
 * @property string $role_name
 * @property string $detail
 */
class RefRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_ref_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'role_name' => 'Role Name',
            'detail' => 'Detail',
        ];
    }

    public static function RoleName($id){
        return self::find()->where(['id'=>$id])->one() ? self::find()->where(['id'=>$id])->one()->role_name : null;
    }
}
