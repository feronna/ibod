<?php

namespace app\models\system_core;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "system_core.user_role".
 *
 * @property int $user_id
 * @property int $role_id
 */
class Tbluserrole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['role_id'], 'integer', 'message'=>'Hanya nombor sahaja'],
            [['user_id'], 'trim'],
            [['user_id', 'role_id'],'unique','targetAttribute'=>['user_id', 'role_id'],'message'=>'No K/P sudah wujud'],
            [['controller_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
        ];
    }
    
    public function getUserBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'user_id']);
    }
}
