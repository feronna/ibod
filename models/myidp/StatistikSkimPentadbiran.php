<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.idp_statistik_pentadbiran_skim}}".
 *
 * @property int $tahun
 * @property string $gred_skim
 * @property int $jumlah_staf
 * @property int $jumlah_capai
 * @property int $jumlah_belum_capai
 * @property int $jumlah_belum_ada_mata
 * @property int $per_jumlah_capai
 * @property int $per_jumlah_belum_capai
 * @property int $per_jumlah_belum_ada_mata
 * @property string $tarikh_kemaskini
 */
class StatistikSkimPentadbiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_statistik_pentadbiran_skim}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'gred_skim'], 'required'],
            [['tahun', 'jumlah_staf', 'jumlah_capai', 'jumlah_belum_capai', 'jumlah_belum_ada_mata', 'per_jumlah_capai', 'per_jumlah_belum_capai', 'per_jumlah_belum_ada_mata'], 'integer'],
            [['tarikh_kemaskini'], 'safe'],
            [['gred_skim'], 'string', 'max' => 25],
            [['tahun', 'gred_skim'], 'unique', 'targetAttribute' => ['tahun', 'gred_skim']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'gred_skim' => 'Gred Skim',
            'jumlah_staf' => 'Jumlah Staf',
            'jumlah_capai' => 'Jumlah Capai',
            'jumlah_belum_capai' => 'Jumlah Belum Capai',
            'jumlah_belum_ada_mata' => 'Jumlah Belum Ada Mata',
            'per_jumlah_capai' => 'Per Jumlah Capai',
            'per_jumlah_belum_capai' => 'Per Jumlah Belum Capai',
            'per_jumlah_belum_ada_mata' => 'Per Jumlah Belum Ada Mata',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }

    public static function countStaff($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = StatistikSkimPentadbiran::find()
            ->where(['tahun' => $tahun])
            ->andWhere(['gred_skim' => $kumpulan])
            ->one();

        if ($category == 0) {
            $count = $model->jumlah_staf;
        } elseif ($category == 1) {
            $count = $model->jumlah_capai;
        } elseif ($category == 2) {
            $count = $model->per_jumlah_capai;
        } elseif ($category == 3) {
            $count = $model->jumlah_belum_capai;
        } elseif ($category == 4) {
            $count = $model->per_jumlah_belum_capai;
        } elseif ($category == 5) {
            $count = $model->jumlah_belum_ada_mata;
        } elseif ($category == 6) {
            $count = $model->per_jumlah_belum_ada_mata;
        }

        return $count;
    }
}
