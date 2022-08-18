<?php

namespace app\models\cbelajar;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "hrd.lkk_tbl_penyelia".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama
 * @property string $emel
 * @property string $jawatan
 * @property string $jabatan
 * @property string $password
 * @property int $access_level
 * @property string $last_login
 * @property string $last_ipaccess
 * @property string $staff_icno
 * @property string $HighestEduLevelCd
 */
class LkkTblPenyelia extends \yii\db\ActiveRecord
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
            [['access_level'], 'integer'],
            [['icno', 'emel', 'jawatan', 'password','reportID'], 'string', 'max' => 50],
            [['nama', 'jabatan', 'last_login', 'last_ipaccess'], 'string', 'max' => 255],
            [['staff_icno'], 'string', 'max' => 12],
            [['HighestEduLevelCd'], 'string', 'max' => 11],
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
            'jabatan' => 'Jabatan',
            'password' => 'Password',
            'access_level' => 'Access Level',
            'last_login' => 'Last Login',
            'last_ipaccess' => 'Last Ipaccess',
            'staff_icno' => 'Staff Icno',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno']);
    }
    public function getPenyelia()
    {
        return $this->hasOne(\app\models\system_core\ExternalUser::className(), ['username' => 'emel']);
    }
     public function getSvsem()
    {
        return $this->hasOne(TblLkk::className(), ['reportID' => 'reportId']);
    }
    public function getPengajian() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'staff_icno'])->where(['cb_tbl_pengajian.status'=>[1,4,2]])
                ->orderBy(['cb_tbl_pengajian.tarikh_mula'=>SORT_DESC]);
       
   }
   public function getBiasiswa() {
       
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'staff_icno'])->where(['cb_tbl_biasiswa.status'=>1]);
       
   }
   
   public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }
}
