<?php

namespace app\models\keselamatan;

use app\models\cuti\CutiRekod;
use app\models\cuti\Layak;
use app\models\hronline\Tblprcobiodata;
use app\models\cuti\JenisCuti;
use app\models\cuti\TblRecords;
use Yii;

/**
 * This is the model class for table "keselamatan.cuti_rekod".
 *
 * @property string $cuti_rekod_id
 * @property string $cuti_icno
 * @property string $cuti_mula
 * @property string $cuti_tamat
 * @property string $cuti_catatan
 * @property int $cuti_tempoh
 * @property int $cuti_jenis_id 		
 * @property int $cuti_lampir_dok bool value must be true/1 if pemohon lampir dok
 * @property string $cuti_session_id
 * @property string $cuti_session_ip
 * @property string $cuti_ganti_oleh
 * @property string $cuti_ganti_status NULL, L, TL
 * @property string $cuti_ganti_status_pada
 * @property string $cuti_dok_peraku_oleh ICNO penyelia cuti yg peraku dokumen
 * @property string $cuti_peraku_oleh
 * @property string $cuti_lulus_oleh
 * @property string $cuti_status_dok_peraku NULL, L, TL
 * @property string $cuti_status_peraku NULL, L, TL
 * @property string $cuti_status_lulus NULL, L, TL, P, B
 * @property string $cuti_mohon_pada
 * @property string $cuti_dok_peraku_pada
 * @property string $cuti_peraku_pada
 * @property string $cuti_lulus_pada
 * @property string $cuti_admin_oleh peg/admin di pendaftar yg overwrite status
 * @property string $cuti_status_admin status yg overwrite by admin
 * @property string $cuti_catatan_peraku
 * @property string $cuti_catatan_lulus
 * @property string $cuti_batal
 * @property string $cuti_batal_pada
 * @property string $cuti_destinasi
 */
class cuti extends \yii\db\ActiveRecord {

// public static function getDb() {
//        return Yii::$app->get('db2'); // second database
//    }
//    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.cuti_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cuti_icno'], 'required'],
            [['full_date'], 'required', 'message' => 'Sila Pilih Tarikh Bercuti Dari - Hingga'],
            [['cuti_mula', 'cuti_tamat', 'cuti_ganti_status_pada', 'cuti_mohon_pada', 'cuti_dok_peraku_pada', 'cuti_peraku_pada', 'cuti_lulus_pada', 'cuti_batal_pada'], 'safe'],
            [['cuti_tempoh', 'cuti_jenis_id', 'cuti_lampir_dok'], 'integer'],
//            ['cuti_mula', 'required', 'message' => 'Please choose a username.'],
//            [['cuti_mula'], 'required', 'message' => 'Sila Pilih Tarikh Mula Bercuti'],
//            [['cuti_mula'], 'required', 'on' => ['cutimula']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain
            [['cuti_catatan'], 'required', 'message' => 'Sila Nyatakan Alasan Anda Bercuti'],
            [['cuti_batal', 'cuti_destinasi'], 'string'],
            [['cuti_icno', 'cuti_session_id', 'cuti_ganti_oleh', 'cuti_dok_peraku_oleh', 'cuti_peraku_oleh', 'cuti_lulus_oleh', 'cuti_admin_oleh'], 'string', 'max' => 12],
            [['cuti_catatan', 'cuti_catatan_peraku', 'cuti_catatan_lulus'], 'string', 'max' => 200],
            [['cuti_session_ip'], 'string', 'max' => 30],
            [['full_date'], 'string', 'max' => 25],
            [['cuti_ganti_status', 'cuti_status_dok_peraku', 'cuti_status_peraku', 'cuti_status_lulus', 'cuti_status_admin'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'cuti_rekod_id' => 'Cuti Rekod ID',
            'cuti_icno' => 'Cuti Icno',
            'cuti_mula' => 'Cuti Mula',
            'cuti_tamat' => 'Cuti Tamat',
            'cuti_catatan' => 'Cuti Catatan',
            'cuti_tempoh' => 'Cuti Tempoh',
            'cuti_jenis_id' => 'Cuti Jenis ID',
            'cuti_lampir_dok' => 'Cuti Lampir Dok',
            'cuti_session_id' => 'Cuti Session ID',
            'cuti_session_ip' => 'Cuti Session Ip',
            'cuti_ganti_oleh' => 'Cuti Ganti Oleh',
            'cuti_ganti_status' => 'Cuti Ganti Status',
            'cuti_ganti_status_pada' => 'Cuti Ganti Status Pada',
            'cuti_dok_peraku_oleh' => 'Cuti Dok Peraku Oleh',
            'cuti_peraku_oleh' => 'Cuti Peraku Oleh',
            'cuti_lulus_oleh' => 'Cuti Lulus Oleh',
            'cuti_status_dok_peraku' => 'Cuti Status Dok Peraku',
            'cuti_status_peraku' => 'Cuti Status Peraku',
            'cuti_status_lulus' => 'Cuti Status Lulus',
            'cuti_mohon_pada' => 'Cuti Mohon Pada',
            'cuti_dok_peraku_pada' => 'Cuti Dok Peraku Pada',
            'cuti_peraku_pada' => 'Cuti Peraku Pada',
            'cuti_lulus_pada' => 'Cuti Lulus Pada',
            'cuti_admin_oleh' => 'Cuti Admin Oleh',
            'cuti_status_admin' => 'Cuti Status Admin',
            'cuti_catatan_peraku' => 'Cuti Catatan Peraku',
            'cuti_catatan_lulus' => 'Cuti Catatan Lulus',
            'cuti_batal' => 'Cuti Batal',
            'cuti_batal_pada' => 'Cuti Batal Pada',
            'cuti_destinasi' => 'Cuti Destinasi',
        ];
    }

