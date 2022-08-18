<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.idp_statistik_kursus_luar}}".
 *
 * @property int $month_id
 * @property int $tahun
 * @property int $jum_pohon_pengurusan
 * @property int $jum_pohon_pelaksana
 * @property int $jum_lulus_pengurusan
 * @property int $jum_lulus_pelaksana
 * @property string $tarikh_kemaskini
 */
class StatistikKursusLuar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_statistik_kursus_luar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_id', 'tahun'], 'required'],
            [['month_id', 'tahun', 'jum_pohon_pengurusan', 'jum_pohon_pelaksana', 'jum_lulus_pengurusan', 'jum_lulus_pelaksana'], 'integer'],
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
            'jum_pohon_pengurusan' => 'Jum Pohon Pengurusan',
            'jum_pohon_pelaksana' => 'Jum Pohon Pelaksana',
            'jum_lulus_pengurusan' => 'Jum Lulus Pengurusan',
            'jum_lulus_pelaksana' => 'Jum Lulus Pelaksana',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }

    public static function countKursusByStatus($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = StatistikKursusLuar::find()
            ->where(['tahun' => $tahun])
            ->andWhere(['month_id' => $kumpulan])
            ->one();

        if ($category == 0) {
            $count = $model->jum_pohon_pengurusan;
        } elseif ($category == 1) {
            $count = $model->jum_pohon_pelaksana;
        } elseif ($category == 2) {
            $count = $model->jum_lulus_pengurusan;
        } elseif ($category == 3) {
            $count = $model->jum_lulus_pelaksana;
        } 

        return $count;
    }

    public static function countKursusByStatusTotal($category, $tahun)
    {
        $count = 0;

        $model = StatistikKursusLuar::find()
            ->where(['tahun' => $tahun]);

        if ($category == 0) {
            $count = $model->sum('jum_pohon_pengurusan');
        } elseif ($category == 1) {
            $count = $model->sum('jum_pohon_pelaksana');
        } elseif ($category == 2) {
            $count = $model->sum('jum_lulus_pengurusan');
        } elseif ($category == 3) {
            $count = $model->sum('jum_lulus_pelaksana');
        } 

        return $count;
    }
}
