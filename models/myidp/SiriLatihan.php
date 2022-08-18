<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Campus;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "myidp.SiriLatihan".
 *
 * @property int $siriLatihanID
 * @property int $kursusLatihanID
 * @property string $siri
 * @property string $lokasi
 * @property string $tarikhMula
 * @property string $tarikhAkhir
 * @property string $dayasaMula
 * @property int $jumlahJamLatihan
 * @property int $jumlahMataIDP
 * @property string $statusLatihan
 * @property string $filename
 */
class SiriLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $file;

    public static function tableName()
    {
        return 'hrd.idp_SiriLatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursusLatihanID', 'jumlahJamLatihan', 'kuota', 'kampusID', 'metod'], 'integer'],
            [['tarikhMula', 'tarikhAkhir', 'masaMula', 'masaTamat'], 'safe'],
            [['jumlahMataIDP', 'lulusYuran', 'lulusTiket', 'lulusPenginapan'], 'number'],
            [['kampusID'], 'required'],
            [['linkZoom', 'linkBahan'], 'string'],
            [['siri', 'statusSiriLatihan'], 'string', 'max' => 25],
            [['lokasi', 'filename'], 'string', 'max' => 100],
            [['file'], 'file', 'extensions' => 'pdf, png, jpg', 'maxFiles' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => 'Siri Latihan ID',
            'kursusLatihanID' => 'Kursus Latihan ID',
            'siri' => 'Siri',
            'lokasi' => 'Lokasi',
            'tarikhMula' => 'Tarikh Mula',
            'tarikhAkhir' => 'Tarikh Akhir',
            'masaMula' => 'Masa Mula',
            'masaTamat' => 'Masa Tamat',
            'jumlahJamLatihan' => 'Jumlah Jam Latihan',
            'jumlahMataIDP' => 'Jumlah Mata Idp',
            'statusSiriLatihan' => 'Status Siri Latihan',
            'filename' => 'Filename',
            'kuota' => 'Kuota',
            'kampusID' => 'Kampus',
            'linkZoom' => 'Pautan Latihan Atas Talian',
            'linkBahan' => 'Pautan Bahan Kursus (Google Drive)',
            'metod' => 'Metod',
            'lulusYuran' => Yii::t('app', 'Lulus Yuran'),
            'lulusTiket' => Yii::t('app', 'Lulus Tiket'),
            'lulusPenginapan' => Yii::t('app', 'Lulus Penginapan'),
        ];
    }

    public function getSasaranb()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(BorangPenilaianLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    /** Relation **/
    public function getSasaran3()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(KursusLatihan::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }

    public function getSiriAmount($id)
    {
        $currentYear = date('Y');

        $count = SiriLatihan::find()
            ->where(['kursusLatihanID' => $id])
            ->andWhere(['YEAR(tarikhMula)' => $currentYear])
            ->count();

        return $count;
    }

    /** Relation **/
    public function getSasaran5()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SlotLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function getSasaran7()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(SiriLatihanBahan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    /** Relation **/
    public function getCeramah()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(Ceramah::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function getTarikhKursus2()
    {

        $formatteddate = "";
        $formatteddate2 = "";

        if ($this->tarikhMula) {
            $dayyDateTime = \DateTime::createFromFormat('Y-m-d', $this->tarikhMula);
            $formatteddate = $dayyDateTime->format('d-m-Y');
            //$hariMula = substr($formatteddate,0,8).''.'20';
        }

        if ($this->tarikhAkhir) {
            $dayyDateTime2 = \DateTime::createFromFormat('Y-m-d', $this->tarikhAkhir);
            $formatteddate2 = $dayyDateTime2->format('d-m-Y');
            //$hariAkhir = substr($formatteddate2,0,8).''.'20';
        }

        if ($formatteddate == $formatteddate2) {

            return $formatteddate;
        } else {

            return $formatteddate . ' - ' . $formatteddate2;
        }
    }

    public function getTarikhKursus()
    {

        $hariMula = "";
        $hariAkhir = "";

        if ($this->tarikhMula) {
            $dayyDateTime = \DateTime::createFromFormat('Y-m-d', $this->tarikhMula);
            $formatteddate = $dayyDateTime->format('d-m-Y');
            $hariMula = substr($formatteddate, 0, 8) . '' . '22';
        }

        if ($this->tarikhAkhir) {
            $dayyDateTime2 = \DateTime::createFromFormat('Y-m-d', $this->tarikhAkhir);
            $formatteddate2 = $dayyDateTime2->format('d-m-Y');
            $hariAkhir = substr($formatteddate2, 0, 8) . '' . '22';
        }

        if ($hariMula == $hariAkhir) {

            return $hariMula;
        } else {

            return $hariMula . ' - ' . $hariAkhir;
        }
    }

    public function getLokasiKursus()
    {

        if ($this->lokasi != NULL) {
            return $this->lokasi;
        } else {
            return "AKAN DIMAKLUMKAN KEMUDIAN";
        }
    }

    public function getBulanKursus()
    {

        $bulan = '0';

        //$result = self::getsomthin();

        if ($this->tarikhMula != NULL) {

            $dayyDateTime = \DateTime::createFromFormat('Y-m-d', $this->tarikhMula);
            $formatteddate = $dayyDateTime->format('m');
            $bulan = $formatteddate;

            return $bulan;
        } else {

            return $bulan;
        }
    }

    public function kursusListByMonth($dayonth, $tahun)
    {
        $currentYear = $tahun;

        $day = SiriLatihan::find()
            ->joinWith('sasaran3')
            ->where(['statusKursusLatihan' => 'AKTIF', 'jenisLatihanID' => 'latihanDalaman'])
            ->andWhere(['YEAR(tarikhMula)' => $currentYear])
            ->orderBy('tarikhMula');

        $dataProvider = new ActiveDataProvider([
            'query' => $day,
            'pagination' => false,
            'sort' => false,
        ]);

        $filteredModels = [];
        //$filteredModels2 = [];

        foreach ($dataProvider->models as $dayodel) {
            if ($dayodel->bulanKursus == $dayonth) {
                $filteredModels[] = $dayodel;
                //$dataProvider->setModels($filteredModels);
            }
            //else {
            //$filteredModels2[] = $dayodel;
            //$dataProvider->setModels($filteredModels2);
            //}
        }

        $dataProvider->setModels($filteredModels);

        return $dataProvider;
    }

    public function getTarikh($day)
    {

        //$day = $bulan;
        if ($day == 01) {
            $day = "Januari";
        } elseif ($day == 02) {
            $day = "Februari";
        } elseif ($day == 03) {
            $day = "Mac";
        } elseif ($day == 04) {
            $day = "April";
        } elseif ($day == 05) {
            $day = "Mei";
        } elseif ($day == 06) {
            $day = "Jun";
        } elseif ($day == 07) {
            $day = "Julai";
        } elseif ($day == '08') {
            $day = "Ogos";
        } elseif ($day == '09') {
            $day = "September";
        } elseif ($day == '10') {
            $day = "Oktober";
        } elseif ($day == '11') {
            $day = "November";
        } elseif ($day == '12') {
            $day = "Disember";
        } else {
            $day = "TIDAK DITETAPKAN";
        }

        return $day;
    }

    public function getCampusName()
    {
        return $this->hasOne(Campus::className(), ['campus_id' => 'kampusID']);
    }

    /** Relation **/
    public function getSasaran8()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(KursusSasaran::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    /** Relation **/
    public function getSasaran9()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(KursusJemputan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function CheckKuota($siriLatihanID)
    {

        $ckuota = PermohonanLatihan::find()
            ->where(['siriLatihanID' => $siriLatihanID])
            ->count();

        return $ckuota;
    }

    public function getHari()
    {

        setlocale(LC_ALL, 'my_MY');

        $hariMula = $this->tarikhMula;
        $hariAkhir = $this->tarikhAkhir;

        $timestamp = strtotime($hariMula);
        //$day = date('l', $timestamp);

        $day = strftime('%A', $timestamp);

        //echo strftime("%A %d %B %Y", mktime(0, 0, 0, 12, 22, 1978));

        $timestamp2 = strtotime($hariAkhir);
        //$day2 = date('l', $timestamp2);

        $day2 = strftime('%A', $timestamp2);

        //var_dump($day);

        if ($day == 'Sunday') {
            $day = "Ahad";
        } elseif ($day == 'Monday') {
            $day = "Isnin";
        } elseif ($day == 'Tuesday') {
            $day = "Selasa";
        } elseif ($day == 'Wednesday') {
            $day = "Rabu";
        } elseif ($day == 'Thursday') {
            $day = "Khamis";
        } elseif ($day == 'Friday') {
            $day = "Jumaat";
        } elseif ($day == 'Saturday') {
            $day = "Sabtu";
        }

        if ($day2 == 'Sunday') {
            $day2 = "Ahad";
        } elseif ($day2 == 'Monday') {
            $day2 = "Isnin";
        } elseif ($day2 == 'Tuesday') {
            $day2 = "Selasa";
        } elseif ($day2 == 'Wednesday') {
            $day2 = "Rabu";
        } elseif ($day2 == 'Thursday') {
            $day2 = "Khamis";
        } elseif ($day2 == 'Friday') {
            $day2 = "Jumaat";
        } elseif ($day2 == 'Saturday') {
            $day2 = "Sabtu";
        }

        if ($day == $day2) {
            return $day;
        } else {
            return $day . ' - ' . $day2;
        }
    }

    public function CheckPastProgram()
    {

        $today = date('Y-m-d');

        //if ($this->tarikhMula <= $today){
        //For MCO only
        if (($this->tarikhMula < $today) && $this->statusSiriLatihan == 'SEDANG BERJALAN') {
            return 0;
        } else {
            return 1;
        }
    }

    public function getStatusSiri()
    {

        $status = '';

        if ($this->statusSiriLatihan == 'ACTIVE' || $this->statusSiriLatihan == 'AKTIF') {
            $status = '<span style="width:150px" class="label label-primary">AKTIF</span>';
        } elseif ($this->statusSiriLatihan == 'SEDANG BERJALAN') {
            $status = '<span style="width:150px" class="label label-success">TELAH DIJALANKAN</span>';
        } elseif ($this->statusSiriLatihan == 'DITANGGUHKAN') {
            $status = '<span style="width:150px" class="label label-danger">DITANGGUHKAN</span>';
        } elseif ($this->statusSiriLatihan == 'INACTIVE') {
            $status = '<span style="width:150px" class="label label-danger">DIBATALKAN</span>';
        }
        return $status;
    }

    public function liveKursusByMonth($dayonth)
    {
        $day = SiriLatihan::find()
            ->joinWith('sasaran3')
            ->where(['statusSiriLatihan' => 'SEDANG BERJALAN'])
            ->andWhere(['<>', 'unitBertanggungjawab', 'JFPIU'])
            ->orderBy('tarikhMula');

        $dataProvider = new ActiveDataProvider([
            'query' => $day,
            'pagination' => false,
            'sort' => false,
        ]);

        $filteredModels = [];
        //$filteredModels2 = [];

        foreach ($dataProvider->models as $dayodel) {
            if ($dayodel->bulanKursus == $dayonth) {
                $filteredModels[] = $dayodel;
                //$dataProvider->setModels($filteredModels);
            }
            //else {
            //$filteredModels2[] = $dayodel;
            //$dataProvider->setModels($filteredModels2);
            //}
        }

        $dataProvider->setModels($filteredModels);

        return $dataProvider;
    }

    public function getSasaran66()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(PermohonanLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function getStatusSixMonths($id)
    {
        $status = 0;

        $modelSiri = SiriLatihan::find()->where(['siriLatihanID' => $id])->one();
        $dateSiri = date_create($modelSiri->tarikhMula);
        $dateBefore = date_add($dateSiri, date_interval_create_from_date_string("6 months"));
        $dateBefore2 = date_format($dateBefore, "Y-m-d");

        if ($dateBefore2 <= date('Y-m-d')) {
            //$status = 1;

            return '&nbsp;<span class="badge bg-green"><i class="fa fa-check" aria-hidden="true"></i></span>';
        } else {
            //$status = 2;

            return '&nbsp;<span class="badge bg-red"><i class="fa fa-remove" aria-hidden="true"></i></span>';
        }

        //return $status;
    }

    public static function countKursusByMonthlyStatus($kumpulan, $category, $year)
    {

        $count = 0;

        if ($category == 0) { //jumlah kursus
            $count = SiriLatihan::find()
                ->joinWith('sasaran3')
                ->where(['MONTH(tarikhMula)' => $kumpulan, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
                ->andWhere(['<>', 'statusSiriLatihan', 'INACTIVE'])
                ->count();
        } elseif ($category == 1) { //telah dilaksanakan
            $count = SiriLatihan::find()
                ->joinWith('sasaran3')
                ->where(['MONTH(tarikhMula)' => $kumpulan, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
                ->andWhere(['statusSiriLatihan' => 'SEDANG BERJALAN'])
                ->count();
        } elseif ($category == 3) { //jumlah belum laksana
            $count = SiriLatihan::find()
                ->joinWith('sasaran3')
                ->where(['MONTH(tarikhMula)' => $kumpulan, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
                ->andWhere(['statusSiriLatihan' => 'ACTIVE'])
                ->count();
        } elseif ($category == 5) { //jumlah tangguh
            $count = SiriLatihan::find()
                ->joinWith('sasaran3')
                ->where(['MONTH(tarikhMula)' => $kumpulan, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
                ->andWhere(['statusSiriLatihan' => 'DITANGGUHKAN'])
                ->count();
        }

        return $count;
    }

    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach($provider as $item) {
            $total += $item[$fieldName];

        }

        return $total;
    }
}
