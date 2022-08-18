<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_external_user".
 *
 * @property int $id
 * @property string $user_id auto generate 'UMSUSER001' pengganti utk ICNO (GetID pakai ni)
 * @property string $name
 * @property string $username
 * @property string $pwsd
 * @property string $last_login
 * @property string $last_ipaccess
 * @property string $modul_url ni utk redirect ke specific modul (contoh cuti belajar)
 * @property string $create_by icno - siapa yang kasi register
 * @property string $create_dt register bila (datetime)
 * @property string $update_by icno - siapa yang kasi update detail
 * @property string $update_dt update bila (datetime)
 */
class ExternalUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_external_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_dt', 'update_dt'], 'safe'],
            [['user_id'], 'string', 'max' => 100],
                        [['access'], 'integer'],

            [['terima'], 'string', 'max' => 100],
            [['name', 'username', 'pwsd', 'last_login', 'last_ipaccess', 'return_url'], 'string', 'max' => 255],
            [['create_by', 'update_by'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'username' => 'Username',
            'pwsd' => 'Pwsd',
            'last_login' => 'Last Login',
            'last_ipaccess' => 'Last Ipaccess',
            'return_url' => 'Return Url',
            'create_by' => 'Create By',
            'create_dt' => 'Create Dt',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
        ];
    }

    public function getCOOPass(){
        return $this->pwsd;
    }

    public function getCOOldID(){
        return $this->user_id;
    }

    public function getICNO() {
        return $this->user_id;
    }
      public function getPenyelia()
    {
        return $this->hasOne(\app\models\cbelajar\TblPengajian::className(), ['emel' => 'user_id']);
    }
//    public function getKakitangan() {
//        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
//    }
}
