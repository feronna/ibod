<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Department;

/**
 * This is the model class for table "hrd.idp_statistik_jabatan".
 *
 * @property int $dept_id
 * @property int $tahun
 * @property int $jumlah_staf
 * @property int $jumlah_capai
 * @property int $jumlah_belum_capai
 * @property int $jumlah_belum_ada_mata
 * @property int $per_jumlah_capai
 * @property int $per_jumlah_belum_capai
 * @property int $per_jumlah_belum_ada_mata
 * @property string $tarikh_kemaskini
 */
class IdpStatistikJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_statistik_jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id', 'tahun'], 'required'],
            [['dept_id', 'tahun', 'jumlah_staf', 'jumlah_capai', 'jumlah_belum_capai', 'jumlah_belum_ada_mata', 'per_jumlah_capai', 'per_jumlah_belum_capai', 'per_jumlah_belum_ada_mata'], 'integer'],
            [['tarikh_kemaskini'], 'safe'],
            [['dept_id', 'tahun'], 'unique', 'targetAttribute' => ['dept_id', 'tahun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dept_id' => 'Dept ID',
            'tahun' => 'Tahun',
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

    public function getJabatan()
    {
        return $this->hasOne(Department::class(), ['id'=>'dept_id']);
    }

    public static function countStaffByDept($kumpulan, $category, $tahun)
    {

        $count = 0;

        $model = IdpStatistikJabatan::find()
                    ->where(['tahun' => $tahun])
                    ->andWhere(['dept_id' => $kumpulan])
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
}