    public function getPemohon() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohon_icno']);
    }

    public function getJenis() {
        return $this->hasOne(JenisCuti::className(), ['jenis_cuti_id' => 'cuti_jenis_id']);
    }

    public function getTarikh() {

        return $this->changeDateFormat($this->cuti_mula) . ' - ' . $this->changeDateFormat($this->cuti_tamat);
    }

    public function getPemohoncuti() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'cuti_icno']);
    }

    public function changeDateFormat($date) {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getFormatTarikh() {

        return $this->changeDateFormat($this->cuti_mula);
    }

    public function getFormatTarikhTamat() {

        return $this->changeDateFormat($this->cuti_tamat);
    }

    public function getPeraku() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_icno']);
    }

    public function getPelulus() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_icno']);
    }

    public function getStatusPengganti() {

        $val = '';

        if ($this->cuti_ganti_status == 'TT') {
            $val = 'Tunggu Tindakan';
        }

        if ($this->cuti_ganti_status == 'L') {
            $val = 'Bersetuju';
        }

        return $val;
    }

    public function getStatusPeraku() {

        $val = '';

        if ($this->cuti_status_peraku == 'TT') {
            $val = 'Tunggu Tindakan';
        } elseif ($this->cuti_status_peraku == 'L') {
            $val = 'Diluluskan';
        } elseif ($this->cuti_status_peraku == 'TL') {
            $val = 'Tidak Diluluskan';
        } else {
            $val = '-';
        }

        return $val;
    }

    public function getStatusLulus() {

        $val = '';

        if ($this->cuti_status_lulus == 'TT') {
            $val = 'Tunggu Tindakan';
        } elseif ($this->cuti_status_lulus == 'L') {
            $val = 'Diluluskan';
        } elseif ($this->cuti_status_lulus == 'TL') {
            $val = 'Tidak Diluluskan';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function getBakiLatests($icno) {

        $baki = 0;

        $layak = Layak::getLatestLayak($icno);

        if ($layak) {
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;

            $jum_cuti = Cuti::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $jum_cuti;
        }

        return $baki;
    }
    public static function totalLayak($icno) {

        $total_layak = 0;

        $layak = Layak::getLatestLayak($icno);

        if ($layak) {
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;

           
        }

        return $total_layak;
    }

    public static function totalCuti($icno, $mula, $tamat) {

        $val = 0;

        $command = Yii::$app->db->createCommand("SELECT SUM(cuti_tempoh) FROM keselamatan.cuti_rekod a
                                                WHERE a.cuti_status_lulus != 'TL'
                                                AND a.cuti_status_lulus != 'L'
                                                AND a.cuti_mula BETWEEN :mula AND :tamat
                                                AND a.cuti_jenis_id IN (1,2)
                                                AND a.cuti_icno = :icno")
                ->bindValue(':icno', $icno)
                ->bindValue(':mula', $mula)
                ->bindValue(':tamat', $tamat);

        if ($command) {
            $val = $command->queryScalar();
        }

        return $val;
    }

    public function bakiCutiLastYear($icno, $mula, $tamat) {
        $curr_year = date("Y");

        $LastYearStart = date("Y", strtotime($mula));
        $LastYearEnd = date("Y", strtotime($tamat));
        if ($curr_year != $LastYearStart) {
            $date = strtotime("$mula -1 year");
            $layak_mula = date('Y-m-d', $date);
        } else {
            $layak_mula = $mula;
        }

        $date = strtotime("$tamat -1 year");
        $layak_tamat = date('Y-m-d', $date);

//        var_dump($layak_mula,$layak_tamat);die;
        $val = 0;

        $command = Yii::$app->db->createCommand("SELECT SUM(layak_cuti) FROM hrm.cuti_entitlement a
                                                WHERE a.layak_mula BETWEEN :mula AND :tamat
                                                AND a.layak_icno = :icno")
                ->bindValue(':icno', $icno)
                ->bindValue(':mula', $layak_mula)
                ->bindValue(':tamat', $layak_tamat);

        if ($command) {
            $val = $command->queryScalar();
        }

        $lastjumcuti = TblRecords::totalCuti($icno, $layak_mula, $layak_tamat);

        $baki = $val - $lastjumcuti;
        return $baki;
    }

    public static function getLastLayak($icno, $mula, $tamat) {
        $val = 0;

        $command = Yii::$app->db->createCommand("SELECT SUM(layak_cuti) FROM hrm.cuti_entitlement a
                                                WHERE a.layak_mula BETWEEN :mula AND :tamat
                                                AND a.layak_icno = :icno")
                ->bindValue(':icno', $icno)
                ->bindValue(':mula', $mula)
                ->bindValue(':tamat', $tamat);

        if ($command) {
            $val = $command->queryScalar();
        }

        return $val;
    }

}
