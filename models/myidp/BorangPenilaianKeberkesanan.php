<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "myidp.borangPenilaianKeberkesanan".
 *
 * @property int $siriLatihanID
 * @property string $pesertaID
 * @property string $ringkasanLatihan
 * @property int $s1
 * @property int $s2
 * @property int $s3
 * @property int $s4
 * @property int $s5
 * @property string $tarikhStafIsi
 * @property string $ketuaID
 * @property int $k1
 * @property int $k2
 * @property int $k3
 * @property string $tarikhKetuaIsi
 * @property int $statusBorang
 */
class BorangPenilaianKeberkesanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_bpk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'pesertaID'], 'required'],
            [['siriLatihanID', 's1', 's2', 's3', 's4', 's5', 'k1', 'k2', 'k3', 'statusBorang'], 'integer'],
            [['ringkasanLatihan'], 'string'],
            [['tarikhStafIsi', 'tarikhKetuaIsi'], 'safe'],
            [['pesertaID', 'ketuaID'], 'string', 'max' => 12],
            [['siriLatihanID', 'pesertaID'], 'unique', 'targetAttribute' => ['siriLatihanID', 'pesertaID']],

            [
                ['s1', 's2', 's3', 's4', 's5', 'k1', 'k2', 'k3', 'ringkasanLatihan'],
                'required', 'on' => 'bm',
                'message' => 'Sila isi ruangan ini.'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => 'Kursus Latihan ID',
            'pesertaID' => 'Peserta ID',
            'ringkasanLatihan' => 'Ringkasan Latihan',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
            's4' => 'S4',
            's5' => 'S5',
            'tarikhStafIsi' => 'Tarikh Staf Isi',
            'ketuaID' => 'Ketua ID',
            'k1' => 'K1',
            'k2' => 'K2',
            'k3' => 'K3',
            'tarikhKetuaIsi' => 'Tarikh Ketua Isi',
            'statusBorang' => 'Status Borang',
        ];
    }

    public function getPeserta()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pesertaID']);
    }

    public function getSiri()
    {
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function CheckBorangStatusUrusetia($siriID, $pesertaID)
    {

        $checkBorang = BorangPenilaianKeberkesanan::find()
            ->where(['pesertaID' => $pesertaID])
            ->andWhere(['siriLatihanID' => $siriID])
            ->one();

        if ($checkBorang && ($checkBorang->statusBorang == '2')) {

            return Html::button('<i class="fa fa-warning" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true, 'title' => Yii::t('app', 'Borang penilaian keberkesanan tidak diisi')]);
        } elseif ($checkBorang && ($checkBorang->statusBorang == '3')) {

            return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaiankeberkesanan?id=' . $siriID . '&pesertaID=' . $pesertaID . '&type=2', [
                'title' => Yii::t('app', 'Papar Borang'),
                'data-pjax' => 0,
                'target' => "_blank",
                'class' => 'btn-sm btn-primary btn-block text-center'
            ]);
        } elseif ($checkBorang && ($checkBorang->statusBorang == '1')) {
            return Html::button('<i class="fa fa-warning" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true, 'title' => Yii::t('app', 'Borang penilaian keberkesanan tidak diisi')]);
        } else {
            return "";
        }
    }

    public function CheckBorangStatusk($siriID, $pesertaID)
    {

        $checkBorang = BorangPenilaianKeberkesanan::find()
            ->where(['pesertaID' => $pesertaID])
            ->andWhere(['siriLatihanID' => $siriID])
            ->one();

        if ($checkBorang && ($checkBorang->statusBorang == '2')) {

            return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaiankeberkesanan?id=' . $siriID . '&pesertaID=' . $pesertaID . '&type=2', [
                'title' => Yii::t('app', 'Papar Borang'),
                'data-pjax' => 0,
                'target' => "_blank",
                'class' => 'btn-sm btn-success btn-block text-center'
            ]);
        } elseif ($checkBorang && ($checkBorang->statusBorang == '3')) {

            return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaiankeberkesanan?id=' . $siriID . '&pesertaID=' . $pesertaID . '&type=2', [
                'title' => Yii::t('app', 'Papar Borang'),
                'data-pjax' => 0,
                'target' => "_blank",
                'class' => 'btn-sm btn-primary btn-block text-center'
            ]);
        } elseif ($checkBorang && ($checkBorang->statusBorang == '1')) {
            return Html::button('<i class="fa fa-warning" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true, 'title' => Yii::t('app', 'Borang penilaian keberkesanan tidak diisi')]);
        } else {
            return "";
        }
    }

    public function CheckBorangStatuskk($siriID, $pesertaID)
    {

        $checkBorang = BorangPenilaianKeberkesanan::find()
            ->where(['pesertaID' => $pesertaID])
            ->andWhere(['siriLatihanID' => $siriID])
            ->one();

        return $checkBorang->statusBorang;
    }

    public function calculateStaffByDept($siriID, $deptID)
    {
        $countp = 0;

        $countp = BorangPenilaianKeberkesanan::find()
            ->joinWith('peserta')
            ->where(['siriLatihanID' => $siriID, 'statusBorang' => 2, 'DeptId' => $deptID])
            ->count();

        if ($countp > 0) {
            return '&nbsp;<span class="badge bg-red">' . $countp . '</span>';
        } else {
            return '&nbsp;<span class="badge bg-blue"><i class="fa fa-check" aria-hidden="true"></i></span>';
        }
    }

    public static function totalPendingSpecial($icno)
    {
        $today = date('Y-m-d');

        $countp = 0;

        $check = Department::find()
            ->where(['chief' => $icno])
            ->orWhere(['pp' => $icno, 'id' => '164']) //HUMS
            ->all();

        if ($check) {

            foreach ($check as $c) {

                $model2 = BorangPenilaianKeberkesanan::find()
                    ->joinWith('peserta')
                    ->joinWith('siri.sasaran3')
                    ->where([
                        'statusBorang' => 2, 'DeptId' => $c->id, 'idp_kursusLatihan.kompetensi' => '6',
                        'idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman', 'Status' => '1'
                    ])
                    ->all();


                //echo '<pre>' , var_dump($model2) , '</pre>';
                //die();

                foreach ($model2 as $modelSiri) {
                    $dateSiri = date_create($modelSiri->siri->tarikhMula);
                    $dateBefore = date_add($dateSiri, date_interval_create_from_date_string("6 months"));
                    $dateBefore2 = date_format($dateBefore, "Y-m-d");

                    if ($dateBefore2 <= $today) {
                        $countp = $countp + 1;
                    }
                }
            }
        }

        if ($countp > 0) {
            return $countp;
        } else {
            return ' ';
        }
    }

    public function calculateSudahIsi($siriID)
    {
        $countp = 0;

        $countp = BorangPenilaianKeberkesanan::find()
            ->where(['siriLatihanID' => $siriID, 'statusBorang' => 2])
            ->orWhere(['siriLatihanID' => $siriID, 'statusBorang' => 3])
            ->count();

        if ($countp > 0) {
            //return '&nbsp;<span class="badge bg-green">' . $countp . '</span>';

            return Html::a($countp, 'laporan-kehadiran-siri?id='.$siriID, [
                'title' => Yii::t('app', 'Papar Borang'),
                'data-pjax' => 0,
                'target' => "_blank",
                'class' => 'btn-sm btn-primary btn-block text-center'
              ]);
        } else {
            return "";
        }
    }

    public function calculateKetuaIsi($siriID)
    {
        $countp = 0;

        $countp = BorangPenilaianKeberkesanan::find()
            ->where(['siriLatihanID' => $siriID])
            ->andWhere(['statusBorang' => 3])
            ->count();

        if ($countp > 0) {
            //return '&nbsp;<span class="badge bg-green">' . $countp . '</span>';

            return Html::a($countp, 'laporan-kehadiran-siri?id='.$siriID, [
                'title' => Yii::t('app', 'Papar Borang'),
                'data-pjax' => 0,
                'target' => "_blank",
                'class' => 'btn-sm btn-primary btn-block text-center'
              ]);
        } else {
            return "0";
        }
    }

    public function calcPurataKeberkesanan($siriID, $section){
        
        $model = BorangPenilaianKeberkesanan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['statusBorang' => 3])
                    ->all();
        
        $modelCount = BorangPenilaianKeberkesanan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['statusBorang' => 3])
                    ->count();
        
        $total = 0;
        //SIKAP
        if ($section == '1'){ 
            foreach ($model as $model){
                $total = $total + $model->k1;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*1*5))*100);
            } else {
                return '0';
            }
        } 
        //PENGETAHUAN
        elseif ($section == '2'){
            foreach ($model as $model){
                $total = $total + $model->k2;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*1*5))*100);
            } else {
                return '0';
            }
        } 
        //KEMAHIRAN DAN PRODUKTIVITI
        elseif ($section == '3'){
            foreach ($model as $model){
                $total = $total + $model->k3;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*1*5))*100);
            } else {
                return '0';
            }
        } 
        
    }
}
