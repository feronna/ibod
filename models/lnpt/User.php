<?php

namespace app\models\lnpt;

use Yii;
use app\models\lnpt\markah;

/**
 * This is the model class for table "elnpt.user".
 *
 * @property int $staff_id
 * @property string $user_id
 * @property string $pwd
 * @property string $nama_staf
 * @property string $no_ums_per
 * @property string $email
 * @property string $jawatan
 * @property string $kod
 * @property string $taraf_jawatan
 * @property int $jabatan
 * @property string $program
 * @property string $gred_gaji
 * @property int $access
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'elnpt.user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan', 'access'], 'integer'],
            [['user_id'], 'string', 'max' => 12],
            [['pwd'], 'string', 'max' => 255],
            [['nama_staf'], 'string', 'max' => 150],
            [['no_ums_per'], 'string', 'max' => 15],
            [['email', 'jawatan', 'program'], 'string', 'max' => 100],
            [['kod'], 'string', 'max' => 6],
            [['taraf_jawatan'], 'string', 'max' => 30],
            [['gred_gaji'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'Staff ID',
            'user_id' => 'User ID',
            'pwd' => 'Pwd',
            'nama_staf' => 'Nama Staf',
            'no_ums_per' => 'No Ums Per',
            'email' => 'Email',
            'jawatan' => 'Jawatan',
            'kod' => 'Kod',
            'taraf_jawatan' => 'Taraf Jawatan',
            'jabatan' => 'Jabatan',
            'program' => 'Program',
            'gred_gaji' => 'Gred Gaji',
            'access' => 'Access',
        ];
    }
    
     public function getMarkah() {
        return $this->hasOne(markah::className(), ['staff_id' => 'staff_id']);
    }
}
