<?php

namespace app\models\keselamatan;

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
//use app\models\keselamatan\TblStaffKeselamatan;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\RefShifts;
use app\models\kehadiran\TblWp;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\cuti\CutiRekod;
use app\models\cuti\CutiUmum;
use app\models\cuti\TblRecords;
use app\models\KeluarPejabat;
use app\models\keselamatan\TblStaffKeselamatan;
use Yii;
use DateTime;

/**
 * This is the model class for table "keselamatan.tbl_rollcall".
 *
 * @property int $id
 * @property string $anggota_icno
 * @property string $month
 * @property string $date
 * @property string $year
 * @property string $syif
 * @property string $HH
 * @property string $THH
 * @property string $HLMJ
 * @property string $HLMT
 * @property string $HKWLN
 * @property string $THB
 * @property string $THBH
 * @property string $THBLMJ
 * @property string $THBLMT
 * @property string $THBKWLN
 * @property string $THTC
 * @property string $THLMJ
 * @property string $THLMT
 * @property string $THKWLN
 * @property string $do_icno
 * @property string $catatan
 */
class TblRollcall extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_rollcall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'year', 'time', 'app_dt', 'report_dt', 'verified_dt', 't_date'], 'safe'],
            [['anggota_icno', 'do_icno', 'peg_peraku', 'peg_pelulus'], 'string', 'max' => 20],
            [['do_icno', 'penganti_do_icno', 'verified_by', 'sent_by'], 'string', 'max' => 12],
            [['verified_stat'], 'string', 'max' => 8],
            [['month'], 'string', 'max' => 15],
            [['masa_masuk_tugas'], 'string', 'max' => 15],
            [['penganti_do'], 'string', 'max' => 50],
            [['sts_sent'], 'string', 'max' => 10],
            [['type'], 'string', 'max' => 5],
            [['status'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Status Pengesahan !'],
            [['verifier_comment'], 'required', 'message' => 'Sila Masukkan Ulasan !'],
            // [['verifier_comment'], 'required', 'on' => 'reason', 'message' => 'Sila Masukkan Ulasan !'],
            [['catatan'], 'required', 'on' => 'reason', 'message' => 'Sila Masukkan Catatan !'],
            [['pos_kawalan_id', 'syif', 'HH', 'THH', 'HLMJ', 'HLMT', 'HKWLN', 'THB', 'THBH', 'THBLMJ', 'THBLMT', 'THBKWLN', 'THTC', 'THLMJ', 'THLMT', 'THKWLN'], 'string', 'max' => 15],
            [['CG', 'CSG', 'CR', 'CK', 'CGKA', 'CS', 'CTR', 'CTG', 'CKA', 'TLP'], 'string', 'max' => 1],
            [['catatan', 'remark', 'verifier_comment'], 'string', 'max' => 250],
            [['app_remark'], 'string', 'max' => 150],
            [['status'], 'string', 'max' => 10],
            [['namafile'], 'string', 'max' => 100],
            [['namafile'], 'file', 'skipOnEmpty' => True, 'extensions' => 'pdf,jpeg,png,jpg'],
            //            [['doc_sokongan'], 'required', 'on' => 'dokumen', 'message' => 'Sila Muat Naik Dokumen Sokongan !'],
            [['reason_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'anggota_icno' => 'Anggota Icno',
            'month' => 'Month',
            'date' => 'Date',
            'year' => 'Year',
            'syif' => 'Syif',
            'HH' => 'Hh',
            'THH' => 'Thh',
            'HLMJ' => 'Hlmj',
            'HLMT' => 'Hlmt',
            'HKWLN' => 'Hkwln',
            'THB' => 'Thb',
            'THBH' => 'Thbh',
            'THBLMJ' => 'Thblmj',
            'THBLMT' => 'Thblmt',
            'THBKWLN' => 'Thbkwln',
            'THTC' => 'Thtc',
            'THLMJ' => 'Thlmj',
            'THLMT' => 'Thlmt',
            'THKWLN' => 'Thkwln',
            'do_icno' => 'Do Icno',
            'catatan' => 'Catatan',
            'status' => 'Status',
            'masa_masuk_tugas' => 'Masa Masuk Tugas',
        ];
    }

    public function getReportDt()
    {

        $val = '-';

        if ($this->report_dt) {

            $val = $this->changeDateFormat($this->report_dt);
        }

        return $val;
    }
    public function getJadual()
    {
        if ($this->type == "H") {
            return '<span class="label label-primary">Hakiki</span>';
        }
        if ($this->type == "LMT") {
            return '<span class="label label-success ">LMT</span>';
        }
        if ($this->type == "LMJ") {
            return '<span class="label label-info">LMJ</span>';
        }
    }

    public function getStaff()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'anggota_icno']);
    }

    public function getStat()
    {
        if ($this->status == "STS") {
            return '<span class="label label-primary">Beri Catatan</span>';
        }
        if ($this->status == "APPROVED") {
            return '<span class="label label-success">Diluluskan</span>';
        }
        if ($this->status == "REMARKED") {
            return '<span class="label label-info">Telah Diberi Catatan</span>';
        }
        if ($this->status == "SIMPAN") {
            return '<span class="label label-info">STS Belum Ada Tindakan</span>';
        }
        if ($this->status == "REJECTED") {
            return '<span class="label label-info">Ditolak</span>';
        }
    }

    public function getPos()
    {
        return $this->hasOne(RefPosKawalan::className(), ['id' => 'pos_kawalan_id']);
    }

    public function getPoskawalan()
    {
        $syif = TblShiftKeselamatan::findOne(['icno' => $this->staff->ICNO]);
        $pos_kawalan = RefPosKawalan::findOne(['id' => $syif->pos_kawalan_id]);
        return $pos_kawalan->pos_kawalan;
    }
    public static function Syif($id, $date)
    {
        $val = "";
        $model = TblShiftKeselamatan::findOne(['icno' => $id, 'tarikh' => $date]);
        if ($model) {
            $val = RefPosKawalan::findOne(['id' => $model->pos_kawalan_id]);
        } else {
            $val = "";
        }
        return $val->pos_kawalan;
    }
    public function getSyif()
    {
        $date = date('Y-m-d');
        $identity = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['icno' => $this->staff->ICNO])->one();
        $syif = RefShifts::find()->where(['id' => $identity->shift_id])->one();
        return $syif->jenis_shifts;
    }

    public function getUnitname()
    {
        $id = TblStaffKeselamatan::find()->where(['staff_icno' => $this->staff->ICNO])->one();
        $unit = RefUnit::find()->where(['id' => $id->unit_id])->one();
        //        var_dump($unit->unit_name);die;
        return $unit->unit_name;
    }

    public function getKp()
    {
        if ($this->ketua_pos == '1') {
            return '<span ">KP</span>';
        }
        if ($this->penolong_ketua_pos == '1') {
            return '<span "> PKP </span>';
        }
    }

    public function changeDateFormat($date)
    {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getStatusH()
    {

        $THBH = '';
        $THTC = '';
        $THBLMJ = '';
        $THBLMT = '';
        $THBKWLN = '';
        $THLMJ = '';
        $THLMT = '';
        $THKWLN = '';
        $THH = '';

        if ($this->THBH == '1') {
            $THBH = 'THBH';
        }
        if ($this->THBLMJ == '1') {
            $THBLMJ = 'THBLMJ';
        }
        if ($this->THBLMT == '1') {
            $THBLMT = 'THBLMT';
        }
        if ($this->THBKWLN == '1') {
            $THBKWLN = 'THBKWLN';
        }
        if ($this->THLMJ == '1') {
            $THLMJ = 'THLMJ';
        }
        if ($this->THLMT == '1') {
            $THLMT = 'THLMT';
        }
        if ($this->THKWLN == '1') {
            $THKWLN = 'THKWLN';
        }
        if ($this->THH == '1') {
            $THH = 'THH';
        }
        if ($this->THTC == '1') {
            $THTC = 'THTC';
        }

        return '<span class="label label-danger">' . $THBH . '</span>' .
            ' <span class="label label-danger">' . $THBLMJ . '</span> ' .
            ' <span class="label label-danger">' . $THBLMT . '</span>' . '</span> ' .
            ' <span class="label label-danger">' . $THBKWLN . '</span> ' .
            ' <span class="label label-danger">' . $THLMJ . '</span>' .
            ' <span class="label label-danger">' . $THLMT . '</span>' .
            ' <span class="label label-danger">' . $THKWLN . '</span>' .
            ' <span class="label label-danger">' . $THH . '</span>' .
            //                ' <span class="label label-danger">' . $gmk . '</span>' .
            //                ' <span class="label label-danger">' . $gmk . '</span>' .
            ' <span class="label label-danger">' . $THTC . '</span>';
    }

    public function getWbb()
    {
        return $this->hasOne(RefWp::className(), ['id' => 'wp_id']);
    }

    /**
 
     * @return \yii\db\ActiveQuery
     */
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getSender()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'sent_by']);
    }
    public function getVerifier()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }


    public function getVerifedstat()
    {
        if ($this->verified_stat == 'PENDING') {
            $v = 'Belum DiSahkan';
        } else {
            $v = 'DiSahkan';
        }

        return '<span class="label label-info">' . $v . '</span>';
    }

    public function getApp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }
    public function getPm()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'verified_by']);
    }

    public function getPeraku()
    {
        if ($this->app_by !== NULL) {
            return $this->app->CONm;
        } else {
            return '-';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(RefReason::className(), ['id' => 'reason_id']);
    }

    public static function PendingReason()
    {

        $icno = Yii::$app->user->getId();

        $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND remark IS NULL AND (status_in IS NOT NULL OR status_out IS NOT NULL OR absent = 1)';
        $model = self::findBySql($sql, [':icno' => $icno])->all();

        return $model;
    }

    public static function BtnTime()
    {

        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');

        $btn = Html::a('<i id="time_in" class="fa fa-clock-o"></i>&nbsp;Timein', ['/kehadiran/timein'], ['class' => 'btn btn-primary btn-block']);

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);

        //check dlu klu sda check in atau ada data dlm table
        if ($model) {
            $btn = Html::a('<i class="fa fa-clock-o"></i>&nbsp;TimeOut', ['/kehadiran/timeout', 'id' => $model->id], ['class' => 'btn btn-success btn-block']);
        }

        return $btn;
    }

    public function getFormatTimeIn()
    {

        $val = '-';

        if ($this->time_in) {

            $val = $this->changeDatetimeToTime($this->time_in);
        } else {
            $val = $this->changeDatetimeToTime($this->ot_in);
        }

        return $val;
    }

    public function getFormatTimeOut()
    {

        $val = '-';

        if ($this->time_out) {

            $val = $this->changeDatetimeToTime($this->time_out);
        }

        return $val;
    }

    public function getFormatTimeInOt()
    {

        $val = '-';

        if ($this->ot_in) {

            $val = $this->changeDatetimeToTime($this->ot_in);
        } else {
            $val = $this->changeDatetimeToTime($this->ot_in);
        }

        return $val;
    }

    public function getFormatTimeOutOt()
    {

        $val = '-';

        if ($this->ot_out) {

            $val = $this->changeDatetimeToTime($this->ot_out);
        }

        return $val;
    }

    public function changeDatetimeToTime($datetime)
    {

        $dt = date_create($datetime);

        $time = date_format($dt, "h:i A");

        return $time;
    }

    public function getFormatOtIn()
    {

        $val = '';

        if ($this->ot_in) {

            $val = $this->changeDatetimeToTime($this->ot_in);
        }

        return $val;
    }

    public function getFormatOtOut()
    {

        $val = '';

        if ($this->ot_out) {

            $val = $this->changeDatetimeToTime($this->ot_out);
        }

        return $val;
    }

    public function DaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }
        return $datesArray;
    }
    public static function CountSts($id)
    {
        $val = '0';
        $year = date('Y');
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];

        $model = TblRollcall::find()->where(['anggota_icno' => $id])->andWhere(['year' => $year])
            ->andWhere(['IN', 'status', $value])
            ->count();
        if ($model) {
            $val = $model;
        } else {
            $val = '0';
        }
        return $val;
    }
    public static function CountStsApproved($id)
    {
        $val = '0';
        $year = date('Y');
        $value = ['APPROVED'];

        $model = TblRollcall::find()->where(['anggota_icno' => $id])->andWhere(['year' => $year])
            ->andWhere(['IN', 'status', $value])
            ->count();
        if ($model) {
            $val = $model;
        } else {
            $val = '0';
        }
        return $val;
    }

    public static function CountStsRejected($id)
    {
        $val = '0';
        $year = date('Y');
        $value = ['REJECTED'];

        $model = TblRollcall::find()->where(['anggota_icno' => $id])->andWhere(['year' => $year])
            ->andWhere(['IN', 'status', $value])
            ->count();
        if ($model) {
            $val = $model;
        } else {
            $val = '0';
        }
        return $val;
    }
    public static function CountHadir($tahun, $bulan, $type, $icno, $key, $value)
    {
        // var_dump($bulan, $type, $icno, $key, $value);die;
        $val = '0';
        $cyear = date("Y");

        if ($tahun != $cyear) {
            $year = $tahun;
        } else {
            $year = $cyear;
        }
        $var = self::DaysInYearMonth($year, $bulan, 'Y-m-d');
        if ($value == "STS") {
            $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];
        } else {
            $value = $value;
        }
        $model = TblRollcall::findOne(['anggota_icno' => $icno]);

        if ($model && $value == "STS") {
            $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];

            foreach ($var as $v) {
                $check = (new \yii\db\Query())
                    ->from('keselamatan.tbl_rollcall')
                    ->where(['anggota_icno' => $icno])
                    // ->andWhere(['month' => $bulan])
                    ->andWhere(['date' => $v])
                    ->andWhere(['type' => $type])
                    ->andWhere(['IN', $key, $value])
                    ->exists();
                if ($check) {
                    $val = $val + 1;
                } else {
                    $val = $val + 0;
                }
            }
        } else {
            foreach ($var as $v) {
                $check = (new \yii\db\Query())
                    ->from('keselamatan.tbl_rollcall')
                    ->where(['anggota_icno' => $icno])
                    // ->andWhere(['month' => $bulan])
                    ->andWhere(['date' => $v])
                    ->andWhere(['type' => $type])
                    ->andWhere([$key => $value])
                    ->exists();
                if ($check) {
                    $val = $val + 1;
                } else {
                    $val = $val + 0;
                }
            }
        }
        // foreach($model as $k)
        // {


        // $timestamp = strtotime($k->date);

        // $day = date('m', $timestamp);

        // if($day == $bulan){
        //     $val = $val+ 1;

        // }

        // }
        // var_dump($val);
        // die;
        // if ($model) {

        //     $val = (new \yii\db\Query())
        //         ->from('keselamatan.tbl_rollcall')
        //         ->where(['anggota_icno' => $icno])
        //         ->andWhere(['month' => $bulan])
        //         // ->andWhere(['date' => $model->date])
        //         ->andWhere(['type' => $type])
        //         ->andWhere([$key => $value])
        //         ->count();
        // }
        // var_dump($model->date);die;
        return $val;
    }

    public static function CountHadirYearly($month, $year, $yearend, $type, $icno, $key, $value)
    {
        // var_dump($yearend);die;
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        // ->where(['between', 'date', $dateS, $dateE])
        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $dateEnd = DateTime::createFromFormat("Y-n", "$yearend-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";
        // var_dump($end,$mula);die;
        $val = '0';
        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'type' => $type]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();

            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $mula, $end])
                ->andWhere(['year' => $year])
                ->andWhere(['type' => $type])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere([$key => $value])
                ->count();
        }
        return $val;
    }

    public static function CountCutiRehat($icno, $month, $year)
    {

        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";
        $val = TblRecords::getIncrement($icno, $mula, $end);

        if ($val == NULL) {
            return $val = '0';
        } else {
            return $val;
        }
    }

    public static function countCSakit1($icno, $month, $year)
    {

        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";
        $command = Yii::$app->db->createCommand("SELECT SUM(tempoh) FROM hrm.cuti_tbl_records a
                                                WHERE a.status != 'REJECTED'
                                                AND a.start_date BETWEEN :mula AND :tamat
                                                AND a.jenis_cuti_id = 20
                                                AND a.icno = :icno")
            ->bindValue(':icno', $icno)
            ->bindValue(':mula', $mula)
            ->bindValue(':tamat', $end);

        if ($command) {
            $val = $command->queryScalar();
        }
        if ($val == NULL) {
            return $val = '0';
        } else {
            return $val;
        }
    }

    public static function countGanti($icno, $month, $year)
    {
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";
        $command = Yii::$app->db->createCommand("SELECT SUM(tempoh) FROM hrm.cuti_tbl_records a
        WHERE a.status != 'REJECTED'
        AND a.start_date BETWEEN :mula AND :tamat
        AND a.jenis_cuti_id = 4
        AND a.icno = :icno")
            ->bindValue(':icno', $icno)
            ->bindValue(':mula', $mula)
            ->bindValue(':tamat', $end);

        if ($command) {
            $val = $command->queryScalar();
        }
        if ($val == NULL) {
            return $val = '0';
        } else {
            return $val;
        }
    }

    public static function totalCGanti($icno, $mula, $tamat)
    {

        $command = Yii::$app->db->createCommand("SELECT SUM(tempoh) FROM hrm.cuti_tbl_records a
        WHERE a.status != 'REJECTED'
        AND a.start_date BETWEEN :mula AND :tamat
        AND a.jenis_cuti_id = 4
        AND a.icno = :icno")
            ->bindValue(':icno', $icno)
            ->bindValue(':mula', $mula)
            ->bindValue(':tamat', $tamat);

        if ($command) {
            $val = $command->queryScalar();
        }
        if ($val == NULL) {
            return $val = '0';
        } else {
            return $val;
        }
    }

    public static function totalCSakit1($icno, $mula, $tamat)
    {

        $command = Yii::$app->db->createCommand("SELECT SUM(tempoh) FROM hrm.cuti_tbl_records a
        WHERE a.status != 'REJECTED'
        AND a.start_date BETWEEN :mula AND :tamat
        AND a.jenis_cuti_id = 20
        AND a.icno = :icno")
            ->bindValue(':icno', $icno)
            ->bindValue(':mula', $mula)
            ->bindValue(':tamat', $tamat);

        if ($command) {
            $val = $command->queryScalar();
        }
        if ($val == NULL) {
            return $val = '0';
        } else {
            return $val;
        }
    }

    public static function CountCtr($id, $month, $year)
    {
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $val = '0';

        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";
        $model = TblRollcall::findOne(['anggota_icno' => $id]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();

            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $mula, $end])
                ->andWhere(['year' => $year])
                ->andWhere(['anggota_icno' => $id])
                ->andWhere(['CTR' => 1])
                ->count();
        }
        return $val;
    }
    public static function CountCgka($id, $month, $year)
    {
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $val = '0';

        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";
        $model = TblRollcall::findOne(['anggota_icno' => $id]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();

            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_shift_keselamatan')
                ->where(['between', 'date', $mula, $end])
                ->andWhere(['year' => $year])
                ->andWhere(['anggota_icno' => $id])
                ->andWhere(['CTR' => 1])
                ->count();
        }
        return $val;
    }
    public static function CountHadirYearlySpecific($month, $year, $type, $icno, $key, $value)
    {
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $val = '0';
        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'type' => $type]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();

            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['month' => $mth])
                ->andWhere(['year' => $year])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere([$key => $value])
                ->count();
        }
        return $val;
    }

    public static function CountTotal($dateS, $dateE, $icno, $key, $value, $type)
    {
        // var_dump($dateS, $dateE, $icno, $key, $value);die;
        $val = '0';
        $model = TblRollcall::findOne(['anggota_icno' => $icno]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();


            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $dateS, $dateE])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere([$key => $value])
                ->andWhere(['type' => $type])
                ->count();
        }
        // var_dump($key);die;
        return $val;
    }
    public static function CountTotalCT($dateS, $dateE, $icno, $key, $value)
    {
        // var_dump($dateS, $dateE, $icno, $key, $value);die;
        $val = '0';
        $model = TblRollcall::findOne(['anggota_icno' => $icno]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();


            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $dateS, $dateE])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere([$key => $value])
                // ->andWhere(['type' => $type])
                ->count();
        }
        // var_dump($key);die;
        return $val;
    }
    public static function CountTotalTHTC($dateS, $dateE, $icno, $key, $value)
    {
        // var_dump($dateS, $dateE, $icno, $key, $value);die;
        $val = '0';
        $model = TblRollcall::findOne(['anggota_icno' => $icno]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();


            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $dateS, $dateE])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere([$key => $value])
                // ->andWhere(['type' => $type])
                ->count();
        }
        // var_dump($key);die;
        return $val;
    }
    public static function CountTotalSts($id, $dateS, $dateE)
    {
        $val = '0';
        // $year = date('Y');
        // $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];

        $model = TblRollcall::find()->where(['anggota_icno' => $id])->one();
        if ($model) {
            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $dateS, $dateE])
                ->andWhere(['anggota_icno' => $id])
                ->andWhere(['IN', 'status', $value])
                ->count();
        }
        return $val;
    }
    public static function CountStartYearlySts($month, $year, $icno)
    {
        // var_dump($month, $year,$icno);die;
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $val = '0';

        $date = DateTime::createFromFormat("Y-n", "$year-$mth");
        $day = $date->format("t");
        $mula = "$year-$mth-01";
        $end = "$year-$mth-$day";

        $model = TblRollcall::findOne(['anggota_icno' => $icno]);
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();

            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['between', 'date', $mula, $end])
                ->andWhere(['year' => $year])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere(['IN', 'status', $value])
                ->count();
        }
        return $val;
    }

    public static function Catatan($icno, $tarikh)
    {
        $val = '-';
        $val1 = '';
        $val2 = '';

        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'H']);
        $model1 = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'LMJ']);
        $model2 = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'LMT']);

        if ($model) {

            $val = $model->catatan;
        }
        if ($model1) {

            $val1 = $model1->catatan;
        }
        if ($model2) {

            $val2 = $model2->catatan;
        }

        return '<span>' . $val . '</span>' . '<br>' .
            ' <span>' . $val1 . '</span> ' .
            ' <span>' . $val2 . '</span> ';
    }

    /**
     * untuk dapatkan semua status in,out,absent, external
     * 
     * @return string
     */
    public function getStatusAll()
    {

        $absent = '';
        $incomplete = '';
        $external = '';

        if ($this->absent == '1') {
            $absent = 'ABSENT';
        }

        if ($this->incomplete == '1') {
            $incomplete = 'INCOMPLETE';
        }

        if ($this->external == '1') {
            $external = 'EXTERNAL';
        }

        return '<span class="label label-danger">' . $this->status_in . '</span> <span class="label label-danger">' . $this->status_out . '</span> <span class="label label-danger">' . $absent . '</span>' . '</span> <span class="label label-danger">' . $incomplete . '</span> <span class="label label-danger">' . $external . '</span>';
    }

    public static function totalHour($from, $to)
    {

        $differenceFormat = '%h:%i';

        $datetime1 = date_create($from);
        $datetime2 = date_create($to);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    public function getMapBtnIn()
    {

        if ($this->in_lat_lng) {
            //            var_dump($this->in_lat_lng);die;
            return Html::button('Masuk', ['value' => Url::to("index.php?r=kehadiran/show_map&latlng=$this->in_lat_lng"), 'class' => 'mapBtn btn btn-sm btn-success', 'id' => 'modalButton']);
        }

        return '-';
    }

    public function getMapBtnOut()
    {
        if ($this->out_lat_lng) {
            return Html::button('Keluar', ['value' => Url::to("index.php?r=kehadiran/show_map&latlng=$this->out_lat_lng"), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']);
        }
        return '-';
    }

    public function getFormatTarikh()
    {

        return $this->changeDateFormat($this->tarikh);
    }

    public function getFormatDate()
    {

        return $this->changeDateFormat($this->date);
    }

    public function ipType($ip, $latlng)
    {
        $check = '';
        //        var_dump('r');die;
        //        $pre = substr($ip, 0, 2);
        //        if ($pre == '10' && $ip != NULL) {
        //            $check = '<i style="background-color:green; color:white;">Internal</i>';
        //        } else if ($pre != '10.' && $ip != NULL) {
        //            $check = '<i style="background-color:red; color:white;">External</i>';
        //        } else {
        //            $check = '';
        //        }
        if ($ip) {
            if (self::checkIp($ip) === '1') {
                if (!TblLocation::CheckZone($latlng)) {
                    $check = '<i style="background-color:red; color:white;">External</i>';
                } else {
                    $check = '<i style="background-color:green; color:white;">Internal</i>';
                }
            } else {
                $check = '<i style="background-color:green; color:white;">Internal</i>';
            }
        }


        return $check;
    }

    public static function totalPendingReason($icno, $numberOnly = false, $isRaw = false)
    {

        $total = 0;

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND (status_in IS NOT NULL OR status_out IS NOT NULL OR incomplete = 1 OR absent = 1 OR external = 1) AND remark_status IS NULL ';
        $model = TblRekod::findBySql($sql, [':icno' => $icno])->all();

        if ($model) {
            $total = count($model);
        }

        if ($total > 0) {
            if ($numberOnly) {
                return $total;
            } else {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        } else {
            if ($numberOnly) {
                return 0;
            } else {
                return '';
            }
        }
    }

    //if number only is true, return number only
    public static function totalPendingKetidakpatuhan($icno, $numberOnly = false, $isRaw = false)
    {
        $total = 0;
        $model = TblRekod::findAll(['app_by' => $icno, 'remark_status' => 'ENTRY']);

        if ($isRaw) {
            return $model;
        }

        if ($model) {
            $total = count($model);
        }

        if ($total > 0) {
            if ($numberOnly) {
                return $total;
            } else {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        } else {
            if ($numberOnly) {
                return 0;
            } else {
                return '';
            }
        }
    }

    public static function totalPendingWbb($icno, $numberOnly = false, $isRaw = false)
    {
        $total = 0;
        $total_ver = 0;
        $total_app = 0;

        $ver = TblWp::findAll(['ver_by' => $icno, 'status' => 'ENTRY']);
        $app = TblWp::findAll(['app_by' => $icno, 'status' => 'VERIFIED']);

        if ($ver) {
            $total_ver = count($ver);
        }

        if ($app) {
            $total_app = count($app);
        }

        $total = $total_ver + $total_app;

        if ($total > 0) {
            if ($numberOnly) {
                return $total;
            } else {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        } else {
            if ($numberOnly) {
                return 0;
            } else {
                return '';
            }
        }
    }

    public static function totalPendingAll($icno)
    {
        $wbb = self::totalPendingWbb($icno, true);
        $ketidakpatuhan = self::totalPendingKetidakpatuhan($icno, true);
        $reason = self::totalPendingReason($icno, true);

        $total = $wbb + $ketidakpatuhan + $reason;

        return $total;
    }

    //utk return jenis ip 1 = external | 0 = internal
    public static function checkIp($ip)
    {

        $v = '0';

        $pre = substr($ip, 0, 2);

        if ($pre != '10') {
            $v = '1';
        }

        return $v;
    }

    /**
     * 
     * @param type $icno icno 
     * @param type $date
     * @param type $type 1 = in , 2 out, 3 ot in, 4, ot out
     */
    public static function DisplayTime($icno, $tarikh, $type)
    {

        $val = '-';

        if ($icno && $tarikh) {
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        }

        if ($model) {

            if ($type == 1) {
                //                $val = $model->formatTimeIn . '<br>' . $model->ipType($model->in_ip, $model->in_lat_lng);
                $val = $model->formatTimeIn;
            }

            if ($type == 2) {
                //                $val = $model->formatTimeOut . '<br>' . $model->ipType($model->out_ip, $model->out_lat_lng);
                $val = $model->formatTimeOut;
            }

            if ($type == 5) {
                $val = $model->statusAll;
            }
        }

        return $val;
    }

    //utk dapatkan raw incomplicae sts
    public static function IncStatus($icno, $tarikh)
    {

        $val = '-';
        $in = '';
        $out = '';
        $incomplete = '';
        $absent = '';
        $external = '';

        if ($icno && $tarikh) {
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        }

        if ($model) {

            if ($model->status_in) {
                $in = 'LATE_IN';
            }

            if ($model->status_out) {
                $out = 'EARLY_OUT';
            }

            if ($model->incomplete == 1) {
                $incomplete = 'INCOMPLETE';
            }

            if ($model->absent == 1) {
                $absent = 'ABSENT';
            }

            if ($model->external == 1) {
                $external = 'EXTERNAL';
            }

            $val = $in . ' ' . $out . ' ' . $incomplete . ' ' . $absent . ' ' . $external;
        }

        return $val;
    }

    public static function TotalWorkingPerMonth($month, $year)
    {

        $val = 0;

        //        $year = date('Y');

        $sql_cuti_umum = 'SELECT * FROM e_cuti.cuti_umum WHERE MONTH(tarikh_cuti) =:month AND YEAR(tarikh_cuti) =:year';
        $cuti_umum = CutiUmum::findBySql($sql_cuti_umum, [':year' => $year, 'month' => $month])->All();

        foreach ($cuti_umum as $umum) {
            if (TblRekod::DisplayDay($umum->tarikh_cuti) == 'Sat' || TblRekod::DisplayDay($umum->tarikh_cuti) == 'Sun') {
                $val++;
            }
        }

        $working_day = 0;
        foreach (TblRekod::dayInMonth($month, $year) as $k => $v) {
            if ($v != 'Sat' && $v != 'Sun') {
                $working_day++;
            }
        }

        $jum_cuti_umum = count($cuti_umum) - $val;

        $total = $working_day - $jum_cuti_umum;


        return $total;
    }

    public function dayInMonth($month, $year)
    {

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $list[] = date('D', $i);
        }

        return $list;
    }

    public function number_of_working_days($from, $to)
    {
        $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
        $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

        $from = new DateTime($from);
        $to = new DateTime($to);
        $to->modify('+1 day');
        $interval = new DateInterval('P1D');
        $periods = new DatePeriod($from, $interval, $to);

        $days = 0;
        foreach ($periods as $period) {
            if (!in_array($period->format('N'), $workingDays))
                continue;
            if (in_array($period->format('Y-m-d'), $holidayDays))
                continue;
            if (in_array($period->format('*-m-d'), $holidayDays))
                continue;
            $days++;
        }
        return $days;
    }

    //yg ni function utk return html format ... klu ubah function displaycutiRaw mesti ubah yg ni juga ok
    public static function DisplayCuti($icno, $tarikh)
    {

        $val = '-';

        // Ni untuk check cuti umum

        $cuti_umum = CutiUmum::find()->where(['tarikh_cuti' => $tarikh])->asArray()->one();
        //ni utk keselamatan pnya cuti
        $cuti_rehat = TblShiftKeselamatan::find()->where(['icno' => $icno])->andWhere(['shift_id' => 7])->asArray()
            ->andWhere(['tarikh' => $tarikh])->all();
        //        var_dump($cuti_rehat);die;
        // returns all inactive customers
        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
        //        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN OutstationDateTimeStart AND OutstationDateTimeEnd';
        //        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();
        // returns all inactive customers
        $sql = 'SELECT * FROM e_cuti.cuti_rekod WHERE cuti_icno=:icno AND :tarikh BETWEEN cuti_mula AND cuti_tamat';
        $model = CutiRekod::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();
        //        var_dump($model);die;
        //        if ($outstation) {
        //            $val = '<p style="font-size:8pt; padding:0; background-color: yellow" class="text-center">' . $outstation['Name'] . '</p>';
        //        }

        if ($model) {
            $val = '<span class="label label-primary">' . $model->jenis->jenis_cuti_nama . '</span>';
        }

        if ($cuti_umum) {
            $val = '<span class="label label-warning">' . $cuti_umum['nama_cuti'] . '</span>';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sat') {
            $val = '<span class="label label-success">' . 'Weekend' . '</span>';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sun') {
            $val = '<span class="label label-success">' . 'Weekend' . '</span>';
        }
        if ($cuti_rehat) {
            $val = '<span class="label label-success">' . 'Cuti Rehat' . '</span>';
        }

        return $val;
        //        var_dump($val);die;
    }

    //yg ni function utk return text sahaja... klu ubah function displaycuti mesti ubah yg ni juga ok
    public static function DisplayCutiRaw($icno, $tarikh)
    {

        $val = '-';

        // Ni untuk check cuti umum

        $cuti_umum = CutiUmum::find()->where(['tarikh_cuti' => $tarikh])->asArray()->one();

        // returns all inactive customers
        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
        //        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN OutstationDateTimeStart AND OutstationDateTimeEnd';
        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        // returns all inactive customers
        $sql = 'SELECT * FROM e_cuti.cuti_rekod WHERE cuti_icno=:icno AND :tarikh BETWEEN cuti_mula AND cuti_tamat';
        $model = CutiRekod::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();


        if ($outstation) {
            $val = $outstation['Name'];
        }

        if ($model) {
            $val = $model->jenis->jenis_cuti_nama;
        }

        if ($cuti_umum) {
            $val = $cuti_umum['nama_cuti'];
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sat') {
            $val = 'Weekend';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sun') {
            $val = 'Weekend';
        }

        return $val;
    }

    public function checkAbsent($icno, $tarikh)
    {

        $v = FALSE;
        $cuti_rehat = TblShiftKeselamatan::find()->where(['icno' => $icno])->andWhere(['shift_id' => 7])->asArray()
            ->andWhere(['tarikh' => $tarikh])->all();
        //-------------------Check Cuti Umum---------------------//
        $cuti_umum = CutiUmum::findOne(['tarikh_cuti' => $tarikh]);

        if ($cuti_rehat) {
            $v = TRUE;
        }
        if ($cuti_umum) {
            $v = TRUE;
        }
        //-------------------Check Cuti Umum---------------------//
        //-------------------Check Outstation---------------------//
        //        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
        //        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->one();
        ////
        //        if ($outstation) {
        //            $v = TRUE;
        //        }
        //-------------------Check Outstation---------------------//
        //-------------------Check Cuti---------------------//
        $sql = 'SELECT * FROM e_cuti.cuti_rekod WHERE cuti_icno=:icno AND :tarikh BETWEEN cuti_mula AND cuti_tamat';
        $model = CutiRekod::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();

        if ($model) {
            $v = TRUE;
        }

        //-------------------Check Cuti---------------------//
        //-------------------Check RESTDAY------------------//
        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
        if ($staff) {
            $shift = TblShiftKeselamatan::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->one();
            //            var_dump($shift->shift_id);die;
            //klu wp id = REST day ID = 34
            if ($shift->shift_id == 7) {
                $v = TRUE;
            }
        }
        //-------------------Check RESTDAY------------------//


        return $v;
    }

    /**
     * 
     * @param date $tarikh date
     * @param char $format default null, 'l' for full day format
     * @return char return Day of the date
     */
    public static function DisplayDay($tarikh, $format = null)
    {

        $timestamp = strtotime($tarikh);

        $day = date('D', $timestamp);

        if ($format) {
            $day = date($format, $timestamp);
        }

        return $day;
    }

    public static function DisplayLoc($icno, $tarikh)
    {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);



        if ($model) {

            $val = $model->in_lat_lng ? '<a href="https://www.google.com/maps/@' . $model->in_lat_lng . ',16z" target="_blank" class="btn-primary btn-sm">IN</a>' : '';
            $val .= '&nbsp;';
            $val .= $model->out_lat_lng ? '<a href="https://www.google.com/maps/@' . $model->out_lat_lng . ',16z" target="_blank" class="btn-primary btn-sm">OUT</a>' : '';
        }

        return $val;
    }

    public static function DisplayLocIn($icno, $tarikh)
    {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->in_lat_lng ? $model->in_lat_lng : '-';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function DisplayLocOut($icno, $tarikh)
    {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->out_lat_lng ? $model->out_lat_lng : '-';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function IdByDate($icno, $tarikh)
    {
        $val = NULL;

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->id;
        }

        return $val;
    }

    public static function DisplayHours($icno, $tarikh)
    {

        $val = '-';

        // returns all inactive customers
        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND tarikh=:tarikh AND time_in IS NOT NULL AND time_out IS NOT NULL';
        $model = TblRekod::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {

            $in = $model['time_in'];
            $out = $model['time_out'];
            $val = self::totalHour($in, $out);
        }

        return $val;
    }

    public function getShiftRollcall()
    {
        return $this->hasOne(RefShifts::className(), ['jenis_shifts' => 'syif']);
    }

    public static function DisplayHakiki($icno, $tarikh)
    {
        $val = '-';

        $model = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => $tarikh,]);
        // $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'H']);

        if ($model) {

            $shift = RefShifts::findOne(['id' => $model->shift_id]);
            if ($shift->jenis_shifts === null) {
                $val = '-';
            } else {

                $val = $shift->jenis_shifts;
            }
        }

        return $val;
    }

    public static function StatusHakiki($icno, $tarikh)
    {
        $val = '-';

        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'H']);

        if ($model) {

            if ($model->THTC == 1) {
                $val1 = 'THTC';
                $val = '<span class="label label-danger">' . $val1 . '</span>';
            } elseif ($model->CTR == 1) {
                $val = 'CTR';
            } elseif ($model->CS == 1) {
                $val = 'CS';
            } elseif ($model->CG == 1) {
                $val = 'CG';
            } elseif ($model->CGKA == 1) {
                $val = 'CGKA';
            } elseif ($model->CKA == 1) {
                $val = 'CKA';
            } elseif ($model->CK == 1) {
                $val = 'CK';
            } elseif ($model->TLP == 1) {
                $val = 'TLP';
            } elseif ($model->HH == 1) {
                $val = 'H';
            } elseif ($model->HH == 0) {
                $val = 'THH';
            } else {
                $val = '-';
            }
        }

        return $val;
    }

    public static function DisplayLmj($icno, $tarikh)
    {
        $val = '-';

        $model = TblOt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        // $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'LMJ']);

        if ($model) {

            $shift = RefShifts::findOne(['id' => $model->shift_id]);
            if ($shift->jenis_shifts === null) {
                $val = '-';
            } else {

                $val = $shift->jenis_shifts;
            }
        }

        return $val;
    }

    public static function StatusLmj($icno, $tarikh)
    {
        $val = '-';

        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'LMJ']);

        if ($model) {

            if ($model->THTC == 1) {
                $val1 = 'THTC';
                $val = '<span class="label label-danger">' . $val1 . '</span>';
            } elseif ($model->CS == 1) {
                $val = 'CS';
            } elseif ($model->CTR == 1) {
                $val = 'CTR';
            } elseif ($model->CG == 1) {
                $val = 'CG';
            } elseif ($model->CGKA == 1) {
                $val = 'CGKA';
            } elseif ($model->CKA == 1) {
                $val = 'CKA';
            } elseif ($model->CK == 1) {
                $val = 'CK';
            } elseif ($model->TLP == 1) {
                $val = 'TLP';
            } elseif ($model->HLMJ == 1) {
                $val = 'H';
            } elseif ($model->HLMJ == 0) {
                $val = 'THLMJ';
            } else {
                $val = '-';
            }
        }

        return $val;
    }

    public static function DisplayLmt($icno, $tarikh)
    {
        $val = '-';

        $model = TblLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        // $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'LMT']);

        if ($model) {

            $shift = RefLmt::findOne(['id' => $model->lmt_id]);
            if ($shift->jenis_shifts === null) {
                $val = '-';
            } else {

                $val = $shift->jenis_shifts;
            }
        }

        return $val;
    }

    public static function StatusLmt($icno, $tarikh)
    {
        $val = '-';

        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'LMT']);

        if ($model) {


            if ($model->THTC == 1) {
                $val1 = 'THTC';
                $val = '<span class="label label-danger">' . $val1 . '</span>';
            } elseif ($model->CS == 1) {
                $val = 'CS';
            } elseif ($model->CG == 1) {
                $val = 'CG';
            } elseif ($model->CTR == 1) {
                $val = 'CTR';
            } elseif ($model->CGKA == 1) {
                $val = 'CGKA';
            } elseif ($model->CKA == 1) {
                $val = 'CKA';
            } elseif ($model->CK == 1) {
                $val = 'CK';
            } elseif ($model->TLP == 1) {
                $val = 'TLP';
            } elseif ($model->THBH == 0) {
                $val = 'H';
            } elseif ($model->THBLMT == 1) {
                $val = 'THBLMT';
            } else {
                $val = '-';
            }
        }

        return $val;
    }

    public static function StatusKawalan($icno, $tarikh)
    {
        $val = '-';

        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'KAWALAN']);

        if ($model) {

            if ($model->THTC == 1 && $model->THBKWLN == 1) {
                $val = 'THTC';
            } elseif ($model->THBKWLN == 1) {
                $val = 'THBKWLN';
            } elseif ($model->THBKWLN == 0) {
                $val = 'H';
            } else {
                $val = '-';
            }
        }

        return $val;
    }

    public static function DisplayKawalan($icno, $tarikh)
    {
        $val = '-';

        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'date' => $tarikh, 'type' => 'KAWALAN']);

        if ($model) {

            if ($model->syif === null) {
                $val = '-';
            } else {
                $val = $model->syif;
            }
        }

        return $val;
    }

    public static function DisplayShift($icno, $tarikh)
    {
        $val = '-';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        //        var_dump($model);
        if ($model) {
            //echo "x";die;
            if ($model->wp_id === null) {
                $val = '-';
            } else {
                $val = $model->shift->jenis_shifts;
            }
        }

        return $val;
    }

    /**
     * 
     * @param type $icno
     * @param type $month
     * @param type $type 1 = late_in, 2 = early_out, 3 = Incomplete, 4 = absent, 5 = external
     * @return type
     */
    public static function countReport($month, $type, $camp)
    {
        $report = "";
        if ($type == "THB") {
            $sql = 'SELECT * FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND (THBH = 1 OR THBLMJ = 1 OR THBLMT = 1 OR THBKWLN = 1)';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "THTC-H") {
            $sql = 'SELECT * FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND THTC = 1 AND type = "H"';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "THTC-LMJ") {
            $sql = 'SELECT * FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND THTC = 1 AND type = "LMJ"';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "LATE-IN") {

            $sql = 'SELECT * FROM keselamatan.tbl_rekod a 
            LEFT JOIN keselamatan.tbl_staff_keselamatan b ON b.staff_icno = a.icno
            WHERE MONTH(a.tarikh)=:mth 
            AND b.campus_id=:camp AND a.status_in = "LATE_IN"';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "EARLY-OUT") {

            $sql = 'SELECT * FROM keselamatan.tbl_rekod a 
            LEFT JOIN keselamatan.tbl_staff_keselamatan b ON b.staff_icno = a.icno
            WHERE MONTH(a.tarikh)=:mth 
            AND b.campus_id=:camp AND a.status_out = "EARLY_OUT"';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "STS DIKELUARKAN") {

            $sql = 'SELECT * FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp
            AND (status != "NO_STS")';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CR") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CR = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CS") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CS = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CTR") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CTR = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CGKA") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CGKA = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CKA") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CKA = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CG") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CG = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CSG") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CSG = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CTG") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CTG = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }
        if ($type == "CK") {
            $sql = 'SELECT DISTINCT anggota_icno,date FROM keselamatan.tbl_rollcall WHERE MONTH(date)=:mth AND campus_id=:camp AND CK = 1 ';
            $reports = TblRollcall::findBySql($sql, [':mth' => $month, ':camp' => $camp])->asArray()->all();
            $report = count($reports);
        }

        return $report;
    }
    public static function countKetidakpatuhan($icno, $month, $type)
    {

        $val = 0;

        if ($type == 1) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND status_in = "LATE_IN"';
        }

        if ($type == 2) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND status_out = "EARLY_OUT"';
        }

        if ($type == 3) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND incomplete = 1';
        }

        if ($type == 4) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND absent = 1';
        }

        if ($type == 5) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND external = 1';
        }

        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

        if ($model) {
            $val = count($model);
        }

        return $val;
    }

    public static function viewBulan($mth)
    {

        $nama_bulan = '';

        if ($mth == 1) {
            $nama_bulan = 'January';
        }
        if ($mth == 2) {
            $nama_bulan = 'February';
        }
        if ($mth == 3) {
            $nama_bulan = 'Mac';
        }
        if ($mth == 4) {
            $nama_bulan = 'April';
        }
        if ($mth == 5) {
            $nama_bulan = 'May';
        }
        if ($mth == 6) {
            $nama_bulan = 'June';
        }
        if ($mth == 7) {
            $nama_bulan = 'July';
        }
        if ($mth == 8) {
            $nama_bulan = 'August';
        }
        if ($mth == 9) {
            $nama_bulan = 'September';
        }
        if ($mth == 10) {
            $nama_bulan = 'October';
        }
        if ($mth == 11) {
            $nama_bulan = 'November';
        }
        if ($mth == 12) {
            $nama_bulan = 'December';
        }


        return $nama_bulan;
    }

    public static function TotalWorkingHours($icno, $month, $type = 1)
    {

        $times = array();
        $value = '';

        $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND time_in IS NOT NULL AND time_out IS NOT NULL';
        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

        if ($type == 1) {


            if ($model) {

                foreach ($model as $rekod) {
                    $times[] = $rekod->hoursMinutes;
                }
            }

            $value = TblRekod::instance()->SumTotalHours($times);
        }

        if ($type == 2) {
            $value = count($model);
        }

        return $value;
    }

    public function getHoursMinutes()
    {

        $differenceFormat = '%h:%i';

        $datetime1 = date_create($this->time_in);
        $datetime2 = date_create($this->time_out);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    /**
     * 
     * @param array $times
     * @return string
     */
    function SumTotalHours($times)
    {
        $minutes = 0;
        // loop throught all the times
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public static function RemarkStatus($icno, $tarikh)
    {

        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {


            if ($model['remark_status'] == 'ENTRY') {
                $val = '<font>[ &#10004; ]</font>';
            } else if ($model['remark_status'] == 'APPROVED') {
                $val = '<font color="white" style="background-color:green;">[ &#10004; ]</font>';
            } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['status_in'] !== null || $model['status_out'] !== null) {
                $val = '<font style="color:red">[ &#x2716; ]</font>';
            } else {
                $val = '-';
            }
        }


        return $val;
    }

    public static function RemarkStatusRaw($icno, $tarikh)
    {

        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {


            if ($model['remark_status'] == 'ENTRY') {
                $val = 1;
            } else if ($model['remark_status'] == 'APPROVED') {
                $val = 2;
            } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['status_in'] !== null || $model['status_out'] !== null) {
                $val = 3;
            } else {
                $val = '-';
            }
        }


        return $val;
    }

    public static function viewRemark($icno, $tarikh)
    {
        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {
            $val = $model['remark'];
        }

        return $val;
    }

    public function getStatusRemark()
    {

        if ($this->remark_status !== NULL) {

            if ($this->remark_status == 'ENTRY') {
                return 'MENUNGGU TINDAKAN';
            }

            if ($this->remark_status == 'APPROVED') {
                return 'DITERIMA';
            }

            if ($this->remark_status == 'REJECTED') {
                return 'ALASAN/CATATAN DITOLAK';
            }
        } else {
            return 'TIADA';
        }
    }

    /**
     * if return 1 ada kesalahan pada rekod/hari tersebut
     * klu 0 bersih x da kesalahan
     */
    public function getKetidakpatuhan()
    {
        if ($this->absent === '1' || $this->incomplete === '1' || $this->external === '1' || $this->status_in !== null || $this->status_out !== null) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 
     * @return 1 status remark tidak diterima atau status tiada tindakan daripada pegawai
     * klu 0 kesalah telah disucikan.
     */
    public function getXAmpun()
    {
        if ($this->getKetidakpatuhan() == 1 && ($this->remark_status == 'REJECTED' || $this->remark_status == 'ENTRY' || $this->remark_status === NULL)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function totalRejected($icno, $month)
    {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM tbl_rekod WHERE MONTH(tarikh)=:month AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL) AND (remark_status = "ENTRY" OR remark_status IS NULL OR remark_status = "REJECTED")';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function totalSalah($icno, $month)
    {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM tbl_rekod WHERE MONTH(tarikh)=:month AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL)';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function totalApproved($icno, $month)
    {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM tbl_rekod WHERE MONTH(tarikh)=:month AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL) AND remark_status = "APPROVED"';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function kadWarna($total, $color)
    {

        if ($color == 'YELLOW') {

            if ($total >= 3) {
                return 'GREEN';
            } else {
                return 'YELLOW';
            }
        }

        if ($color == 'GREEN') {

            if ($total >= 2 && $total < 3) {
                return 'GREEN';
            } elseif ($total >= 3) {
                return 'RED';
            } else {
                return 'YELLOW';
            }
        }

        if ($color == 'RED') {
            if ($total >= 1) {
                return 'RED';
            } else {
                return 'GREEN';
            }
        }
    }

    public static function checkToday($icno, $tarikh)
    {

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->one();

        if ($model) {
            return true;
        }

        return false;
    }

    public function getDisplayLink()
    {
        if (!empty($this->namafile && $this->namafile != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->namafile), Yii::$app->FileManager->DisplayFile($this->namafile));
        }
        return 'File not exist!';
    }
}
