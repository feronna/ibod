<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_results".
 *
 * @property int $id
 * @property int $main_id
 * @property string $penilaian_hidup
 * @property string $emosi_positif
 * @property string $kepuasan_kerja
 * @property string $keterlibatan_kerja
 * @property string $dkums
 */
class Results extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_results';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'penilaian_hidup', 'emosi_positif', 'kepuasan_kerja', 'keterlibatan_kerja', 'dkums'], 'required'],
            [['main_id'], 'integer'],
            [['penilaian_hidup', 'emosi_positif', 'kepuasan_kerja', 'keterlibatan_kerja', 'dkums'], 'number'],
            [['penilaian_hidup', 'emosi_positif', 'kepuasan_kerja', 'keterlibatan_kerja', 'dkums'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_id' => 'Main ID',
            'penilaian_hidup' => 'Penilaian Hidup',
            'emosi_positif' => 'Emosi Positif',
            'kepuasan_kerja' => 'Kepuasan Kerja',
            'keterlibatan_kerja' => 'Keterlibatan Kerja',
            'dkums' => 'DKUMS',
            'tahapPenilaianHidup' => 'Tahap Penilaian Hidup',
            'tahapEmosiPositif' => 'Tahap Emosi Positif',
            'tahapKepuasanKerja' => 'Tahap Kepuasan Kerja',
            'tahapKeterlibatanKerja' => 'Tahap Keterlibatan Kerja',
            'tahapDkums' => 'TAHAP DKUMS',
        ];
    }

    public function getMain()
    {
        return $this->hasOne(TblMain::class, ['id' => 'main_id']);
    }
    
    public function getTahapPenilaianHidup()
    {

        $main = new TblMain();

        return $main->kategori($this->penilaian_hidup);
    }

    public function getTahapEmosiPositif()
    {

        $main = new TblMain();

        return $main->kategori($this->emosi_positif);
    }

    public function getTahapKepuasanKerja()
    {

        $main = new TblMain();

        return $main->kategori($this->kepuasan_kerja);
    }

    public function getTahapKeterlibatanKerja()
    {

        $main = new TblMain();

        return $main->kategori($this->keterlibatan_kerja);
    }

    public function getTahapDkums()
    {

        $main = new TblMain();

        return $main->kategori($this->dkums);
    }
    
}
