<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\RefCpdGroup;
use app\models\myidp\RefCpdGroupGredJawatan;

/**
 * This is the model class for table "{{%myidp.idpMata}}".
 *
 * @property string $staffID
 * @property string $tahun
 * @property string $mataUmum
 * @property string $mataElektif
 * @property string $mataTeras
 * @property string $mataTerasUni
 * @property string $mataTerasSkim
 */
class IdpMataV2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_tbl_idpmata_xpenilaian}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staffID', 'tahun'], 'required'],
            [['mataUmum', 'mataElektif', 'mataTeras', 'mataTerasUni', 'mataTerasSkim', 'status', 'statusIDP', 'statusIDP2'], 'number'],
            [['staffID'], 'string', 'max' => 12],
            [['tahun'], 'string', 'max' => 4],
            [['staffID', 'tahun'], 'unique', 'targetAttribute' => ['staffID', 'tahun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staffID' => Yii::t('app', 'Staff ID'),
            'tahun' => Yii::t('app', 'Tahun'),
            'mataUmum' => Yii::t('app', 'Mata Umum'),
            'mataElektif' => Yii::t('app', 'Mata Elektif'),
            'mataTeras' => Yii::t('app', 'Mata Teras'),
            'mataTerasUni' => Yii::t('app', 'Mata Teras Uni'),
            'mataTerasSkim' => Yii::t('app', 'Mata Teras Skim'),
            'status' => Yii::t('app', 'Status'),
            'statusIDP' => Yii::t('app', 'Status IDP'),
            'statusIDP2' => Yii::t('app', 'Status IDP 2'),
        ];
    }
    
    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staffID']);
    }
    
    public function getMataMinKump(){
        
        $model3 = Tblprcobiodata::findOne(['ICNO' => $this->staffID]);
        $gredj = $model3->jawatan->gred;
        
        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj])->one();
//        $cpdgroup = $modelcpdgroupgj->cpdgroup;
//        $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();

