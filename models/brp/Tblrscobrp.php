<?php

namespace app\models\brp;
use app\models\hronline\GredJawatan;
use Yii;
use app\models\hronline\Pensionstatus;
use app\models\hronline\Tblprcobiodata;
use app\models\brp\Brp;
use app\models\gaji\TblStaffRoc;
use app\models\gaji\TblStaffRocBatch;
use app\models\gaji\TblStaffRocBatchSmbu;
use app\models\vhrms\ViewPayroll;
/**
 * This is the model class for table "brp.tblrscobrp".
 *
 * @property int $brp_id
 * @property string $icno
 * @property string $brpCd
 * @property string $remark
 * @property int $jawatan_id
 * @property string $tarikh_mulai
 * @property string $tarikh_hingga
 * @property string $tarikh_lulus Untuk Induksi Sahaja
 * @property string $rujukan_surat
 * @property string $tarikh_surat
 * @property int $isPencen 0=Tidak Pencen, 1=Pencen, 2=Terbuka
 * @property string $gaji_sebulan
 * @property int $status 0=Belum Disemak, 1=Telah Disemak
 * @property string $status_date Tarikh Disemak
 * @property string $status_update_by
 * @property int $sah 0=Belum Sah, 1=Sah
 * @property string $sah_date Tarikh Disahkan
 * @property string $sah_by
 * @property string $t_lpg_id
 * @property string $data_source
 * @property string $insert_date
 * @property string $insert_id
 * @property string $last_update
 * @property string $update_by
 */
