<?php

namespace app\models\msiso;
use app\models\msiso\TblClause;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;


use Yii;

/**
 * This is the model class for table "utilities.iso_tbl_ofi".
 *
 * @property int $id
 * @property string $rujukan_fail
 * @property string $dept
 * @property string $clause
 * @property string $butiran
 * @property string $tindakan tindakan penambahbaikan auditee
 * @property string $auditor_name
 * @property string $auditor_icno
 * @property string $tarikh_audit
 * @property string $created_by
 * @property string $created_at
 * @property string $attachment
 * @property int $status
 */
class TblOfi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_tbl_ofi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clause','butiran', 'tarikh_audit', 'penambahbaikan'], 'required', 'message' => 'Ruang ini adalah mandatori'], 
            [['butiran', 'attachment', 'catatan_bengkel', 'penambahbaikan'], 'string'],
            [['tarikh_audit', 'updated_at', 'auditor2_dt', 'dept_auditee_dept', 'tarikh_bengkel', 'entry_dt'], 'safe'],
            [['status', 'status_tindakan', 'deptId'], 'integer'],
            [['rujukan_fail', 'tindakan_bengkel'], 'string', 'max' => 50],
            [['dept', 'auditor_name'], 'string', 'max' => 150],
            [['clause', 'updated_by', 'year', 'parent_id', 'icno_auditee_dept'], 'string', 'max' => 12],
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
            'dept' => 'Dept',
            'clause' => 'Clause',
            'butiran' => 'Butiran',
            'tindakan' => 'Tindakan',
            'auditor_name' => 'Auditor Name',
            'auditor_icno' => 'Auditor Icno',
            'tarikh_audit' => 'Tarikh Audit',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'attachment' => 'Attachment',
            'status' => 'Status', 
            'parent_id' => 'Parent Id',
            'icno_auditee_dept' => 'Department Auditee By', 
            'dept_auditee_dt' => 'Tarikh kemaskini Jabatan',
            'deptId' => 'ID Jabatan',
            'entry_dt' => 'Tarikh Ofi', //tarikh mula pengisian ofi
        ];
    }
    public function getKakitangan() {
      return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_auditee_dept']);
    }
    public function getDept() {
      return $this->hasOne(Department::className(), ['id' => 'deptId']);
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
    public function getDeptDt() {
      if ($this->dept_auditee_dt != '') {
          return $this->getTarikh($this->dept_auditee_dt);
      }
  }
  public function getBengkelDt() {
    if ($this->tarikh_bengkel != '') {
        return $this->getTarikh($this->tarikh_bengkel);
    }
  }
 
  public function getKlausa() {
    return $this->hasOne(TblClause::className(), ['clause_order' => 'clause']);
  }

  public function getStatusTindakan() {
    if ($this->status_tindakan == '1') {
        return '<span class="label label-success">SELESAI</span>';
    } 
    if ($this->status_tindakan == '2') {
        return '<span class="label label-primary">MENUNGGU TINDAKAN</span>';
    } 
    if ($this->status_tindakan == '3') {
      return '<span class="label label-danger">KEMASKINI</span>';
    }  
    if ($this->status_tindakan == '4') {
      return '<span class="label label-warning">TINDAKAN AUDITEE</span>';
    }  
    if ($this->status_tindakan == '5') {
    return '<span class="label label-default">NOTIFIKASI</span>';
    }  
     
  } 
  public static function countTotalClauseByDept($kumpulan, $category, $tahun)
  {
    $count = 0;

    $model = TblOfi::find()->where(['dept' => $kumpulan])->andwhere(['year' => $tahun])->count(); 
   
    return $model; 
  }
  public static function countClauseByDept($kumpulan, $category, $tahun)
  {
    $count = 0;

    $model = TblOfi::find()->where(['dept' => $kumpulan, 'clause' => $category])->andwhere(['year' => $tahun])->count(); 
   
    return $model; 
  } 
  public static function countTotalByDept($kumpulan)
  {
    $count = 0;
    $tahun = date('Y');
    $model = TblOfi::find()->where(['deptId' => $kumpulan, ])->andwhere(['year' => $tahun])->count(); 
   
    return $model; 
  } 
}
