<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "{{%myidp.kehadiran}}".
 *
 * @property int $slotID
 * @property string $staffID
 * @property string $statusPeserta
 * @property string $tarikhMasa
 * @property int $kategoriKursusID
 */
class Kehadiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_kehadiran}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slotID', 'staffID'], 'required'],
            [['slotID', 'kategoriKursusID'], 'integer'],
            [['tarikhMasa'], 'safe'],
            [['staffID'], 'string', 'max' => 12],
            [['statusPeserta'], 'string', 'max' => 25],
            [['slotID', 'staffID'], 'unique', 'targetAttribute' => ['slotID', 'staffID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'slotID' => Yii::t('app', 'Slot ID'),
            'staffID' => Yii::t('app', 'Staff ID'),
            'statusPeserta' => Yii::t('app', 'Status Peserta'),
            'tarikhMasa' => Yii::t('app', 'Tarikh Masa'),
            'kategoriKursusID' => Yii::t('app', 'Kategori Kursus ID'),
        ];
    }

    /** Relation **/
    // KursusLatihan[kategoriJawatanID] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getPeserta()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staffID']);
    }

    /** Relation **/
    public function getSasaran9()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SlotLatihan::className(), ['slotID' => 'slotID']);
    }

    public function getStatusPeserta_()
    {

        $a = " ";

        if ($this->statusPeserta != NULL) {

            if ($this->statusPeserta == 'sendiriMohon') {
                $a = '<span class="label label-primary">MOHON</span>';
            } elseif ($this->statusPeserta == 'walk-in') {
                $a = '<span class="label label-danger">WALK-IN</span>';
            }
        }

        return $a;
    }

    public function getJenisKursus()
    {

        $a = "BUKAN SASARAN";

        if ($this->kategoriKursusID != 0) {

            if ($this->kategoriKursusID == 1) {
                $a = '<span class="label label-default">UMUM</span>';
            } elseif ($this->kategoriKursusID == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->kategoriKursusID == 4) {
                $a = '<span class="label label-primary">ELEKTIF</span>';
            } elseif ($this->kategoriKursusID == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->kategoriKursusID == 6) {
                $a = '<span class="label label-info">TERAS SKIM</span>';
            } elseif ($this->kategoriKursusID == 7) {
                $a = '<span class="label label-success">IMPAK TINGGI</span>';
            }

            return $a;
        } else {

            $checkKompetensi = KursusLatihan::find()
                ->where(['kursusLatihanID' => $this->sasaran9->sasaran4->kursusLatihanID])
                ->one();

            if ($checkKompetensi->kompetensi == NULL) {
                //$a = '<span class="label label-success">BUKAN SASARAN</span>';
                $a = Html::button('UBAH', ['value' => 'ubah-jenis-kursus?slotID=' . $this->slotID . '&peserta=' . $this->staffID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
            } else {
                $a = $this->sasaran9->sasaran4->sasaran3->kompetensii;
                //                $this->kategoriKursusID = $this->sasaran9->sasaran4->sasaran3->kompetensi;
                //                $this->save(false);
            }

            return $a;
        }

        return $a;
    }

    public function getTarikhKursus()
    {

        $formatteddate = date('d-m-Y h:i:s A', strtotime($this->tarikhMasa));

        return $formatteddate;
    }

    public function calculateMataUmumStaff($siriLatihanID, $chosenStaff)
    {
        $mataaa = 0;

        $mata = SlotLatihan::find()
            ->joinWith('sasaran55')
            ->where(['siriLatihanID' => $siriLatihanID])
            ->andWhere(['idp_kehadiran.staffID' => $chosenStaff])
            ->all();

        //        foreach ($mata as $mataa){
        //            $mataaa = $mataaa + $mataa->mataSlot;
        //        }

        foreach ($mata as $mataa) {
            $mataaa = $mataaa + 1;
        }

        return $mataaa;
    }

    public function calculateMataStaff($siriLatihanID, $chosenStaff)
    {
        $mataaa = 0;

        $mata = SlotLatihan::find()
            ->joinWith('sasaran55')
            ->where(['siriLatihanID' => $siriLatihanID])
            ->andWhere(['idp_kehadiran.staffID' => $chosenStaff])
            ->all();

        foreach ($mata as $mataa) {
            $mataaa = $mataaa + $mataa->mataSlot;
        }

        $kursus = SiriLatihan::find()
            ->where(['siriLatihanID' => $siriLatihanID])
            ->one();

        if ($kursus->sasaran3->jenisLatihanID != 'jfpiu') {

            $checkBorang = BorangPenilaianLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])
                ->andWhere(['pesertaID' => $chosenStaff])
                ->one();

            if ($checkBorang) {

                if ($checkBorang->statusBorang == '2') {

                    return $mataaa;
                } else {

                    if ($chosenStaff != Yii::$app->user->getId()) {
                        return Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['value' => 'borangpenilaianlatihan?id=' . $siriLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block', 'disabled' => true]);
                    } else {

                        if ('YEAR' . ($checkBorang->sasaranSiriK->tarikhMula) == date('Y')) {

                            //return Html::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['value' => 'borangpenilaianlatihan?id='.$siriLatihanID, 'class' => 'mapBtn btn-sm btn-primary btn-block', 'disabled' => false]);
                            return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'borangpenilaianlatihan?id=' . $siriLatihanID . '&pesertaID=' . $chosenStaff . '&type=2', [
                                'title' => Yii::t('app', 'Papar Borang'),
                                'data-pjax' => 0,
                                'target' => "_blank",
                                'class' => 'btn-sm btn-primary btn-block'
                            ]);
                        } else {
                            return Html::button('<i class="fa fa-warning" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true, 'title' => Yii::t('app', 'Borang penilaian latihan tidak diisi')]);
                        }
                    }
                }
            } else {

                $checkBorangK = BorangPenilaianKeberkesanan::find()
                    ->where(['pesertaID' => $chosenStaff])
                    ->andWhere(['siriLatihanID' => $siriLatihanID])
                    ->one();

                if (!$checkBorangK) {
                    $borangpl = new BorangPenilaianLatihan();
                    $borangpl->pesertaID = $chosenStaff;
                    //$borangpl->kursusLatihanID = $kursusID->kursusLatihanID;
                    $borangpl->siriLatihanID = $siriLatihanID;
                    $borangpl->statusBorang = '1';
                    //$borangpl->save(false);

                    $borangpk = new BorangPenilaianKeberkesanan();
                    $borangpk->pesertaID = $chosenStaff;
                    //$borangpk->kursusLatihanID = $kursusID->kursusLatihanID;
                    $borangpk->siriLatihanID = $siriLatihanID;
                    $borangpk->statusBorang = '1';
                    //$borangpk->save(false);

                    if ($borangpl->save() && $borangpk->save()) {
                        return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id=' . $siriLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block', 'disabled' => true]);
                    } else {
                        return "RALAT";
                    }
                }
            }
        } else {
            return $mataaa;
        }
    }

    public function calculateMataUmum($siriLatihanID)
    {
        $mataaa = 0;

        $mata = SlotLatihan::find()
            ->joinWith('sasaran55')
            ->where(['siriLatihanID' => $siriLatihanID])
            ->andWhere(['idp_kehadiran.staffID' => Yii::$app->user->getId()])
            ->all();

        foreach ($mata as $mataa) {
            //$mataaa = $mataaa + $mataa->mataSlot;
            $mataaa = $mataaa + 1;
        }

        return $mataaa;
    }

    public function calculateMata($siriLatihanID)
    {
        $mataaa = 0;

        $mata = SlotLatihan::find()
            ->joinWith('sasaran55')
            ->where(['siriLatihanID' => $siriLatihanID])
            ->andWhere(['idp_kehadiran.staffID' => Yii::$app->user->getId()])
            ->all();

        foreach ($mata as $mataa) {
            $mataaa = $mataaa + $mataa->mataSlot;
        }

        $kursus = SiriLatihan::find()
            ->where(['siriLatihanID' => $siriLatihanID])
            ->one();

        //        var_dump($kursus->kursusLatihanID);
        //        die();

        //        $checkBorang = BorangPenilaianLatihan::find()
        //                ->where(['kursusLatihanID' => $kursus->kursusLatihanID])
        //                ->andWhere(['pesertaID' => Yii::$app->user->getId()])
        //                ->one();

        if ($kursus->sasaran3->jenisLatihanID != 'jfpiu') {

            $checkBorang = BorangPenilaianLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])
                ->andWhere(['pesertaID' => Yii::$app->user->getId()])
                ->one();

            if ($checkBorang) {

                if (($checkBorang->statusBorang == '2') && ($checkBorang->tarikhMasa != NULL)) {

                    return $mataaa;
                } elseif (($checkBorang->statusBorang == '2') && ($checkBorang->tarikhMasa == NULL)) {

                    return 'RALAT';
                } 
                else {
                    //return Html::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['value' => 'borangpenilaianlatihan?id='.$siriLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                    return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'borangpenilaianlatihan?id=' . $siriLatihanID . '&pesertaID=' . Yii::$app->user->getId() . '&type=2', [
                        'title' => Yii::t('app', 'Papar Borang'),
                        'data-pjax' => 0,
                        'target' => "_blank",
                        'class' => 'btn-sm btn-danger btn-block'
                    ]);
                }
            } else {

                //            $checkBorang = BorangPenilaianLatihan::find()
                //                ->where(['pesertaID' => $pesertaID])
                //                ->andWhere(['kursusLatihanID' => $kursusID])
                //                ->one();

                //            $checkBorangK = BorangPenilaianKeberkesanan::find()
                //                ->where(['pesertaID' => Yii::$app->user->getId()])
                //                ->andWhere(['kursusLatihanID' => $kursus->kursusLatihanID])
                //                ->one();

                $checkBorangK = BorangPenilaianKeberkesanan::find()
                    ->where(['pesertaID' => Yii::$app->user->getId()])
                    ->andWhere(['siriLatihanID' => $siriLatihanID])
                    ->one();

                if (!$checkBorangK) {
                    $borangpl = new BorangPenilaianLatihan();
                    $borangpl->pesertaID = Yii::$app->user->getId();
                    //$borangpl->kursusLatihanID = $kursusID->kursusLatihanID;
                    $borangpl->siriLatihanID = $siriLatihanID;
                    $borangpl->statusBorang = '1';
                    //$borangpl->save(false);

                    $borangpk = new BorangPenilaianKeberkesanan();
                    $borangpk->pesertaID = Yii::$app->user->getId();
                    //$borangpk->kursusLatihanID = $kursusID->kursusLatihanID;
                    $borangpk->siriLatihanID = $siriLatihanID;
                    $borangpk->statusBorang = '1';
                    //$borangpk->save(false);

                    if ($borangpl->save(false) && $borangpk->save(false)) {
                        return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id=' . $siriLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                    } else {
                        return "RALAT";
                    }
                }
            }
        } else {
            return $mataaa;
        }
    }

    public function calculateMataTotalStaff($jenis, $chosenStaff, $currentYear)
    {
        //$currentYear = date('Y');

        $mataaa = 0;

        $elektif = SlotLatihan::find()
            ->joinWith('sasaran55')
            ->where(['idp_kehadiran.staffID' => $chosenStaff])
            ->andWhere(['idp_kehadiran.kategoriKursusID' => $jenis])
            ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
            ->all();

        foreach ($elektif as $mataa) {

            $kursus = SiriLatihan::find()
                ->where(['siriLatihanID' => $mataa->siriLatihanID])
                ->one();

            if ($jenis != '1' && $kursus->sasaran3->jenisLatihanID != 'jfpiu') {

                $checkBorang = BorangPenilaianLatihan::find()
                    ->where(['siriLatihanID' => $mataa->siriLatihanID])
                    ->andWhere(['pesertaID' => $chosenStaff])
                    ->andWhere(['statusBorang' => 2])
                    ->one();

                //            $checkBorangK = BorangPenilaianKeberkesanan::find()
                //                    ->where(['pesertaID' => Yii::$app->user->getId()])
                //                    ->andWhere(['siriLatihanID' => $elektif->siriLatihanID])
                //                    ->andWhere(['statusBorang' => 2])
                //                    ->one();

                if ($checkBorang) {
                    $mataaa = $mataaa + $mataa->mataSlot;
                }
            } else {

                if ($kursus->sasaran3->jenisLatihanID == 'jfpiu' && $jenis != '1') {
                    $mataaa = $mataaa + $mataa->mataSlot;
                } else {
                    $mataaa = $mataaa + 1;
                }
            }
        }

        return $mataaa;
    }

    public function calculateMataTotal($jenis)
    {
        $currentYear = date('Y');

        $mataaa = 0;

        $elektif = SlotLatihan::find()
            ->joinWith('sasaran55')
            ->where(['idp_kehadiran.staffID' => Yii::$app->user->getId()])
            ->andWhere(['idp_kehadiran.kategoriKursusID' => $jenis])
            ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
            ->all();

        if ($jenis != 1) {

            foreach ($elektif as $mataa) {

                if ($mataa->sasaran4->sasaran3->jenisLatihanID != 'jfpiu') {

                    $checkBorang = BorangPenilaianLatihan::find()
                        ->where(['siriLatihanID' => $mataa->siriLatihanID])
                        ->andWhere(['pesertaID' => Yii::$app->user->getId()])
                        ->andWhere(['statusBorang' => 2])
                        ->one();

                    if ($checkBorang) {
                        $mataaa = $mataaa + $mataa->mataSlot;
                    }
                } else {
                    $mataaa = $mataaa + $mataa->mataSlot;
                }
            }
        } else {

            foreach ($elektif as $mataa) {
                $mataaa = $mataaa + 1;
            }
        }

        //        foreach ($elektif as $mataa){
        //            
        //            $kursus = SiriLatihan::find()
        //                ->where(['siriLatihanID' => $mataa->siriLatihanID])
        //                ->one();
        //            
        //            if($jenis != '1' && $kursus->sasaran3->jenisLatihanID != 'jfpiu'){
        //            
        //                $checkBorang = BorangPenilaianLatihan::find()
        //                    ->where(['siriLatihanID' => $mataa->siriLatihanID])
        //                    ->andWhere(['pesertaID' => Yii::$app->user->getId()])
        //                    ->andWhere(['statusBorang' => 2])
        //                    ->one();
        //
        //    //            $checkBorangK = BorangPenilaianKeberkesanan::find()
        //    //                    ->where(['pesertaID' => Yii::$app->user->getId()])
        //    //                    ->andWhere(['siriLatihanID' => $elektif->siriLatihanID])
        //    //                    ->andWhere(['statusBorang' => 2])
        //    //                    ->one();
        //
        //                if ($checkBorang){
        //                    $mataaa = $mataaa + $mataa->mataSlot;
        //                }
        //            } else {
        //                $mataaa = $mataaa + $mataa->mataSlot;
        //            }
        //        }

        return $mataaa;
    }

    public function getMata($jenis)
    {

        $currentYear = date('Y');

        $model2 = IdpMata::find()
            ->where(['staffID' => Yii::$app->user->getId()])
            ->andWhere(['tahun' => $currentYear])
            ->one();

        if ($jenis == 'teras') {

            return $model2->mataTeras;
        } elseif ($jenis == 'elektif') {

            return $model2->mataElektif;
        } elseif ($jenis == 'umum') {

            return $model2->mataUmum;
        } elseif ($jenis == 'terasUni') {

            return $model2->mataTerasUni;
        } elseif ($jenis == 'terasSkim') {

            return $model2->mataTerasSkim;
        }
    }

    public function calculatePeserta($siriID)
    {
        $totalpeserta = Kehadiran::find()
            ->joinWith('sasaran9')
            ->where(['siriLatihanID' => $siriID])
            ->count();

        return $totalpeserta;
    }

    public function calculatePesertaSlot($slotID)
    {
        $totalPeserta = 0;

        $totalpeserta = Kehadiran::find()
            ->where(['slotID' => $slotID])
            ->count();

        return $totalpeserta;
    }

    /**
     * @param $slotID = id Kursus
     * @param $staffID = icno
     * 
     * 
     */
    public static function addKehadiran($slotID, $staffID)
    {
        $checkPeserta = Kehadiran::find()
            ->where(['staffID' => $staffID])
            ->andWhere(['slotID' => $slotID])
            ->one();

        if (!$checkPeserta) {

            $model2 = new Kehadiran;
            $model2->slotID = $slotID;
            $model2->staffID = $staffID;
            $model2->tarikhMasa = date("Y-m-d H:i:s");
            $model2->statusPeserta = 'walk-in';
            $model2->kategoriKursusID = '1'; //umum
            if($model2->save(false)){
                return true;
            }
        }
    
        return false;
    }

}
