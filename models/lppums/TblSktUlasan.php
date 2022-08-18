<?php

namespace app\models\lppums;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\lppums\TblLppTahun;
use app\models\lppums\TblRequest;
use app\models\lppums\TblMain;
use app\models\system_core\ExternalUser;

/**
 * This is the model class for table "hrm.lppums_tbl_skt_ulasan".
 *
 * @property string $skt_ulasan_id
 * @property string $lpp_id
 * @property string $skt_ulasan_pyd
 * @property string $skt_ulasan_ppp
 * @property string $su_pyd_datetime
 * @property string $su_ppp_datetime
 * @property string $skt_ulasan_tt_pyd
 * @property string $skt_ulasan_tt_ppp
 * @property string $su_tt_pyd_datetime
 * @property string $su_tt_ppp_datetime
 */
class TblSktUlasan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_skt_ulasan';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

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
            [['lpp_id'], 'integer'],
            [['skt_ulasan_pyd', 'skt_ulasan_ppp'], 'string'],
            [['su_pyd_datetime', 'su_ppp_datetime', 'su_tt_pyd_datetime', 'su_tt_ppp_datetime'], 'safe'],
            [['skt_ulasan_tt_pyd', 'skt_ulasan_tt_ppp'], 'string', 'max' => 12],
            ['skt_ulasan_ppp', 'required', 'when' => function ($model) {
                return $model->skt_ulasan_tt_ppp != null;
            }, 'message' => 'Please enter ulasan.'],
            ['skt_ulasan_tt_ppp', 'checkTamatPenilaian'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'skt_ulasan_id' => 'Skt Ulasan ID',
            'lpp_id' => 'Lpp ID',
            'skt_ulasan_pyd' => 'Skt Ulasan Pyd',
            'skt_ulasan_ppp' => 'Skt Ulasan Ppp',
            'su_pyd_datetime' => 'Su Pyd Datetime',
            'su_ppp_datetime' => 'Su Ppp Datetime',
            'skt_ulasan_tt_pyd' => 'Skt Ulasan Tt Pyd',
            'skt_ulasan_tt_ppp' => 'Skt Ulasan Tt Ppp',
            'su_tt_pyd_datetime' => 'Su Tt Pyd Datetime',
            'su_tt_ppp_datetime' => 'Su Tt Ppp Datetime',
        ];
    }

    public function getPyd()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'skt_ulasan_tt_pyd']);
    }

    public function getPpp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'skt_ulasan_tt_ppp']);
    }

    public function getExternalUser()
    {
        return $this->hasOne(ExternalUser::className(), ['user_id' => 'skt_ulasan_tt_ppp']);
    }

    public function getPppDetails()
    {
        if ($this->ppp) {
            return $this->ppp->CONm;
        }


        if ($this->externalUser) {
            return $this->externalUser->name;
        }
    }

    public function checkTamatPenilaian($attribute, $params, $validator)
    {
        $lpp = TblMain::findOne(['lpp_id' => $this->lpp_id]);
        $tahun = TblLppTahun::findOne(['lpp_tahun' => $lpp->tahun]);

        $req = TblRequest::findOne(['lpp_id' => $lpp->lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);

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

    protected function checkKeselamatan2021($lpp)
    {
        if (date('Y/m/d') <= '2022/05/25' && $lpp->jspiu == 2)
            return false;

        return true;
    }
}
