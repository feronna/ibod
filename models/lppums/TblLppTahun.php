<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "new_hrm.lppums_tbl_lpp_tahun".
 *
 * @property string $lpp_tahun
 * @property string $lpp_tkh_hantar
 * @property string $lpp_aktif
 * @property string $tetap_skt_mula
 * @property string $tetap_skt_tamat
 * @property string $kajian_skt_mula
 * @property string $kajian_skt_tamat
 * @property string $pencapaian_skt_mula
 * @property string $pengisian_PYD_tamat
 */
class TblLppTahun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_lpp_tahun';
    }
    
//    public static function getDb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_tahun', 'lpp_aktif', 'tetap_skt_mula', 'tetap_skt_tamat', 'kajian_skt_mula', 'kajian_skt_tamat', 'pencapaian_skt_mula', 'pengisian_PYD_tamat', 'penilaian_PPP_tamat', 'penilaian_PPK_tamat'], 'required'],
//            [['tetap_skt_tamat'], 'required','when' => function ($model){
//                return is_null($model->tetap_skt_mula) == true;
//            }],
//            [['kajian_skt_tamat'], 'required','when' => function ($model){
//                return is_null($model->kajian_skt_mula) == true;
//            }],
            [['lpp_tahun', 'lpp_tkh_hantar', 'tetap_skt_mula', 'tetap_skt_tamat', 'kajian_skt_mula', 'kajian_skt_tamat', 'pencapaian_skt_mula', 'pengisian_PYD_tamat', 'penilaian_PPP_tamat', 'penilaian_PPK_tamat'], 'safe'],
            [['lpp_aktif'], 'string', 'max' => 1],
            [['lpp_tahun'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_tahun' => 'Lpp Tahun',
            'lpp_tkh_hantar' => 'Lpp Tkh Hantar',
            'lpp_aktif' => 'Lpp Aktif',
            'tetap_skt_mula' => 'Tetap Skt Mula',
            'tetap_skt_tamat' => 'Tetap Skt Tamat',
            'kajian_skt_mula' => 'Kajian Skt Mula',
            'kajian_skt_tamat' => 'Kajian Skt Tamat',
            'pencapaian_skt_mula' => 'Pencapaian Skt Mula',
            'pengisian_PYD_tamat' => 'Pengisian  Pyd Tamat',
        ];
    }
}
