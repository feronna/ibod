<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.idp_statistik_permohonan_mata}}".
 *
 * @property int $month_id
 * @property int $tahun
 * @property int $jum_pohon_pengurusan_pen
 * @property int $jum_pohon_pelaksana_pen
 * @property int $jum_lulus_pengurusan_pen
 * @property int $jum_lulus_pelaksana_pen
 * @property int $jum_pohon_pengurusan_aka
 * @property int $jum_pohon_pelaksana_aka
 * @property int $jum_lulus_pengurusan_aka
 * @property int $jum_lulus_pelaksana_aka
 * @property string $tarikh_kemaskini
 */
class StatistikPermohonanMata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_statistik_permohonan_mata}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_id', 'tahun'], 'required'],
            [['month_id', 'tahun', 'jum_pohon_pengurusan_pen', 'jum_pohon_pelaksana_pen', 'jum_lulus_pengurusan_pen', 'jum_lulus_pelaksana_pen', 'jum_pohon_pengurusan_aka', 'jum_pohon_pelaksana_aka', 'jum_lulus_pengurusan_aka', 'jum_lulus_pelaksana_aka'], 'integer'],
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
            'jum_pohon_pengurusan_pen' => 'Jum Pohon Pengurusan Pen',
            'jum_pohon_pelaksana_pen' => 'Jum Pohon Pelaksana Pen',
            'jum_lulus_pengurusan_pen' => 'Jum Lulus Pengurusan Pen',
            'jum_lulus_pelaksana_pen' => 'Jum Lulus Pelaksana Pen',
            'jum_pohon_pengurusan_aka' => 'Jum Pohon Pengurusan Aka',
            'jum_pohon_pelaksana_aka' => 'Jum Pohon Pelaksana Aka',
            'jum_lulus_pengurusan_aka' => 'Jum Lulus Pengurusan Aka',
            'jum_lulus_pelaksana_aka' => 'Jum Lulus Pelaksana Aka',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }

    public static function countKursusByStatus($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = StatistikPermohonanMata::find()
            ->where(['tahun' => $tahun])
            ->andWhere(['month_id' => $kumpulan])
            ->one();

        if ($category == 0) {
            $count = $model->jum_pohon_pengurusan_pen + $model->jum_pohon_pelaksana_pen;
        } elseif ($category == 1) {
            $count = $model->jum_pohon_pengurusan_aka + $model->jum_pohon_pelaksana_aka;
        } elseif ($category == 2) {
            $count = $model->jum_lulus_pengurusan_pen + $model->jum_lulus_pelaksana_pen;
        } elseif ($category == 3) {
            $count = $model->jum_lulus_pengurusan_aka + $model->jum_lulus_pelaksana_aka;
        } 

        return $count;
    }
}
