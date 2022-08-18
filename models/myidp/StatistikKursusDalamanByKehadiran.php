<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.idp_statistik_kehadiran_bulanan}}".
 *
 * @property int $month_id
 * @property int $tahun
 * @property int $jumlah_terlaksana
 * @property int $jumlah_memohon
 * @property int $jumlah_hadir
 * @property int $jumlah_walk_in
 * @property int $per_jumlah_walk_in
 * @property int $jumlah_tidak_hadir
 * @property int $per_jumlah_hadir
 * @property int $per_jumlah_tidak_hadir
 * @property string $tarikh_kemaskini
 */
class StatistikKursusDalamanByKehadiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_statistik_kehadiran_bulanan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_id', 'tahun'], 'required'],
            [['month_id', 'tahun', 'jumlah_terlaksana', 'jumlah_memohon', 'jumlah_hadir', 'jumlah_walk_in', 'per_jumlah_walk_in', 'jumlah_tidak_hadir', 'per_jumlah_hadir', 'per_jumlah_tidak_hadir'], 'integer'],
            [['tarikh_kemaskini'], 'safe'],
            [['month_id', 'tahun'], 'unique', 'targetAttribute' => ['month_id', 'tahun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'month_id' => 'Month ID',
            'tahun' => 'Tahun',
            'jumlah_terlaksana' => 'Jumlah Terlaksana',
            'jumlah_memohon' => 'Jumlah Memohon',
            'jumlah_hadir' => 'Jumlah Hadir',
            'jumlah_walk_in' => 'Jumlah Walk In',
            'per_jumlah_walk_in' => 'Per Jumlah Walk In',
            'jumlah_tidak_hadir' => 'Jumlah Tidak Hadir',
            'per_jumlah_hadir' => 'Per Jumlah Hadir',
            'per_jumlah_tidak_hadir' => 'Per Jumlah Tidak Hadir',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }

    public static function countKursusByStatus($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = StatistikKursusDalamanByKehadiran::find()
            ->where(['tahun' => $tahun])
            ->andWhere(['month_id' => $kumpulan])
            ->one();

        if ($category == 1) {
            $count = $model->jumlah_terlaksana; //jumlah kursus mengikut bulan
        } elseif ($category == 2) {
            $count = $model->jumlah_memohon; //jumlah staf memohon kursus di sistem
        } elseif ($category == 3) {
            $count = $model->jumlah_hadir; //jumlah hadir keseluruhan (memohon + walk-in)
        } elseif ($category == 4) {
            $count = $model->per_jumlah_hadir;
        } elseif ($category == 5) {
            $count = $model->jumlah_tidak_hadir; //jumlah staf memohon yang tidak hadir
        } elseif ($category == 6) {
            $count = $model->per_jumlah_tidak_hadir;
        } elseif ($category == 7) {
            $count = $model->jumlah_walk_in; //jumlah hadir secara walk-in
        } elseif ($category == 8) {
            $count = $model->per_jumlah_walk_in;
        } elseif ($category == 9) { // jumlah staf memohon yang hadir
            if ($model->jumlah_hadir != 0) {
                $count = ($model->jumlah_hadir - $model->jumlah_walk_in);
            } else {
                $count = 0;
            }
        }

        return $count;
    }

    public static function countKursusByStatusTotal($category, $tahun)
    {

        $count = 0;

        $model = StatistikKursusDalamanByKehadiran::find()
            ->where(['tahun' => $tahun]);

        if ($category == 1) {
            $count = $model->sum('jumlah_terlaksana'); //jumlah kursus mengikut bulan
        } elseif ($category == 2) {
            $count = $model->sum('jumlah_memohon'); //jumlah staf memohon kursus di sistem
        } elseif ($category == 3) {
            $count = $model->sum('jumlah_hadir'); //jumlah hadir keseluruhan (memohon + walk-in)
        } elseif ($category == 4) {
            $count = $model->per_jumlah_hadir;
        } elseif ($category == 5) {
            $count = $model->sum('jumlah_tidak_hadir'); //jumlah staf memohon yang tidak hadir
        } elseif ($category == 6) {
            $count = $model->per_jumlah_tidak_hadir;
        } elseif ($category == 7) {
            $count = $model->sum('jumlah_walk_in'); //jumlah hadir secara walk-in
        } elseif ($category == 8) {
            $count = $model->per_jumlah_walk_in;
        } elseif ($category == 9) {
            if ($model->sum('jumlah_hadir') != 0) {
                $count = (($model->sum('jumlah_hadir') - $model->sum('jumlah_walk_in')));
            } else {
                $count = 0;
            }
        }

        return round($count, 2);
    }
}
