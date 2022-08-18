<?php

namespace app\models\keselamatan;
use app\models\hronline\Tblprcobiodata;
use DateTime;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_tindakan_bertulis_lisan".
 *
 * @property int $id
 * @property int $t_bertulis
 * @property int $t_lisan
 * @property string $date
 * @property string $receiver_icno
 * @property string $sender_icno
 */
class TblTindakanBertulisLisan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_tindakan_bertulis_lisan';
    }
    public $tahun;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_bertulis', 't_lisan'], 'integer'],
            [['date','tahun'], 'safe'],
            [['receiver_icno', 'sender_icno'], 'string', 'max' => 12],
            [['comment'], 'string', 'max' => 500],
            // [['date'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Tarikh !'],
            [['comment','date'], 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            't_bertulis' => 'T Bertulis',
            't_lisan' => 'T Lisan',
            'date' => 'Date',
            'receiver_icno' => 'Receiver Icno',
            'sender_icno' => 'Sender Icno',
        ];
    }
    
    public function getReceiver() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'receiver_icno']);
    }
    public function getSender() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'sender_icno']);
    }

    public static function viewMonth($mth)
    {

        $nama_bulan = '';

        if ($mth == 'Januari') {
            $nama_bulan = '01';
        }
        if ($mth == 'Februari') {
            $nama_bulan = '02';
        }
        if ($mth == 'Mac') {
            $nama_bulan = '03';
        }
        if ($mth == 'April') {
            $nama_bulan = '04';
        }
        if ($mth == 'Mei') {
            $nama_bulan = '05';
        }
        if ($mth == 'Jun') {
            $nama_bulan = '06';
        }
        if ($mth == 'Julai') {
            $nama_bulan = '07';
        }
        if ($mth == 'Ogos') {
            $nama_bulan = '08';
        }
        if ($mth == 'September') {
            $nama_bulan = '09';
        }
        if ($mth == 'Oktober') {
            $nama_bulan = '10';
        }
        if ($mth == 'November') {
            $nama_bulan = '11';
        }
        if ($mth == 'Disember') {
            $nama_bulan = '12';
        }


        return $nama_bulan;
    }


    public static function CountTb($mth, $year, $id)
    {        
        // var_dump($mth, $year, $id);die;

        $val = '0';
        $month = self::viewMonth($mth);
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $day = $date->format("t");
        $mula = "$year-$month-01";
        $end = "$year-$month-$day";
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];
        $model = TblTindakanBertulisLisan::find()->where(['receiver_icno' => $id])->one();
        if ($model) {
            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_tindakan_bertulis_lisan')
                ->where(['between', 'date', $mula, $end])
                ->andWhere(['t_bertulis'=>1])
                ->andWhere(['receiver_icno' => $id])
                ->count();
        }
        else {
            $val = 0;
        }
        return $val;
    }

    public static function CountTl($mth, $year, $id)
    {        
        // var_dump($mth, $year, $id);die;

        $val = '0';
        $month = self::viewMonth($mth);
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $day = $date->format("t");
        $mula = "$year-$month-01";
        $end = "$year-$month-$day";
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];
        $model = TblTindakanBertulisLisan::find()->where(['receiver_icno' => $id])->one();
        if ($model) {
            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_tindakan_bertulis_lisan')
                ->where(['between', 'date', $mula, $end])
                ->andWhere(['t_lisan'=>1])
                ->andWhere(['receiver_icno' => $id])
                ->count();
        }
        else {
            $val = 0;
        }
        return $val;
    }
    public static function CountTotalTl($id, $dateS, $dateE)
    {
        $val = '0';
        // $year = date('Y');
        // $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];

        $model = TblRollcall::find()->where(['anggota_icno' => $id])->one();
        if ($model) {
            $val = (new \yii\db\Query())
            ->from('keselamatan.tbl_tindakan_bertulis_lisan')
            ->where(['between', 'date', $dateS, $dateE])
                ->andWhere(['receiver_icno' => $id])
                ->andWhere(['t_lisan'=>1])
                ->count();
        }
        return $val;
    }
    public static function CountTotalTb($id, $dateS, $dateE)
    {
        $val = '0';
        // $year = date('Y');
        // $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $value = ['REMARKED', 'STS', 'APPROVED', 'REJECTED'];

        $model = TblRollcall::find()->where(['anggota_icno' => $id])->one();
        if ($model) {
            $val = (new \yii\db\Query())
            ->from('keselamatan.tbl_tindakan_bertulis_lisan')
            ->where(['between', 'date', $dateS, $dateE])
                ->andWhere(['receiver_icno' => $id])
                ->andWhere(['t_bertulis'=>1])
                ->count();
        }
        return $val;
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'receiver_icno']);
    }

}
