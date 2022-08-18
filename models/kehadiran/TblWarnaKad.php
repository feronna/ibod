<?php

namespace app\models\kehadiran;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblRekod;

/**
 * This is the model class for table "attendance.tbl_warnakad".
 *
 * @property int $id
 * @property string $month_date generate setiap 1 haribulan
 * @property string $icno setiap bulan cuma ada 1 sahaja icno
 * @property string $color YELLOW = kuning , GREEN = hijau, RED = merah
 * @property int $ketidakpatuhan Jumlah Ketidakpatuhan
 * @property int $approved Jumlah Ketidakpatuhan yang diluluskan
 * @property int $disapproved Jumlah Ketidakpatuhan yang tidak diluluskan
 */
class TblWarnaKad extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_warnakad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_date', 'icno', 'color'], 'required'],
            [['month_date'], 'safe'],
            [['ketidakpatuhan', 'approved', 'disapproved'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['color'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month_date' => 'Month Date',
            'icno' => 'Icno',
            'color' => 'Card Color',
            'ketidakpatuhan' => 'Total Non-compliances',
            'approved' => 'Total Approved',
            'disapproved' => 'Total Disapproved',
            'month' => 'Month',
            'monthName' => 'Month',
        ];
    }

    /**
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getMonth()
    {
        $month = date("m", strtotime($this->month_date));

        return $month;
    }

    public function getMonthName()
    {
        $month = date("m", strtotime($this->month_date));

        $name = TblRekod::viewBulan($month);

        return $name;
    }



    /**
     * untuk check warna kad ikut icno dan bulan
     * 
     * 
     * @param type $icno
     */
    public static function WarnaKadSemasa($icno, $month, $type = NULL, $year)
    {

        $value = '';

        $sql = 'SELECT * FROM attendance.tbl_warnakad WHERE icno=:icno ORDER BY month_date DESC';
        $model = TblWarnaKad::findBySql($sql, [':icno' => $icno])->one();


        if ($model) {

            if ($type == NULL) {
                $value = $model->color;
            }

            if ($type == 1) {
                $value = $model->ketidakpatuhan;
            }
            if ($type == 2) {
                $value = $model->approved;
            }
            if ($type == 3) {
                $value = $model->disapproved;
            }
        }

        return strtolower($value);
    }

    public static function JumlahWarnaKad($tahun, $bulan, $color)
    {

        $sql = 'SELECT * FROM attendance.tbl_warnakad WHERE YEAR(month_date) =:tahun AND MONTH(month_date) =:bulan AND color=:color';
        $model = self::findBySql($sql, [':tahun' => $tahun, ':bulan' => $bulan, ':color' => $color])->all();

        if ($model) {
            return count($model);
        }

        return 0;
    }

    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }

    public static function warnaMonth($today, $year, $month)
    {

        $month_warna = $month;



        //klu bulan 1
        if ($month == 01) {
            $month_warna = 12;
        } elseif ($today == "$year-$month-01" || $today == "$year-$month-02" || $today == "$year-$month-03" || $today == "$year-$month-04" || $today == "$year-$month-05" || $today == "$year-$month-06" || $today == "$year-$month-07" || $today == "$year-$month-08" || $today == "$year-$month-09") {
            $month_warna = $month - 1;
        }


        return $month_warna;
    }

    public static function status($green, $red)
    {
        if ($red >= 1) {
            $status = "Sangat Tidak Memuaskan";
        } else if ($green >= 3) {
            return "Tidak Memuaskan";
        } else if ($green == 1 || $green == 2) {
            return "Memuaskan";
        } else {
            $status = "Cemerlang";
        }

        return $status;
    }

    /**
     * Prestasi warna kad mengikut tahun
     *
     * @param int $year
     * @param string $icno 
     *
     * @return string 'Cemerlang | Memuaskan | Tidak Memuaskan | Sangat Tidak Memuaskan'
     *
     */
    public static function prestasiWarnaKad($year, $icno)
    {

        $totalGreen = self::find()->where(['color' => 'GREEN', 'icno' => $icno, 'YEAR(month_date)' => $year])->count();
        $totalRed = self::find()->where(['color' => 'RED', 'icno' => $icno, 'YEAR(month_date)' => $year])->count();

        return self::status($totalGreen, $totalRed);
    }
    
        public static function status2($green, $red, $yellow) // Guna dalam sistem pengesahan
    {
        if ($red >= 1) {
            $status = "Sangat Tidak Memuaskan";
        } else if ($green >= 3) {
            return "Tidak Memuaskan";
        } else if ($green == 1 || $green == 2) {
            return "Memuaskan";
        } else if ($yellow == 0 && $red == 0 && $green == 0) {
            $status = "Tidak berkaitan";
        }else {
            $status = "Cemerlang";
        }

        return $status;
    }

    /**
     * Prestasi warna kad mengikut tahun
     *
     * @param int $year
     * @param string $icno 
     *
     * @return string 'Cemerlang | Memuaskan | Tidak Memuaskan | Sangat Tidak Memuaskan'
     *
     */
    public static function prestasiWarnaKad2($year, $icno) // Guna dalam sistem pengesahan
    {

        $totalGreen = self::find()->where(['color' => 'GREEN', 'icno' => $icno, 'YEAR(month_date)' => $year])->count();
        $totalRed = self::find()->where(['color' => 'RED', 'icno' => $icno, 'YEAR(month_date)' => $year])->count();
        $totalYellow = self::find()->where(['color' => 'YELLOW', 'icno' => $icno, 'YEAR(month_date)' => $year])->count();

        return self::status2($totalGreen, $totalRed, $totalYellow);
    }

    /**
     * Get total card color by year
     *
     * @param int $year
     * @param string $icno 
     * @param string color 'YELLOW' | 'GREEN' | 'RED'
     *
     * @return int $total
     *
     */
    public static function totalByCardColor($year, $icno, $color)
    {
        return self::find()->where(['color' => $color, 'icno' => $icno, 'YEAR(month_date)' => $year])->count();
    }
}
