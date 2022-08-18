<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_semak_syarat".
 *
 * @property int $id
 * @property string $icno
 * @property int $iklan_id
 * @property string $terima
 * @property string $syarat_id
 * @property string $semak_sabatikal
 * @property string $catatan_sabatikal
 * @property int $HighestEduLevelCd
 * @property string $semak_latihan
 * @property string $catatan_latihan
 * @property string $status_semakan
 * @property string $created_dt
 * @property int $tahun
 * @property int $parent_id
 * @property int $idBorang
 */
class TblSemakSyarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_semak_syarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'required'],
            [['iklan_id', 'HighestEduLevelCd', 'tahun', 'parent_id', 'idBorang'], 'integer'],
            [['catatan_sabatikal', 'catatan_latihan'], 'string'],
            [['created_dt'], 'safe'],
            [['icno'], 'string', 'max' => 14],
            [['terima'], 'string', 'max' => 10],
            [['syarat_id', 'semak_sabatikal', 'semak_latihan'], 'string', 'max' => 20],
            [['status_semakan'], 'string', 'max' => 30],
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
            'iklan_id' => 'Iklan ID',
            'terima' => 'Terima',
            'syarat_id' => 'Syarat ID',
            'semak_sabatikal' => 'Semak Sabatikal',
            'catatan_sabatikal' => 'Catatan Sabatikal',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'semak_latihan' => 'Semak Latihan',
            'catatan_latihan' => 'Catatan Latihan',
            'status_semakan' => 'Status Semakan',
            'created_dt' => 'Created Dt',
            'tahun' => 'Tahun',
            'parent_id' => 'Parent ID',
            'idBorang' => 'Id Borang',
        ];
    }
//    public function getSyarat() {
//        return $this->hasOne(RefPhd::className(), ['id' => 'syarat_id']);
//    }
    
    
     public function getStatussemakan() {
        if ($this->status_semakan == 'Dimajukan Untuk Pertimbangan UPL') {
            return '<span class="label label-success">Dibawa Ke Mesyuarat</span>';
        }
        if ($this->status_semakan == 'Dokumen Tindak Lengkap') {
            return '<span class="label label-warning">Dokumen Tidak Lengkap</span>';
        }
        if ($this->status_semakan === NULL) {
            return '-';
        }
    }
      
  
        public function getStatuss() {
       
        if ($this->status == 'DIMAJUKAN UNTUK PERTIMBANGAN UPL ') {
            return '<span class="label label-info">Dibawa Ke Mesyuarat </span>';
        }
        if ($this->status == 'DOKUMEN TIDAK LENGKAP') {
            return '<span class="label label-primary">Dokumen Tidak Lengkap</span>';
        }
        if ($this->status == '') {
            return '-';
        }
    }
    
    
    public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
    }

     public function getTahapPendidikan() {
        
        return $this->pendidikanTertinggi->HighestEduLevel;
    }
}
