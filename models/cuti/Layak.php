<?php

namespace app\models\cuti;

use Yii;
use app\models\cuti\CutiRekod;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscoapmtstatus;
use DateTime;
use yii\helpers\Html;

use phpDocumentor\Reflection\Types\Self_;

/**
 * This is the model class for table "e_cuti.layak".
 *
 * @property string $layak_id
 * @property string $layak_icno
 * @property string $layak_mula
 * @property string $layak_tamat
 * @property int $layak_cuti
 * @property int $layak_bawa_lepas
 * @property int $layak_bawa_depan
 * @property int $layak_ambil
 * @property int $layak_gcr
 * @property int $layak_hapus
 */
class Layak extends \yii\db\ActiveRecord
{

    // public static function getDb()
    // {
    //     return Yii::$app->get('db2'); // second database
    // }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_entitlement';
        // return 'e_cuti.layak';
    }
    public $tempv2;
    public $tempv1;
    public $tempv3;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layak_mula', 'layak_tamat', 'tempv2', 'tempv1', 'tempv3'], 'safe'],
            [['indicator', 'layak_selaras', 'layak_cuti', 'layak_bawa_lepas', 'layak_bawa_depan', 'layak_ambil', 'layak_gcr', 'layak_hapus'], 'integer'],
            [['layak_icno'], 'string', 'max' => 12],
            [['catatan'], 'string'],
            // [['catatan'], 'required', 'message' => 'Sila Masukkan catatan'],

            [['layak_mula'], 'required', 'message' => 'Sila Pilih Tarikh Mula Kelayakan'],
            [['layak_mula'], 'checkEntitlement', 'on' => ['layak']],
            [['layak_bawa_depan'], 'checkCbth', 'on' => ['carry']],
            [['layak_bawa_depan'], 'checkCbth', 'on' => ['adjust']],
            [['layak_gcr'], 'checkGcr', 'on' => ['carry']],
            [['tempv3'], 'check', 'on' => ['adjust']],
            [['layak_hapus'], 'checkTotal', 'on' => ['carry']],
            // [['layak_hapus'], 'checkTotalA', 'on' => ['adjust']],
            [['layak_selaras'], 'checkAdjustment', 'on' => ['adjust']],
            [['gcrfile', 'adjfile'], 'safe'],
            [['gcrfile', 'adjfile'], 'file', 'maxSize' => 5242880],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'layak_id' => 'Layak ID',
            'layak_icno' => 'Layak Icno',
            'layak_mula' => 'Layak Mula',
            'layak_tamat' => 'Layak Tamat',
            'layak_cuti' => 'Layak Cuti',
            'layak_bawa_lepas' => 'Layak Bawa Lepas',
            'layak_bawa_depan' => 'Layak Bawa Depan',
            'layak_ambil' => 'Layak Ambil',
            'layak_gcr' => 'Layak Gcr',
            'layak_hapus' => 'Layak Hapus',
        ];
    }
    //to check if there any entitlement that need to be added
    public static function totalCheckent($icno)
    {
        $today = date('Y-m-d');
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['<=', 'layak_tamat', $today])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    //to check carried forward leave or for GCR
    public function checkAdjustment($attribute, $params)
    {
        $gcr =  Layak::getTotalGcr($this->layak_icno, 0);
        $ad = 160 - $gcr;
        //    var_dump($ad);die;

        if ($this->layak_gcr > $ad) {
            $this->addError($attribute, 'Penyelarasan Tidak Boleh Melebihi ' . floor($ad) . '.');
        }
    }
    public function checkCbth($attribute, $params)
    {

        // $lyk = Layak::findOne(['layak_id'=>$this->layak_id]);
        if ($this->layak_cuti  <= 20) {
            $check = 40;
        } else
            // if ($this->layak_cuti  == 20) {
            //     $check = 40;
            // }
            if ($this->layak_cuti  == 25) {
                $check = 50;
            } else
        if ($this->layak_cuti  == 35) {
                $check = 70;
            } else
        if ($this->layak_cuti  >= 30) {
                $check = 60;
            } else {
                $check = 50;
            }
        // $check = ($this->layak_cuti) / 2;
        // var_dump($lyk->layak_cuti);die;

        if ($this->layak_bawa_depan > $check) {
            $this->addError($attribute, 'CBTH Tidak Boleh Melebihi ' . floor($check) . '.');
        }
    }
    public function checkGcr($attribute, $params)
    {

        // $lyk = Layak::findOne(['layak_id'=>$this->layak_id]);
        $gcr =  Layak::getTotalGcr($this->layak_icno, 0);

        if ($this->layak_cuti  < 20) {
            $check = $this->layak_cuti;
        } else {


            if ($this->layak_cuti  >= 30) {
                $check = 15;
            } elseif ($this->layak_cuti == 25) {
                $check = 12;
            } else {
                $check = ($this->layak_cuti) / 2;
            }
        }
        // $check = ($this->layak_cuti) / 2;
        // var_dump($lyk->layak_cuti);die;


        if ($this->layak_gcr > $check) {
            $this->addError($attribute, 'GCR Tidak Boleh Melebihi ' . floor($check) . '.');
        }
        if (($this->layak_gcr + $gcr) > 160 ) {
            $this->addError($attribute, 'GCR Tidak Boleh melebihi 160 . Jumlah GCR Semasa Adalah ' . floor($gcr) . '.');
        }
    }
    public function check($attribute, $params)
    {

        // $lyk = Layak::findOne(['layak_id'=>$this->layak_id]);
        $gcr =  Layak::getTotalGcr($this->layak_icno, 0);
        $ad = 160 - $gcr;

        if ($this->tempv3  > $ad) {
            $this->addError($attribute, 'Penyelarasan GCR tidak boleh melebihi ' . floor($ad) . '.');
        }
     
        // if ($gcr > 150) {
        //     $this->addError($attribute, 'Penyelarasan GCR ' . floor($ad) . '.');
        // }
    }
    // public function checkTotalA($attribute, $params)
    // {

    //     // $lyk = Layak::findOne(['layak_id'=>$this->layak_id]);
    //     $check = Layak::getBakiLast($this->layak_id);
    //     $total = ($this->layak_bawa_depan + $this->layak_hapus + ( $this->tempv3));
    //     // var_dump($lyk->layak_cuti);die;

    //     if ($total != 0) {
    //         if ($check > $total) {
    //             $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR + Lupus = ' . $check . '.');
    //         } elseif ($check < $total) {
    //             $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR + Lupus Tidak Melebihi ' . $check . '.');
    //         }
    //     }
    // }
    public function checkTotal($attribute, $params)
    {

        // $lyk = Layak::findOne(['layak_id'=>$this->layak_id]);
        $check = Layak::getBakiLast($this->layak_id);
        $total = $this->layak_bawa_depan + $this->layak_hapus + $this->layak_gcr;
        // var_dump($lyk->layak_cuti);die;

        if ($total != 0) {
            if ($check > $total) {
                $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR + Lupus = ' . $check . '.');
            } elseif ($check < $total) {
                $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR + Lupus Tidak Melebihi ' . $check . '.');
            }
        }
    }
    public function checkEntitlement($attribute, $params)
    {
        // var_dump($this->layak_icno);die;
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        // $arr = explode(" ", $this->full_date);

        $start_sql = 'SELECT * FROM hrm.cuti_entitlement WHERE layak_icno=:icno AND (:date BETWEEN layak_mula AND layak_tamat)';
        $start_date_exist = Layak::findBySql($start_sql, [':icno' => $this->layak_icno, ':date' => $this->layak_mula])->exists();
        // $start_date_exist = Layak::find()
        // ->where(['between', $this->layak_mula, $start_date, $end_date])->andWhere(['icno' => $this->layak_icno])->andWhere(['!=', 'id', $this->id])->all();


        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan tarikh mula kelayakan lain!');
        }
    }
    public function getJumlahCuti()
    {
        $layak = ($this->layak_cuti);
        $bctl = ($this->layak_bawa_lepas);
        $jumlahCuti = ($layak + $bctl);

        return $jumlahCuti;
    }

    public function getMohon($icno)
    {

        return $this->hasOne(Layak::className(), ['layak_icno' => $icno])->andFilterWhere(['between', 'layak_mula', 'layak_tamat', $this->layak_mula, $this->layak_tamat])->all();
    }

    //Layak::find()->where(['layak_icno' => $icno])->andFilterWhere(['between', 'layak_mula', 'layak_tamat', $this->layak_mula, $this->layak_tamat])->all();

    public function getJumcuti()
    {
        return $this->getTotalcuti($this->layak_icno, $this->getTahunLayak());
    }

    public function getTahunLayak()
    {
        return Yii::$app->formatter->asDate($this->layak_mula, 'php:Y');
    }

    public function getJum()
    {
        return $this->getMohon($this->layak_icno);
    }

    public function getTotalcuti($icno, $year)
    {

        // $modelcuti = CutiRekod::find()->where(['cuti_icno' => $icno, 'cuti_jenis_id' => [1, 2]])->with('layak.mohon')->all();
        // $totalcuti = 0;
        // foreach ($modelcuti as $modelcutis) {
        //     $totalcuti = $modelcutis->cuti_tempoh;
        // }
        // $total = 0

        $model = TblRecords::find()->where(['icno' => $icno, 'jenis_cuti_id' => [1, 2], 'YEAR(start_date)' => $year])->count();

        return $model;
    }

    public function getbakiCuti()
    {
        $jum = $this->jumlahCuti;
        $mohon = $this->jumcuti;
        $bakiCuti = ($jum - $mohon);

        return $bakiCuti;
    }

    public function getTarikh($bulan)
    {

        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function getLayakMula()
    {
        return $this->getTarikh($this->layak_mula);
    }

    public function getLayakTamat()
    {
        return $this->getTarikh($this->layak_tamat);
    }

    /**
     * Function ni utk dptkan latest punya kelayakan. kdg2 dlm 1 tahun ada 2 kelayakan.. ni sebab yang kontrak
     * 
     * @param varchar $icno
     * @return object
     */
    public static function getLatestLayak($icno, $start = null, $year = null)
    {
        /*change to this after full migrate*/
        // $sql = "SELECT * FROM hrm.cuti_entitlement a
        //         INNER JOIN (SELECT b.layak_icno, MAX(b.layak_mula) AS layak_mula_latest FROM hrm.cuti_entitlement b GROUP BY b.layak_icno) 
        //         c ON a.layak_icno = c.layak_icno AND a.layak_mula = c.layak_mula_latest
        //         WHERE a.layak_icno= :icno
        //         LIMIT 1";


        // $sql = "SELECT * FROM e_cuti.layak a
        //         INNER JOIN (SELECT b.layak_icno, MAX(b.layak_mula) AS layak_mula_latest FROM e_cuti.layak b GROUP BY b.layak_icno) 
        //         c ON a.layak_icno = c.layak_icno AND a.layak_mula = c.layak_mula_latest
        //         WHERE a.layak_icno= :icno
        //         LIMIT 1";
        if (!$start) {
            $start = date('Y');
        }
        if (!$year) {
            $year = date('Y');
        }

        $model = Layak::find()->where(['layak_icno' => $icno])->andWhere(['YEAR(layak_mula)' => $start])->andWhere(['YEAR(layak_tamat)' => $year])->orderBy(['layak_mula' => SORT_DESC])->one();
        // $model = Layak::find()->where(['layak_icno' => $icno])->orderBy(['layak_mula' => SORT_ASC])->one();
        // var_dump($model);die;
        // $model = Layak::findBySql($sql, [':icno' => $icno])->one();

        // var_dump($model);die;
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }


    public static function getRate($icno, $start, $end)
    {

        $year = date('Y', strtotime($start));
        $total = 0;
        $rate = 0;
        $first = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->orderBy(['ApmtStatusStDt' => SORT_ASC])->andWhere(['=', 'ApmtStatusCd', '1'])->one();

        $data = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $stat = GredJawatan::find()->where(['id' => $data->gredJawatan])->one();
        if ($first) {

            if ($first->ApmtStatusStDt < "2005-09-01") {
                $rate = Layak::calRate($stat->job_group, $stat->gred_no, $first->ApmtStatusStDt, $start, $stat->gred_skim);
            }
            if (($first->ApmtStatusStDt >= "2005-09-01") && ($first->ApmtStatusStDt <= "2008-12-31")) {

                if (($stat->job_group != 1) && ($stat->gred_no  < 21) && ($stat->gred_skim != "VK") && ($stat->gred_skim != "VU")) {
                    // echo 'here';die;
                    $years = date('Y', strtotime($start)) - date('Y', strtotime($first->ApmtStatusStDt));
                    if ($years >= 10) {
                        $rate = 25;
                    } else {
                        $rate = 20;
                    }
                } elseif ((($stat->job_group != 1) && ($stat->gred_no  >= 21)) && (($stat->job_group != 1) && ($stat->gred_no  <= 30))) {
                    // echo 'sini';die;
                    $years = date('Y', strtotime($start)) - date('Y', strtotime($first->ApmtStatusStDt));
                    if ($years >= 10) {
                        $rate = 30;
                    } else {
                        $rate = 25;
                    }
                } else {

                    $years = date('Y', strtotime($start)) - date('Y', strtotime($first->ApmtStatusStDt));

                    // $diff = abs(strtotime($first->ApmtStatusStDt) - strtotime($start));
                    // $years = floor($diff / (365 * 60 * 60 * 24));
                    // var_dump($years);die;
                    if ($years >= 10) {
                        $rate = 30;
                    } else {
                        $rate = 30;
                    }
                }
                // echo $rate;die;
                // $rate = Layak::calRate($stat->job_group, $stat->gred_no, $first->ApmtStatusStDt, $start, $stat->gred_skim);
            }
            if ($first->ApmtStatusStDt > "2009-01-01") {
                if (($stat->job_group != 1) && ($stat->gred_no  < 21) && ($stat->gred_skim != "VK") && ($stat->gred_skim != "VU")) {
                    // echo '11';die;
                    $years = date('Y', strtotime($start)) - date('Y', strtotime($first->ApmtStatusStDt));

                    // $years = floor($diff / (365 * 60 * 60 * 24));
                    // var_dump($diff);die;
                    if ($years >= 10) {
                        $rate = 25;
                    } else {
                        $rate = 20;
                    }
                } else {

                    $rate = 25;
                }
            }
        } else {
            if (($stat->job_group != 1) && ($stat->gred_no  < 21) && ($stat->gred_skim != "VK") && ($stat->gred_skim != "VU") && ($stat->gred_skim != "UMSDF" && $stat->nama != "Postdoktoral" )) {

                $rate = 20;
            } else {

                $rate = 25;
            }
        }
        // var_dump($rate);die;
        $startDate = strtotime($start);
        $endDate = strtotime($end);
        $days = ($endDate - $startDate) / 86400 + 1;
        //Jumlah Hari Berkhidmat x (darab) Kadar Cuti Rehat Setahun( Entitlement) /(bahagi) 365 hari
        $total = round(($days * $rate) / 365);
        // var_dump($total);
        // die;

        return $total;
    }
    public static function calRate($job_group, $gred_no, $first_lantik, $start, $skim)
    {
        $rate = 0;
        // var_dump($job_group,$gred_no,$first_lantik,$start,$skim);die;
        if (($job_group != 1) && ($gred_no  < 21) && ($skim != "VK") && ($skim != "VU")) {

            $years = date('Y', strtotime($start)) - date('Y', strtotime($first_lantik));
            if ($years >= 10) {
                $rate = 25;
            } else {
                $rate = 20;
            }
        } elseif ((($job_group != 1) && ($gred_no  >= 21)) && (($job_group != 1) && ($gred_no  <= 30))) {


            $years = date('Y', strtotime($start)) - date('Y', strtotime($first_lantik));
            // $years = floor($diff / (365 * 60 * 60 * 24));
            if ($years >= 10) {
                $rate = 30;
            } else {
                $rate = 25;
            }
        } else {

            $years = date('Y', strtotime($start)) - date('Y', strtotime($first_lantik));
            // $years = floor($diff / (365 * 60 * 60 * 24));
            // var_dump($years);die;
            if ($years >= 10) {
                $rate = 35;
            } else {
                $rate = 30;
            }
        }
        return $rate;
    }
    public static function getLayakCuti($icno, $start, $end = null)
    {
        $year = date('Y', strtotime($start));
        if ($end == null) {
            $end = $year . '-12-31';
        }
        // var_dump($icno, $start, $end);die;

        $total = 0;
        $rate = 25;
        $first = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->orderBy(['ApmtStatusStDt' => SORT_ASC])->one();

        $data = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $stat = GredJawatan::find()->where(['id' => $data->gredJawatan])->one();
        if (($stat->job_group != 1) && ($stat->gred_no < 21)) {
            $rate = 20;
            // var_dump($first->ApmtStatusStDt);die;
            $diff = abs(strtotime($first->ApmtStatusStDt) - strtotime($start));
            $years = floor($diff / (365 * 60 * 60 * 24));
            if ($years >= 10) {
                $rate = 25;
            }
        }
        $startDate = strtotime($start);
        $endDate = strtotime($end);

        $days = ($endDate - $startDate) / 86400 + 1;
        //Jumlah Hari Berkhidmat x (darab) Kadar Cuti Rehat Setahun( Entitlement) /(bahagi) 365 hari
        $total = floor(($days * $rate) / 365);
        // var_dump($total);die;

        return $total;
    }

    public static function getBakiOld($icno, $start = null, $end)
    {
        // var_dump($icno, $start , $end);die;
        $baki = 0;
        if ($start == NULL) {
            // echo 'ddd';die;
            $layak = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $end])->one();
        } else {
            // echo 'd';die;
            $layak = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_mula' => $start])->andWhere(['layak_tamat' => $end])->one();
        }

        if ($layak) {
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas + $layak->layak_selaras;

            $jum_cuti = TblRecords::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $total_layak - $jum_cuti;
        }
        // var_dump($baki);die;
        return $baki;
    }
    public static function getBakiGcr($icno, $start, $end)
    {
        $baki = 0;

        $layak = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $end])->one();

        if ($layak) {
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;

            $jum_cuti = TblRecords::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $total_layak - $jum_cuti;
        }
        // var_dump($baki);die;
        return $baki;
    }

    public static function getBakiLatest($icno)
    {

        $baki = 0;

        $layak = self::getLatestLayak($icno);

        if ($layak) {
            // $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas + $layak->layak_selaras;

            $jum_cuti = TblRecords::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $total_layak - $jum_cuti;
        }
        // var_dump($baki);die;

        return $baki;
    }
    //total cuti layakk + layak bawa lepas
    public static function getTotal($icno, $start, $end)
    {

        $baki = 0;

        $layak = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_mula' => $start])->andWhere(['layak_tamat' => $end])->one();

        if ($layak) {
            $baki = $layak->layak_cuti + $layak->layak_bawa_lepas;
        }

        return $baki;
    }

    public static function getTotalGcr($icno, $year)
    {

        $sumtotal = 0;

        if ($year == 0) {
            $layak = Layak::find()->where(['layak_icno' => $icno])->all();
        } else {

            $layak = Layak::find()->where(['layak_icno' => $icno])->andWhere(['YEAR(layak_mula)' => $year])->all();
        }

        foreach ($layak as $sum) {
            $sumtotal += $sum['layak_gcr'];
        }

        return $sumtotal;
    }

    public static function getTotalGcrA($icno, $year)
    {

        $sumtotal = 0;
        $sumtotal1 = 0;
        $sumtotal2 = 0;

        if ($year == 0) {
            $layak = Layak::find()->where(['layak_icno' => $icno])->all();
        } else {

            $layak = Layak::find()->where(['layak_icno' => $icno])->andWhere(['YEAR(layak_mula)' => $year])->all();
        }

        foreach ($layak as $sum) {
            $sumtotal1 += $sum['layak_gcr'];
            $sumtotal2 += $sum['layak_selaras'];

            $sumtotal =  $sumtotal1 -  $sumtotal2;
        }

        return $sumtotal;
    }



    public static function getEntitlementDate($icno, $start, $end, $year)
    {

        $baki = 0;
        // var_dump($end);
        if ($year == 0) {
            $date = DateTime::createFromFormat("Y-m-d", $end);
            $tahun =  $date->format("Y");
            $layak = self::find()->where(['>', 'layak_tamat', $end])->andWhere(['layak_icno' => $icno])->andWhere(['YEAR(layak_mula)' => $tahun])->one();

            // foreach($layak as $lyk){
            //     $layak1 = $lyk->layak_mula;
            //     $layak2= $lyk->layak_tamat;
            // }
            // $entitlement = $layak1 .' - '.$layak2;
            $entitlement = $layak->layak_mula . ' - ' . $layak->layak_tamat;
        } else {


            $layak = self::find()->where(['>', 'layak_tamat', $end])->andWhere(['layak_icno' => $icno])->andWhere(['YEAR(layak_mula)' => $year])->one();
            // var_dump($layak);die;
            // if ($layak) {
            //     $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;

            //     $jum_cuti = CutiRekod::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            //     $baki = $total_layak - $jum_cuti;
            // }
            $entitlement = $layak->layak_mula . ' - ' . $layak->layak_tamat;
        }
        return $entitlement;
    }

    public function getLayakMulaDmy()
    {

        return $this->changeDateFormat($this->layak_mula);
    }

    public function getLayakTamatDmy()
    {

        return $this->changeDateFormat($this->layak_tamat);
    }

    public function changeDateFormat($date)
    {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getTotalLayak()
    {
        return $this->layak_cuti + $this->layak_bawa_lepas;
    }

    // public static function getListTahunLayak($icno) {

    //     $model = Layak::find()->where(['icno'=>$icno])->all();

    //     return $model;

    // }

    //
    public static function getBakiLast($id)
    {

        $baki = 0;
        $layak =  Layak::find()->where(['layak_id' => $id])->one();
        if ($layak) {
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;

            $jum_cuti = TblRecords::totalCuti($layak->layak_icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $total_layak - $jum_cuti;
        }
        // echo($id.'/');

        return $baki;
    }


    public function getTahunCuti($icno = null) // List down tahun bercuti untuk penyata
    {

        // $criteria=new CDbCriteria;
        // $login = $icno ? $icno : Yii::app()->user->getState('ICNO');

        // $criteria->select='DATE_FORMAT(layak_mula,"%Y") tahun_cuti';
        // $criteria->condition='layak_icno=:layak_icno';
        // $criteria->params=array(':layak_icno'=>$login);
        // $criteria->order='tahun_cuti DESC';
        // $model = Layak::model()->findAll($criteria);
        $model = Layak::find()
            ->where(['layak_icno' => $this->layak_icno])
            ->groupBy(['tahun_cuti' => SORT_DESC]);
        return $model;
    }

    public function getTahun()
    {

        //     $model = Layak::find()
        // ->where(['layak_icno'=>$icno])
        // ->groupBy (['tahun_cuti'=>SORT_DESC]);  

        return date('Y', strtotime($this->layak_mula));
        // return $model;
    }
    public function getDisplayLink()
    {
        if (!empty($this->file_hashcode && $this->file_hashcode != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->file_hashcode), Yii::$app->FileManager->DisplayFile($this->file_hashcode));
        }
        return 'File not exist!';
    }
}
