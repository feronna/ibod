<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\JenisKecacatan;
use app\models\hronline\PuncaKecacatan;
use app\models\hronline\Tblkecacatan;
 
class TblpKecacatan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $file ;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_kecacatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DisabilityDt','HealDt','FileOku'], 'safe'],
            [['SocialWelfareNo', 'DrRptNo', 'DisabilityTypeCd', 'DisabilityCauseCd', 'DisabilityDt'], 'required', 'message'=>'Required'],
            [['ICNO'], 'string', 'max' => 12],
            [['DisabilityTypeCd', 'DisabilityCauseCd'], 'string', 'max' => 2],
            [['SocialWelfareNo', 'DrRptNo'], 'string', 'max' => 20],
            [['ICNO', 'DisabilityTypeCd'], 'unique', 'targetAttribute' => ['ICNO', 'DisabilityTypeCd']], 
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 1024 * 1024 * 5], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'DisabilityTypeCd' => 'Jenis Kecacatan',
            'DisabilityCauseCd' => 'Punca Kecacatan',
            'DisabilityDt' => 'Tarikh Kecacatan', 
            'SocialWelfareNo' => 'No. Fail Kebajikan',
            'HealDt' => 'Tarikh Sembuh',
            'DrRptNo' => 'No. Laporan Doktor',
        ];
    }
    
    public function getJenisKecacatan() {
        return $this->hasOne(JenisKecacatan::className(), ['DisabilityTypeCd'=>'DisabilityTypeCd']);
    }
    
     public function getPuncaKecacatan() {
        return $this->hasOne(PuncaKecacatan::className(), ['DisabilityCauseCd'=>'DisabilityCauseCd']);
    }
    
    public function Tarikh($bulan){
        
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
    
    public function LaporDiri($ICNO) {
        $model = TblpKecacatan::findAll(['ICNO'=>$ICNO]);
        $simpan = new Tblkecacatan();
        
        if($model){
            foreach ($model as $model){
                $simpan->ICNO = $model->ICNO;
                $simpan->DisabilityTypeCd = $model->DisabilityTypeCd;
                $simpan->DisabilityCauseCd = $model->DisabilityCauseCd;
                $simpan->DisabilityDt = $model->DisabilityDt;  
                $simpan->SocialWelfareNo = $model->SocialWelfareNo; 
                $simpan->HealDt = $model->HealDt;
                $simpan->DrRptNo = $model->DrRptNo; 
                $simpan->save(false);
            }
        } 
    } 
}
