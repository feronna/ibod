<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\TblPenempatan;
use app\models\hronline\Tblrscoapmtstatus;

/**
 * This is the model class for table "{{%myidp.rpt_statistik_idp}}".
 *
 * @property int $tahun
 * @property string $icno
 * @property int $idp_mata_min
 * @property int $idp_kom_teras
 * @property int $idp_mata_teras
 * @property int $idp_kom_elektif
 * @property int $idp_mata_elektif
 * @property int $idp_kom_umum
 * @property int $idp_mata_umum
 * @property int $idp_kom_teras_uni
 * @property int $jum_mata_dikira
 * @property int $baki
 * @property int $status 0=Tiada Mata IDP,1=Belum Capai Mata Minima,2=Capai Mata Minima
 * @property string $tarikh_kemaskini
 * @property int $id
 * @property int $kat 1=Akademik,2=Pentadbiran
 * @property int $idp_mata_teras_uni
 * @property int $idp_kom_teras_skim
 * @property int $idp_mata_teras_skim
 * @property int $jum_mata_semasa
 */
class RptStatistikIdpV2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_rpt_statistik_idp_xpenilaian}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'icno'], 'required'],
            [['tahun', 'idp_mata_min', 'idp_kom_teras', 'idp_mata_teras', 'idp_kom_elektif', 'idp_mata_elektif', 'idp_kom_umum', 'idp_mata_umum', 'idp_kom_teras_uni', 'jum_mata_dikira', 'baki', 'status', 'kat', 'idp_mata_teras_uni', 'idp_kom_teras_skim', 'idp_mata_teras_skim', 'jum_mata_semasa', 'staf_status', 'statusIDP', 'statusIDP2', 'status_teras_uni', 'status_teras_skim', 'status_elektif', 'status_umum', 'status_teras', 'sandangan_id', 'penempatan_id'], 'integer'],
            [['tarikh_kemaskini'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['tahun', 'icno'], 'unique', 'targetAttribute' => ['tahun', 'icno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'icno' => 'Icno',
            'idp_mata_min' => 'Idp Mata Min',
            'idp_kom_teras' => 'Idp Kom Teras',
            'idp_mata_teras' => 'Idp Mata Teras',
            'idp_kom_elektif' => 'Idp Kom Elektif',
            'idp_mata_elektif' => 'Idp Mata Elektif',
            'idp_kom_umum' => 'Idp Kom Umum',
            'idp_mata_umum' => 'Idp Mata Umum',
            'idp_kom_teras_uni' => 'Idp Kom Teras Uni',
            'jum_mata_dikira' => 'Jum Mata Dikira',
            'baki' => 'Baki',
            'status' => 'Status',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
            'id' => 'ID',
            'kat' => 'Kat',
            'idp_mata_teras_uni' => 'Idp Mata Teras Uni',
            'idp_kom_teras_skim' => 'Idp Kom Teras Skim',
            'idp_mata_teras_skim' => 'Idp Mata Teras Skim',
            'jum_mata_semasa' => 'Jum Mata Semasa',
            'staf_status' => 'Staf Status',
            'statusIDP' => 'Status Idp',
            'statusIDP2' => 'Status Idp2',
            'status_teras_uni' => 'Status Teras Uni',
            'status_teras_skim' => 'Status Teras Skim',
            'status_elektif' => 'Status Elektif',
            'status_umum' => 'Status Umum',
            'status_teras' => 'Status Teras',
        ];
    }
    
    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getSandangan(){
        return $this->hasOne(Tblrscosandangan::className(), ['id' => 'sandangan_id']);
    }

    public function getPenempatan(){
        return $this->hasOne(Tblpenempatan::className(), ['id' => 'penempatan_id']);
    }
    
    public function findLantikan($icno, $year){
        
        if ($year == date('Y')){
            
            $modelLantikan = Tblrscoapmtstatus::find()
                    ->where(['ICNO' => $icno])
                    ->orderBy(['ApmtStatusStDt' => SORT_DESC])
                    ->one();
     
        } else {
            
            $modelLantikan = Tblrscoapmtstatus::find()
                    ->where(['ICNO' => $icno])
                    ->andWhere(['<>', 'YEAR(ApmtStatusStDt)', date('Y')])
                    ->orderBy(['ApmtStatusStDt' => SORT_DESC])
                    ->one();
            
        }
        
        if ($modelLantikan){
            return strtoupper($modelLantikan->statusLantikan->ApmtStatusNm);     
        } else {
            return "vjhgu";
        }
        
    }
    
    public function findPenempatan($icno, $year, $category){
        
        if ($year == date('Y')){
            
            $model = TblPenempatan::find()
                ->where(['ICNO' => $icno])
                ->orderBy(['date_start' => SORT_DESC])
                ->one();
        } else {
            
            $model = TblPenempatan::find()
                ->where(['ICNO' => $icno])
                ->andWhere(['<>', 'YEAR(date_start)', date('Y')])
                ->orderBy(['date_start' => SORT_DESC])
                ->one();
            
        }
        
//                echo '<pre>' , var_dump(($model)) , '</pre>';
//                die();
        
        if ($model && ($category == '1')){
            return $model->department->shortname;
        } elseif ($model && ($category == '2')){
            return strtoupper($model->campus->campus_name);
        } 
        
        //return $model->dept_id;
        
    }
    
    public function countStatistics($kumpulan, $category, $calctype) {
        
        $count = 0;
        
        if ($category == 0){
            
            $model = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['<>', 'tblprcobiodata.Status', '6'])
                    ->andWhere(['job_group' => $kumpulan])
                    ->all();
            
        } elseif ($category == 1) {
            
            $model = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['<>', 'tblprcobiodata.Status', '6'])
                    ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 1])
                    ->all();
            
        } elseif ($category == 2){
            
            $model = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['<>', 'tblprcobiodata.Status', '6'])
                    ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 2])
                    ->all();
            
        }
        
        if ($calctype == 0) { //countCapaiMin
        
            foreach ($model as $model){
                if ($model->idp_mata_min != 0){

                    if ($model->jum_mata_dikira >= $model->idp_mata_min){
                        $count = $count + 1;
                    } 
                }
            }
        } elseif ($calctype == 1){ //countBelumCapaiMin
            
            foreach ($model as $model){
                if ($model->idp_mata_min != 0){

                    if (($model->jum_mata_dikira < $model->idp_mata_min) 
                            && ($model->jum_mata_dikira != 0) ){
                        $count = $count + 1;
                    } 
                }
            }
        } elseif ($calctype == 2){ //countBelumAdaMata
            
            foreach ($model as $model){
                if ($model->idp_mata_min != 0){

                    if ($model->jum_mata_dikira == 0){
                        $count = $count + 1;
                    } 
                }
            }
            
        }
        
        return $count;
    }
    
    public function getBakii(){
        
//        if ($this->baki <= $this->idp_mata_min && $this->baki >= 0 && is_int($this->idp_mata_min)){
//            return "<div style='color:red'>-". $this->baki."</div>";
//        } else {
//            return "<div style='color:green'>+".abs($this->baki)."</div>";
//        }
        
        if ($this->baki <= $this->idp_mata_min && $this->baki != 0 && is_int($this->idp_mata_min)){
            return "<div style='color:red'>-".$this->baki."</div>";
        } else {
            if ($this->baki == 0){
                return "<div style='color:green'>".abs($this->baki)."</div>";
            } else {
                return "<div style='color:green'>+".abs($this->baki)."</div>";
            }
        } 
    }
    
    public function getMataMinKump(){
        
        if ($this->idp_mata_min) {
            
            return $this->idp_mata_min;
        } else {
            return "<div style='color:red'>Tidak perlu mata IDP</div>";
        }     
    }
}
