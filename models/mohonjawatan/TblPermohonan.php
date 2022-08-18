<?php

namespace app\models\mohonjawatan;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\mohonjawatan\TblPenetapanGaji;
use app\models\hronline\Department;
use app\models\mohonjawatan\RefItka;
use app\models\mohonjawatan\RefItp;
use app\models\mohonjawatan\RefBiw;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "mohonjawatan.tbl_permohonan".
 *
 * @property int $id
 * @property string $icno icno pemohon untuk tarik data
 * @property string $tujuan tujuan permohonan
 * @property string $doc_sokongan dokument sokongan
 * @property string $latarbelakang latar belakang jfpiu
 * @property string $ori_org carta organisasi sedia ada
 * @property string $fungsi_ori carta fungsi ori
 * @property string $new_org carta organisasi cadangan
 * @property string $fungsi_new carta fungsi cadangan
 * @property string $ringkasan ringkasan_perjawatan
 * @property string $jawatan_dipohon jawatan dan gred dipohon
 * @property int $bilangan bilangan jawatan dipohon
 * @property string $implikasi_kewangan bilangan * gaji jawatan
 * @property string $justifikasi sokongan untuk permohonan pemohon
 */
class TblPermohonan extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.mj_tbl_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bilangan', 'bilangan_diluluskan'], 'integer'],
            [['implikasi_kewangan'], 'number'],
            [['icno', 'app_by', 'ver_by'], 'string', 'max' => 20],
            [['unit'], 'string', 'max' => 50],
            [['tujuan', 'justifikasi', 'catatan', 'catatan_kj'], 'string', 'max' => 250],
            [['tujuan','jawatan_dipohon'], 'required','message' => 'Sila Lengkapkan Ruangan Ini'],
            [['status', 'status_kj'], 'string', 'max' => 25],
            [['doc_sokongan'], 'required', 'on' => 'dokumen', 'message' => 'Sila Muat Naik Dokumen Sokongan !'],
            [['doc_sokongan', 'latarbelakang', 'ori_org', 'fungsi_ori', 'new_org', 'fungsi_new', 'ringkasan'], 'file', 'skipOnEmpty' => True, 'extensions' => 'pdf,jpeg,png,jpg'],
            [['tarikh_mohon'], 'safe'],
            [['jawatan_dipohon'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'ICNO',
            'dept_id' => 'J/F/P/I/U',
            'unit' => 'Unit Ditetapkan',
            'tujuan' => 'Tujuan',
            'doc_sokongan' => 'Dokument Sokongan',
            'latarbelakang' => 'Latar belakang JFPIU',
            'ori_org' => 'Carta Organisasi Sedia Ada',
            'fungsi_ori' => 'Carta Fungsi Sedia Ada',
            'new_org' => 'Carta Organisasi Cadangan',
            'fungsi_new' => 'Carta Fungsi Cadangan',
            'ringkasan' => 'Ringkasan Perjawatan',
            'jawatan_dipohon' => 'Jawatan Dipohon',
            'bilangan' => 'Bilangan',
            'bilangan_diluluskan' => 'Bilangan Diluluskan',
            'implikasi_kewangan' => 'Implikasi Kewangan',
            'justifikasi' => 'Justifikasi',
            'tarikh_mohon' => 'Tarikh Mohon',
            'app_by' => 'Diluluskan oleh',
            'ver_by' => 'Disahkan oleh',
            'status' => 'Status',
            'status_kj' => 'Status_kj',
            'catatan' => 'Catatan',
        ];
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getGredjawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_dipohon']);
    }

    public function getDept() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }

    public function getData() {
        return $this->hasOne(TblPermohonan::findAll(['app_by' => '$icno']));
    }

    public function getNamajawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan']);
    }

    public function getStatusLabel() {

        if ($this->status == 'ENTRY') {
            return '<span "> </span>';
        } elseif ($this->status == 'VERIFIED') {
            return '<span class="label label-primary">DISAHKAN</span>';
        } elseif ($this->status == 'APPROVED') {
            return '<span class="label label-success">Masih Dalam Proses</span>';
        } elseif ($this->status == 'PINDAAN') {
            return '<span class="label label-info"> </span>';
        } elseif ($this->status == 'REJECTED') {
            return '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        } else {
            return '<span "> </span>';
        }
    }

    public function getStatuskj() {
        if ($this->status_kj == 'ENTRY') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_kj == 'VERIFIED') {
            return '<span class="label label-primary">DISAHKAN</span>';
        }
        if ($this->status_kj == 'DRAFT') {
            return '<span class="label label-default">DRAF</span>';
        }
        if ($this->status_kj == 'APPROVED') {
            return '<span class="label label-success">DIPERAKUI</span>';
        }
        if ($this->status_kj == 'PINDAAN') {
            return '<span class="label label-info">PINDAAN</span>';
        }
        if ($this->status_kj == 'REJECTED') {
            return '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        }
    }

    public static function jawatan($id) {
        $value = '';
        $model = Tblprcobiodata::findOne(['ICNO' => $id]);
        if ($model) {
            $value1 = $model->DeptId;
            $value = Department::findOne(['id' => $value1]);
        }
        return $value;
        die;
    }

    public function getSokongan() {
        if (!empty($this->doc_sokongan)) {
            return \Yii::$app->request->baseUrl . '/' . $this->doc_sokongan;
        }
    }

    public function getTarikh($bulan) {

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

    public function getTarikhMohon() {
        return $this->getTarikh($this->tarikh_mohon);
    }

//    public function getTarikhMohon() {
//        Yii::$app->formatter->locale = 'ms-MY';
//        return $this->tarikh_mohon ? Yii::$app->formatter->format($this->tarikh_mohon, ['date', 'dd MMM Y']) : '-';
//    }
//    public function getTarikhMula() {
//        return $this->entry_dt ? date('d/m/Y', strtotime($this->start_date)) : '-';
//    }
//
//    public function getTarikhTamat() {
//        return $this->end_date ? date('d/m/Y', strtotime($this->end_date)) : '-';
//    }

    public function getDisplayDoc() {
        if (!empty($this->doc_sokongan && $this->doc_sokongan != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->doc_sokongan), Yii::$app->FileManager->DisplayFile($this->doc_sokongan));
        }
        return 'File not exist!';
    }

    public function getDisplayRingkasan() {
        if (!empty($this->ringkasan)) {
            return html::a(Yii::$app->FileManager->NameFile($this->ringkasan), Yii::$app->FileManager->DisplayFile($this->ringkasan));
        }
        return 'File not exist!';
    }

}
