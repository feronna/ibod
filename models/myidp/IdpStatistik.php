<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_statistik".
 *
 * @property int $tahun
 * @property int $kumpkhidmat_id id from kumpkhidmat hronline
 * @property int $jumlah_staf
 * @property int $jumlah_capai
 * @property int $jumlah_belum_capai
 * @property int $jumlah_belum_ada_mata
 * @property int $per_jumlah_capai
 * @property int $per_jumlah_belum_capai
 * @property int $per_jumlah_belum_ada_mata
 */
class IdpStatistik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_statistik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'kumpkhidmat_id'], 'required'],
            [['tahun', 'kumpkhidmat_id', 'jumlah_staf', 'jumlah_capai', 'jumlah_belum_capai', 'jumlah_belum_ada_mata', 'per_jumlah_capai', 'per_jumlah_belum_capai', 'per_jumlah_belum_ada_mata'], 'integer'],
            [['tahun', 'kumpkhidmat_id'], 'unique', 'targetAttribute' => ['tahun', 'kumpkhidmat_id']],
            [['tarikh_kemaskini'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'kumpkhidmat_id' => 'Kumpkhidmat ID',
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

        $model = IdpStatistik::find()
                    ->where(['tahun' => $tahun])
                    ->andWhere(['kumpkhidmat_id' => $kumpulan])
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

        $model = IdpStatistik::find()->where(['tahun' => $tahun])->all();

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
