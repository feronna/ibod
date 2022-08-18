<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_ulasan".
 *
 * @property string $ulasan_id
 * @property string $lnpk_id
 * @property int $tempoh_PPP_bulan
 * @property string $ulasan_PPP_prestasi prestasi keseluruhan
 * @property string $ulasan_PPP_tt
 * @property string $ulasan_PPP_tt_datetime
 */
class TblUlasan extends \yii\db\ActiveRecord
{
    const SCENARIO_PPP = 'ppp';
    const SCENARIO_PPK = 'ppk';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_ulasan';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['ppp'] = ['tempoh_PPP_bulan', 'ulasan_PPP_prestasi'];
        $scenarios['ppk'] = ['tempoh_PPK_bulan', 'ulasan_PPK_prestasi', 'ulasan_PPK_prestasi_atas'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lnpk_id', 'tempoh_PPP_bulan', 'tempoh_PPK_bulan'], 'integer'],
            [['ulasan_PPP_prestasi', 'ulasan_PPK_prestasi', 'ulasan_PPK_prestasi_atas'], 'string'],
            [['ulasan_PPP_tt_datetime', 'ulasan_PPK_tt_datetime'], 'safe'],
            [['ulasan_PPP_tt', 'ulasan_PPK_tt'], 'string', 'max' => 12],
            // [['ulasan_PPP_tt', 'ulasan_PPP_tt_datetime'], 'validateSahPPP'],
            // [['ulasan_PPK_tt', 'ulasan_PPK_tt_datetime'], 'validateSahPPK'],
            // [['tempoh_PPP_bulan', 'ulasan_PPP_prestasi'], 'required', 'on' => self::SCENARIO_PPP],
            // [['tempoh_PPK_bulan', 'ulasan_PPK_prestasi', 'ulasan_PPK_prestasi_atas'], 'required', 'on' => self::SCENARIO_PPK],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ulasan_id' => 'Ulasan ID',
            'lnpk_id' => 'Lnpk ID',
            'tempoh_PPP_bulan' => 'Bulan',
            'ulasan_PPP_prestasi' => 'Ulasan Prestasi',
            'ulasan_PPP_tt' => 'Ulasan Pp Tt',
            'ulasan_PPP_tt_datetime' => 'Ulasan Pp Tt Datetime',
        ];
    }

    public function validateSahPPP($attribute, $params, $validator)
    {
        if ($this->tempoh_PPP_bulan == null || $this->ulasan_PPP_prestasi == null) {
            $this->addError($attribute, 'Incomplete Data');
        }
    }

    public function validateSahPPK($attribute, $params, $validator)
    {
        if ($this->tempoh_PPK_bulan == null || $this->ulasan_PPK_prestasi == null || $this->ulasan_PPK_prestasi_atas == null) {
            $this->addError($attribute, 'Incomplete Data');
        }
    }

    public function getBorang()
    {
        return $this->hasOne(TblMain::className(), ['lnpk_id' => 'lnpk_id']);
    }
}
