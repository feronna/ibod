<?php

namespace app\models\keselamatan;

use app\models\keselamatan\RefShifts;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_tukar_syif".
 *
 * @property int $id
 * @property string $anggota_icno
 * @property string $tarikh_permohonan
 * @property string $penganti_icno
 * @property string $pelulus_icno
 * @property string $tarikh_tukar
 * @property string $status
 * @property string $alasan_penukaran
 * @property string $catatan_pelulus
 */
class TblTukarSyif extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.tbl_tukar_syif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['tarikh_permohonan', 'penganti_peraku_dt', 'perakuan_pelulus_dt'], 'safe'],
            [['pemohon_icno', 'penganti_icno', 'pelulus_icno', 'tarikh_tukar'], 'string', 'max' => 20],
            [['status_p', 'status_pelulus', 'shift_id', 'tukar_shift_id'], 'string', 'max' => 10],
            [['alasan_penukaran', 'catatan_pelulus'], 'string', 'max' => 250],
            [['alasan_penukaran'], 'required', 'message' => 'Sila Berikan Alasan!'],
            [['catatan_pelulus'], 'required', 'message' => 'Sila Berikan Catatan!'],
            [['shift_id'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Penganti'],
//            [['penganti_icno'], 'required', 'message' => 'Sila Pilih Tarikh Bercuti Dari - Hingga'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'anggota_icno' => 'Anggota Icno',
            'tarikh_permohonan' => 'Tarikh Permohonan',
            'penganti_icno' => 'Penganti Icno',
            'pelulus_icno' => 'Pelulus Icno',
            'tarikh_tukar' => 'Tarikh Tukar',
            'status' => 'Status',
            'alasan_penukaran' => 'Alasan Penukaran',
            'catatan_pelulus' => 'Catatan Pelulus',
        ];
    }

    public function getPelulus() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_icno']);
    }

    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getPenganti() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'penganti_icno']);
    }

    public function getPemohon() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohon_icno']);
    }

    public function changeDateFormat($date) {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getFormatTarikh() {

        return $this->changeDateFormat($this->tarikh_tukar);
    }

    public function getShifts() {
        return $this->hasOne(RefShifts::className(), ['id' => 'tukar_shift_id']);
    }

    public function getCurrshift() {
        return $this->hasOne(RefShifts::className(), ['id' => 'curr_shift_id']);
    }

    public function getStatus() {

        $val = '';

        if ($this->status_p == 'TT') {
            $val = 'Tunggu Tindakan';
        }

        if ($this->status_p == 'L') {
            $val = 'Bersetuju';
        }
        if ($this->status_p == 'TL') {
            $val = 'Tidak Bersetuju';
        }

        return $val;
    }

    public function getStatusLulus() {

        $val = '';


        if ($this->status_pelulus == 'TT') {
            $val = 'Tunggu Tindakan';
        }

        if ($this->status_pelulus == 'L') {
            $val = 'Diluluskan';
        }
        if ($this->status_pelulus == 'TL') {
            $val = 'Tidak Diluluskan';
        }

        return $val;
    }

}
