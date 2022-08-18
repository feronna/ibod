<?php

namespace app\models\hronline;

use Yii;
use app\models\myidp\RptStatistikIdpV2;
use yii\db\Query;
use yii\db\QueryBuilder;

/**
 * This is the model class for table "hronline.kumpkhidmat".
 *
 * @property int $id
 * @property string $name
 * @property string $mymohesCd
 */
class Kumpulankhidmat extends \yii\db\ActiveRecord
{
    public $_totalCount;

    public static function getDb()
    {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.kumpkhidmat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['mymohesCd'], 'string', 'max' => 10],
            [['grpGroupCode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mymohesCd' => 'Mymohes Cd',
            'grpGroupCode' => 'GRP Salary Code',
        ];
    }

    public function getGredJawatan(){
        return $this->hasMany(GredJawatan::className(), ['job_group' => 'id']);
    }

    public static function countStaff($kumpulan, $category, $tahun)
    {

        $count = 0;

        if ($category == 0) { //keseluruhan

            if ($tahun == date('Y')) {

                //                $count = RptStatistikIdpV2::find()
                //                        ->joinWith('biodata.jawatan')
                //                        ->where(['job_group' => $kumpulan])
                //                        ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                //                        ->count();

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    ->andWhere(['job_group' => $kumpulan])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        $count = $count + 1;
                        //array_push($h, $modelS->icno);
                    }
                }
                //                echo '<pre>' , var_dump(($h)) , '</pre>';
                //                die();

            } else {

                //raw SQLs
                /**
                 * // returns all inactive customers
                        $sql = 'SELECT * FROM customer WHERE status=:status';
                        $customers = Customer::findBySql($sql, [':status' => Customer::STATUS_INACTIVE])->all();
                 */
                //                $sql = 'SELECT *
                //                        FROM hronline.tblrscosandangan g
                //                        JOIN hronline.gredjawatan h ON g.gredjawatan = h.id
                //                        WHERE g.start_date = (SELECT MAX(t2.start_date)
                //                                             FROM hronline.tblrscosandangan t2
                //                                             WHERE t2.ICNO = g.ICNO)
                //                        AND g.ICNO IN 
                //                        (SELECT DISTINCT a.ICNO
                //                            FROM hronline.tblrscosandangan a
                //                            JOIN hronline.gredjawatan b ON a.gredjawatan = b.id
                //                            JOIN hrd.idp_rpt_statistik_idp_xpenilaian d ON a.ICNO = d.icno
                //                            WHERE b.job_group ='.$kumpulan.'
                //                            AND d.staf_status = 1
                //                            AND d.statusIDP = 1
                //                            AND YEAR(a.start_date) != 2021
                //                            ORDER BY a.ICNO, a.id DESC)
                //                            AND h.job_group ='.$kumpulan; //di live not found hrd.idp_rpt_statistik_idp_xpenilaian
                //maybe sebab cross server

                //                $sql = 'SELECT *
                //                        FROM hronline.tblrscosandangan g
                //                        JOIN hronline.gredjawatan h ON g.gredjawatan = h.id
                //                        WHERE g.start_date = (SELECT MAX(t2.start_date)
                //                                             FROM hronline.tblrscosandangan t2
                //                                             WHERE t2.ICNO = g.ICNO)
                //                        AND g.ICNO IN 
                //                        (SELECT DISTINCT a.ICNO
                //                            FROM hronline.tblrscosandangan a
                //                            JOIN hronline.gredjawatan b ON a.gredjawatan = b.id
                //                            WHERE b.job_group ='.$kumpulan.'
                //                            AND YEAR(a.start_date) != '.date('Y').'
                //                            ORDER BY a.ICNO, a.id DESC)
                //                            AND h.job_group ='.$kumpulan;
                //                
                //                $modelS = Tblrscosandangan::findBySql($sql)
                //                        ->all();
                //                
                //                $subQuery = RptStatistikIdpV2::find()
                //                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                //                        ->all();
                //                
                //                
                //                $sount = 0;
                //                foreach ($modelS as $modelS){
                //                    foreach ($subQuery as $subq){
                //                        if ($subq->icno == $modelS->ICNO) {
                //                            $count = $count + 1;
                //                        }
                //                    }
                //                }
                //
                //                return $count;

                //                $count = RptStatistikIdpV2::find()
                //                        ->joinWith('sandangan.jawatan')
                //                        ->where(['job_group' => $kumpulan])
                //                        ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                //                        ->count();

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if ($modelS && ($modelS->jawatan->job_group == $kumpulan)) {
                        $count = $count + 1;
                        //array_push($h, $modelS->icno);
                    }
                }

                //                echo '<pre>' , var_dump(count($modelS)) , '</pre>';
                //                die();
            }
        } elseif ($category == 1) { //akademik

            //            $count = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->count();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 1])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        $count = $count + 1;
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 1)
                    ) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($category == 2) { //pentadbiran

            //            $count = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->count();

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
                        $count = $count + 1;
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 2)
                    ) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($category == 3) { //akademik

            //            $count = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->count();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    //                        ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 1])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        $count = $count + 1;
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 1)
                    ) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($category == 4) { //pentadbiran

            //            $count = RptStatistikIdpV2::find()
            //                    ->joinWith('biodata.jawatan')
            //                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
            //                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
            //                    ->count();

            if ($tahun == date('Y')) {

                $modelB = Tblprcobiodata::find()
                    ->joinWith('jawatan')
                    ->where(['Status' => '1'])
                    // ->andWhere(['cpd_group' => $kumpulan])
                    ->andWhere(['job_category' => 2])
                    ->all();

                foreach ($modelB as $mB) {

                    $modelS = RptStatistikIdpV2::find()
                        ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                        ->one();

                    if ($modelS) {
                        $count = $count + 1;
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if (
                        $modelS
                        && ($modelS->jawatan->cpd_group == $kumpulan)
                        && ($modelS->jawatan->job_category == 2)
                    ) {
                        $count = $count + 1;
                    }
                }
            }
        } elseif ($category == 5) { //keseluruhan

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
                        $count = $count + 1;
                    }
                }
            } else {

                $modelB = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                    ->all();

                //$h = [];
                foreach ($modelB as $mB) {

                    $modelS = Tblrscosandangan::find()
                        ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                        ->one();

                    if ($modelS && ($modelS->jawatan->job_group == $kumpulan)) {
                        $count = $count + 1;
                        //array_push($h, $modelS->icno);
                    }
                }
            }
        }

        return $count;
    }

    public function getTotal($category)
    {

        $count = 0;

        if ($category == 0) { //keseluruhan

            $count = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['<>', 'Status', '6'])
                ->count();
        } elseif ($category == 1) { //akademik

            $count = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['<>', 'Status', '6'])
                ->andWhere(['job_category' => 1])
                ->count();
        } elseif ($category == 2) { //pentadbiran

            $count = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['<>', 'Status', '6'])
                ->andWhere(['job_category' => 2])
                ->count();
        }

        return $count;
    }
}
