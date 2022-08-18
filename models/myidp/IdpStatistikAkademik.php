<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_statistik_akademik".
 *
 * @property int $tahun
 * @property string $vckl_kod_kumpulan vckl_kod_kumpulan from v_idp_kumpulan
 * @property int $jumlah_staf
 * @property int $jumlah_capai
 * @property int $jumlah_belum_capai
 * @property int $jumlah_belum_ada_mata
 * @property int $per_jumlah_capai
 * @property int $per_jumlah_belum_capai
 * @property int $per_jumlah_belum_ada_mata
 * @property string $tarikh_kemaskini
 */
class IdpStatistikAkademik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_statistik_akademik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'vckl_kod_kumpulan'], 'required'],
            [['tahun', 'jumlah_staf', 'jumlah_capai', 'jumlah_belum_capai', 'jumlah_belum_ada_mata', 'per_jumlah_capai', 'per_jumlah_belum_capai', 'per_jumlah_belum_ada_mata'], 'integer'],
            [['tarikh_kemaskini'], 'safe'],
            [['vckl_kod_kumpulan'], 'string', 'max' => 50],
            [['tahun', 'vckl_kod_kumpulan'], 'unique', 'targetAttribute' => ['tahun', 'vckl_kod_kumpulan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'vckl_kod_kumpulan' => 'Vckl Kod Kumpulan',
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

    public static function countStaffByKumpulan($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = IdpStatistikAkademik::find()
                    ->where(['tahun' => $tahun])
                    ->andWhere(['vckl_kod_kumpulan' => $kumpulan])
                    ->one();

        if ($category == 0) { 
            $count = $model->jumlah_staf;
        } elseif ($category == 1){
            $count = $model->jumlah_capai;
        } elseif ($category == 2){
            $count = $model->per_jumlah_capai;
        } elseif ($category == 3){
            $count = $model->jumlah_belum_capai;
        } elseif ($category == 4){
            $count = $model->per_jumlah_belum_capai;
        } elseif ($category == 5){
            $count = $model->jumlah_belum_ada_mata;
        } elseif ($category == 6){
            $count = $model->per_jumlah_belum_ada_mata;
        }

        return $count;
    }

    public static function countStaff($category, $tahun)
    {

        $count = 0;

        $model = IdpStatistikAkademik::find()->where(['tahun' => $tahun])->all();

        if ($category == 0) { 
            foreach ($model as $model){
                $count = $count + $model->jumlah_staf;
            }

        } elseif ($category == 1){
            foreach ($model as $model){
                $count = $count + $model->jumlah_capai;
            }

        } elseif ($category == 2){
            foreach ($model as $model){
                $count = $count + $model->jumlah_belum_capai;
            }
        } elseif ($category == 3){
            foreach ($model as $model){
                $count = $count + $model->jumlah_belum_ada_mata;
            }
        } 

        return $count;
    }
}
