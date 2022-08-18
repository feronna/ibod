<?php

namespace app\models\cbelajar;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "hrd.cb_tbl_elaun_lulus".
 *
 * @property int $id
 * @property string $icno
 * @property string $dt_stajaan
 * @property string $dt_ntajaan
 * @property string $t_tajaan
 * @property string $dt_slanjutb
 * @property string $dt_nlanjutb
 * @property string $t_ltajaan
 * @property string $kadar
 * @property string $family
 * @property string $pasangan
 * @property string $anak
 * @property string $t_bk
 * @property string $t_bkt
 * @property string $tempoh_bk
 * @property string $t_lbkm
 * @property string $t_lbkt
 * @property string $tempoh_bkl
 * @property string $esh
 * @property string $ep
 * @property string $ebk
 * @property string $epk
 * @property string $ebkk
 * @property string $eb
 * @property string $eaps
 * @property string $eap
 * @property string $ebsr
 * @property string $catatan
 */
class TblElaunLulus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_elaun_lulus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catatan','c_lanjut'], 'string'],
            [['icno'], 'string', 'max' => 12],
            [['dt_stajaan', 'dt_ntajaan', 'dt_slanjutb', 'dt_nlanjutb', 't_ltajaan', 'kadar', 'pasangan', 'anak', 't_bk', 't_bkt', 'tempoh_bk', 't_lbkm', 't_lbkt', 'tempoh_bkl', 'esh', 'ep', 'ebk', 'epk', 'eb', 'eaps', 'eap', 'ebsr'], 'string', 'max' => 50],
            [['t_tajaan'], 'string', 'max' => 20],
            [['lokasi'], 'string', 'max' => 255],
            [['family'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'dt_stajaan' => 'Dt Stajaan',
            'dt_ntajaan' => 'Dt Ntajaan',
            't_tajaan' => 'T Tajaan',
            'dt_slanjutb' => 'Dt Slanjutb',
            'dt_nlanjutb' => 'Dt Nlanjutb',
            't_ltajaan' => 'T Ltajaan',
            'kadar' => 'Kadar',
            'family' => 'Family',
            'pasangan' => 'Pasangan',
            'anak' => 'Anak',
            't_bk' => 'T Bk',
            't_bkt' => 'T Bkt',
            'tempoh_bk' => 'Tempoh Bk',
            't_lbkm' => 'T Lbkm',
            't_lbkt' => 'T Lbkt',
            'tempoh_bkl' => 'Tempoh Bkl',
            'esh' => 'Esh',
            'ep' => 'Ep',
            'ebk' => 'Ebk',
            'epk' => 'Epk',
            'ebk' => 'Ebkk',
            'eb' => 'Eb',
            'eaps' => 'Eaps',
            'eap' => 'Eap',
            'ebsr' => 'Ebsr',
            'lokasi' => 'Lokasi',
            'catatan' => 'Catatan',
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
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

    public function getDt() {
        return  $this->getTarikh($this->dt_stajaan);

    }
    public function getDt1() {
        return  $this->getTarikh($this->dt_ntajaan);

    }
     public function getBk() {
        return  $this->getTarikh($this->t_bk);

    }
   
    public function getBk1() {
        return  $this->getTarikh($this->t_bkt);

    }
    public function getDuit() {
       
        return $this->hasMany(TblElaun::className(), ['icno' => 'icno']);
       
   }
    public function getBiasiswa() {
       
        return $this->hasOne(TblBiasiswa::className(), ['id' => 'bID']);
       
   }
   public function getJenise() {
       
        return $this->hasOne(RefElaun::className(), ['id' => 'esh']);
       
   }
    public function getTempoh(){
     
 
        $date1 = TblElaunLulus::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('dt_stajaan');
        $date2 = TblElaunLulus::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('dt_ntajaan');

//        $ts1 =strtotime($date1); 
//$ts2 = strtotime($date2); 
//$year1 = date('Y', $ts1); 
//$year2 = date('Y', $ts2); 
//$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
////$days = date('d', $ts1);
////$days2 = date('d', $ts2);
//return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1)). ' BULAN' ;
             $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }
        if((($ts2 - $ts1) / (60*60*24)+1) >= 31){
            $months++;
            $day = (($ts2 - $ts1) / (60*60*24)+1) - 31;
            if($day != 0){
               $disday = $day . ' Hari'; 
            }else{
                $disday = ''; 
            }
        }else{
            $disday = (($ts2 - $ts1) / (60*60*24)+1) . ' Hari';
        }

        return $months. ' Bulan '. $disday; // 120 month, 26 days
        
        
    } 
    
    public function getTempohbk(){
     
 
        $date1 = TblElaunLulus::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('t_bk');
        $date2 = TblElaunLulus::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('t_bkt');

        $ts1 =strtotime($date1); 
$ts2 = strtotime($date2); 
$year1 = date('Y', $ts1); 
$year2 = date('Y', $ts2); 
$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
$days = date('d', $ts1);
$days2 = date('d', $ts2);
return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1) / ($days2-$days)). ' BULAN' ;
    } 
     public function getTempohlanjutan(){
       
        $date1 = TblElaunLulus::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan'=>$this->idLanjutan])->min('dt_slanjutb');
        $date2 = TblElaunLulus::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan' =>$this->idLanjutan])->min('dt_nlanjutb');

      
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
    } 
}
