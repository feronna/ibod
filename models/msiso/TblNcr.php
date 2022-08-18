<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.iso_tbl_ncr".
 *
 * @property int $id
 * @property string $rujukan_fail
 * @property int $jenis_audit 1 = audit dalaman, 2 = audit susulan
 * @property string $tarikh_audit
 * @property string $dept
 * @property string $conformity_req
 * @property string $conformity_find
 * @property string $auditor1 juruaudit
 * @property string $auditee1
 * @property string $auditee1_icno
 * @property string $invest_result
 * @property string $auditee2
 * @property string $auditee2_icno
 * @property string $action_plan
 * @property string $auditee3
 * @property string $auditee3_icno
 * @property string $verifikasi
 * @property string $auditee4
 * @property string $auditee4_icno
 * @property string $semakan_icno
 * @property string $semakan_name
 * @property string $semakan_dt
 * @property int $closing_ncr 0 = close, 1 = open
 * @property string $closing_ncr_dt
 * @property string $attachment
 */
class TblNcr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_tbl_ncr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auditee_icno','jenis_audit','klasifikasi', 'tarikh_audit', 'clause', 'conformity_req', 'conformity_find', 'conformity_proof', 'invest_result', 'action_plan', 'verifikasi','closing_ncr','closing_ncr_dt'], 'required', 'message' => 'Ruang ini adalah mandatori'], 
            [['jenis_audit', 'closing_ncr', 'klasifikasi', 'status_semasa', 'parent_id', 'status_tindakan', 'deptId'], 'integer'],
            [['updated_dt','tarikh_audit', 'closing_ncr_dt', 'opening_ncr_dt', 'entry_dt', 'auditee3_dt', 'auditee4_dt', 'tarikh_bengkel', 'auditee_dt', 'ver_dt', 'updated_dt'], 'safe'],
            [['conformity_req', 'conformity_find', 'invest_result', 'action_plan', 'verifikasi', 'attachment', 'conformity_proof', 'catatan_bengkel'], 'string'],
            [['rujukan_fail', 'tindakan_bengkel'], 'string', 'max' => 50],
            [['dept', 'auditor', 'auditee'], 'string', 'max' => 150],
            [['auditee_icno', 'year', 'auditor_icno', 'clause', 'updated_by','bengkel_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rujukan_fail' => 'Rujukan Fail',
            'jenis_audit' => 'Jenis Audit',
            'tarikh_audit' => 'Tarikh Audit',
            'dept' => 'Dept',
            'conformity_req' => 'Conformity Req',
            'conformity_find' => 'Conformity Find',
            'auditor' => 'Auditor 1',
            'auditee' => 'Auditee 1',
            'auditee_icno' => 'Auditee 1 Icno',
            'invest_result' => 'Invest Result',
            'auditee2' => 'Auditee 2',
            'auditee2_icno' => 'Auditee 2 Icno',
            'action_plan' => 'Action Plan',
            'auditee3' => 'Auditee 3',
            'auditee3_icno' => 'Auditee 3 Icno',
            'verifikasi' => 'Verifikasi',
            'auditee4' => 'Auditee 4',
            'auditee4_icno' => 'Auditee 4 Icno', 
            'closing_ncr' => 'Closing Ncr',
            'closing_ncr_dt' => 'Closing Ncr Dt',
            'attachment' => 'Attachment',
            'klasifikaso' => 'Klasifikasi,',
            'conformity_proof' => 'Conformity Proof',
            'opening_ncr_dt' => 'Opening Ncr Dt',
            'entry_dt' => 'Entry Date',
            'year' => 'Tahun',
            'status_semasa' => 'status semasa',
            'auditor_icno' => 'Auditor Icno',
            'auditee3_dt' => 'Auditee Date',
            'auditee4_dt' => 'Auditee Date',
            'parent_id' => 'parent id',
            'deptId' => 'Id Jabatan',
            'clause' => 'Klausa',
            'tindakan_bengkel' => 'Tindakan',
            'catatan_bengkel' => 'catatan',
            'tarikh_bengkel' => 'tarikh bengkel',
            'auditee_dt' => 'Tarikh Auditee',
            'ver_dt' => 'Tarikh Verifikasi',
            'updated_by' => 'Updated By',
            'updated_dt' => 'tarikh',
            'bengkel_by' => 'Bengkel By',
        ];
    }
    public function getKakitangan() {
      return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'auditee_icno']);
    }
    public function getSemakanby() {
      return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'updated_by']);
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
    
    public function getTarikhAudit() {
        if ($this->tarikh_audit != '') {
            return $this->getTarikh($this->tarikh_audit);
        }
    }
    public function getTarikhAuditee() {
      if ($this->auditee_dt != '') {
          return $this->getTarikh($this->auditee_dt);
      }
  }
  public function getTarikhVerifikasi() {
    if ($this->ver_dt != '') {
        return $this->getTarikh($this->ver_dt);
    }
  }
  public function getClosingNcrDt() {
    if ($this->closing_ncr_dt != '') {
        return $this->getTarikh($this->closing_ncr_dt);
    }
  }

    public function getJenisAudit() {
        if ($this->jenis_audit == '1') {
            return 'Audit Dalaman';
        }  
        if ($this->jenis_audit == '2') {
            return 'Audit Susulan';
        } 
    }

    public function getJenisKlasifikasi() {
        if ($this->klasifikasi == '1') {
            return 'Minor';
        }  
        if ($this->klasifikasi == '2') {
            return 'Major';
        }  
    }
    public function getClosing() {
      if ($this->closing_ncr == '1') {
          return 'Ya';
      } 
     
      if ($this->closing_ncr == '0') {
          return 'Tidak';
      } 
  }
  public function getStatusTindakan() {
    if ($this->status_tindakan == '1') {
        return '<span class="label label-success">SELESAI</span>';
    } 
    if ($this->status_tindakan == '2' ) {
        return '<span class="label label-primary">MENUNGGU TINDAKAN</span>';
    } 
    if ($this->status_tindakan == '3') {
      return '<span class="label label-danger">KEMASKINI</span>';
    }  
    if ($this->status_tindakan == '4') {
      return '<span class="label label-warning">TINDAKAN AUDITEE</span>';
    }  
    if ($this->status_tindakan == '5') {
    return '<span class="label label-default">TINDAKAN AUDITOR</span>';
    }  
    if ($this->status_tindakan == '6') {
      return '<span class="label label-danger">SEMAKAN</span>';
    }
    if ($this->status_tindakan == '7') {
      return '<span class="label label-default">NOTIFIKASI</span>';
    }   
   }
   public function getKlausa() {
    return $this->hasOne(TblClause::className(), ['clause_order' => 'clause']);
  }
  public function getBengkelDt() {
    if ($this->tarikh_bengkel != '') {
        return $this->getTarikh($this->tarikh_bengkel);
    }
}
public static function countTotalClauseByDept($kumpulan, $category, $tahun)
  {
    $count = 0;

    $model = TblNcr::find()->where(['dept' => $kumpulan])->andwhere(['year' => $tahun])->count(); 
   
    return $model;

  }
  public static function countClauseByDept($kumpulan, $category, $tahun)
  {
    $count = 0;

    $model = TblNcr::find()->where(['dept' => $kumpulan, 'clause' => $category])->andwhere(['year' => $tahun])->count(); 
   
    return $model;

  }
  public static function countTotalByDept($kumpulan)
  {
    $count = 0;
    $tahun = date('Y');

    $model = TblNcr::find()->where(['deptId' => $kumpulan, ])->andwhere(['year' => $tahun])->count(); 
   
    return $model; 
  } 

}
