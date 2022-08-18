<?php

namespace app\models\myidp;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%hrd.idp_statistik_kursus_dalaman_by_bulan}}".
 *
 * @property int $month_id
 * @property int $tahun
 * @property int $jumlah_kursus
 * @property int $jumlah_terlaksana
 * @property int $jumlah_belum_laksana
 * @property int $jumlah_tangguh
 * @property int $per_jumlah_terlaksana
 * @property int $per_jumlah_belum_laksana
 * @property int $per_jumlah_tangguh
 * @property string $tarikh_kemaskini
 */
class StatistikKursusDalamanByBulan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_statistik_kursus_dalaman_by_bulan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_id', 'tahun'], 'required'],
            [['month_id', 'tahun', 'jumlah_kursus', 'jumlah_terlaksana', 'jumlah_belum_laksana', 'jumlah_tangguh', 'per_jumlah_terlaksana', 'per_jumlah_belum_laksana', 'per_jumlah_tangguh'], 'integer'],
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
            'jumlah_kursus' => 'Jumlah Kursus',
            'jumlah_terlaksana' => 'Jumlah Terlaksana',
            'jumlah_belum_laksana' => 'Jumlah Belum Laksana',
            'jumlah_tangguh' => 'Jumlah Tangguh',
            'per_jumlah_terlaksana' => 'Per Jumlah Terlaksana',
            'per_jumlah_belum_laksana' => 'Per Jumlah Belum Laksana',
            'per_jumlah_tangguh' => 'Per Jumlah Tangguh',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }

    public static function countKursusByStatus($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = StatistikKursusDalamanByBulan::find()
            ->where(['tahun' => $tahun])
            ->andWhere(['month_id' => $kumpulan])
            ->one();

        if ($category == 0) {
            $count = $model->jumlah_kursus;
        } elseif ($category == 1) {
            $count = $model->jumlah_terlaksana;
        } elseif ($category == 2) {
            $count = $model->per_jumlah_terlaksana;
        } elseif ($category == 3) {
            $count = $model->jumlah_belum_laksana;
        } elseif ($category == 4) {
            $count = $model->per_jumlah_belum_laksana;
        } elseif ($category == 5) {
            $count = $model->jumlah_tangguh;
        } elseif ($category == 6) {
            $count = $model->per_jumlah_tangguh;
        }

        return $count;
    }

    public static function countKursusByStatusTotal($category, $tahun)
    {

        $count = 0;

        $model = StatistikKursusDalamanByBulan::find()
            ->where(['tahun' => $tahun]);

        if ($category == 0) {
            $count = $model->sum('jumlah_kursus');
        } elseif ($category == 1) {
            $count = $model->sum('jumlah_terlaksana');
        } elseif ($category == 2) {
            $count = $model->sum('per_jumlah_terlaksana')/1200*100;
        } elseif ($category == 3) {
            $count = $model->sum('jumlah_belum_laksana');
        } elseif ($category == 4) {
            $count = $model->sum('per_jumlah_belum_laksana')/1200*100;
        } elseif ($category == 5) {
            $count = $model->sum('jumlah_tangguh');
        } elseif ($category == 6) {
            $count = $model->sum('per_jumlah_tangguh')/1200*100;
        }

        return round($count, 2);
    }
}
