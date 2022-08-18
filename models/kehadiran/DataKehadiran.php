<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "raw_data_kehadiran".
 *
 * @property string $nama
 * @property string $icno
 * @property string $jenis_wp
 * @property string $gred
 * @property string $jawatan
 * @property int $jwtn_id
 * @property string $dept
 * @property int $dept_id
 * @property string $tarikh
 * @property int $bulan
 * @property int $tahun
 * @property string $day
 * @property int $late_in
 * @property int $early_out
 * @property string $incomplete
 * @property string $absent 1 = kira absent | system generated
 * @property string $external 1 = external ip | 0 = internal ip
 * @property string $time_in
 * @property string $time_out
 * @property string $hours
 * @property string $remark_status ENTRY | APPROVED
 */
class DataKehadiran extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'attendance.raw_data_kehadiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['jwtn_id', 'dept_id', 'bulan', 'tahun', 'late_in', 'early_out'], 'integer'],
            [['tarikh'], 'safe'],
            [['nama', 'jawatan'], 'string', 'max' => 255],
            [['icno'], 'string', 'max' => 15],
            [['jenis_wp'], 'string', 'max' => 100],
            [['gred', 'day', 'remark_status'], 'string', 'max' => 10],
            [['dept'], 'string', 'max' => 300],
            [['incomplete', 'absent', 'external'], 'string', 'max' => 1],
            [['time_in', 'time_out'], 'string', 'max' => 8],
            [['hours'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'nama' => 'Nama',
            'icno' => 'Icno',
            'jenis_wp' => 'Jenis Wp',
            'gred' => 'Gred',
            'jawatan' => 'Jawatan',
            'jwtn_id' => 'Jwtn ID',
            'dept' => 'Dept',
            'dept_id' => 'Dept ID',
            'tarikh' => 'Tarikh',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'day' => 'Day',
            'late_in' => 'Late In',
            'early_out' => 'Early Out',
            'incomplete' => 'Incomplete',
            'absent' => 'Absent',
            'external' => 'External',
            'time_in' => 'Time In',
            'time_out' => 'Time Out',
            'hours' => 'Hours',
            'remark_status' => 'Remark Status',
        ];
    }

    public static function totalPersonalSalah($icno, $tahun, $bulan) {

        $late = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'late_in' => 1])->count();
        $early_out = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'early_out' => 1])->count();
        $incomplete = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'incomplete' => 1])->count();
        $absent = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'absent' => 1])->count();
        $external = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'external' => 1])->count();
        
        $count = $late+$early_out+$incomplete+$absent+$external;

        return (int) $count;
    }
    
    public static function totalIndividuLatein($icno, $tahun, $bulan) {

        $count = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'late_in' => 1])->count();

        return (int) $count;
    }
    
    public static function totalIndividuIncomplete($icno, $tahun, $bulan) {

        $count = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'incomplete' => 1])->count();

        return (int) $count;
    }
    
    public static function totalIndividuEarlyout($icno, $tahun, $bulan) {

        $count = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'early_out' => 1])->count();

        return (int) $count;
    }
    
    public static function totalIndividuAbsent($icno, $tahun, $bulan) {

        $count = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'absent' => 1])->count();

        return (int) $count;
    }
    
    public static function totalIndividuExternal($icno, $tahun, $bulan) {

        $count = self::find()->where(['icno' => $icno, 'tahun' => $tahun, 'bulan' => $bulan, 'external' => 1])->count();

        return (int) $count;
    }
    
    public static function totalLatein($dept_id, $tahun, $bulan) {


        $count = self::find()->where(['dept_id' => $dept_id, 'tahun' => $tahun, 'bulan' => $bulan, 'late_in' => 1])->count();

        return (int) $count;
    }

    public static function totalEarlyout($dept_id, $tahun, $bulan) {


        $count = self::find()->where(['dept_id' => $dept_id, 'tahun' => $tahun, 'bulan' => $bulan, 'early_out' => 1])->count();

        return (int) $count;
    }

    public static function totalIncomplete($dept_id, $tahun, $bulan) {


        $count = self::find()->where(['dept_id' => $dept_id, 'tahun' => $tahun, 'bulan' => $bulan, 'incomplete' => 1])->count();

        return (int) $count;
    }

    public static function totalAbsent($dept_id, $tahun, $bulan) {


        $count = self::find()->where(['dept_id' => $dept_id, 'tahun' => $tahun, 'bulan' => $bulan, 'absent' => 1])->count();

        return (int) $count;
    }

    public static function totalExternal($dept_id, $tahun, $bulan) {

        $count = self::find()->where(['dept_id' => $dept_id, 'tahun' => $tahun, 'bulan' => $bulan, 'external' => 1])->count();

        return (int) $count;
    }

}
