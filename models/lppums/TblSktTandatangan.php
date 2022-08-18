<?php

namespace app\models\lppums;

use Yii;

use app\models\hronline\Tblprcobiodata;
use app\models\system_core\ExternalUser;

/**
 * This is the model class for table "hrm.lppums_tbl_skt_tandatangan".
 *
 * @property string $skt_tt_id
 * @property string $lpp_id
 * @property string $skt_tt_pyd
 * @property string $skt_tt_pyd_datetime
 * @property string $skt_tt_ppp
 * @property string $skt_tt_ppp_datetime
 */
class TblSktTandatangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_skt_tandatangan';
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
            [['skt_tt_pyd_datetime', 'skt_tt_ppp_datetime'], 'safe'],
            [['skt_tt_pyd', 'skt_tt_ppp'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'skt_tt_id' => 'Skt Tt ID',
            'lpp_id' => 'Lpp ID',
            'skt_tt_pyd' => 'Skt Tt Pyd',
            'skt_tt_pyd_datetime' => 'Skt Tt Pyd Datetime',
            'skt_tt_ppp' => 'Skt Tt Ppp',
            'skt_tt_ppp_datetime' => 'Skt Tt Ppp Datetime',
        ];
    }

    public function getPyd()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'skt_tt_pyd']);
    }

    public function getPpp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'skt_tt_ppp']);
    }

    public function getExternalUser()
    {
        return $this->hasOne(ExternalUser::className(), ['user_id' => 'skt_tt_ppp']);
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
}
