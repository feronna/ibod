<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "utilities.iso_audit_plan".
 *
 * @property int $id
 * @property string $audit_plan
 * @property string $created_by
 * @property string $created_dt
 * @property string $year
 * @property string $catatan
 * @property string $confirm_audit_plan
 */
class AuditPlan extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'utilities.iso_audit_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['title',], 'required', 'message' => 'Ruang ini adalah mandatori'], 
            [['audit_plan', 'confirm_audit_plan', 'title'], 'string'],
            [['created_dt'], 'safe'],
            [['created_by'], 'string', 'max' => 12],
            [['year', 'status', 'parent_id'], 'string', 'max' => 11],
            [['catatan'], 'string', 'max' => 250],
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
            'audit_plan' => 'Audit Plan',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'year' => 'Year',
            'catatan' => 'Catatan',
            'confirm_audit_plan' => 'Confirm Audit Plan',
            'file' => 'Audit Plan',
            'title' => 'Title',
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

    public function getUploadDt() {
        if ($this->created_dt != '') {
            return $this->getTarikh($this->created_dt);
        }
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    }
}
