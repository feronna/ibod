<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_tbl_nd".
 *
 * @property int $id
 * @property int $laporID
 * @property string $icno
 * @property string $dt_nominal
 * @property string $nd_nominal
 * @property string $dt_setuju
 * @property string $j_nd
 * @property string $dt_ppuu
 * @property string $catatan
 * @property string $update_by
 */
class TblNd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_nd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['laporID','HighestEduLevelCd'], 'integer'],
            [['catatan'], 'string'],
            [['icno', 'update_by'], 'string', 'max' => 12],
            [['dt_nominal', 'nd_nominal', 'dt_setuju', 'j_nd', 'dt_ppuu'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'laporID' => 'Lapor ID',
            'icno' => 'Icno',
            'dt_nominal' => 'Dt Nominal',
            'nd_nominal' => 'Nd Nominal',
            'dt_setuju' => 'Dt Setuju',
            'j_nd' => 'J Nd',
            'dt_ppuu' => 'Dt Ppuu',
            'catatan' => 'Catatan',
            'update_by' => 'Update By',
        ];
    }
    
    public function getTempoh1(){
       
        $date1 = TblNd::find()->where(['icno' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('dt_nominal');
                
        $date2 = date("Y-m-d");

//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days
        
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
    }
    
    public function getTempohh(){
       
        $date1 = TblNd::find()->where(['icno' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('dt_nominal');
                        $date2 = TblNd::find()->where(['icno' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('nd_nominal');

//        $date2 = date("Y-m-d");

//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days
        
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = 1 +(($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
    }
    public function getDtnominal() {
        return  $this->getTarikh($this->dt_nominal);

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
     public function getDtsetuju() {
     if($this->dt_setuju)
     {
        return  $this->getTarikh($this->dt_setuju);

    }
    else
    {
        return "-";
    }
     }
    public function getTempohhh(){
       
        $date1 = TblNd::find()->where(['icno' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('dt_setuju');
//        $date2 = TblLapordiri::find()->where(['icno' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('nd_nominal');

        $date2 = date("Y-m-d");

//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days
        
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
    }
}
