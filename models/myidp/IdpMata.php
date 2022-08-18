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
class IdpMata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_tbl_idpmata}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staffID', 'tahun'], 'required'],
            [['mataUmum', 'mataElektif', 'mataTeras', 'mataTerasUni', 'mataTerasSkim', 'status', 'statusIDP', 'statusIDP2', 'status_pb', 'id_cb_tbl_pengajian'], 'number'],
            [['staffID'], 'string', 'max' => 12],
            [['tahun'], 'string', 'max' => 4],
            [['staffID', 'tahun'], 'unique', 'targetAttribute' => ['staffID', 'tahun']],
            [['tarikhKemaskini'], 'safe'],
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
            'tarikhKemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staffID']);
    }

    public function getMataMinKump()
    {

        $model3 = Tblprcobiodata::findOne(['ICNO' => $this->staffID]);
        //        $gredj = $model3->jawatan->gred;
        //        
        //        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj])->one();
        ////        $cpdgroup = $modelcpdgroupgj->cpdgroup;
        ////        $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
        //
        ////        return $modelcpdgroup->mataMin;
        //        
        //        if ($modelcpdgroupgj) {
        //
        //            $cpdgroup = $modelcpdgroupgj->cpdgroup;
        //            $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
        //            
        //            return $modelcpdgroup->mataMin;
        //        } else {
        //            return "<div style='color:red'>Tidak perlu mata IDP</div>";
        //        }

        if ($model3) {

            $model = RptStatistikIdp::find()->where(['icno' => $this->staffID, 'tahun' => $this->tahun])->one();

            if ($model) {

                return $model->idp_mata_min;
            } else {
                return "<div style='color:red'>Tidak perlu mata IDP</div>";
            }
        }
    }

    public function getMinKompetensi($type)
    {

        $model3 = Tblprcobiodata::findOne(['ICNO' => $this->staffID]);
        //        $gredj = $model3->jawatan->gred;
        //        
        //        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj])->one();
        //        $cpdgroup = $modelcpdgroupgj->cpdgroup;
        //        $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
        //        
        //        if ($type == 5){
        //            
        //            return $modelcpdgroup->minTerasUni;
        //        } elseif ($type == 6) {
        //            return $modelcpdgroup->minTerasSkim;
        //        
        //        } elseif($type == 4) {
        //            return $modelcpdgroup->minElektif;
        //        } elseif($type == 3) {
        //            return $modelcpdgroup->minTeras;
        //        } elseif($type == 1) {
        //            return $modelcpdgroup->minUmum;
        //        } 

        if ($model3) {

            $model = RptStatistikIdp::find()->where(['icno' => $this->staffID, 'tahun' => $this->tahun])->one();

            if ($model) {
                if ($type == 5) {
                    return $model->idp_kom_teras_uni;
                } elseif ($type == 6) {
                    return $model->idp_kom_teras_skim;
                } elseif ($type == 4) {
                    return $model->idp_kom_elektif;
                } elseif ($type == 3) {
                    return $model->idp_kom_teras;
                } elseif ($type == 1) {
                    return $model->idp_kom_umum;
                }
            }
        }
    }

    public function getPercentKompetensi($type)
    {

        if ($type == 5) {
            $a = $this->mataTerasUni;
        } elseif ($type == 6) {
            $a = $this->mataTerasSkim;
        } elseif ($type == 4) {
            $a = $this->mataElektif;
        } elseif ($type == 3) {
            $a = $this->mataTeras;
        } elseif ($type == 1) {
            $a = $this->mataUmum;
        }

        if ((($a / $this->getMinKompetensi($type)) * 100) >= 100) {
            $p = 100;
        } else {
            $p = ($a / $this->getMinKompetensi($type)) * 100;
        }

        return $p;
    }

    public function getColorKompetensi($type)
    {

        if ($type == 5) {
            $a = $this->mataTerasUni;
        } elseif ($type == 6) {
            $a = $this->mataTerasSkim;
        } elseif ($type == 4) {
            $a = $this->mataElektif;
        } elseif ($type == 3) {
            $a = $this->mataTeras;
        } elseif ($type == 1) {
            $a = $this->mataUmum;
        }

        if ($a >= $this->getMinKompetensi($type)) {
            $progressBarColour = 'progress-bar-success';
        } else {
            $progressBarColour = 'progress-bar-danger';
        }

        return $progressBarColour;
    }

    public function getPbarLabel($type)
    {

        if ($type == 5) {
            $a = $this->mataTerasUni;
        } elseif ($type == 6) {
            $a = $this->mataTerasSkim;
        } elseif ($type == 4) {
            $a = $this->mataElektif;
        } elseif ($type == 3) {
            $a = $this->mataTeras;
        } elseif ($type == 1) {
            $a = $this->mataUmum;
        }

        if (round((($a / $this->getMinKompetensi($type)) * 100), 0) >= 100) {
            $a = '100%';
        } else {
            $a = round((($a / $this->getMinKompetensi($type)) * 100), 0) . '%';
        }

        return $a;
    }

    public function getJumlahMataAmbilKira()
    {

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
        } elseif ($model3->jawatan->job_category == 1) {

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

    public function getBaki()
    {

        $baki = $this->getMataMinKump() - $this->getJumlahMataAmbilKira();

        //        if ($this->biodata->jawatan->job_category == 2){
        //        
        //            $baki = $this->getMataMinKump() - $this->mataTerasUni - $this->mataTerasSkim - $this->mataElektif;
        //        } elseif ($this->biodata->jawatan->job_category == 1){
        //            $baki = $this->getMataMinKump() - $this->mataTeras - $this->mataUmum - $this->mataElektif;
        //        }

        if ($baki <= $this->getMataMinKump() && $baki != 0 && is_int($this->getMataMinKump())) {
            return "<div style='color:red'>-" . $baki . "</div>";
        } else {
            if ($baki == 0) {
                return "<div style='color:green'>" . abs($baki) . "</div>";
            } else {
                return "<div style='color:green'>+" . abs($baki) . "</div>";
            }
        }
    }

    public function getMataMinKump2()
    {

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

    public function updateMata($staffChosen, $year)
    {
        //table mata
        $check = IdpMata::find()->where(['tahun' => $year, 'staffID' => $staffChosen])->one();

        $arrayJenis = array("1", "3", "4", "5", "6");

        for ($i = 0; $i < count($arrayJenis); $i++) {

            $mataaa = 0;
            $mataaax = 0;

            $elektif = Kehadiran::find()
                ->where(['idp_kehadiran.staffID' => $check->staffID])
                ->andWhere(['idp_kehadiran.kategoriKursusID' => $arrayJenis[$i]])
                ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $year])
                ->all();

            foreach ($elektif as $mataaxp) {

                if ($arrayJenis[$i] != 1) {
                    $mataaax = $mataaax + $mataaxp->sasaran9->mataSlot;
                } elseif ($arrayJenis[$i] == 1) {
                    $mataaax = $mataaax + 1;
                }
            }

            if ($arrayJenis[$i] != 1) {

                foreach ($elektif as $mataa) {

                    if ($mataa->sasaran9->sasaran4->sasaran3->jenisLatihanID != 'jfpiu') {

                        $checkBorang = BorangPenilaianLatihan::find()
                            ->where(['siriLatihanID' => $mataa->sasaran9->siriLatihanID])
                            ->andWhere(['pesertaID' => $check->staffID])
                            ->andWhere(['statusBorang' => 2])
                            ->one();

                        if ($checkBorang) {
                            $mataaa = $mataaa + $mataa->sasaran9->mataSlot;
                        }
                    } else {
                        $mataaa = $mataaa + $mataa->sasaran9->mataSlot;
                    }
                }
            } else {

                foreach ($elektif as $mataa) {
                    $mataaa = $mataaa + 1;
                }
            }

            $check2 = IdpMataV2::find()->where(['tahun' => $check->tahun, 'staffID' => $check->staffID])->one();

            if ($arrayJenis[$i] == 1) {
                $check->mataUmum = $mataaa;
            } elseif ($arrayJenis[$i] == 3) {
                $check->mataTeras = $mataaa;
            } elseif ($arrayJenis[$i] == 4) {
                $check->mataElektif = $mataaa;
            } elseif ($arrayJenis[$i] == 5) {
                $check->mataTerasUni = $mataaa;
            } elseif ($arrayJenis[$i] == 6) {
                $check->mataTerasSkim = $mataaa;
            }

            //added on 25/3/2021 because V1 and V2 does not have the same amount of staff
            if ($check2) {
                if ($arrayJenis[$i] == 1) {
                    $check2->mataUmum = $mataaax;
                } elseif ($arrayJenis[$i] == 3) {
                    $check2->mataTeras = $mataaax;
                } elseif ($arrayJenis[$i] == 4) {
                    $check2->mataElektif = $mataaax;
                } elseif ($arrayJenis[$i] == 5) {
                    $check2->mataTerasUni = $mataaax;
                } elseif ($arrayJenis[$i] == 6) {
                    $check2->mataTerasSkim = $mataaax;
                }
            }

            $check->tarikhKemaskini = date('Y-m-d H:i:s');

            $check->save(false);
            if ($check2) {
                $check2->save(false);
            }
        }

        //table statistik
        /** current year **/

        $modelB = RptStatistikIdp::find()
            ->where(['icno' => $check->staffID])
            ->andWhere(['tahun' => $year])
            ->one();

        if (!$modelB) {
            $modelBB = new RptStatistikIdp();
            $modelBB->icno = $check->staffID;
            $modelBB->tahun = $year;
            $modelBB->staf_status = $check->status;
            $modelBB->statusIDP = $check->statusIDP;
            $modelBB->statusIDP2 = $check->statusIDP2;
            $modelBB->tarikh_kemaskini = date('Y-m-d H:i:s');
            $modelBB->save(false);
        } else {
            $modelB->staf_status = $check->status;
            $modelB->statusIDP = $check->statusIDP;
            $modelB->statusIDP2 = $check->statusIDP2;
            $modelB->tarikh_kemaskini = date('Y-m-d H:i:s');
            $modelB->save(false);
        }

        $new = RptStatistikIdp::find()
            ->where(['icno' => $check->staffID])
            ->andWhere(['tahun' => $year])
            ->one();

        $new->idp_mata_teras = $check->mataTeras;
        $new->idp_mata_elektif = $check->mataElektif;
        $new->idp_mata_umum = $check->mataUmum;
        $new->idp_mata_teras_skim = $check->mataTerasSkim;
        $new->idp_mata_teras_uni = $check->mataTerasUni;

        /** calculate min **/
        $model3 = Tblprcobiodata::findOne(['ICNO' => $check->staffID]);

        if ($model3) {
            $gredj = $model3->jawatan->gred;

            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => $year])->one();

            if ($modelcpdgroupgj) {

                $cpdgroup = $modelcpdgroupgj->cpdgroup;
                $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup, 'tahun' => $year])->one();

                //                        if ($new->staf_status == '1' && $new->statusIDP2 == '1'){
                //                        if ($new->staf_status == '1' && $new->statusIDP2 != '2'){
                //                            if ($new->staf_status == '1' && $new->statusIDP2 != '3'){
                if (($new->staf_status == '1' && $new->statusIDP2 == '1') ||
                    ($new->staf_status == '1' && $new->statusIDP2 == '5') ||
                    ($new->staf_status == '1' && $new->statusIDP2 == '6') ||
                    ($new->staf_status == '1' && $new->statusIDP2 == '7')
                ) {
                    $mataMin = $modelcpdgroup->mataMin;
                    $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                    $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                    $mataMinElektif = $modelcpdgroup->minElektif;
                    $mataMinTeras = $modelcpdgroup->minTeras;
                    $mataMinUmum = $modelcpdgroup->minUmum;
                    //}     
                } elseif (($new->staf_status == '2' && $new->statusIDP2 == '7') ||
                    ($new->staf_status == '3' && $new->statusIDP2 == '7') ||
                    ($new->staf_status == '4' && $new->statusIDP2 == '7')
                ) {

                    $mataMin = 0;
                    $mataMinTerasUni = 0;
                    $mataMinTerasSkim = 0;
                    $mataMinElektif = 0;
                    $mataMinTeras = 0;
                    $mataMinUmum = 0;
                } elseif (($new->staf_status == '1' && $new->statusIDP2 == '2')) {

                    if ($modelcpdgroup->mataMin != 0) {
                        $mataMin = round($modelcpdgroup->mataMin / 2, 0);
                    } else {
                        $mataMin = $modelcpdgroup->mataMin;
                    }

                    if ($modelcpdgroup->minTerasUni != 0) {
                        $mataMinTerasUni = round($modelcpdgroup->minTerasUni / 2, 0);
                    } else {
                        $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                    }

                    if ($modelcpdgroup->minTerasSkim != 0) {
                        $mataMinTerasSkim = round($modelcpdgroup->minTerasSkim / 2, 0);
                    } else {
                        $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                    }

                    if ($modelcpdgroup->minElektif != 0) {
                        $mataMinElektif = round($modelcpdgroup->minElektif / 2, 0);
                    } else {
                        $mataMinElektif = $modelcpdgroup->minElektif;
                    }

                    if ($modelcpdgroup->minTeras != 0) {
                        $mataMinTeras = round($modelcpdgroup->minTeras / 2, 0);
                    } else {
                        $mataMinTeras = $modelcpdgroup->minTeras;
                    }

                    if ($modelcpdgroup->minUmum != 0) {
                        $mataMinUmum = round($modelcpdgroup->minUmum / 2, 0);
                    } else {
                        $mataMinUmum = $modelcpdgroup->minUmum;
                    }
                } elseif (($new->staf_status == '1' && $new->statusIDP2 == '3')) {

                    if ($modelcpdgroup->mataMin != 0) {
                        $mataMin = round(round($modelcpdgroup->mataMin / 2, 0) / 2, 0);
                    } else {
                        $mataMin = $modelcpdgroup->mataMin;
                    }

                    if ($modelcpdgroup->minTerasUni != 0) {
                        $mataMinTerasUni = round(round($modelcpdgroup->minTerasUni / 2, 0) / 2, 0);
                    } else {
                        $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                    }

                    if ($modelcpdgroup->minTerasSkim != 0) {
                        $mataMinTerasSkim = round(round($modelcpdgroup->minTerasSkim / 2, 0) / 2, 0);
                    } else {
                        $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                    }

                    if ($modelcpdgroup->minElektif != 0) {
                        $mataMinElektif = round(round($modelcpdgroup->minElektif / 2, 0) / 2, 0);
                    } else {
                        $mataMinElektif = $modelcpdgroup->minElektif;
                    }

                    if ($modelcpdgroup->minTeras != 0) {
                        $mataMinTeras = round(round($modelcpdgroup->minTeras / 2, 0) / 2, 0);
                    } else {
                        $mataMinTeras = $modelcpdgroup->minTeras;
                    }

                    if ($modelcpdgroup->minUmum != 0) {
                        $mataMinUmum = round(round($modelcpdgroup->minUmum / 2, 0) / 2, 0);
                    } else {
                        $mataMinUmum = $modelcpdgroup->minUmum;
                    }
                }

                if ($new->biodata->jawatan->job_category == 1) {
                    if (($mataMinTeras + $mataMinElektif + $mataMinUmum) > $mataMin) {
                        $mataMinUmum = $mataMinUmum - abs($mataMin - ($mataMinTeras + $mataMinElektif + $mataMinUmum));
                    }
                } elseif ($new->biodata->jawatan->job_category == 2) {
                    if (($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim) > $mataMin) {
                        $mataMinElektif = $mataMinElektif - abs($mataMin - ($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim));
                    }
                }

                $new->idp_mata_min = $mataMin;
                $new->idp_kom_teras_uni = $mataMinTerasUni;
                $new->idp_kom_teras_skim = $mataMinTerasSkim;
                $new->idp_kom_elektif = $mataMinElektif;
                $new->idp_kom_teras = $mataMinTeras;
                $new->idp_kom_umum = $mataMinUmum;

                if ($model3->jawatan->job_category == 2) {

                    //                            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
                    //                            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
                    //                            $minTerasSkim = $modelcpdgroup->minTerasSkim;

                    $minElektif = $mataMinElektif; //fixed data in db
                    $minTerasUniversiti = $mataMinTerasUni;
                    $minTerasSkim = $mataMinTerasSkim;

                    if ($check->mataElektif >= $minElektif) {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $minElektif;
                    } else {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $check->mataElektif;
                    }

                    /*             * ************************************************************************ */
                    if ($check->mataTerasUni >= $minTerasUniversiti) {
                        $terasUniTrue = $minTerasUniversiti;
                    } else {
                        $terasUniTrue = $check->mataTerasUni;
                    }

                    /*             * ************************************************************************** */
                    if ($check->mataTerasSkim >= $minTerasSkim) {
                        $terasSkimTrue = $minTerasSkim;
                    } else {
                        $terasSkimTrue = $check->mataTerasSkim;
                    }

                    /*             * ************************************************************************** */
                    //amountOfPoint that are actually counted
                    $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;
                    $jumlahMataSemasa = $check->mataElektif + $check->mataTerasUni + $check->mataTerasSkim + $check->mataUmum;
                } elseif ($model3->jawatan->job_category == 1) {

                    //                            $minMata = $modelcpdgroup->mataMin;

                    //academic - comment out on 9/12/2020
                    //                            $minMata = $mataMin;
                    //
                    //                            $minTerasAcademic = round(0.5 * $minMata);
                    //                            $minElektifAcademic = round(0.3 * $minMata);
                    //                            $minUmumAcademic = round(0.2 * $minMata);

                    $minTerasAcademic = $mataMinTeras;
                    $minElektifAcademic = $mataMinElektif;
                    $minUmumAcademic = $mataMinUmum;

                    //determine IDP percentage and progress-bar colour
                    if ($check->mataElektif >= $minElektifAcademic) {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $minElektifAcademic;
                    } else {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $check->mataElektif;
                    }

                    /*             * ************************************************************************ */
                    if ($check->mataTeras >= $minTerasAcademic) {
                        $terasTrue = $minTerasAcademic;
                    } else {
                        $terasTrue = $check->mataTeras;
                    }

                    /*             * ************************************************************************** */
                    if ($check->mataUmum >= $minUmumAcademic) {
                        $umumTrue = $minUmumAcademic;
                    } else {
                        $umumTrue = $check->mataUmum;
                    }

                    /*************************************************************************** */
                    //amountOfPoint that are actually counted
                    $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;
                    $jumlahMataSemasa = $check->mataElektif + $check->mataTeras + $check->mataUmum;
                }

                $new->jum_mata_dikira = $jumlahMataAmbilKira;
                $new->jum_mata_semasa = $jumlahMataSemasa;

                //$new->baki = $modelcpdgroup->mataMin - $jumlahMataAmbilKira;

                $new->baki = $mataMin - $jumlahMataAmbilKira;

                if ($new->baki == 0) {
                    $new->status = 2;
                } elseif ($new->baki > 0) {
                    $new->status = 1;
                }

                $new->save(false);
            }
        }
        /** closed check **/


        /**** xpenilaian ****/

        $modelBB = RptStatistikIdpV2::find()->where(['icno' => $check2->staffID])->andWhere(['tahun' => $year])->one();

        if (!$modelBB) {
            $modelBB = new RptStatistikIdpV2();
            $modelBB->icno = $check2->staffID;
            $modelBB->tahun = $year;
            $modelBB->staf_status = $check2->status;
            $modelBB->statusIDP = $check2->statusIDP;
            $modelBB->statusIDP2 = $check2->statusIDP2;
            $modelBB->tarikh_kemaskini = date('Y-m-d H:i:s');
            $modelBB->save(false);
        } else {
            $modelBB->staf_status = $check2->status;
            $modelBB->statusIDP = $check2->statusIDP;
            $modelBB->statusIDP2 = $check2->statusIDP2;
            $modelBB->tarikh_kemaskini = date('Y-m-d H:i:s');
            $modelBB->save(false);
        }

        $new = RptStatistikIdpV2::find()->where(['tahun' => $year, 'icno' => $check2->staffID])->one();

        $new->idp_mata_teras = $check->mataTeras;
        $new->idp_mata_elektif = $check->mataElektif;
        $new->idp_mata_umum = $check->mataUmum;
        $new->idp_mata_teras_skim = $check->mataTerasSkim;
        $new->idp_mata_teras_uni = $check->mataTerasUni;

        /** calculate min **/
        $model3 = Tblprcobiodata::findOne(['ICNO' => $check2->staffID]);

        if ($model3) {

            $gredj = $model3->jawatan->gred;

            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => $year])->one();

            if ($modelcpdgroupgj) {

                $cpdgroup = $modelcpdgroupgj->cpdgroup;
                $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup, 'tahun' => $year])->one();

                //                        $new->idp_mata_min = $modelcpdgroup->mataMin;
                //                        $new->idp_kom_teras_uni = $modelcpdgroup->minTerasUni;
                //                        $new->idp_kom_teras_skim = $modelcpdgroup->minTerasSkim;
                //                        $new->idp_kom_elektif = $modelcpdgroup->minElektif;
                //                        $new->idp_kom_teras = $modelcpdgroup->minTeras;
                //                        $new->idp_kom_umum = $modelcpdgroup->minUmum;

                if (($new->staf_status == '1' && $new->statusIDP2 == '1') ||
                    ($new->staf_status == '1' && $new->statusIDP2 == '5') ||
                    ($new->staf_status == '1' && $new->statusIDP2 == '6') ||
                    ($new->staf_status == '1' && $new->statusIDP2 == '7')
                ) {
                    //                        if ($new->staf_status == '1' && $new->statusIDP2 != '2'){
                    //                            if ($new->staf_status == '1' && $new->statusIDP2 != '3'){
                    $mataMin = $modelcpdgroup->mataMin;
                    $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                    $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                    $mataMinElektif = $modelcpdgroup->minElektif;
                    $mataMinTeras = $modelcpdgroup->minTeras;
                    $mataMinUmum = $modelcpdgroup->minUmum;
                    //                            }

                    //} elseif ($new->staf_status == '1' && $new->statusIDP2 == '2'){
                } elseif (($new->staf_status == '2' && $new->statusIDP2 == '7') ||
                    ($new->staf_status == '3' && $new->statusIDP2 == '7') ||
                    ($new->staf_status == '4' && $new->statusIDP2 == '7')
                ) {

                    $mataMin = 0;
                    $mataMinTerasUni = 0;
                    $mataMinTerasSkim = 0;
                    $mataMinElektif = 0;
                    $mataMinTeras = 0;
                    $mataMinUmum = 0;
                } elseif (($new->staf_status == '1' && $new->statusIDP2 == '2')) {

                    if ($modelcpdgroup->mataMin != 0) {
                        $mataMin = round($modelcpdgroup->mataMin / 2, 0);
                    } else {
                        $mataMin = $modelcpdgroup->mataMin;
                    }

                    if ($modelcpdgroup->minTerasUni != 0) {
                        $mataMinTerasUni = round($modelcpdgroup->minTerasUni / 2, 0);
                    } else {
                        $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                    }

                    if ($modelcpdgroup->minTerasSkim != 0) {
                        $mataMinTerasSkim = round($modelcpdgroup->minTerasSkim / 2, 0);
                    } else {
                        $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                    }

                    if ($modelcpdgroup->minElektif != 0) {
                        $mataMinElektif = round($modelcpdgroup->minElektif / 2, 0);
                    } else {
                        $mataMinElektif = $modelcpdgroup->minElektif;
                    }

                    if ($modelcpdgroup->minTeras != 0) {
                        $mataMinTeras = round($modelcpdgroup->minTeras / 2, 0);
                    } else {
                        $mataMinTeras = $modelcpdgroup->minTeras;
                    }

                    if ($modelcpdgroup->minUmum != 0) {
                        $mataMinUmum = round($modelcpdgroup->minUmum / 2, 0);
                    } else {
                        $mataMinUmum = $modelcpdgroup->minUmum;
                    }
                } elseif (($new->staf_status == '1' && $new->statusIDP2 == '3')) {

                    if ($modelcpdgroup->mataMin != 0) {
                        $mataMin = round(round($modelcpdgroup->mataMin / 2, 0) / 2, 0);
                    } else {
                        $mataMin = $modelcpdgroup->mataMin;
                    }

                    if ($modelcpdgroup->minTerasUni != 0) {
                        $mataMinTerasUni = round(round($modelcpdgroup->minTerasUni / 2, 0) / 2, 0);
                    } else {
                        $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                    }

                    if ($modelcpdgroup->minTerasSkim != 0) {
                        $mataMinTerasSkim = round(round($modelcpdgroup->minTerasSkim / 2, 0) / 2, 0);
                    } else {
                        $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                    }

                    if ($modelcpdgroup->minElektif != 0) {
                        $mataMinElektif = round(round($modelcpdgroup->minElektif / 2, 0) / 2, 0);
                    } else {
                        $mataMinElektif = $modelcpdgroup->minElektif;
                    }

                    if ($modelcpdgroup->minTeras != 0) {
                        $mataMinTeras = round(round($modelcpdgroup->minTeras / 2, 0) / 2, 0);
                    } else {
                        $mataMinTeras = $modelcpdgroup->minTeras;
                    }

                    if ($modelcpdgroup->minUmum != 0) {
                        $mataMinUmum = round(round($modelcpdgroup->minUmum / 2, 0) / 2, 0);
                    } else {
                        $mataMinUmum = $modelcpdgroup->minUmum;
                    }
                }

                if ($new->biodata->jawatan->job_category == 1) {
                    if (($mataMinTeras + $mataMinElektif + $mataMinUmum) > $mataMin) {
                        $mataMinUmum = $mataMinUmum - abs($mataMin - ($mataMinTeras + $mataMinElektif + $mataMinUmum));
                    }

                    //new 04/12/2020
                    $new->status_teras_uni = 0;
                    $new->status_teras_skim = 0;
                } elseif ($new->biodata->jawatan->job_category == 2) {
                    if (($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim) > $mataMin) {
                        $mataMinElektif = $mataMinElektif - abs($mataMin - ($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim));
                    }

                    //new 04/12/2020
                    $new->status_teras = 0;
                    $new->status_umum = 1;
                }

                $new->idp_mata_min = $mataMin;
                $new->idp_kom_teras_uni = $mataMinTerasUni;
                $new->idp_kom_teras_skim = $mataMinTerasSkim;
                $new->idp_kom_elektif = $mataMinElektif;
                $new->idp_kom_teras = $mataMinTeras;
                $new->idp_kom_umum = $mataMinUmum;

                if ($model3->jawatan->job_category == 2) {

                    //                            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
                    //                            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
                    //                            $minTerasSkim = $modelcpdgroup->minTerasSkim;

                    $minElektif = $mataMinElektif; //fixed data in db
                    $minTerasUniversiti = $mataMinTerasUni;
                    $minTerasSkim = $mataMinTerasSkim;

                    if ($check->mataElektif >= $minElektif) {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $minElektif;

                        //new 04/12/2020
                        $new->status_elektif = 1;
                    } else {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $check->mataElektif;

                        //new 04/12/2020
                        $new->status_elektif = 2;
                    }

                    /*             * ************************************************************************ */
                    if ($check->mataTerasUni >= $minTerasUniversiti) {
                        $terasUniTrue = $minTerasUniversiti;

                        //new 04/12/2020
                        $new->status_teras_uni = 1;
                    } else {
                        $terasUniTrue = $check->mataTerasUni;

                        //new 04/12/2020
                        $new->status_teras_uni = 2;
                    }

                    /*             * ************************************************************************** */
                    if ($check->mataTerasSkim >= $minTerasSkim) {
                        $terasSkimTrue = $minTerasSkim;

                        //new 04/12/2020
                        $new->status_teras_skim = 1;
                    } else {
                        $terasSkimTrue = $check->mataTerasSkim;

                        //new 04/12/2020
                        $new->status_teras_skim = 2;
                    }

                    /*             * ************************************************************************** */
                    //amountOfPoint that are actually counted
                    $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;
                    $jumlahMataSemasa = $check->mataElektif + $check->mataTerasUni + $check->mataTerasSkim + $check->mataUmum;
                } elseif ($model3->jawatan->job_category == 1) {

                    //                            $minMata = $modelcpdgroup->mataMin;

                    //academic - comment out on 9/12/2020
                    //                            $minMata = $mataMin;
                    //
                    //                            $minTerasAcademic = round(0.5 * $minMata);
                    //                            $minElektifAcademic = round(0.3 * $minMata);
                    //                            $minUmumAcademic = round(0.2 * $minMata);

                    $minTerasAcademic = $mataMinTeras;
                    $minElektifAcademic = $mataMinElektif;
                    $minUmumAcademic = $mataMinUmum;

                    //determine IDP percentage and progress-bar colour
                    if ($check->mataElektif >= $minElektifAcademic) {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $minElektifAcademic;

                        //new 04/12/2020
                        $new->status_elektif = 1;
                    } else {
                        //electiveIDPPoint that are counted
                        $elektifTrue = $check->mataElektif;

                        //new 04/12/2020
                        $new->status_elektif = 2;
                    }

                    /*             * ************************************************************************ */
                    if ($check->mataTeras >= $minTerasAcademic) {
                        $terasTrue = $minTerasAcademic;

                        //new 04/12/2020
                        $new->status_teras = 1;
                    } else {
                        $terasTrue = $check->mataTeras;

                        //new 04/12/2020
                        $new->status_teras = 2;
                    }

                    /*             * ************************************************************************** */
                    if ($check->mataUmum >= $minUmumAcademic) {
                        $umumTrue = $minUmumAcademic;

                        //new 04/12/2020
                        $new->status_umum = 1;
                    } else {
                        $umumTrue = $check->mataUmum;

                        //new 04/12/2020
                        $new->status_umum = 2;
                    }

                    /*************************************************************************** */
                    //amountOfPoint that are actually counted
                    $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;
                    $jumlahMataSemasa = $check->mataElektif + $check->mataTeras + $check->mataUmum;
                }

                $new->jum_mata_dikira = $jumlahMataAmbilKira;
                $new->jum_mata_semasa = $jumlahMataSemasa;

                //$new->baki = $modelcpdgroup->mataMin - $jumlahMataAmbilKira;

                $new->baki = $mataMin - $jumlahMataAmbilKira;

                if ($new->baki == 0) {
                    $new->status = 2;
                } elseif ($new->baki > 0) {
                    $new->status = 1;
                }

                $new->save(false);
            }
        }

        echo "1";
    }

    public function addStaff($staffID)
    {
        $currentYear = date('Y');
        $checks = Tblprcobiodata::find()->where(['ICNO' => $staffID])->one();

        /** check gredJawatan perlu IDP atau tidak (by tahun)***/
        $gredj = $checks->jawatan->gred;

        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => $currentYear])->one();

        if (!$modelcpdgroupgj) {
            $statusIDP = '6';
            $statusIDP2 = '6';
        } else {

            if ($checks->jawatan->isKhas == '1') {
                $statusIDP = '5';
                $statusIDP2 = '5';
            } else {
                if ($checks->jawatan->job_category == '2') { //pentadbiran
                    if (
                        $checks->statLantikan == '2' || //Lantikan Sementara
                        $checks->statLantikan == '6' || //Lantikan Pekerja Sambilan Harian
                        $checks->statLantikan == '7' || //Lantikan Kontrak Jabatan
                        $checks->statLantikan == '51' || //Lantikan Pinjaman
                        $checks->statLantikan == '52'
                    ) { //Lantikan Dipinjamkan
                        $statusIDP = '5';
                        $statusIDP2 = '5';
                    } elseif ($checks->statLantikan == '1' || $checks->statLantikan == '3') { //Lantikan Tetap / Lantikan Kontrak
                        if ($checks->Status == '1') { //Aktif

                            if (date_create($checks->startDateStatus)->format("Y") == $currentYear) {
                                $dateStart = date_create($checks->startDateStatus);
                                $dateEndYear = date_create($currentYear . "-12-31");
                                //date_diff() function calculate the difference two dates
                                $dateDuration = date_diff($dateStart, $dateEndYear);
                                //format the date difference
                                $dateDuration2 = $dateDuration->format('%a');

                                if ($dateDuration2 >= 182) {
                                    $statusIDP2 = '1';
                                } elseif ($dateDuration2 >= 91 && $dateDuration2 < 182) {
                                    $statusIDP2 = '2';
                                } elseif ($dateDuration2 < 91) {
                                    $statusIDP2 = '3';
                                }
                            } else {
                                $statusIDP2 = '1';
                            }

                            $statusIDP = '1';
                        } else {
                            $statusIDP = '7';
                            $statusIDP2 = '7'; //tidak aktif bergaji penuh & statLantikan tetap
                        }
                    }
                } else {

                    //akademik
                    if ($checks->statLantikan == '1' || $checks->statLantikan == '2' || $checks->statLantikan == '3') {
                        if ($checks->Status == '1') {

                            if (date_create($checks->startDateStatus)->format("Y") == $currentYear) {
                                $dateStart = date_create($checks->startDateStatus);
                                $dateEndYear = date_create($currentYear . "-12-31");
                                //date_diff() function calculate the difference two dates
                                $dateDuration = date_diff($dateStart, $dateEndYear);
                                //format the date difference
                                $dateDuration2 = $dateDuration->format('%a');

                                if ($dateDuration2 >= 182) {
                                    $statusIDP2 = '1';
                                } elseif ($dateDuration2 >= 91 && $dateDuration2 < 182) {
                                    $statusIDP2 = '2';
                                } elseif ($dateDuration2 < 91) {
                                    $statusIDP2 = '3';
                                }
                            } else {
                                $statusIDP2 = '1';
                            }

                            $statusIDP = '1';
                        } else {
                            $statusIDP = '7';
                            $statusIDP2 = '7'; //tidak aktif bergaji penuh & statLantikan tetap
                        }
                    } else {
                        $statusIDP = '5';
                        $statusIDP2 = '5';
                    }
                }
            }
        }

        $modelB = IdpMata::find()
            ->where(['staffID' => $checks->ICNO])
            ->andWhere(['tahun' => $currentYear])
            ->one();

        if (!$modelB) {
            $modelB = new IdpMata();
            $modelB->staffID = $checks->ICNO;
            $modelB->tahun = $currentYear;
            $modelB->status = $checks->Status;
            $modelB->statusIDP = $statusIDP;
            $modelB->statusIDP2 = $statusIDP2;
            $modelB->tarikhKemaskini = date('Y-m-d H:i:s');
            $modelB->save(false);
        } else {
            $modelB->status = $checks->Status;
            $modelB->statusIDP = $statusIDP;
            $modelB->statusIDP2 = $statusIDP2;
            $modelB->tarikhKemaskini = date('Y-m-d H:i:s');
            $modelB->save(false);
        }

        if ($modelB->save(false)) {

            $modelBBB = RptStatistikIdp::find()
                ->where(['icno' => $modelB->staffID])
                ->andWhere(['tahun' => $currentYear])
                ->one();

            if (!$modelBBB) {
                $modelBBB = new RptStatistikIdp();
                $modelBBB->icno = $modelB->staffID;
                $modelBBB->tahun = date('Y');
                $modelBBB->staf_status = $modelB->status;
                $modelBBB->statusIDP = $modelB->statusIDP;
                $modelBBB->statusIDP2 = $modelB->statusIDP2;
                $modelBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                $modelBBB->save(false);
            } else {
                $modelBBB->staf_status = $modelB->status;
                $modelBBB->statusIDP = $modelB->statusIDP;
                $modelBBB->statusIDP2 = $modelB->statusIDP2;
                $modelBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                $modelBBB->save(false);
            }
        }

        $modelBB = IdpMataV2::find()
            ->where(['staffID' => $checks->ICNO])
            ->andWhere(['tahun' => $currentYear])
            ->one();

        if (!$modelBB) {
            $modelBB = new IdpMataV2();
            $modelBB->staffID = $checks->ICNO;
            $modelBB->tahun = $currentYear;
            $modelBB->status = $checks->Status;
            $modelBB->statusIDP = $statusIDP;
            $modelBB->statusIDP2 = $statusIDP2;
            $modelBB->save(false);
        } else {
            $modelBB->status = $checks->Status;
            $modelBB->statusIDP = $statusIDP;
            $modelBB->statusIDP2 = $statusIDP2;
            $modelBB->save(false);
        }

        if ($modelBB->save(false)){

            $modelBBBB = RptStatistikIdpV2::find()
                ->where(['icno' => $modelBB->staffID])
                ->andWhere(['tahun' => $currentYear])
                ->one();

            if (!$modelBBBB) {
                $modelBBBB = new RptStatistikIdpV2();
                $modelBBBB->icno = $modelBB->staffID;
                $modelBBBB->tahun = $currentYear;
                $modelBBBB->staf_status = $modelBB->status;
                $modelBBBB->statusIDP = $modelBB->statusIDP;
                $modelBBBB->statusIDP2 = $modelBB->statusIDP2;
                $modelBBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                $modelBBBB->save(false);
            } else {
                $modelBBBB->staf_status = $modelBB->status;
                $modelBBBB->statusIDP = $modelBB->statusIDP;
                $modelBBBB->statusIDP2 = $modelBB->statusIDP2;
                $modelBBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                $modelBBBB->save(false);
            }

        }
    }
}
