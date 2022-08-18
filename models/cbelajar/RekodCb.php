<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
/**
 * This is the model class for table "cbelajar.rekod_cb".
 *
 * @property int $id
 * @property int $tahun
 * @property string $CONm
 * @property string $umur
 * @property string $icno
 * @property string $umsper
 * @property string $gredJawatan
 * @property int $HighestEduLevelCd
 * @property string $COEmail
 * @property string $HighestEduLevel
 * @property string $InstNm
 * @property string $Country
 * @property string $major
 * @property string $nama_tajaan
 * @property string $tarikh_mula
 * @property string $tarikh_tamat
 * @property string $COL 17
 * @property string $COL 18
 * @property string $COL 19
 * @property string $COL 20
 * @property string $COL 21
 * @property string $COL 22
 * @property string $COL 23
 * @property string $COL 24
 * @property string $COL 25
 * @property string $COL 26
 * @property string $COL 27
 * @property string $COL 28
 * @property string $COL 29
 * @property string $COL 30
 * @property string $COL 31
 * @property string $COL 32
 */
class RekodCb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbelajar.rekod_cb';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
    {
        return [
            [['tahun', 'HighestEduLevelCd', 'bon'], 'integer'],
            [['catatan'], 'string'],
            [['CONm', 'nominal_damages'], 'string', 'max' => 255],
            [['icno'], 'string', 'max' => 12],
            [['umsper', 'Country'], 'string', 'max' => 16],
            [['gredJawatan'], 'string', 'max' => 13],
            [['COEmail'], 'string', 'max' => 28],
            [['HighestEduLevel'], 'string', 'max' => 29],
            [['InstNm'], 'string', 'max' => 51],
            [['major', 'tarikh_tamat'], 'string', 'max' => 37],
            [['nama_tajaan'], 'string', 'max' => 32],
            [['tarikh_mula'], 'string', 'max' => 35],
            [['terima'], 'string', 'max' => 10],
            [['status_pengajian'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'CONm' => 'Co Nm',
            'icno' => 'Icno',
            'umsper' => 'Umsper',
            'gredJawatan' => 'Gred Jawatan',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'COEmail' => 'Co Email',
            'HighestEduLevel' => 'Highest Edu Level',
            'InstNm' => 'Inst Nm',
            'Country' => 'Country',
            'major' => 'Major',
            'nama_tajaan' => 'Nama Tajaan',
            'tarikh_mula' => 'Tarikh Mula',
            'tarikh_tamat' => 'Tarikh Tamat',
            'bon' => 'Bon',
            'terima' => 'Terima',
            'status_pengajian' => 'Status Pengajian',
            'nominal_damages' => 'Nominal Damages',
            'catatan' => 'Catatan',
        ];
    }
     public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
      public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_id']);
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    public function getNegara() {
        return $this->hasOne(\app\models\hronline\Negara::className(), ['CountryCd'=>'CountryCd']);
    }
    public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
    }

    public function getTahapPendidikan() {
        
        return $this->pendidikanTertinggi->HighestEduLevel;
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

    public function getTarikhmula() {
        return  $this->getTarikh($this->tarikh_mula);

    }

    public function getTarikhtamat() {
        return  $this->getTarikh($this->tarikh_tamat);
    }
    
//     public function getBon1(){
//        
//        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_mula');
//        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_tamat');
//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        
//        return $ts2-$ts1;
//    } 
//}
}