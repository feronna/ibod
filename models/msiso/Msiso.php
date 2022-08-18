<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.iso_tbl_audit".
 *
 * @property int $id
 * @property string $form_name
 * @property int $form_id
 * @property string $catatan
 * @property string $updated_by
 * @property string $updated_dt
 * @property int $isActive
 * @property int $status
 * @property string $attachment
 */
class Msiso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_tbl_msiso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'audit_role'], 'required', 'message' => 'Ruang ini adalah mandatori'], 
            [['form_id', 'isActive', 'status'], 'integer'],
            [['catatan', 'attachment'], 'string'],
            [['updated_dt'], 'safe'],
            [['form_name', 'name'], 'string', 'max' => 250],
            [['dept', 'audit_role'], 'string', 'max' => 50],
            [['updated_by', 'icno', 'skop'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_name' => 'Form Name',
            'form_id' => 'Form ID',
            'catatan' => 'Catatan',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'isActive' => 'Is Active',
            'status' => 'Status',
            'attachment' => 'Attachment',
            'icno' => 'ICNO',
            'name' => 'Name',
            'dept' => 'Department',
            'audit_role' => 'Auditor Role',
            'skop' => 'Skop',
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

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getAuditorRole() {
        if ($this->audit_role == '1') {
            return 'Audit Team Leader';
        } 
       
        if ($this->audit_role == '2') {
            return 'Auditor';
        }
          
    }

    
}
