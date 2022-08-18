<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_lpp_tahun".
 *
 * @property string $lpp_tahun
 * @property string $lpp_aktif
 * @property string $lpp_trkh_hantar
 * @property string $pengisian_PYD_tamat
 */
class TblLppTahun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_lpp_tahun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_tahun', 'lpp_aktif', 'lpp_trkh_hantar', 'pengisian_PYD_tamat', 
                'penilaian_PPP_tamat', 'penilaian_PPK_tamat', 'penilaian_PEER_tamat'], 'required'],
            [['lpp_tahun', 'lpp_trkh_hantar', 'pengisian_PYD_tamat', 
                'penilaian_PPP_tamat', 'penilaian_PPK_tamat', 'penilaian_PEER_tamat'], 'safe'],
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
            'lpp_aktif' => 'Lpp Aktif',
            'lpp_trkh_hantar' => 'Lpp Trkh Hantar',
            'pengisian_PYD_tamat' => 'Pengisian Pyd Tamat',
            'penilaian_PPP_tamat' => 'Penilaian Ppp Tamat', 
            'penilaian_PPK_tamat' => 'Penilaian Ppk Tamat', 
            'penilaian_PEER_tamat' => 'Penilaian Peer Tamat',
        ];
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if($insert == true) {
            //$date = DateTime::createFromFormat("Y-m-d", $this->lpp_trkh_hantar);
            //echo $date->format("Y");
            $this->lpp_tahun = date('Y', strtotime($this->lpp_trkh_hantar));
        }
        return true;
    }
}
