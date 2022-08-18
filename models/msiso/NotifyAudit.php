<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.iso_notify_audit".
 *
 * @property int $id
 * @property string $iso_audit
 * @property string $dept
 * @property string $plan_audit_dt
 * @property string $plan_audit_time
 * @property string $created_by
 * @property string $created_dt
 * @property string $confirm_audit_dt
 * @property string $confirm_audit_time
 * @property string $year
 * @property string $catatan
 * @property string $attachment
 */
class NotifyAudit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_notify_audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept', 'plan_audit_dt', 'from_audit_time', 'to_audit_time'], 'required', 'message' => 'Ruang ini adalah mandatori'],  
            [['plan_audit_dt', 'created_dt', 'confirm_audit_dt'], 'safe'],
            [['catatan', 'attachment'], 'string'],
            [['iso_audit', 'from_audit_time', 'confirm_audit_time', 'to_audit_time'], 'string', 'max' => 50],
            [['dept'], 'string', 'max' => 250],
            [['created_by', 'year', 'chief', 'pp'], 'string', 'max' => 12],
            [['status', 'deptId'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iso_audit' => 'Iso Audit',
            'dept' => 'Dept',
            'plan_audit_dt' => 'Plan Audit Dt',
            'from_audit_time' => 'Dari Masa',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'confirm_audit_dt' => 'Confirm Audit Dt',
            'confirm_audit_time' => 'Confirm Audit Time',
            'year' => 'Year',
            'catatan' => 'Catatan',
            'attachment' => 'Attachment',
            'status' => 'Status',
            'to_audit_time' => 'Hingga masa',
            'chief' => 'Ketua Jabatan',
            'pp' => 'Ketua Pentadbiran',
            'deptId' => 'Department ID',

        ];
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

    public function getAuditDt() {
        if ($this->plan_audit_dt != '') {
            return $this->getTarikh($this->plan_audit_dt);
        }
    }
    public function getKakitangan() {
      return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'auditor_icno']);
  }
}
