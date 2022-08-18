<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\SektorPekerjaan;
use app\models\hronline\JenisBadanMajikan;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use app\models\hronline\Tblpengalamankerja;
/**
 * This is the model class for table "ejobs.tbl_exp_kerja".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $OrgNm
 * @property string $OccSectorCd
 * @property string $CorpBodyTypeCd
 * @property string $PrevEmpStartDt
 * @property string $PrevEmpEndDt 
 * @property string $PrevJobPost
 * @property string $PrevPostLvl
 * @property string $PrevSlry
 * @property string $PrevElaun
 * @property string $PrevDateSlryInc
 * @property string $ReasonEndPrev
 */
class TblpPengalamanKerja extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_exp_kerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'statusPerkhidmatan','OrgNm','OccSectorCd', 'CorpBodyTypeCd','StateCd','CityCd','CountryCd','Addr1','Postcode','PrevJobPost','PrevPostLvl','PrevSlry','PrevEmpStartDt', 'ReasonEndPrev'], 'required', 'message'=>'Required'],
            [['PrevEmpStartDt', 'PrevEmpEndDt', 'PrevDateSlryInc'], 'safe'],
            [['PrevSlry', 'PrevElaun'], 'number'],
            [['ICNO'], 'string', 'max' => 12],
            [['OrgNm'], 'string', 'max' => 80],
            [['OccSectorCd', 'CorpBodyTypeCd'], 'string', 'max' => 2],
            [['ReasonEndPrev'], 'string', 'max' => 300],
            [['PrevJobPost', 'PrevPostLvl'], 'string', 'max' => 100],
            [['ICNO', 'OrgNm', 'PrevEmpStartDt'], 'unique', 'targetAttribute' => ['ICNO', 'OrgNm', 'PrevEmpStartDt']],
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
            'OrgNm' => 'Nama Majikan',
            'OccSectorCd' => 'Sektor Pekerjaan',
            'CorpBodyTypeCd' => 'Jenis Majikan',
            'PrevEmpStartDt' => 'Tarikh Mula',
            'PrevEmpEndDt' => 'Tarikh Berhenti', 
            'PrevJobPost' => 'Nama Jawatan',
            'PrevPostLvl' => 'Peringkat Jawatan',
            'PrevSlry' => 'Gaji Bulanan Terakhir(RM)',
            'PrevElaun' => 'Elaun Bulanan(RM)',
            'PrevDateSlryInc' => 'Tarikh Kenaikan Gaji Terakhir',
            'ReasonEndPrev' => 'Alasan Berhenti',
        ];
    } 
    
    public function getSektorPekerjaan() {
        return $this->hasOne(SektorPekerjaan::className(), ['OccSectorCd'=>'OccSectorCd']);
    }
    
    public function getJenisBadanMajikan() {
        return $this->hasOne(JenisBadanMajikan::className(), ['CorpBodyTypeCd'=>'CorpBodyTypeCd']);
    }
    
    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }

    public function getBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd' => 'CityCd']);
    }

    public function getAlamatPenuh() { 
        return $this->Addr1.', '.$this->Addr2.', '.$this->Addr3.'</br>'.
               $this->Postcode.', '.$this->bandar->City.', '.$this->negeri->State.', '.$this->negara->Country.'.';
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
    
    public function getStatusKhidmat() {
        if($this->statusPerkhidmatan==1){
            return 'Yes';
        }else{
            return 'No';
        }
    }
    
    public function LaporDiri($ICNO) {
        $model = TblpPengalamanKerja::findAll(['ICNO'=>$ICNO]);
        $simpan = new Tblpengalamankerja();
        
        if($model){
            foreach ($model as $model){
                $simpan->ICNO = $model->ICNO;
                $simpan->OrgNm = $model->OrgNm;
                $simpan->OccSectorCd = $model->OccSectorCd;
                $simpan->CorpBodyTypeCd = $model->CorpBodyTypeCd; 
                $simpan->PrevEmpStartDt = $model->PrevEmpStartDt;
                $simpan->PrevEmpEndDt = $model->PrevEmpEndDt; 
                $simpan->WithServices = $model->statusPerkhidmatan;
                $simpan->save(false);
            }
        } 
    } 
}
