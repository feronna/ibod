<?php

namespace app\models\myidp;

use Yii;
use app\models\myidp\PermohonanLatihan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;

/**
 * This is the model class for table "myidp.kursusSasaran".
 *
 * @property int $sasaranID
 * @property int $kursusLatihanID
 * @property int $gredJawatanID
 * @property int $kategoriKursusID
 * @property int $tahap
 */
class KursusSasaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_kursusSasaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'gredJawatanID', 'kategoriKursusID', 'tahap'], 'required'],
            [['siriLatihanID', 'gredJawatanID', 'kategoriKursusID', 'tahap'], 'integer'],
            //[['siriLatihanID', 'gredJawatanID', 'tahap'], 'unique', 'targetAttribute' => ['siriLatihanID', 'gredJawatanID', 'tahap']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sasaranID' => 'Sasaran ID',
            'siriLatihanID' => 'Siri Latihan ID',
            'gredJawatanID' => 'Gred Jawatan ID',
            'kategoriKursusID' => 'Kategori Kursus ID',
            'tahap' => 'Tahap',
        ];
    }
    
    /** Relation **/
    public function getSasaran(){
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID'=>'siriLatihanID']);
    }
    
    /** Relation **/
    public function getJawatan(){
        return $this->hasOne(GredJawatan::className(), ['id'=>'gredJawatanID']);
    }
    
    /** Relation **/
    public function getKategori(){
        return $this->hasOne(Kategori::className(), ['kategori_id' => 'kategoriKursusID']);
    }
    
    /** Relation **/
    public function getKursus(){
        return $this->hasMany(PermohonanLatihan::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }
    
    /**get 'tahap' **/
    public function getTahapKhidmat() {
        
        if (($this->tahap) == 3){
            //$tahap='LANJUTAN';
            return 'LANJUTAN';
        }
        else if (($this->tahap) == 2){
            //$tahap='PERTENGAHAN';
            return 'PERTENGAHAN';
        }
        else{
            //$tahap='ASAS';
            return 'ASAS';
        }
    }
    
    public function SasaranAmount($gredID) {
        
        //get current year
        $currentYear = date('Y');
        
//        $amount = \app\models\hronline\Tblprcobiodata::find()
//                ->where(['Tblprcobiodata.gredJawatan'=>$gredID])
//                ->andWhere(['<>','Tblprcobiodata.Status', 6])
//                ->joinWith('idp')
//                ->andWhere(['tahap' => $this->tahap])
//                ->andWhere(['tahun' => $currentYear]) 
//                ->count();
        
//        $amount = Idp::find()
//                ->where(['gredjawatan'=>$gredID])
//                ->andWhere(['tahap' => $this->tahap])
//                ->andWhere(['tahun' => 2019]) 
//                ->count();
        
        $count = 0;
        
        $amount = Tblprcobiodata::find()
                ->where(['gredJawatan'=>$gredID])
                ->andWhere(['<>', 'Status', '6',])
                ->all();
        
        foreach ($amount as $a){
            if ($a->tahapKhidmat == $this->tahap){
                $count++;
            }
        }
     
        return $count;        
    }
    
    public function PohonAmount($siriLatihanID, $gredJawatanID) {
        
        //get current year
        $currentYear = date('Y');
        
//        $amount = PermohonanLatihan::find()
//                ->where(['kursusLatihanID' => $kursusLatihanID])  
//                ->andWhere(['caraPermohonan' => 'sendiriMohon'])
////                ->joinWith('biodata')
////                ->andWhere(['gredJawatan' => $gredJawatanID])
//                ->joinWith('idp')
//                ->andWhere(['gredjawatan' => $gredJawatanID])
//                ->andWhere(['tahap' => $this->tahap])
//                ->andWhere(['tahun' => $currentYear])
//                ->count();
        
        $count = 0;
        
        $amount = PermohonanLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])  
                ->andWhere(['caraPermohonan' => 'sendiriMohon'])
                ->joinWith('biodata')
                ->andWhere(['gredJawatan' => $gredJawatanID])
                ->andWhere(['<>', 'Status', '6',])
                ->all();
        
        foreach ($amount as $a){
            if ($a->biodata->tahapKhidmat == $this->tahap){
                $count++;
            }
        }
     
        return $count;       
    }
    
//    public function CheckPohon($siriLatihanID) {
//        
//        $userID = Yii::$app->user->getId();
//        
//        $cpohon = PermohonanLatihan::find()
//                ->where(['siriLatihanID' => $siriLatihanID])  
//                ->andWhere(['staffID' => $userID])
//                ->all();
//
//        //sreturn $cpohon;        
//    }
    
    public function JemputanAmount($siriLatihanID, $gredJawatanID) {
        
        //get current year
        $currentYear = date('Y');
        
//        $amount = PermohonanLatihan::find()
//                ->where(['kursusLatihanID' => $kursusLatihanID])
//                ->andWhere(['caraPermohonan' => 'jemputan'])
//                ->joinWith('idp')
//                ->andWhere(['gredjawatan' => $gredJawatanID])
//                ->andWhere(['tahap' => $this->tahap])
//                ->andWhere(['tahun' => $currentYear])
//                ->count();
//
//        return $amount;
        
        $count = 0;
        
        $amount = PermohonanLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])  
                ->andWhere(['caraPermohonan' => 'jemputan'])
                ->joinWith('biodata')
                ->andWhere(['gredJawatan' => $gredJawatanID])
                ->andWhere(['<>', 'Status', '6',])
                ->all();
        
        foreach ($amount as $a){
            if ($a->biodata->tahapKhidmat == $this->tahap){
                $count++;
            }
        }
     
        return $count;

        
    }
    
    public function CheckJenisKursus($kursusLatihanID) {
        
        $userID = Yii::$app->user->getId();
        
        //get current year
        $currentYear = date('Y');

        //find [v_co_icno] from database that match with [$id]-currentUser AND
        //find [tahun] from database that match with [$currentYear]
        $model = Idp::find()->where(['v_co_icno' => $userID, 'tahun' => $currentYear])->one();
        
        //get 'gredjawatan' from database
        $gredJawatan = $model->gredjawatan;
        $tahap = $model->tahap;
        
        $cpohon = $this::find()
                ->where(['kursusLatihanID' => $kursusLatihanID])  
                ->andWhere(['gredJawatanID' => $gredJawatan])
                ->andWhere(['tahap' => $tahap])
                ->one();

        return $cpohon;        
    }
 
}
