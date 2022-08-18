<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.iso_best_practice".
 *
 * @property int $id
 * @property string $dept
 * @property string $year
 * @property string $best_practice
 * @property string $created_by
 * @property string $created_dt
 * @property int $status
 * @property int $parent_id
 * @property string $attachment
 */
class TblBestPractice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file; 
    public static function tableName()
    {
        return 'utilities.iso_best_practice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['best_practice'], 'required', 'message' => 'Ruang ini adalah mandatori'],  
            [['best_practice', 'attachment'], 'string'],
            [['created_dt'], 'safe'],
            [['status', 'parent_id'], 'integer'],
            [['dept'], 'string', 'max' => 250],
            [['year', 'created_by', 'rujukan_fail'], 'string', 'max' => 12],
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
            'dept' => 'Dept',
            'year' => 'Year',
            'best_practice' => 'Best Practice',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'status' => 'Status',
            'parent_id' => 'Parent ID',
            'file' => 'Attachment',
            'rujukan_fail' => 'Rujukan Fail',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'created_by']);
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
        if ($this->created_dt != '') {
            return $this->getTarikh($this->created_dt);
        }
    }
}
