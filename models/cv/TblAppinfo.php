<?php

namespace app\models\cv;

use app\models\hronline\Tblprcobiodata;
use app\models\cv\GredJawatan;
use Yii;

class TblAppinfo extends \yii\db\ActiveRecord {

    public $gred_apply;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_appinfo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['why_applied', 'qualification', 'accomplishment', 'contribute'], 'string', 'max' => 100000],
            [['harta_date', 'induksi_date', 'gred_apply', 'uid', 'tatatertib_state', 'induksi_skip'], 'safe'],
            [['tatatertib_status', 'induksi_status', 'induksi_result', 'harta_status', 'besa_status'], 'integer'],
            [['fid'], 'string', 'max' => 100],
            [['ICNO', 'added', 'lastupdate'], 'string', 'max' => 20],
            [['uid'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'fid' => 'Fid',
            'ICNO' => 'ICNO',
            'why_applied' => 'Why Applied',
            'qualification' => 'Qualification',
            'accomplishment' => 'Accomplishment',
            'contribute' => 'Contribute',
            'harta_date' => 'Harta Date',
            'tatatertib_status' => 'Tatatertib Status',
            'tatatertib_state' => 'Tatatertib State',
            'induksi_status' => 'Induksi Status',
            'induksi_date' => 'Induksi Date',
            'induksi_result' => 'Induksi Result',
            'induksi_skip' => 'Induksi Skip',
            'ptk_status' => 'Ptk Status',
            'ptk_date' => 'Ptk Date',
            'ptk_result' => 'Ptk Result',
            'ptk_skip' => 'Ptk Skip',
            'added' => 'Added',
            'lastupdate' => 'Lastupdate',
            'harta_status' => 'Harta Status',
        ];
    }

    public function getGroupJawatan() {
        $biodata = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        if ($biodata->jawatan->job_category == 1) {
            return 1;
        } else {
            return 2;
        }
    }

    public function statusBesa() {
        if ($this->besa_status == 1) {
            return "Ya";
        } else {
            return "Tidak";
        }
    }

    public function statusTatatertib() {
        $model = \app\models\tatatertib_staf\TblRekodTatatertib::findOne(['icno' => $this->ICNO]);

        if (empty($model)) {
            return "Ya";
        } else {
            return "Tidak";
        }
    }

    public function statusHarta() {
        if ($this->tatatertib_status == 1) {
            return "Ya";
        } else {
            return "Tidak";
        }
    }

    public function getSahHarta() {
        return $this->hasOne(\app\models\harta\TblHarta::className(), ['ICNO' => 'ICNO'])->where(['IN', 'status', [1, 2, 4]]); // asal sdh mohon
    }

    public function findActiveAds() {
        $model = TblAds::find()->all();
        $active = array();
        foreach ($model as $model) {
            if ((date('Y-m-d') >= $model->StartDate) && (date('Y-m-d') <= $model->EndDate)) {
                $active[] = $model->gred_id;
            }
        }

        return $active;
    }

    public function submitApplication($gred_apply, $peraku, $stpakar = null) {
        $biodata = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        $model = new TblPermohonan();
        $model->ICNO = $biodata->ICNO;
        $model->submit_datetime = date('Y-m-d H:i:s');

        if ($biodata->jawatancv->svc == 2) {
            $ads = TblAds::find()->where(['isActive' => 1])->andWhere(['gred_id' => $gred_apply])->one();
            $model->ads_id = $ads->id;
        } else {
            $model->ads_id = $gred_apply;
        }

        if (!is_null($peraku)) { // permohonan pentadbiran (pilih pegawai peraku)
            $model->kj_ICNO = $peraku;
        }

        if (!empty($stpakar)) {
            $model->status_kepakaran = $stpakar;
        }
        $model->current_dept = $biodata->DeptId;
        $model->current_gred = $biodata->gredJawatan;
        $model->dept_hakiki = $biodata->DeptId_hakiki;
        $model->gred_hakiki = $biodata->gredJawatan_2;

        $model->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Application Submitted']);
    }

    public function openPromotion() {
        $model = TblAds::find()->all();
        $active = array();
        foreach ($model as $model) {
            if ((date('Y-m-d') >= $model->StartDate) && (date('Y-m-d') <= $model->EndDate)) {
                $active[] = $model->gred_id;
            }
        }

        $biodata = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        $jawatan = GredJawatan::find()->where(['kumpulan' => $biodata->jawatancv->kumpulan])->all();

        $activeJawatan = array();

        if ($jawatan) {
            foreach ($jawatan as $jawatan) {
                if (in_array($jawatan->id, $active)) {
                    $activeJawatan[] = $jawatan->id;
                }
            }
        } else {
            $activeJawatan[] = null;
        }

        return $activeJawatan;
    }

    public function getSwUniversity() {
        return $this->hasMany(\app\models\cv\TblSwUniversity::className(), ['ICNO' => 'ICNO']);
    }

    public function getSwCommunity() {
        return $this->hasMany(\app\models\cv\TblSwSociety::className(), ['ICNO' => 'ICNO']);
    }

    public function getJobDetails() {
        return $this->hasMany(\app\models\cv\TblJobdetails::className(), ['ICNO' => 'ICNO']);
    }

    public function getRecordLnpt($icno) {
        return \app\models\lppums\TblSenaraiTugas::find()->joinWith('lpp')
                        ->where(['lppums_lpp.PYD' => $icno])
                        ->andWhere(['!=', 'lppums_lpp.tahun', date('Y')])
                        ->orderBy(['lppums_lpp.tahun' => SORT_DESC])
                        ->all();
    }

    public function getInnovation() {
        return $this->hasMany(\app\models\cv\TblInnovation::className(), ['ICNO' => 'ICNO']);
    }

    public function getSkills() {
        return $this->hasMany(\app\models\cv\TblSkills::className(), ['ICNO' => 'ICNO']);
    }

    public function getActivitiesOther() {
        return $this->hasMany(\app\models\cv\TblActivitiesOther::className(), ['ICNO' => 'ICNO']);
    }

    public function getIncome() {
        return $this->hasMany(\app\models\cv\TblIncome::className(), ['ICNO' => 'ICNO']);
    }

    public function getSports() {
        return $this->hasMany(\app\models\cv\TblSports::className(), ['ICNO' => 'ICNO']);
    }

    public function getResearch() {
        return $this->hasMany(\app\models\cv\TblResearch::className(), ['ICNO' => 'ICNO']);
    }

    public function getPaperWork() {
        return $this->hasMany(\app\models\cv\TblPaperwork::className(), ['ICNO' => 'ICNO']);
    }

    public static function Umum($icno, $gred) { // &tempoh
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $c1 = $c2 = $c3 = $c4 = $c5 = 0;

        //Telah disahkan dalam perkhidmatan
        if ($model->confirmDt) {
            $c1 = 1;
        }
        
         $lnpt = 0;

        if (!empty($model->markahlnptCV(3, 'Tahun'))) {
            $lnpt = number_format(($model->markahlnptCV(3, 'Markah') * 0.2) + ($model->markahlnptCV(2, 'Markah') * 0.35) + ($model->markahlnptCV(1, 'Markah') * 0.45));
        } else if (!empty($model->markahlnptCV(2, 'Tahun'))) {
            $lnpt = number_format(($model->markahlnptCV(2, 'Markah') * 0.6) + ($model->markahlnptCV(1, 'Markah') * 0.4));
        } 

        //Mencapai tahap prestasi LNPT sekurang kurangnya 80% dan ke atas bagi tempoh tiga (3)
        if ($lnpt >= 80) {
            $c2 = 1;
        }

        //Berjawatan Tetap
        if ($model->statLantikan == 1) {
            $c3 = 1;
        }

        //Bebas daripada tindakan tatatertib
        $tatatertib = $model->statusTatatertib();
        if ($tatatertib == 'Ya') { //bersih tatatertib
            $c4 = 1;
        }

        //tempoh perkhidmatan 
        $tempoh_kriteria = $model->getServPeriod($gred, 'Kriteria');
        $tempoh = RequirementUmum::tempoh($gred);
        if ($tempoh_kriteria >= $tempoh->ans_no) {
            $c5 = 1;
        }

        if ($c1 == 1 && $c2 == 1 && $c3 == 1 && $c4 == 1 && $c5 == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function Penyelidikan($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $penyelidikan = RequirementUmum::penyelidikan($gred, $model->departmentHakiki->cluster);

        if ($gred == 10) {//VK7
            $researchleader = array_filter($model->research2, function ($var) {
                return ($var['Membership'] == 'Leader' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
            });

            $researchmember = array_filter($model->research2, function ($var) {
                return ($var['Membership'] == 'Member' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
            });

            $totalPenyelidikan = 0;
            $i = 1;
            foreach ($penyelidikan as $p) {
                if ($i == 1) {
                    if (count($researchleader) >= $p->ans_no) {
                        $totalPenyelidikan++;
                    }
                } else if ($i == 2) {
                    $nilai = array_sum(array_column($researchleader, 'Amount')) + array_sum(array_column($researchmember, 'Amount'));
                    if ($nilai >= $p->ans_decimal) {
                        $totalPenyelidikan++;
                    }
                }

                $i++;
            }

            if ($totalPenyelidikan == count($penyelidikan)) {
                return true;
            } else {
                return false;
            }
        }
        if ($gred == 11) {
            $researchleader = array_filter($model->research2, function ($var) {
                return ($var['Membership'] == 'Leader' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
            });

            $researchmember = array_filter($model->research2, function ($var) {
                return ($var['Membership'] == 'Member' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
            });

            $i = 1;
            $totalPenyelidikan = 0;
            foreach ($penyelidikan as $p) {
                if ($i == 1) {
                    if (count($researchleader) >= $p->ans_no) {
                        $totalPenyelidikan++;
                    }
                } else if ($i == 2) {
                    $nilai = array_sum(array_column($researchleader, 'Amount')) + array_sum(array_column($researchmember, 'Amount'));
                    if ($nilai >= $p->ans_decimal) {
                        $totalPenyelidikan++;
                    }
                }

                $i++;
            }
            if ($totalPenyelidikan == count($penyelidikan)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function Penerbitan($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $penerbitan = RequirementUmum::penerbitan($gred, $model->departmentHakiki->cluster);

        if ($gred == 10) {
            $i = 1;
            $totalPenerbitan = 0;
            foreach ($penerbitan as $p) {
                if ($i == 1) {

                    $j = count(array_filter($model->publication, function ($var) {
                                return ($var['Keterangan_PublicationTypeID'] == 'Article');
                            }));

                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                } else if ($i == 2) {

                    $j = count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }));

                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                } else if ($i == 3) {
                    $j = count(array_filter($model->publication, function ($var) {
                                return (($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                } else if ($i == 4) {
                    $j = 0;
                    if ($model->scopus) {
                        $j = $model->scopus->h_index;
                    }
                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                } else if ($i == 5) {
                    $j = 0;
                    if ($model->scopus) {
                        $j = $model->scopus->Citations;
                    }
                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                }
                $i++;
            }

            if ($totalPenerbitan == count($penerbitan)) {
                return true;
            } else {
                return false;
            }
        }
        if ($gred == 11) {
            $cluster = $model->departmentHakiki->cluster;
            $i = 1;
            $totalPenerbitan = 0;
            foreach ($penerbitan as $p) {
                if ($i == 1) {
                    $j = count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article');
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                } else if ($i == 2) {
                    $j = 0;
                    if ($cluster == 1) {
                        $j = count(array_filter($model->publication, function ($var) {
                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                }));
                    } else {
                        $k1 = count(array_filter($model->publication, function ($var) {
                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                }));

                        $k2 = count(array_filter($model->publication, function ($var) {
                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                }));

                        if ($k1 >= 3 && $k2 >= 1) {
                            $j = 3;
                        }
                    }

                    if ($j >= $p->ans_no) {
                        $totalPenerbitan++;
                    }
                } else if ($i == 3) {
                    if ($cluster == 1) {
                        $j = 0;
                        if ($model->scopus) {
                            $j = $model->scopus->Citations;
                        }
                        if ($j >= $p->ans_no) {
                            $totalPenerbitan++;
                        }
                    } else {
                        $j = 'TIDAK';
                        $a = $b = 0;
                        if ($model->scopus) {
                            $a = $model->scopus->Citations;
                        }

                        if ($model->googleScholar) {
                            $b = $model->googleScholar->Citations;
                        }


                        if (($a >= 10) || ($b >= 20)) {
                            $j = 'YA';
                        }

                        if ($j == $p->ans_char) {
                            $totalPenerbitan++;
                        }
                    }
                } else if ($i == 4) {
                    if ($cluster == 1) {
                        $j = 0;
                        if ($model->scopus) {
                            $j = $model->scopus->h_index;
                        }
                        if ($j >= $p->ans_no) {
                            $totalPenerbitan++;
                        }
                    } else {
                        $j = 'TIDAK';
                        $a = $b = 0;
                        if ($model->scopus) {
                            $a = $model->scopus->h_index;
                        }

                        if ($model->googleScholar) {
                            $b = $model->googleScholar->h_index;
                        }

                        if (($a >= 1) || ($b >= 3)) {
                            $j = 'YA';
                        }
                        if ($j >= $p->ans_char) {
                            $totalPenerbitan++;
                        }
                    }
                }
                $i++;
            }
            if ($totalPenerbitan == count($penerbitan)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function Pengajaran($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $pengajaran = RequirementUmum::pengajaran($gred, $model->departmentHakiki->cluster);

        if ($gred == 10) {
            $i = 1;
            $totalPengajaran = 0;
            foreach ($pengajaran as $p) {
                if ($i == 1) {
                    $totalPengajaran++; //temporary hold 80%
                } elseif ($i == 2) {
                    $j = $model->findPenilaianPengajaran($model->ICNO);
                    if ($j > $p->ans_decimal) {
                        $totalPengajaran++;
                    }
                } elseif ($i == 3) {
                    $pra_kredit = array_filter($model->pengajaran, function ($var) {
                        return ($var['KATEGORIPELAJAR'] == 'PRASISWAZAH (PLUMS)' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PERUBATAN' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PPG' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH UMUM');
                    });

                    $pas_kredit = array_filter($model->pengajaran, function ($var) {
                        return ($var['KATEGORIPELAJAR'] == 'PASCASISWAZAH');
                    });

                    $j = array_sum(array_column($pra_kredit, 'JAMKREDIT')) + array_sum(array_column($pas_kredit, 'JAMKREDIT'));
                    if ($j > $p->ans_no) {
                        $totalPengajaran++;
                    }
                }

                $i++;
            }
            if ($totalPengajaran == count($pengajaran)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function Penyeliaan($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $penyeliaan = RequirementUmum::penyeliaan($gred, $model->departmentHakiki->cluster);

        if ($gred == 10) {
            $i = 1;
            $totalPenyeliaan = 0;
            foreach ($penyeliaan as $p) {
                if ($i == 1) {
                    $j = $model->totalTamatPengajianUtama('PHD');
                    if ($j >= $p->ans_no) {
                        $totalPenyeliaan++;
                    }
                } else if ($i == 2) {
                    $j = $model->totalTamatPengajianUtama('MASTER');
                    if ($j >= $p->ans_no) {
                        $totalPenyeliaan++;
                    }
                }
                $i++;
            }
            if ($totalPenyeliaan == count($penyeliaan)) {
                return true;
            } else {
                return false;
            }
        }
        if ($gred == 11) {
            $totalPenyeliaan = 0;
            foreach ($penyeliaan as $p) {
                $a = $model->totalPenyeliaanLevel('MASTER');
                $b = $model->totalTamatPengajianUtama('MASTER');

//                                $c = $model->totalPenyeliaanLevel('PHD');
                $d = $model->totalTamatPengajianUtama('PHD');
                $l = $model->totalTamatPengajianBersama('PHD');

                $e = $model->totalPenyeliaanLevelModCampuran('MASTER');
                $f = $model->totalTamatPengajianUtamaModCampuran('MASTER');

                $g = intdiv($e, 3); // 3 mod campuran = 1 penyelidkan
                $h = intdiv($f, 3);

                $j = 'TIDAK';

                if ((($a + ($d * 2) + $l + $g) >= 3) && (($b + ($d * 2) + $h) >= 2)) {
                    $j = 'YA';
                }

                if ($j == $p->ans_char) {
                    $totalPenyeliaan++;
                }
            }
            if ($totalPenyeliaan == count($penyeliaan)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function Sanjungan($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $persidangan = RequirementUmum::persidangan($gred, $model->departmentHakiki->cluster);

        if ($gred == 10) {
            $i = 1;
            $totalPersidangan = 0;
            foreach ($persidangan as $p) {
                if ($i == 1) {
                    $j = count(array_filter($model->persidangan2, function ($var) {
                                return (($var['Peringkat'] == 'Antarabangsa' || $var['Peringkat'] == 'Kebangsaan') && ($var['Peranan'] == 'Pembentang'));
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPersidangan++;
                    }
                } elseif ($i == 2) {
                    $j = count(array_filter($model->persidangan2, function ($var) {
                                return (($var['Peringkat'] == 'Antarabangsa' || $var['Peringkat'] == 'Kebangsaan') && ($var['Peranan'] == 'Keynote Speaker'));
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPersidangan++;
                    }
                } elseif ($i == 3) {

                    $j = count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPersidangan++;
                    }
                } elseif ($i == 4) {
                    $j = count(array_filter($model->outreaching, function ($var) {
                                return (($var['Keahlian'] == 'Indexed Journal Assessor' || $var['Keahlian'] == 'Book Manuscript Reviewer') && $var['StatusPengesahan'] == 'V');
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPersidangan++;
                    }
                } elseif ($i == 5) {
                    $j = count(array_filter($model->outreaching, function ($var) {
                                return ($var['Keahlian'] == ' External Assessor for Promotion' && $var['StatusPengesahan'] == 'V');
                            }));
                    if ($j >= $p->ans_no) {
                        $totalPersidangan++;
                    }
                } elseif ($i == 6) {
                    $j = count(array_filter($model->asPanel, function ($var) {
                                return ($var['type'] == 13 && $var['level'] == 'phd' && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                            }));

                    if ($j >= $p->ans_no) {
                        $totalPersidangan++;
                    }
                }
                $i++;
            }
            if ($totalPersidangan >= 1) { //atau
                return true;
            } else {
                return false;
            }
        }
        if ($gred == 11) {
            $totalPersidangan = 0;
            foreach ($persidangan as $p) {
                $Antarabangsa = count(array_filter($model->persidangan2, function ($var) {
                            return ($var['Peringkat'] == 'Antarabangsa' && ($var['Peranan'] == 'Keynote Speaker' || $var['Peranan'] == 'Ahli Panel' || $var['Peranan'] == 'Pembentang Jemputan'));
                        }));
                $Kebangsaan = count(array_filter($model->persidangan2, function ($var) {
                            return (($var['Peringkat'] == 'Kebangsaan' || $var['Peringkat'] == 'National') && ($var['Peranan'] == 'Keynote Speaker' || $var['Peranan'] == 'Ahli Panel' || $var['Peranan'] == 'Pembentang Jemputan'));
                        }));
                $j = $Antarabangsa + $Kebangsaan;
                if ($j >= $p->ans_no) {
                    $totalPersidangan++;
                }
            }
            if ($totalPersidangan == count($persidangan)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function Khidmat($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $service = RequirementUmum::service($gred, $model->departmentHakiki->cluster);
        if ($gred == 10) {
            $i = 1;
            $totalService = 0;
            foreach ($service as $p) {
                if ($i == 1) {
                    $j = count(array_filter($model->serviceUniversity, function ($var) {
                                return ($var['role_key'] == 'Chairman');
                            }));
                    if ($j >= $p->ans_no) {
                        $totalService++;
                    }
                } elseif ($i == 2) {
                    $j = count(array_filter($model->serviceUniversity, function ($var) {
                                return ($var['role_key'] == 'Member Committee');
                            }));
                    if ($j >= $p->ans_no) {
                        $totalService++;
                    }
                } elseif ($i == 3) {
                    $j = count(array_filter($model->serviceCommunity, function ($var) {
                                return (($var['level'] == 1 || $var['level'] == 2 || $var['level'] == 3) && ($var['role_key'] == 'Chairman')); //National & internasional
                            }));
                    if ($j >= $p->ans_no) {
                        $totalService++;
                    }
                } elseif ($i == 4) {
                    $j = count(array_filter($model->serviceCommunity, function ($var) {
                                return (($var['level'] == 1 || $var['level'] == 2 || $var['level'] == 3) && ($var['role_key'] == 'Member Committee')); //National & internasional
                            }));
                    if ($j >= $p->ans_no) {
                        $totalService++;
                    }
                }
                $i++;
            }
            if ($totalService >= 1) { //atau
                return true;
            } else {
                return false;
            }
        }
        if ($gred == 11) {
            $totalService = 0;
            foreach ($service as $p) {
                $j = count(array_filter($model->serviceCommunity, function ($var) {
                            return ($var['level'] == 1 || $var['level'] == 2); //National
                        }));
                if ($j >= $p->ans_no) {
                    $totalService++;
                }
            }
            if ($totalService == count($service)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function Perundingan($icno, $gred) {
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $perundingan = RequirementUmum::perundingan($gred, $model->departmentHakiki->cluster);

        if ($gred == 10) {
            $i = 1;
            $totalPerundingan = 0;
            foreach ($perundingan as $p) {
                if ($i == 1) {
                    $j = count(array_filter($model->outreaching, function ($var) {
                                        return ($var['StatusPengesahan'] == 'V'); //verified
                                    })) + count(array_filter($model->outreachingClinical, function ($var) {
                                        return ($var['ApproveStatus'] == 'V'); //verified
                                    }));
                    if ($j >= $p->ans_no) {
                        $s = 1;
                        $totalPerundingan++;
                    } else {
                        $s = 0;
                    }
                } elseif ($i == 2) {
                    $j = count($model->inovasiSelesai) + count($model->getTeknologiInvasi());
                    if ($j >= $p->ans_no) {
                        $s = 1;
                        $totalPerundingan++;
                    } else {
                        $s = 0;
                    }
                } elseif ($i == 3) {
                    $j = count(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Speaker'); //verified
                            }));
                    if ($j >= $p->ans_no) {
                        $s = 1;
                        $totalPerundingan++;
                    } else {
                        $s = 0;
                    }
                }
                $i++;
            }
            if ($totalPerundingan == count($perundingan)) {
                return true;
            } else {
                return false;
            }
        }
        if ($gred == 11) {
            $totalPerundingan = 0;
            foreach ($perundingan as $p) {
                $j = count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V'); //verified
                                })) + count(array_filter($model->outreachingClinical, function ($var) {
                                    return ($var['ApproveStatus'] == 'V'); //verified
                                }));
                if ($j >= $p->ans_no) {
                    $totalPerundingan++;
                }
            }
            if ($totalPerundingan == count($perundingan)) {
                return true;
            } else {
                return false;
            }
        }
    }

}
