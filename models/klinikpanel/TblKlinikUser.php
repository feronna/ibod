<?php

namespace app\models\klinikpanel;

use Yii;

/**
 * This is the model class for table "klinik_user".
 *
 * @property string $icno
 * @property int $user_id
 * @property string $nama_user
 * @property string $date_register
 * @property string $register_by
 * @property string $update_by
 * @property string $date_update
 * @property string $password
 * @property int $user_type
 *
 * @property TblAdminKlinik[] $tblAdminKliniks
 */
class TblKlinikUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'hrm.myhealth_klinik_user';
    }
    
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'required'],
            [['user_id', 'user_type','isUms'], 'integer'],
            [['date_register', 'date_update'], 'safe'],
            [['icno', 'register_by', 'update_by'], 'string', 'max' => 12],
            [['nama_user'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 40],
            [['icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'user_id' => 'User Klinik ID',
            'nama_user' => 'Nama User',
            'date_register' => 'Date Register',
            'register_by' => 'Register By',
            'update_by' => 'Update By',
            'date_update' => 'Date Update',
            'password' => 'Password',
            'user_type' => 'User Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblAdminKlinik()
    {
        return $this->hasMany(TblAdminKlinik::className(), ['ic_admin' => 'icno']);
    }
    
    public function getKlinik()
    {
        return $this->hasOne(RefKlinikpanel::className(), ['klinik_id' => 'user_id']);
    }
}