class Tblrscobrp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.brp_tblrscobrp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remark'], 'string'],
            [['jawatan_id', 'isPencen', 'status', 'sah', 't_lpg_id'], 'integer'],
            [['tarikh_mulai', 'tarikh_hingga', 'tarikh_lulus', 'tarikh_surat', 'status_date', 'sah_date', 'insert_date', 'last_update'], 'safe'],
            [['gaji_sebulan'], 'number'],
            [['icno', 'status_update_by', 'sah_by', 'insert_id', 'update_by'], 'string', 'max' => 12],
            [['brpCd'], 'string', 'max' => 11],
            [['rujukan_surat'], 'string', 'max' => 100],
            [['data_source'], 'string', 'max' => 50],
            [['brpCd', 'remark', 'jawatan_id','isPencen'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'brp_id' => 'Brp ID',
            'icno' => 'Icno',
            'brpCd' => 'Brp Cd',
            'remark' => 'Remark',
            'jawatan_id' => 'Jawatan ID',
            'tarikh_mulai' => 'Tarikh Mulai',
            'tarikh_hingga' => 'Tarikh Hingga',
            'tarikh_lulus' => 'Tarikh Lulus',
            'rujukan_surat' => 'Rujukan Surat',
            'tarikh_surat' => 'Tarikh Surat',
            'isPencen' => 'Is Pencen',
            'gaji_sebulan' => 'Gaji Sebulan',
            'status' => 'Status',
            'status_date' => 'Status Date',
            'status_update_by' => 'Status Update By',
            'sah' => 'Sah',
            'sah_date' => 'Sah Date',
            'sah_by' => 'Sah By',
            't_lpg_id' => 'T Lpg ID',
            'data_source' => 'Data Source',
            'insert_date' => 'Insert Date',
            'insert_id' => 'Insert ID',
            'last_update' => 'Last Update',
            'update_by' => 'Update By',
        ];
    }
    
    
     public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_id']);
    }
    
     public function getPencen() {
        return $this->hasOne(Pensionstatus::className(), ['isPencen' => 'PsnStatusCd']);
    }
  
      public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
      public function getGredJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_id']);
    }
    
    
    public function getJenisBrp() {
        return $this->hasOne(Brp::className(), ['brpCd' => 'brpCd']);
    }
          public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    public function getTarikhMulai() {
        return  $this->getTarikh($this->tarikh_mulai);
    }
    
    public function getTarikhSurat() {
       return  $this->getTarikh($this->tarikh_surat);
    }
    
     public function getTarikhHingga() {
        return  $this->getTarikh($this->tarikh_hingga);
    }
    
    
    
          public function getGajiSebulan() {
          $roc = TblStaffRocBatchSmbu::find()->where(['srb_batch_code' => $this->t_lpg_id])->one();
          $echo_model = NULL;
          $echo_model.= '<table class="tbl-with-border">';
          
   //       if($roc->staffRoc->SR_CHANGE_TYPE == 'CHANGE_ENDDATE'){
          foreach($roc->staffRoc2 as $sroc) {
              if($sroc->SR_CHANGE_TYPE == 'CHANGE_ENDDATE'){         
	          $echo_model.= '<tr><td style=" width:30%; height:auto ;font-size:220%; "><b>'.$sroc->jenisGaji->it_income_desc.'</b></td><td style="font-size:220%; width:30%; height:auto;"><b>'.$sroc->SR_OLD_VALUE.'</td></tr>';
            }else{
                 $echo_model.= '<tr><td style=" width:30%; height:auto ;font-size:220%; "><b>'.$sroc->jenisGaji->it_income_desc.'</b></td><td style="font-size:220%; width:30%; height:auto;"><b>'.$sroc->SR_NEW_VALUE.'</td></tr>';
   
            }
                  
         }
            if($roc->staffRocOne->SR_CHANGE_TYPE == 'CHANGE_ENDDATE'){   
                  if($roc->staffRoc2 != null){
                          $echo_model.= '<tr><td style=" width:30%; height:auto; font-size:220%; "><b>JUMLAH</b></td><td style="font-size:220%; width:30%; height:auto; "><b>'.$roc->sumOld.'</b></td></tr>';     
                  }
            }else{
                   if($roc->staffRoc2 != null){
                          $echo_model.= '<tr><td style=" width:30%; height:auto; font-size:220%; "><b>JUMLAH</b></td><td style="font-size:220%; width:30%; height:auto; "><b>'.$roc->sumNew.'</b></td></tr>';     
                  }
            }
			
                $echo_model.= '</table>';
                
		return $echo_model;
         }
        
           
      public function getGajiSebulan2() {
          $roc = TblStaffRocBatchSmbu::find()->where(['srb_batch_code' => $this->t_lpg_id])->one();
          $echo_model = NULL;
          $echo_model.= '<table class="tbl-with-border">';
          
		 foreach($roc->staffRoc2 as $sroc) {
                if($sroc->SR_CHANGE_TYPE == 'CHANGE_ENDDATE'){  
	          $echo_model.= '<tr><td style="background-color:#ccc; width:50%; height:20%;font-size:100%; padding-right: 20px; padding-top:20px; padding-bottom: 20px; padding-left: 20px;"><b>'.$sroc->jenisGaji->it_income_desc.'</b></td><td style="font-size:100%; padding-right: 20px; width:50%; height:20%;padding-bottom: 20px;  padding-top:20px; padding-left: 20px;">'.$sroc->SR_OLD_VALUE.'</td></tr>';
	       }else{
                  $echo_model.= '<tr><td style="background-color:#ccc; width:50%; height:20%;font-size:100%; padding-right: 20px; padding-top:20px; padding-bottom: 20px; padding-left: 20px;"><b>'.$sroc->jenisGaji->it_income_desc.'</b></td><td style="font-size:100%; padding-right: 20px; width:50%; height:20%;padding-bottom: 20px;  padding-top:20px; padding-left: 20px;">'.$sroc->SR_NEW_VALUE.'</td></tr>';
	        
               }
             }
             
             if($roc->staffRocOne->SR_CHANGE_TYPE == 'CHANGE_ENDDATE'){   
                          if($roc->staffRoc2 != null){
                          $echo_model.= '<tr><td style="background-color:#ccc; width:50%; height:20%;font-size:100%; padding-right: 20px; padding-top:20px;  padding-bottom: 20px; padding-left: 20px;"><b>JUMLAH</b></td><td style="font-size:100%; padding-right: 20px; padding-bottom: 20px;width:50%; height:20%;  padding-top:20px; padding-left: 20px;"><b>'.$roc->sumOld.'</b></td></tr>';     
                          }
             }else{
                   if($roc->staffRoc2 != null){
                          $echo_model.= '<tr><td style="background-color:#ccc; width:50%; height:20%;font-size:100%; padding-right: 20px; padding-top:20px;  padding-bottom: 20px; padding-left: 20px;"><b>JUMLAH</b></td><td style="font-size:100%; padding-right: 20px; padding-bottom: 20px;width:50%; height:20%;  padding-top:20px; padding-left: 20px;"><b>'.$roc->sumNew.'</b></td></tr>';     
                          }
             }

			
			$echo_model.= '</table>';
                
		return $echo_model;
	}
        

          public function getGajiSebulanBrp() {
          $echo_model = NULL;
          $gajiBrp = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->kakitangan->COOldID])->andWhere(['MPH_PAY_MONTH' => \Yii::$app->formatter->asDate($this->tarikh_mulai, 'yyyyMM')])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','E'], ['like', 'MPDH_INCOME_CODE','B'], ['like', 'MPDH_INCOME_CODE','F']])->all();
          $gaji = \app\models\gaji\Tblrscoelaun::find()->where(['el_lpg_id' => $this->t_lpg_id])->all();
          $echo_model.= '<table class="ttable table-sm table-bordered jambo_table table-striped">';
          
          if($gajiBrp != null){
                 foreach ($gaji as $items){
                             $echo_model.= '<tr><td style="background-color:#ccc ; font-size:100%; "><b>'.$items->el_elaun_cd.'</b></td><td style="background-color:#FFFFFF ; font-size:100%; ">'.$items->el_amount.'</td></tr>';
                            }
          }
          else{
             foreach ($gaji as $items){
                             $echo_model.= '<tr><td style="background-color:#ccc ; font-size:100%; "><b>'.$items->el_elaun_cd.'</b></td><td style="background-color:#FFFFFF ; font-size:100%; ">'.$items->el_amount.'</td></tr>';
                            }
          }
          
			$echo_model.= '</table>';
                
		return $echo_model;
	}
        
        

        
}

