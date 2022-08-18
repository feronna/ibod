<?php

namespace app\models\cbelajar;

use Yii;

class TblNilaiSyarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_nilai_syarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'required'],
            [[ 'HighestEduLevelCd'], 'integer'],
            [['created_dt'], 'safe'],
            [['catatan_phd', 'catatan_doktoral'], 'string'],
            [['icno'], 'string', 'max' => 14],
            [['terima'], 'string', 'max' => 10],
            [['semak_phd', 'semak_doktoral', 'syarat_id'], 'string', 'max' => 20],
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
            'created_dt' => 'Created Dt',
            'terima' => 'Terima',
            'catatan_phd' => 'Catatan PHD',
            'semak_phd' => 'Semak PHD',
            'catatan_doktoral' => 'Catatan Doktoral',
            'semak_doktoral' => 'Semak Doktoral',
            'syarat_id' => 'Syarat ID',
            'HighestEduLevelCd' => 'HighestEduLevelCd',
        ];
    }
       
    public function getSyarat() {
        return $this->hasOne(RefPhd::className(), ['id' => 'syarat_id']);
    }
    
    
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
    
    
   
    
    

