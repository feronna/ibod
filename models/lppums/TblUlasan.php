<?php

namespace app\models\lppums;

use Yii;
use app\models\lppums\TblMain;

/**
 * This is the model class for table "hrm.lppums_tbl_ulasan".
 *
 * @property string $ulasan_id
 * @property string $lpp_id
 * @property int $tempoh_PPP_tahun
 * @property int $tempoh_PPP_bulan
 * @property int $tempoh_PPK_tahun
 * @property int $tempoh_PPK_bulan
 * @property string $ulasan_PPP_prestasi prestasi keseluruhan
 * @property string $ulasan_PPP_kemajuan kemajuan kerjaya
 * @property string $ulasan_PPP_markah markah 90 peratus dan ke atas oleh PPP
 * @property string $ulasan_PPK
 * @property string $ulasan_PPK_markah markah 90 peratus dan ke atas oleh PPK
 * @property string $ulasan_PPP_tt
 * @property string $ulasan_PPK_tt
 * @property string $ulasan_PPP_tt_datetime
 * @property string $ulasan_PPK_tt_datetime
 */
class TblUlasan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_ulasan';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'tempoh_PPP_tahun', 'tempoh_PPP_bulan', 'tempoh_PPK_tahun', 'tempoh_PPK_bulan'], 'integer'],
            [['ulasan_PPP_prestasi', 'ulasan_PPP_kemajuan', 'ulasan_PPP_markah', 'ulasan_PPK', 'ulasan_PPK_markah'], 'string'],
            [['ulasan_PPP_tt_datetime', 'ulasan_PPK_tt_datetime'], 'safe'],
            [['ulasan_PPP_tt', 'ulasan_PPK_tt'], 'string', 'max' => 12],
            [['ulasan_PPP_tt', 'ulasan_PPK_tt'], 'checkTamatPenilaian'],
            //            [['tempoh_PPP_tahun', 'tempoh_PPP_bulan', 
            //                'tempoh_PPK_tahun', 'tempoh_PPK_bulan', 
            //                'ulasan_PPP_tt', 'ulasan_PPK_tt', 
            //                'ulasan_PPP_prestasi', 'ulasan_PPP_kemajuan', 
            //                'ulasan_PPP_markah', 'ulasan_PPK', 'ulasan_PPK_markah'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ulasan_id' => Yii::t('app', 'Ulasan ID'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
            'tempoh_PPP_tahun' => Yii::t('app', 'Tempoh Ppp Tahun'),
            'tempoh_PPP_bulan' => Yii::t('app', 'Tempoh Ppp Bulan'),
            'tempoh_PPK_tahun' => Yii::t('app', 'Tempoh Ppk Tahun'),
            'tempoh_PPK_bulan' => Yii::t('app', 'Tempoh Ppk Bulan'),
            'ulasan_PPP_prestasi' => Yii::t('app', 'Ulasan Ppp Prestasi'),
            'ulasan_PPP_kemajuan' => Yii::t('app', 'Ulasan Ppp Kemajuan'),
            'ulasan_PPP_markah' => Yii::t('app', 'Ulasan Ppp Markah'),
            'ulasan_PPK' => Yii::t('app', 'Ulasan Ppk'),
            'ulasan_PPK_markah' => Yii::t('app', 'Ulasan Ppk Markah'),
            'ulasan_PPP_tt' => Yii::t('app', 'Ulasan Ppp Tt'),
            'ulasan_PPK_tt' => Yii::t('app', 'Ulasan Ppk Tt'),
            'ulasan_PPP_tt_datetime' => Yii::t('app', 'Ulasan Ppp Tt Datetime'),
            'ulasan_PPK_tt_datetime' => Yii::t('app', 'Ulasan Ppk Tt Datetime'),
        ];
    }

    public function checkTamatPenilaian($attribute, $params, $validator)
    {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::findOne(['lpp_tahun' => $lpp->tahun]);

        $req = TblRequest::findOne(['lpp_id' => $lpp->lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);

        if (isset($req)) {
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat and date('Y-m-d H:i:s') > $req->close_date && $this->checkKeselamatan2021($lpp)) {
                    $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
                }
            } else {
                if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat and date('Y-m-d H:i:s') > $req->close_date && $this->checkKeselamatan2021($lpp)) {
                    $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
                }
            }
        } else {
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat && $this->checkKeselamatan2021($lpp)) {
                    $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
                }
            } else {
                if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat && $this->checkKeselamatan2021($lpp)) {
                    $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
                }
            }
        }

        $this->addErrors($this->getErrors($attribute));
    }

    protected function checkKeselamatan2021($lpp)
    {
        if (date('Y/m/d') <= '2022/05/25' && $lpp->jspiu == 2)
            return false;

        return true;
    }
}
