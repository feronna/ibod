<?php

namespace app\models\lnpt;

use Yii;

/**
 * This is the model class for table "lppums.lpp".
 *
 * @property string $lpp_id
 * @property string $lpp_datetime
 * @property string $PYD
 * @property int $PYD_sts_lantikan
 * @property int $gred_jawatan_id
 * @property string $tahun
 * @property int $jspiu
 * @property string $PPP
 * @property int $gred_jawatan_id_PPP
 * @property int $jspiu_PPP
 * @property string $PPK
 * @property int $gred_jawatn_id_PPK
 * @property int $jspiu_PPK
 * @property string $PP_ALL
 * @property int $PYD_sah
 * @property string $PYD_sah_datetime
 * @property int $PPP_sah
 * @property string $PPP_sah_datetime
 * @property int $PPK_sah
 * @property string $PPK_sah_datetime
 * @property string $KJ_sah
 * @property string $KJ_sah_datetime
 */
class Lpp extends \yii\db\ActiveRecord
{
    
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'lppums.lpp';
        return 'hrm.lppums_lpp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_datetime', 'tahun', 'PYD_sah_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime', 'KJ_sah_datetime'], 'safe'],
            [['PYD_sts_lantikan', 'gred_jawatan_id', 'jspiu', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK', 'PYD_sah', 'PPP_sah', 'PPK_sah'], 'integer'],
            [['PYD', 'PPP', 'PPK', 'PP_ALL', 'KJ_sah'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_id' => 'Lpp ID',
            'lpp_datetime' => 'Lpp Datetime',
            'PYD' => 'Pyd',
            'PYD_sts_lantikan' => 'Pyd Sts Lantikan',
            'gred_jawatan_id' => 'Gred Jawatan ID',
            'tahun' => 'Tahun',
            'jspiu' => 'Jspiu',
            'PPP' => 'Ppp',
            'gred_jawatan_id_PPP' => 'Gred Jawatan Id  Ppp',
            'jspiu_PPP' => 'Jspiu  Ppp',
            'PPK' => 'Ppk',
            'gred_jawatan_id_PPK' => 'Gred Jawatan Id  Ppk',
            'jspiu_PPK' => 'Jspiu  Ppk',
            'PP_ALL' => 'Pp  All',
            'PYD_sah' => 'Pyd Sah',
            'PYD_sah_datetime' => 'Pyd Sah Datetime',
            'PPP_sah' => 'Ppp Sah',
            'PPP_sah_datetime' => 'Ppp Sah Datetime',
            'PPK_sah' => 'Ppk Sah',
            'PPK_sah_datetime' => 'Ppk Sah Datetime',
            'KJ_sah' => 'Kj Sah',
            'KJ_sah_datetime' => 'Kj Sah Datetime',
        ];
    }
    
    public function getMarkahkeseluruhan() {
        return $this->hasOne(MarkahKeseluruhan::className(), ['lpp_id' => 'lpp_id']);
    }
}