//        return $modelcpdgroup->mataMin;
        
        if ($modelcpdgroupgj) {

            $cpdgroup = $modelcpdgroupgj->cpdgroup;
            $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
            
            return $modelcpdgroup->mataMin;
        } else {
            return "<div style='color:red'>Tidak perlu mata IDP</div>";
        }
        
        
    }
    
    public function getMinKompetensi($type){
        
        $model3 = Tblprcobiodata::findOne(['ICNO' => $this->staffID]);
        $gredj = $model3->jawatan->gred;
        
        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj])->one();
        $cpdgroup = $modelcpdgroupgj->cpdgroup;
        $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
        
        if ($type == 5){
            
            return $modelcpdgroup->minTerasUni;
        } elseif ($type == 6) {
            return $modelcpdgroup->minTerasSkim;
        
        } elseif($type == 4) {
            return $modelcpdgroup->minElektif;
        } elseif($type == 3) {
            return $modelcpdgroup->minTeras;
        } elseif($type == 1) {
            return $modelcpdgroup->minUmum;
        } 
    }
    
    public function getPercentKompetensi($type){
        
        if ($type == 5){
            $a = $this->mataTerasUni;
        } elseif ($type == 6) {
            $a = $this->mataTerasSkim;
        
        } elseif($type == 4) {
            $a = $this->mataElektif;
        } elseif($type == 3) {
            $a = $this->mataTeras;
        } elseif($type == 1) {
            $a = $this->mataUmum;
        }
        
        if ((($a/$this->getMinKompetensi($type))*100) >= 100) {
                $p = 100;
            } else {
                $p = ($a/$this->getMinKompetensi($type))*100;
            }

        return $p;
    }
    
    public function getColorKompetensi($type){
        
        if ($type == 5){
            $a = $this->mataTerasUni;
        } elseif ($type == 6) {
            $a = $this->mataTerasSkim;
        
        } elseif($type == 4) {
            $a = $this->mataElektif;
        } elseif($type == 3) {
            $a = $this->mataTeras;
        } elseif($type == 1) {
            $a = $this->mataUmum;
        }
        
        if ($a >= $this->getMinKompetensi($type)) {
                $progressBarColour = 'progress-bar-success';
            } else {
                $progressBarColour = 'progress-bar-danger';
            }

        return $progressBarColour;
    }
    
    public function getPbarLabel($type){
        
        if ($type == 5){
            $a = $this->mataTerasUni;
        } elseif ($type == 6) {
            $a = $this->mataTerasSkim;
        
        } elseif($type == 4) {
            $a = $this->mataElektif;
        } elseif($type == 3) {
            $a = $this->mataTeras;
        } elseif($type == 1) {
            $a = $this->mataUmum;
        }
        
        if (round((($a/$this->getMinKompetensi($type))*100),0) >= 100){
            $a = '100%';
        } else {
            $a = round((($a/$this->getMinKompetensi($type))*100),0).'%';
        }

        return $a;
    }
    
    public function getJumlahMataAmbilKira(){
        
        $jumlahMataAmbilKira = 0;
        
        $model3 = Tblprcobiodata::findOne(['ICNO' => $this->staffID]);
        $gredj = $model3->jawatan->gred;

        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj])->one();
        
        if ($modelcpdgroupgj) {

            $cpdgroup = $modelcpdgroupgj->cpdgroup;
            $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
        }
        
        if ($model3->jawatan->job_category == 2) {
            
            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
            $minTerasSkim = $modelcpdgroup->minTerasSkim;

            if ($this->mataElektif >= $minElektif) {
                //electiveIDPPoint that are counted
                $elektifTrue = $minElektif;
            } else {
                //electiveIDPPoint that are counted
                $elektifTrue = $this->mataElektif;
            }

            /*             * ************************************************************************ */
            if ($this->mataTerasUni >= $minTerasUniversiti) {
                $terasUniTrue = $minTerasUniversiti;
            } else {
                $terasUniTrue = $this->mataTerasUni;
            }

            /*             * ************************************************************************** */
            if ($this->mataTerasSkim >= $minTerasSkim) {
                $terasSkimTrue = $minTerasSkim;
            } else {
                $terasSkimTrue = $this->mataTerasSkim;
            }

            /*             * ************************************************************************** */
            //amountOfPoint that are actually counted
            $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;
        } elseif ($model3->jawatan->job_category == 1){
            
            $minMata = $modelcpdgroup->mataMin;

            $minTerasAcademic = round(0.5 * $minMata);
            $minElektifAcademic = round(0.3 * $minMata);
            $minUmumAcademic = round(0.2 * $minMata);
            
            //determine IDP percentage and progress-bar colour
            if ($this->mataElektif >= $minElektifAcademic) {
                //electiveIDPPoint that are counted
                $elektifTrue = $minElektifAcademic;
            } else {
                //electiveIDPPoint that are counted
                $elektifTrue = $this->mataElektif;
            }

            /*             * ************************************************************************ */
            if ($this->mataTeras >= $minTerasAcademic) {
                $terasTrue = $minTerasAcademic;
            } else {
                $terasTrue = $this->mataTeras;
            }

            /*             * ************************************************************************** */
            if ($this->mataUmum >= $minUmumAcademic) {
                $umumTrue = $minUmumAcademic;
            } else {
                $umumTrue = $this->mataUmum;

            }

            /*             * ************************************************************************** */
            //amountOfPoint that are actually counted
            $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;
        }
        
        return $jumlahMataAmbilKira;
        
    }
    
    public function getBaki(){
        
        $baki = $this->getMataMinKump() - $this->getJumlahMataAmbilKira();
        
//        if ($this->biodata->jawatan->job_category == 2){
//        
//            $baki = $this->getMataMinKump() - $this->mataTerasUni - $this->mataTerasSkim - $this->mataElektif;
//        } elseif ($this->biodata->jawatan->job_category == 1){
//            $baki = $this->getMataMinKump() - $this->mataTeras - $this->mataUmum - $this->mataElektif;
//        }
        
        if ($baki <= $this->getMataMinKump() && $baki >= 0 && is_int($this->getMataMinKump())){
            return "<div style='color:red'>-".$baki."</div>";
        } else {
            return "<div style='color:green'>+".abs($baki)."</div>";
        }

        
    }
    
    public function getMataMinKump2(){
        
        $mataMin = 0;
        
        $model3 = Tblprcobiodata::findOne(['ICNO' => $this->staffID]);
        $gredj = $model3->jawatan->gred;
        
        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj])->one();

        if ($modelcpdgroupgj) {

            $cpdgroup = $modelcpdgroupgj->cpdgroup;
            $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
            
            $mataMin = $modelcpdgroup->mataMin;
        } 
        
        return $mataMin;
            
    }
    
    
}
