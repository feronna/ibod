<?php

namespace app\models\lppums;

use Yii;
use app\models\lppums\TblMain;
use app\models\lppums\TblLppTahun;

/**
 * This is the model class for table "hrm.lppums_tbl_lpp_markah".
 *
 * @property string $lpp_markah_id
 * @property string $lpp_id
 * @property int $bhk_id
 * @property double $markah_PPP
 * @property double $markah_PPK
 * @property string $tarikh_kemaskini
 * @property string $markah_PPP_
 * @property string $markah_PPK_
 */
class TblLppMarkah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_lpp_markah';
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
            [['lpp_id'], 'required'],
            [['lpp_id', 'bhk_id'], 'integer'],
            [['markah_PPP', 'markah_PPK'], 'number', 'max' => 10, 'min' => 0],
            [['markah_PPP'], 'checkTamatPenilaianPpp', 'when' => function ($model) {
                if ($model->markah_PPP_ == Yii::$app->user->identity->ICNO) {
                    return $model->lpp_id != null;
                }
                return false;
            }],
            [['markah_PPK'], 'checkTamatPenilaianPpk', 'when' => function ($model) {
                if ($model->markah_PPK_ == Yii::$app->user->identity->ICNO) {
                    return $model->lpp_id != null;
                }
                return false;
            }],
            [['markah_PPP'], 'checkTamatPenilaianPpp1', 'when' => function ($model) {
                if ($model->markah_PPP_ == Yii::$app->user->identity->ICNO) {
                    return $model->lpp_id == null;
                }
                return false;
            }],
            [['markah_PPK'], 'checkTamatPenilaianPpk1', 'when' => function ($model) {
                if ($model->markah_PPK_ == Yii::$app->user->identity->ICNO) {
                    return $model->lpp_id == null;
                }
                return false;
            }],
            [['markah_PPP', 'markah_PPK'], 'default', 'value' => 0],
            [['tarikh_kemaskini'], 'safe'],
            [['markah_PPP_', 'markah_PPK_'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_markah_id' => Yii::t('app', 'Lpp Markah ID'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
            'bhk_id' => Yii::t('app', 'Bhk ID'),
            'markah_PPP' => Yii::t('app', 'Markah Ppp'),
            'markah_PPK' => Yii::t('app', 'Markah Ppk'),
            'tarikh_kemaskini' => Yii::t('app', 'Tarikh Kemaskini'),
            'markah_PPP_' => Yii::t('app', 'Markah Ppp'),
            'markah_PPK_' => Yii::t('app', 'Markah Ppk'),
        ];
    }

    public function checkTamatPenilaianPpp1($attribute, $params, $validator)
    {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();

        if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat && $this->checkKeselamatan2021($lpp)) {
            $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function checkTamatPenilaianPpk1($attribute, $params, $validator)
    {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();

        if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat && $this->checkKeselamatan2021($lpp)) {
            $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function checkTamatPenilaianPpp($attribute, $params, $validator)
    {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();

        if (isset($lpp)) {
            $req = TblRequest::findOne(['lpp_id' => $lpp->lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
        }

        if (isset($req)) {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat and date('Y-m-d H:i:s') > $req->close_date && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
            }
        } else {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPP_tamat && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPP sudah tamat');
            }
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function checkTamatPenilaianPpk($attribute, $params, $validator)
    {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();

        if (isset($lpp)) {
            $req = TblRequest::findOne(['lpp_id' => $lpp->lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
        }

        if (isset($req)) {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat and date('Y-m-d H:i:s') > $req->close_date && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
            }
        } else {
            if (date('Y-m-d H:i:s') > $tahun->penilaian_PPK_tamat && $this->checkKeselamatan2021($lpp)) {
                $this->addError($attribute, 'Tempoh penilaian PPK sudah tamat');
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
