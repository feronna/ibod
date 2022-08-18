<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.lkk_tbl_penyelia".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama
 * @property string $emel
 * @property string $jawatan
 * @property string $password
 * @property int $access_level
 * @property string $last_login
 * @property string $last_ipaccess
 */
class TblPenyelia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.lkk_tbl_penyelia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
               [['emel', 'jawatan', 'jabatan','nama'], 'required', 'message'=>"This space is mandatory"],
            [['access_level'], 'integer'],
            [['icno', 'emel', 'jawatan', 'password','staff_icno'], 'string', 'max' => 50],
            [['nama', 'last_login', 'last_ipaccess','jabatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'nama' => 'Nama',
            'emel' => 'Emel',
            'jawatan' => 'Jawatan',
            'password' => 'Password',
            'access_level' => 'Access Level',
            'last_login' => 'Last Login',
            'last_ipaccess' => 'Last Ipaccess',
        ];
    }
}
