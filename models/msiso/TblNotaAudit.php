<?php

namespace app\models\msiso;

use Yii;

/**
 * This is the model class for table "utilities.iso_tbl_nota_audit".
 *
 * @property int $id
 * @property string $iso_no
 * @property string $dept
 * @property string $auditee_by
 * @property string $auditee_name
 * @property string $auditee_dt
 * @property string $auditor_by
 * @property string $auditor_name
 * @property string $auditor_dt
 * @property string $standard
 * @property string $rujukan_fail
 * @property string $list_check
 * @property string $catatan
 * @property string $attachment
 * @property int $status
 */
class TblNotaAudit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public static function tableName()
    {
        return 'utilities.iso_tbl_nota_audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file','audit_date'], 'required', 'message' => 'Ruang ini adalah mandatori'],  
            [['auditee_dt', 'auditor_dt', 'created_dt', 'audit_date'], 'safe'],
            [['list_check', 'catatan', 'attachment'], 'string'],
            [['status', 'parent_id'], 'integer'],
            [['iso_no', 'auditee_by', 'auditor_by', 'created_by', 'year'], 'string', 'max' => 12],
            [['dept', 'auditee_name', 'auditor_name'], 'string', 'max' => 250],
            [['standard'], 'string', 'max' => 50],
            [['rujukan_fail'], 'string', 'max' => 25],
            [['file'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file'],'safe'], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iso_no' => 'Iso No',
            'dept' => 'Dept',
            'auditee_by' => 'Auditee By',
            'auditee_name' => 'Auditee Name',
            'auditee_dt' => 'Auditee Dt',
            'auditor_by' => 'Auditor By',
            'auditor_name' => 'Auditor Name',
            'auditor_dt' => 'Auditor Dt',
            'standard' => 'Standard',
            'rujukan_fail' => 'Rujukan Fail',
            'list_check' => 'List Check',
            'catatan' => 'Catatan',
            'file' => 'Attachment',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_dt' => 'Date Created',
            'audit_date' => 'Tarikh Audit',
            'parent_id' => 'Parent Id',
            'year' => 'Tahun',
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
    
    public function getTarikhAudit() {
        if ($this->created_dt != '') {
            return $this->getTarikh($this->created_dt);
        }
    }
}
