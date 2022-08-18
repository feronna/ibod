<?php

namespace app\models\cbelajar;



use Yii;
use app\models\cbelajar\TblTajaan;
use app\models\cbelajar\TblBantuan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
/**
 * This is the model class for table "cbelajar.tbl_biasiswa".
 *
 * @property int $id
 * @property string $icno
 * @property int $jenisCd
 * @property string $bentukBantuan Bentuk Bantuan
 * @property string $nama_tajaan Nama Tajaan
 * @property string $amaunBantuan Amaun
 * @property int $statusUMS
 */
class TblBiasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $agree;
    public static function tableName()
    {
        return 'hrd.cb_tbl_biasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'iklan_id', 'jenisCd', 'BantuanCd', 'idBorang', 'idPermohonan', 'HighestEduLevelCd', 'status_form'], 'integer'],
            [['icno'], 'required'],
            [['created_dt'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['bentukBantuan'], 'string', 'max' => 100],
            [['CountryCd','c_tajaan', 'nama_tajaan', 'amaunBantuan', 'dt_stajaan', 'dt_ntajaan', 'lanjut_biasiswa', 't_tajaan'], 'string', 'max' => 255],
            [['statusUMS'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'icno' => 'Icno',
            'iklan_id' => 'Iklan ID',
            'jenisCd' => 'Jenis Cd',
            'bentukBantuan' => 'Bentuk Bantuan',
            'BantuanCd' => 'Bantuan Cd',
            'CountryCd' => 'Country Cd',
            'nama_tajaan' => 'Nama Tajaan',
            'amaunBantuan' => 'Amaun Bantuan',
            'statusUMS' => 'Status Ums',
            'created_dt' => 'Created Dt',
            'idBorang' => 'Id Borang',
            'idPermohonan' => 'Id Permohonan',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'status_form' => 'Status Form',
            't_tajaan' => 'TEMPOH TAJAAN',
        ];
    }
    
 public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
     public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'icno']);
    }
     public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }
    public function getTajaan() {
        return $this->hasOne(TblTajaan::className(), ['jenisCd'=>'jenisCd']);
    }
     public function getPenajaan() {
        return $this->hasOne(RefPenajaan::className(), ['id'=>'jenisCd']);
    }
     public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }

   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
public function getPengajian() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
   
//   public function getElaun() {
//       
//        return $this->hasMany(TblElaunLulus::className(), ['bID' => 'id']);
//       
//   }
   public function getElaun() {
       
        return $this->hasOne(TblElaunLulus::className(), ['icno' => 'icno']);
       
   }
    public function getDuit() {
       
        return $this->hasMany(TblElaun::className(), ['bID' => 'id']);
       
   }
    public function getDuit1() {
       
        return $this->hasMany(TblElaun::className(), ['icno' => 'icno']);
       
   }
   public function getSt() {
       
        return $this->hasMany(TblPengajian::className(), ['userID' => 'id']);
       
   }
    public function getE() {
       
        return $this->hasOne(TblElaunLulus::className(), ['bID' => 'id']);
       
   }
   public function getLanjutan() {
        return $this->hasMany(TblLanjutan::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd']);
    }
    public function getEl() {
       
        return $this->hasOne(\app\models\cbelajar\TblElaun::className(), ['bID' => 'id']);
       
   }
   
   
   
   public function getBiasiswa() {
       
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
    public function getBantuan() {
        return $this->hasOne(TblBantuan::className(), ['BantuanCd'=>'BantuanCd']);
    }
    
    
     public function getSponsor() {
        return $this->hasOne(RefBantuan::className(), ['BantuanCd'=>'BantuanCd']);
    }
}
