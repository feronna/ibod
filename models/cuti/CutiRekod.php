<?php

namespace app\models\cuti;

use Yii;
use app\models\cuti\JenisCuti;

/**
 * This is the model class for table "e_cuti.cuti_rekod".
 *
 * @property string $cuti_rekod_id
 * @property string $cuti_icno
 * @property string $cuti_mula
 * @property string $cuti_tamat
 * @property string $cuti_catatan
 * @property string $cuti_tempoh
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
class CutiRekod extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'e_cuti.cuti_rekod';
        // return 'hrm.cuti.leave_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cuti_icno'], 'required'],
            [['cuti_mula', 'cuti_tamat', 'cuti_ganti_status_pada', 'cuti_mohon_pada', 'cuti_dok_peraku_pada', 'cuti_peraku_pada', 'cuti_lulus_pada', 'cuti_batal_pada'], 'safe'],
            [['cuti_tempoh', 'cuti_jenis_id', 'cuti_lampir_dok'], 'integer'],
            [['cuti_batal', 'cuti_destinasi'], 'string'],
            [['cuti_icno', 'cuti_session_id', 'cuti_ganti_oleh', 'cuti_dok_peraku_oleh', 'cuti_peraku_oleh', 'cuti_lulus_oleh', 'cuti_admin_oleh'], 'string', 'max' => 12],
            [['cuti_catatan', 'cuti_catatan_peraku', 'cuti_catatan_lulus'], 'string', 'max' => 200],
            [['cuti_session_ip'], 'string', 'max' => 30],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis() {
        return $this->hasOne(JenisCuti::className(), ['jenis_cuti_id' => 'cuti_jenis_id']);
    }

    public function getLayak() {
        return $this->hasOne(Layak::className(), ['layak_id' => 'cuti_rekod_id']);
    }

    public function getTarikh() {

        return $this->changeDateFormat($this->cuti_mula) . ' - ' . $this->changeDateFormat($this->cuti_tamat);
    }

    public function changeDateFormat($date) {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
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
            $val = 'Diperakukan';
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
        } else {
            $val = '-';
        }

        return $val;
    }

    /**
     * utk dptkan tota
     * 
     * @param type $icno
     * @param type $mula
     * @param type $tamat
     * @return type
     */
    public static function totalCuti($icno, $mula, $tamat) {

        $val = 0;

        $command = Yii::$app->db->createCommand("SELECT SUM(cuti_tempoh) FROM e_cuti.cuti_rekod a
                                                WHERE NOT a.cuti_status_lulus <=> 'TL'
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

    public static function totalCSakit1($icno, $tahun) {

        $val = 0;

        $command = Yii::$app->db->createCommand("SELECT SUM(cuti_tempoh) FROM e_cuti.cuti_rekod a
                                                WHERE a.cuti_status_lulus != 'TL'
                                                AND YEAR(a.cuti_mula) =:tahun
                                                AND a.cuti_jenis_id = 20
                                                AND a.cuti_icno = :icno")
                ->bindValue(':icno', $icno)
                ->bindValue(':tahun', $tahun);

        if ($command) {
            $val = $command->queryScalar();
        }

        return $val;
    }

    public static function totalCSakit2($icno, $tahun) {

        $val = 0;

        $command = Yii::$app->db->createCommand("SELECT SUM(cuti_tempoh) FROM e_cuti.cuti_rekod a
                                                WHERE a.cuti_status_lulus != 'TL'
                                                AND YEAR(a.cuti_mula) =:tahun
                                                AND a.cuti_jenis_id = 21
                                                AND a.cuti_icno = :icno")
                ->bindValue(':icno', $icno)
                ->bindValue(':tahun', $tahun);

        if ($command) {
            $val = $command->queryScalar();
        }

        return $val;
    }

    public static function kiraTempoh($startDate, $endDate, $campus_id) {
        // do strtotime calculations just once
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);


        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week)
                $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week)
                $no_remaining_days--;
        }
        else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)
            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            } else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0) {
            $workingDays += $no_remaining_days;
        }

//        $holidays = CHtml::listData(CutiUmum::model()->findAll(), 'id', 'tarikh_cuti'); #untuk convert pegi array
        $holidays = CutiUmum::find()->select(['id', 'tarikh_cuti', 'sabah_sahaja', 'wilayah_sahaja'])->where(['YEAR(tarikh_cuti)' => 2019])->asArray()->all();
        //We subtract the holidays
        foreach ($holidays as $value) {

            //check dlu selain labuan
            if ($value['sabah_sahaja'] == 1) {
                if ($campus_id == 2) {
                    $workingDays;
                } else {
                    $time_stamp = strtotime($value['tarikh_cuti']);
                    //If the holiday doesn't fall in weekend
                    if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7) {
                        $workingDays--;
                    }
                }

                //semua campus
            } else if ($value['wilayah_sahaja'] == 1) {
                if ($campus_id == 2) {
                   $time_stamp = strtotime($value['tarikh_cuti']);
                    //If the holiday doesn't fall in weekend
                    if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7) {
                        $workingDays--;
                    }
                } else {
                    $workingDays;
                }

                //semua campus
            } else {
                $time_stamp = strtotime($value['tarikh_cuti']);
                //If the holiday doesn't fall in weekend
                if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7) {
                    $workingDays--;
                }
            }
        }

        return round($workingDays);
    }

}
