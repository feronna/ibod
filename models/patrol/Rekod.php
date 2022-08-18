<?php

namespace app\models\patrol;

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefShifts;
use app\models\keselamatan\TblLmt;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblShiftKeselamatan;
use DateTime;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "keselamatan.patrol_rekod".
 *
 * @property int $id
 * @property string $icno
 * @property int $route_id
 * @property int $bit_id
 * @property string $scan_date
 * @property string $lat
 * @property string $lng
 */
class Rekod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $latlng;

    public static function tableName()
    {
        return 'keselamatan.patrol_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_id', 'bit_id', 'shift', 'position', 'type', 'do'], 'integer'],
            [['scan_date'], 'safe'],
            [['latlng'], 'required', 'message' => 'Please allow your Location !'],
            [['latlng', 'catatan'], 'string'],
            [['icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'route_id' => 'Route ID',
            'bit_id' => 'Bit ID',
            'scan_date' => 'Scan Date',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

    public function getPeronda()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getRoute()
    {
        return $this->hasOne(RefPosKawalan::className(), ['id' => 'route_id']);
    }
    public function getBit()
    {
        return $this->hasOne(RefBit::className(), ['id' => 'bit_id']);
    }
    public static function bit($id)
    {
        $val = '';
        $model = self::find()->where(['id' => $id])->one();
        // var_dump($model)
        if ($model->type == 2) {
            $val = 'Mula Rondaan';
        } elseif ($model->type == 3) {
            $val = 'Tamat Rondaan';
        } else {
            $vals = RefBit::findOne(['id' => $model->bit_id]);
            $val = $vals->bit_name;
        }
        return $val;
    }

    public function getChange()
    {

        $dt = date_create($this->scan_date);

        $time = date_format($dt, "d-m-Y h:i A");

        return $time;
    }
    public static function countRondaan($icno, $pos, $date, $count = null)
    {

        $val = 0;
        $model = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => $count])->all();

        if (!$count) {
            $model = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->all();
        }
        if ($model) {
            $val = count($model);
        }

        return $val;
    }
    public static function pcount($icno, $pos, $date, $count)
    {

        $model = self::find()->where(['icno' => $icno])->andWhere(['LIKE', 'scan_date', $date])->orderBy([
            'scan_date' => SORT_DESC,
        ])->one();
        $val = "0";
        //   var_dump($model['patrol_count']);die;
        if ($model == NULL) {
            $val = "0";
        } else {
            if ($model['patrol_count'] == 4) {
                $c1 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 1])->andWhere(['type' => 1])->all();
                $c2 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 2])->andWhere(['type' => 1])->all();
                $c3 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 3])->andWhere(['type' => 1])->all();
                $c4 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 4])->andWhere(['type' => 1])->all();
                $val = '(R1) ' . count($c1) . ' , (R2) ' . count($c2) . ' , (R3) ' . count($c3) . ' , (R4) ' . count($c4);
            }
            if ($model['patrol_count'] == 3) {
                $c1 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 1])->andWhere(['type' => 1])->all();
                $c2 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 2])->andWhere(['type' => 1])->all();
                $c3 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 3])->andWhere(['type' => 1])->all();
                $val = '(R1) ' . count($c1) . ' , (R2) ' . count($c2) . ' , (R3) ' . count($c3);
            }
            if ($model['patrol_count'] == 2) {
                $c1 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 1])->andWhere(['type' => 1])->all();
                $c2 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 2])->andWhere(['type' => 1])->all();
                $val = '(R1) ' . count($c1) . ' , (R2) ' . count($c2);
            }
            if ($model['patrol_count'] == 1) {
                $c1 = self::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['patrol_count' => 1])->andWhere(['type' => 1])->all();
                $val = '(R1) ' . count($c1);
            }
        }
        return $val;
    }
    public static function staff($icno)
    {
        $val = "";
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        if ($model) {
            $val = ucwords(strtolower($model->CONm));
        }
        return $val;
    }
    public function getStatus()
    {
        if ($this->external == 1) {
            $val = '<span class="label label-warning">' . 'External' . '</span>';
        } else {
            $val = '<span class="label label-success">' . 'Internal' . '</span>';
        }
        return $val;
    }
    public static function DisplayLoc($id)
    {
        $val = '';

        $model = Rekod::findOne(['id' => $id]);


        if ($model) {

            $val = $model->in_lat_lng ? '<a href="https://www.google.com/maps/dir/' . $model->in_lat_lng . '/' . $model->in_lat_lng . '/@' . $model->in_lat_lng . ',18z" target="_blank" class="btn-primary btn-sm">IN</a>' : '';
        }

        return $val;
    }
    public static function bil($b)
    {
        $data = ['PERTAMA (2 jam)', 'KEDUA (2 jam)', 'KETIGA (2 jam)', 'KEEMPAT (2 jam)'];

        // if()
    }
    public static function displaytimedo($icno, $pos, $syif, $date)
    {
        // $date = date('Y-m-d');
        // var_dump($icno, $pos , $syif,$date);die;
        $val = "";

        $model = self::find()->where(['icno' => $icno, 'shift' => $syif, 'route_id' => $pos])->andWhere(['like', 'scan_date', $date])->one();
        if ($model) {
            $dt = date_create($model->scan_date);

            $val = date_format($dt, "h:i A");
        }
        return $val;
    }
    public static function displaytime($icno, $pos = null, $syif, $bit, $count, $date)
    {
        // $date = date('Y-m-d');
        $val = "";
        $counts = $count + 1;

        $model = self::find()->where(['icno' => $icno, 'shift' => $syif, 'position' => $bit, 'patrol_count' => $counts])->andWhere(['like', 'scan_date', $date])->one();
        if ($model) {
            $dt = date_create($model->scan_date);

            $val = date_format($dt, "h:i A");
        }
        return $val;
    }
    public static function display($icno, $pos, $syif, $count, $date, $type)
    {
        $val = "";
        $counts = $count + 1;

        $model = self::find()->where(['icno' => $icno, 'shift' => $syif, 'route_id' => $pos, 'patrol_count' => $counts])
            ->andWhere(['type' => $type])->andWhere(['like', 'scan_date', $date])->one();
        if ($model) {
            $dt = date_create($model->scan_date);

            $val = date_format($dt, "h:i A");
        }
        return $val;
    }
    public static function countpatroltime($icno, $pos, $syif, $count, $date)
    {
        $val = "";

        $counts = $count + 1;

        $start = self::find()->where(['icno' => $icno, 'shift' => $syif, 'route_id' => $pos, 'patrol_count' => $counts])
            ->andWhere(['type' => '2'])->andWhere(['like', 'scan_date', $date])->one();
        $end = self::find()->where(['icno' => $icno, 'shift' => $syif, 'route_id' => $pos, 'patrol_count' => $counts])
            ->andWhere(['type' => '3'])->andWhere(['like', 'scan_date', $date])->one();
        if ($start && $end) {

            $datetime1 = new DateTime($start->scan_date);
            $datetime2 = new DateTime($end->scan_date);

            $val = ($datetime1->diff($datetime2)->format('%h:%i'));
        }
        return $val;
    }

    public static function viewsyif($syif)
    {

        $model = RefShifts::findOne(['id' => $syif]);
        return $model->jenis_shifts;
    }
    public static function viewPos($pos)
    {

        $model = RefPosKawalan::findOne(['id' => $pos]);
        return $model->pos_kawalan;
    }
    public static function switch($icno, $date)
    {
        $data = ['3', '4', '5', '18', '19', '20', '23', '24'];

        $query1 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
    unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_shift_keselamatan')
            ->where(['tarikh' => $date])
            ->andWhere(['icno' => $icno])
            ->andWhere(['IN', 'shift_id', $data]);

        $query2 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
    unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_ot')
            ->where(['tarikh' => $date])
            ->andWhere(['icno' => $icno])
            ->andWhere(['IN', 'shift_id', $data]);


        $query3 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,lmt_id,
    unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_lmt')
            ->where(['tarikh' => $date])
            ->andWhere(['icno' => $icno])
            ->andWhere(['IN', 'lmt_id', $data]);

        // $query = TblShiftKeselamatan::find();
        $query = $query1->union($query2)->union($query3)->all();

        return $query;
    }
    public static function partner($icno, $date, $data, $pos)
    {

        $query1 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
    unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_shift_keselamatan')
            ->where(['tarikh' => $date])
            ->andWhere(['!=', 'icno', $icno])
            ->andWhere(['=', 'pos_kawalan_id', $pos])
            ->andWhere(['=', 'shift_id', $data]);

        $query2 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
    unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_ot')
            ->where(['tarikh' => $date])
            ->andWhere(['!=', 'icno', $icno])
            ->andWhere(['=', 'pos_kawalan_id', $pos])
            ->andWhere(['=', 'shift_id', $data]);


        $query3 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,lmt_id,
    unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_lmt')
            ->where(['tarikh' => $date])
            ->andWhere(['!=', 'icno', $icno])
            ->andWhere(['=', 'pos_kawalan_id', $pos])
            ->andWhere(['=', 'lmt_id', $data]);

        // $query = TblShiftKeselamatan::find();
        $query = $query1->union($query2)->union($query3)->all();

        return $query;
    }

    public static function kakitangan($icno)
    {

        $model = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        return $model->CONm;
    }

    public static function countpatrol($icno, $date, $shift)
    {
        $val = 0;
        $model = self::find()->where(['icno' => $icno])->andWhere(['shift' => $shift])->andWhere(['LIKE', 'scan_date', $date])->andWhere(['type' => 1])->all();
        $excused = TblExcused::find()->where(['icno' => $icno])->andWhere(['date' => $date])->andWhere(['shift_id' => $shift])->andWhere(['status' => 'APPROVED'])->one();
        if ($excused) {
            $val = 0;
        }

        if ($model) {
            $val = count($model);
        }

        return $val;
    }
    //accumalated
    public static function countpatrolmonthly($icno, $month)
    {
        $val = 0;
        $model = self::find()->where(['icno' => $icno])->andWhere(['=', 'MONTH(scan_date)', $month])->andWhere(['type' => 1])->all();
        if ($model) {
            $val = count($model);
        }
        return $val;
    }
    public static function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");
        // var_dump($year);die;
        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }

    public static function countpatrolmonthlyhakiki($icno, $month, $year)
    {
        if (self::months($month)) {
            $month =  self::months($month);
        }

        $val = 0;

        $var = self::getDaysInYearMonth($year, $month, 'Y-m-d');

        foreach ($var as $k => $v) {
            $shift = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => $v]);
            if ($shift) {

                $model = self::find()->where(['icno' => $icno])->andWhere(['LIKE', 'scan_date', $v])->andWhere(['type' => 1])->andWhere(['shift' => $shift->shift_id])->all();
                if ($model) {
                    $val += count($model);
                }
            }
        }

        return $val;
    }
    public static function countpatrolmonthlylmj($icno, $month, $year)
    {
        $val = 0;
        if (self::months($month)) {
            $month =  self::months($month);
        }

        $var = self::getDaysInYearMonth($year, $month, 'Y-m-d');

        foreach ($var as $k => $v) {
            $shift = TblOt::findOne(['icno' => $icno, 'tarikh' => $v]);
            if ($shift) {

                $model = self::find()->where(['icno' => $icno])->andWhere(['LIKE', 'scan_date', $v])->andWhere(['type' => 1])->andWhere(['shift' => $shift->shift_id])->all();
                if ($model) {
                    $val += count($model);
                }
            }
        }

        return $val;
    }
    public static function countpatrolmonthlylmt($icno, $month, $year)
    {
        $val = 0;
        if (self::months($month)) {
            $month =  self::months($month);
        }
        $var = self::getDaysInYearMonth($year, $month, 'Y-m-d');

        foreach ($var as $k => $v) {
            $shift = TblLmt::findOne(['icno' => $icno, 'tarikh' => $v]);
            if ($shift) {


                $model = self::find()->where(['icno' => $icno])->andWhere(['LIKE', 'scan_date', $v])->andWhere(['type' => 1])->andWhere(['shift' => $shift->lmt_id])->all();
                if ($model) {
                    $val += count($model);
                }
            }
        }

        return $val;
    }

    public static function patroltotalmonthly($icno, $var)
    {
        $val = 0;

        foreach ($var as $k => $v) {
            $pos = Rekod::pos($icno, $v);
            $syif = Rekod::getSyif($icno, $v);
            // var_dump($pos,$syif);die;
            $val += RefBit::patroltotal($pos, $syif, $icno, $v);
        }
        return $val;
    }
    public static function patroltotalmonthlyLmj($icno, $var)
    {
        $val = 0;

        foreach ($var as $k => $v) {
            $pos = Rekod::pos($icno, $v);
            $syif = Rekod::getSyifLmj($icno, $v);
            // var_dump($pos,$syif);die;
            $val += RefBit::patroltotal($pos, $syif, $icno, $v, "", 1);
        }
        return $val;
    }
    public static function patroltotalmonthlyLmt($icno, $var)
    {
        $val = 0;

        foreach ($var as $k => $v) {
            $pos = Rekod::pos($icno, $v);
            $syif = Rekod::getSyifLmt($icno, $v);
            // var_dump($pos,$syif);die;
            $val += RefBit::patroltotal($pos, $syif, $icno, $v, "", 1);
        }
        return $val;
    }

    public static function getSyif($icno, $tarikh)
    {
        $val = "";
        $model = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {
            $val = $model->shift_id;
        }
        return $val;
    }
    public static function getSyifLmj($icno, $tarikh)
    {
        $val = "";
        $model = TblOt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {
            $val = $model->shift_id;
        }
        return $val;
    }
    public static function getSyifLmt($icno, $tarikh)
    {
        $val = "";
        $model = TblLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {
            $val = $model->lmt_id;
        }
        return $val;
    }
    public static function pos($icno, $tarikh, $ind = null)
    {
        $val = "";
        if ($ind == 1) {
            $model = TblLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        } else
        if ($ind == 2) {
            $model = TblOt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        } else {
            $model = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        }

        if ($model) {
            $val = $model->pos_kawalan_id;
        }
        return $val;
    }
    public static function percent($val1, $val2)
    {
        // var_dump($val1,$val2);
        if ($val1 == 0 || $val2 == 0) {
            $val = 0;
        } else {
            $percent = (($val1 / $val2) * 100);
            $val = number_format((float)$percent, 2, '.', '');
        }

        return $val;
    }
    public static function percentDaily($icno, $v, $inc)
    {
        $val = 0;


        $pos = Rekod::pos($icno, $v, $inc);
        if ($inc == 1) {
            $syif = Rekod::getSyifLmt($icno, $v);

            $excused = TblExcused::find()->where(['icno' => $icno])->andWhere(['date' => $v])->andWhere(['shift_id' => $syif])->andWhere(['status' => 'APPROVED'])->one();
            $val1 = self::percent(Rekod::countpatrol($icno, $v, $syif), RefBit::patroltotal($pos, $syif, $icno, $v, "", 1));

            if ($excused) {
                $val1 = "100";
            }
        } else
            if ($inc == 2) {
            $syif = Rekod::getSyifLmj($icno, $v);
            $excused = TblExcused::find()->where(['icno' => $icno])->andWhere(['date' => $v])->andWhere(['shift_id' => $syif])->andWhere(['status' => 'APPROVED'])->one();
            $val1 = self::percent(Rekod::countpatrol($icno, $v, $syif), RefBit::patroltotal($pos, $syif, $icno, $v, "", 1));

            if ($excused) {
                $val1 = "100";
            }
        } else {
            // echo 'd';die;
            $syif = Rekod::getSyif($icno, $v);
            $excused = TblExcused::find()->where(['icno' => $icno])->andWhere(['date' => $v])->andWhere(['shift_id' => $syif])->andWhere(['status' => 'APPROVED'])->one();
            $val1 = self::percent(Rekod::countpatrol($icno, $v, $syif), RefBit::patroltotal($pos, $syif, $icno, $v, TblRekod::DisplayCuti($icno, $v)));

            if ($excused) {
                $val1 = "100";
            }
        }
        // $val1 = Rekod::countpatrol($icno, $v, Rekod::getSyif($icno, $v)) / RefBit::patroltotal($pos, $syif, $icno, $v);
        $val = $val1;
        // var_dump($val);die;
        if ($val > 100) {
            $val = "100";
        }
        if ($val < 0) {
            $val = "0";
        }

        // echo $val;
        return $val;
    }
    public static function percents($icno, $var, $inc, $year = null)
    {
        $val = 0;

        $val2 = 0;

        if (self::months($var)) {
            // echo 'd';die;
            $mth =  self::months($var);
            $var = self::getDaysInYearMonth($year, $mth, 'Y-m-d');
        }  

        foreach ($var as $k => $v) {

            $val1 = self::percentDaily($icno, $v, $inc);
            $val += $val1;
            $cuti = TblRekod::DisplayCuti($icno, $v);

            if ($inc != 3) {
                $val3 = self::countdays($icno, $v, $inc);
                // var_dump($val3);die;
                $val2 = $val2 + $val3;
            } else {
                if ($cuti == "") {
                    $val2 = $val2 + 1;
                }
            }
        }
        // var_dump($val1);
        if ($val2 == 0) {
            $val = 0;
        } else {
            $val = $val / $val2;
        }
        return $val;
    }
    public static function countdays($icno, $date, $inc)
    {
        // var_dump($icno, $date, $inc);die;
        $data = ['3', '4', '5', '18', '19', '20', '23', '24'];
        $val = false;
        if ($inc == 2) {
            // $syif = Rekod::getSyifLmt($icno, $date);
            $val = TblOt::find()->where(['icno' => $icno, 'tarikh' => $date])->andWhere(['IN', 'shift_id', $data])->count();
        } else {
            // $syif = Rekod::getSyifLmj($icno, $date);
            $val = TblLmt::find()->where(['icno' => $icno, 'tarikh' => $date])->andWhere(['IN', 'lmt_id', $data])->count();
        }
        return $val;
    }
    public static function months($m)
    {
        $v = '';
        if ($m == 'Januari') {
            $v = '01';
        }
        if ($m == 'Februari') {
            $v = '02';
        }
        if ($m == 'Mac') {
            $v = '03';
        }
        if ($m == 'April') {
            $v = '04';
        }
        if ($m == 'Mei') {
            $v = '05';
        }
        if ($m == 'Jun') {
            $v = '06';
        }
        if ($m == 'Julai') {
            $v = '07';
        }
        if ($m == 'Ogos') {
            $v = '08';
        }
        if ($m == 'September') {
            $v = '09';
        }
        if ($m == 'Oktober') {
            $v = '10';
        }
        if ($m == 'November') {
            $v = '11';
        }
        if ($m == 'Disember') {
            $v = '12';
        }
        return $v;
    }

    public static function rating($percent)
    {
        // var_dump($percent);die;
        if ($percent == 0) {
            $val = '0';
        } else
        if (($percent >= 0) && ($percent < 20)) {
            $val = '1';
        } else
        if (($percent >= 20) && ($percent < 40)) {
            $val = '2';
        } else
        if (($percent >= 40) && ($percent < 70)) {
            $val = '3';
        } else
        if (($percent >= 70) && ($percent < 89)) {
            $val = '4';
        } else {
            $val = '5';
        }
        return $val;
    }
}
