<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\myidp\RptStatistikIdpV2;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblrscosandangan;

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
class RptStatistikIdp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_rpt_statistik_idp}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'icno'], 'required'],
            [['tahun', 'idp_mata_min', 'idp_kom_teras', 'idp_mata_teras', 'idp_kom_elektif', 'idp_mata_elektif', 'idp_kom_umum', 'idp_mata_umum', 'idp_kom_teras_uni', 'jum_mata_dikira', 'baki', 'status', 'kat', 'idp_mata_teras_uni', 'idp_kom_teras_skim', 'idp_mata_teras_skim', 'jum_mata_semasa', 'staf_status', 'statusIDP', 'statusIDP2', 'sandangan_id'], 'integer'],
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
            'staf_status' => 'Status',
            'statusIDP' => 'Status IDP',
            'statusIDP2' => 'Status IDP 2'
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getMata()
    {
        return $this->hasOne(IdpMata::className(), ['staffID' => 'icno', 'tahun' => 'tahun']);
    }

    public function countStatisticsDept($kumpulan, $category, $calctype, $year)
    {

        $count = 0;

        if ($category == 0) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['DeptId' => $kumpulan])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $year])
                ->all();
        } elseif ($category == 1) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $year])
                ->all();
        } elseif ($category == 2) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $year])
                ->all();
        }

        if ($calctype == 0) { //countCapaiMin

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->jum_mata_dikira >= $model->idp_mata_min) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 1) { //countBelumCapaiMin

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if (($model->jum_mata_dikira < $model->idp_mata_min)
                        && ($model->jum_mata_dikira != 0)
                    ) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 2) { //countBelumAdaMata

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->jum_mata_dikira == 0) {
                        $count = $count + 1;
                    }
                }
            }
        }

        return $count;
    }

    public function countStatisticsBalance($kumpulan, $category, $calctype)
    {

        $count = 0;

        if ($category == 0) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_group' => $kumpulan])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        } elseif ($category == 1) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        } elseif ($category == 2) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        }

        if ($calctype == 0) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 3 && $model->baki != 0) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 4) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 6 && $model->baki > 3) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 7) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 12 && $model->baki > 6) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 13) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 18 && $model->baki > 12) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 19) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 24 && $model->baki > 18) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 25) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 30 && $model->baki > 24) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 31) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 36 && $model->baki > 30) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($calctype == 37) {

            foreach ($model as $model) {
                if ($model->idp_mata_min != 0) {

                    if ($model->baki <= 42 && $model->baki > 36) {
                        $count = $count + 1;
                    }
                }
            }
        }

        return $count;
    }

    public static function countStatistics($kumpulan, $category, $calctype, $tahun)
    {

        $count = 0;
        $h = [];

        if ($category == 0) {

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    ->andWhere(['job_group' => $kumpulan])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        //$count = $count + 1;
                        array_push($h, $modelS->icno);
                    }
                }
                //                echo '<pre>' , var_dump(($h)) , '</pre>';
                //                die();

            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if ($modelS && ($modelS->jawatan->job_group == $kumpulan)) {
                        //$count = $count + 1;
                        array_push($h, $modelS->ICNO);
                    }
                }
            }
        } elseif ($category == 1) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->all();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 1])
                    ->all();

                //                echo '<pre>' , var_dump(($modelB)) , '</pre>';
                //                die();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        array_push($h, $modelS->icno);
                    }
                }

                //                echo '<pre>' , var_dump(count($h)) , '</pre>';
                //                die();

            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 1)
                    ) {
                        array_push($h, $modelS->ICNO);
                    }
                }
            }
        } elseif ($category == 2) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->all();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 2])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        array_push($h, $modelS->icno);
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 2)
                    ) {
                        array_push($h, $modelS->ICNO);
                    }
                }
            }
        } elseif ($category == 3) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->all();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    // ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 1])
                    ->all();

                //                echo '<pre>' , var_dump(($modelB)) , '</pre>';
                //                die();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        array_push($h, $modelS->icno);
                    }
                }

                //                echo '<pre>' , var_dump(count($h)) , '</pre>';
                //                die();

            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 1)
                    ) {
                        array_push($h, $modelS->ICNO);
                    }
                }
            }
        } elseif ($category == 5) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->all();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        array_push($h, $modelS->icno);
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 2)
                    ) {
                        array_push($h, $modelS->ICNO);
                    }
                }
            }
        }

        //        echo '<pre>' , var_dump(($model)) , '</pre>';
        //        die();

        if ($calctype == 0) { //countCapaiMin

            //            foreach ($model as $model){
            //                if ($model->idp_mata_min != 0){
            //
            //                    //if ($model->jum_mata_dikira >= $model->idp_mata_min){
            //                    if ($model->status == '2'){
            //                        $count = $count + 1;
            //                    } 
            //                }
            //            }

            $count = RptStatistikIdpV2::find()
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $h, 'status' => '2'])
                ->count();

            //                echo '<pre>' , var_dump(($count)) , '</pre>';
            //                die();

        } elseif ($calctype == 1) { //countBelumCapaiMin

            //            foreach ($model as $model){
            //                if ($model->idp_mata_min != 0){
            //
            ////                    if (($model->jum_mata_dikira < $model->idp_mata_min) 
            ////                            && ($model->jum_mata_dikira != 0) ){
            //                    if ($model->status == '1'){
            //                        $count = $count + 1;
            //                    } 
            //                }
            //            }

            $count = RptStatistikIdpV2::find()
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $h, 'status' => '1'])
                ->count();
        } elseif ($calctype == 2) { //countBelumAdaMata

            //            foreach ($model as $model){
            //                if ($model->idp_mata_min != 0){
            //
            ////                    if ($model->jum_mata_dikira == 0){
            //                    if ($model->status == '0'){
            //                        $count = $count + 1;
            //                    } 
            //                }
            //            }

            $count = RptStatistikIdpV2::find()
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $h, 'status' => '0'])
                ->count();
        }

        return $count;
    }

    public function getBakii()
    {

        if ($this->baki <= $this->idp_mata_min && $this->baki != 0 && is_int($this->idp_mata_min)) {
            return "<div style='color:red'>-" . $this->baki . "</div>";
        } else {
            if ($this->baki == 0) {
                return "<div style='color:green'>" . abs($this->baki) . "</div>";
            } else {
                return "<div style='color:green'>+" . abs($this->baki) . "</div>";
            }
        }
    }

    public function getMataMinKump()
    {

        if ($this->idp_mata_min && ($this->idp_mata_min != '0')) {

            return $this->idp_mata_min;
        } else {
            return "<div style='color:red'>Tidak perlu mata IDP</div>";
        }
    }

    public function countStatisticsByComponent($scheme, $jobgroup, $calctype, $component)
    {

        $count = 0;

        if ($jobgroup == 1) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['gred_skim' => $scheme, 'job_group' => '5'])
            //                    ->orWhere(['gred_skim' => $scheme, 'job_group' => '6'])
            //                    ->andWhere(['tblprcobiodata.Status' => '1', 'isKhas' => '0'])
            //                    ->andWhere(['<>', 'statLantikan', '2'])
            //                    ->all();

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['gred_skim' => $scheme, 'job_group' => '5'])
                ->orWhere(['gred_skim' => $scheme, 'job_group' => '6'])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        } elseif ($jobgroup == 2) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['gred_skim' => $scheme, 'job_group' => '4'])
            //                    ->andWhere(['tblprcobiodata.Status' => '1', 'isKhas' => '0'])
            //                    ->andWhere(['<>', 'statLantikan', '2'])
            //                    ->all();

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['gred_skim' => $scheme, 'job_group' => '4', 'staf_status' => '1', 'statusIDP' => '1'])
                ->orWhere(['gred_skim' => $scheme, 'job_group' => '1', 'staf_status' => '1', 'statusIDP' => '1', 'job_category' => '2'])
                ->all();
        } elseif ($jobgroup == 3) {

            //            $model = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['gred_skim' => $scheme, 'job_category' => '1', 'tblprcobiodata.Status' => '1', 'isKhas' => '0', 'statLantikan' => '1'])
            //                    ->orWhere(['gred_skim' => $scheme, 'job_category' => '1', 'tblprcobiodata.Status' => '1', 'isKhas' => '0', 'statLantikan' => '2'])
            //                    ->orWhere(['gred_skim' => $scheme, 'job_category' => '1', 'tblprcobiodata.Status' => '1', 'isKhas' => '0', 'statLantikan' => '3'])
            //                    ->all();

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['gred_skim' => $scheme, 'job_category' => '1', 'staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        }

        if ($calctype == 1 || $calctype == 2 || $calctype == 3) { //countAmountOfStaff

            if ($component == 5) {

                foreach ($model as $model) {

                    if ($model->idp_kom_teras_uni != 0) {

                        if ($model->idp_mata_teras_uni < $model->idp_kom_teras_uni) {
                            $count = $count + 1;
                        }
                    }
                }
            } elseif ($component == 6) {

                foreach ($model as $model) {

                    if ($model->idp_kom_teras_skim != 0) {

                        if ($model->idp_mata_teras_skim < $model->idp_kom_teras_skim) {
                            $count = $count + 1;
                        }
                    }
                }
            } elseif ($component == 4) {

                foreach ($model as $model) {

                    if ($model->idp_kom_elektif != 0) {

                        if ($model->idp_mata_elektif < $model->idp_kom_elektif) {
                            $count = $count + 1;
                        }
                    }
                }
            } elseif ($component == 3) {

                foreach ($model as $model) {

                    if ($model->idp_kom_teras != 0) {

                        if ($model->idp_mata_teras < $model->idp_kom_teras) {
                            $count = $count + 1;
                        }
                    }
                }
            } elseif ($component == 1) {

                foreach ($model as $model) {

                    if ($model->idp_kom_umum != 0) {

                        if ($model->idp_mata_umum < $model->idp_kom_umum) {
                            $count = $count + 1;
                        }
                    }
                }
            }

            if ($calctype == 2) { //countPercentage

                if (GredJawatan::countStaffByScheme($scheme, $jobgroup) != 0) {

                    $count = round($count / GredJawatan::countStaffByScheme($scheme, $jobgroup) * 100);
                    $count = $count . '%';
                }
            }
        }

        return $count;
    }

    public function getStatisticsByComponent($scheme, $jobgroup, $calctype, $component)
    {

        $count = 0;

        if ($jobgroup == 1) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['gred_skim' => $scheme, 'job_group' => '5'])
                ->orWhere(['gred_skim' => $scheme, 'job_group' => '6'])
                ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        } elseif ($jobgroup == 2) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['gred_skim' => $scheme, 'job_group' => '4', 'staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        } elseif ($jobgroup == 3) {

            $model = RptStatistikIdpV2::find()
                ->joinWith('biodata.jawatan')
                ->where(['gred_skim' => $scheme, 'job_category' => '1', 'staf_status' => '1', 'statusIDP' => '1'])
                ->all();
        }

        $a = [];
        if ($calctype == 1 || $calctype == 2 || $calctype == 3) { //countAmountOfStaff

            if ($component == 5) {

                foreach ($model as $model) {

                    if ($model->idp_kom_teras_uni != 0) {

                        if ($model->idp_mata_teras_uni < $model->idp_kom_teras_uni) {
                            //$count = $count + 1;
                            array_push($a, $model->icno);
                        }
                    }
                }
            } elseif ($component == 6) {

                foreach ($model as $model) {

                    if ($model->idp_kom_teras_skim != 0) {

                        if ($model->idp_mata_teras_skim < $model->idp_kom_teras_skim) {
                            //$count = $count + 1;
                            array_push($a, $model->icno);
                        }
                    }
                }
            } elseif ($component == 4) {

                foreach ($model as $model) {

                    if ($model->idp_kom_elektif != 0) {

                        if ($model->idp_mata_elektif < $model->idp_kom_elektif) {
                            //$count = $count + 1;
                            array_push($a, $model->icno);
                        }
                    }
                }
            } elseif ($component == 3) {

                foreach ($model as $model) {

                    if ($model->idp_kom_teras != 0) {

                        if ($model->idp_mata_teras < $model->idp_kom_teras) {
                            //$count = $count + 1;
                            array_push($a, $model->icno);
                        }
                    }
                }
            } elseif ($component == 1) {

                foreach ($model as $model) {

                    if ($model->idp_kom_umum != 0) {

                        if ($model->idp_mata_umum < $model->idp_kom_umum) {
                            //$count = $count + 1;
                            array_push($a, $model->icno);
                        }
                    }
                }
            }

            if ($calctype == 2) { //countPercentage

                if (GredJawatan::countStaffByScheme($scheme, $jobgroup) != 0) {

                    $count = round($count / GredJawatan::countStaffByScheme($scheme, $jobgroup) * 100);
                    $count = $count . '%';
                }
            }
        }

        $modelG = RptStatistikIdpV2::find()
            ->joinWith('biodata')
            ->where(['idp_rpt_statistik_idp_xpenilaian.icno' => $a])
            ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $modelG,
        ]);

        return $dataProvider;
    }

    public static function countStatisticsByScheme($gred_skim, $calctype, $tahun)
    {

        $count = 0;
        $h = [];

        if ($tahun == date('Y')) {

            $modelB = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['Status' => '1'])
                ->andWhere(['gred_skim' => $gred_skim])
                ->all();

            foreach ($modelB as $mB) {

                $modelS = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                    ->one();

                if ($modelS) {
                    array_push($h, $modelS->icno);
                }
            }
        } else {

            $modelB = RptStatistikIdpV2::find()
                ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                ->all();

            foreach ($modelB as $mB) {

                $modelS = Tblrscosandangan::find()
                    ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                    ->one();

                if (
                    $modelS
                    && ($modelS->jawatan->gred_skim == $gred_skim)
                ) {
                    array_push($h, $modelS->ICNO);
                }
            }
        }

        if ($calctype == 2) { //countCapaiMin

            $count = RptStatistikIdpV2::find()
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $h, 'status' => '2'])
                ->count();

        } elseif ($calctype == 1) { //countBelumCapaiMin

            $count = RptStatistikIdpV2::find()
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $h, 'status' => '1'])
                ->count();

        } elseif ($calctype == 0) { //countBelumAdaMata

            $count = RptStatistikIdpV2::find()
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $h, 'status' => '0'])
                ->count();
        }

        return $count;
    }
}
