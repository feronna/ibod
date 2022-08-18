<?php

namespace app\models\lppums;

use Yii;
use app\models\lppums\TblMain;

/**
 * This is the model class for table "tbl_skt_tandatangan".
 *
 * @property string $skt_tt_id
 * @property string $lpp_id
 * @property string $skt_tt_pyd
 * @property string $skt_tt_pyd_datetime
 * @property string $skt_tt_ppp
 * @property string $skt_tt_ppp_datetime
 */
class TblTandatangan extends \yii\db\ActiveRecord
{
    
    public $flag_pyd;
    
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
//    public static function getdb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_pyd'], 'required', 'requiredValue' => 1, 'message' => 'Sila pangkah sebelum hantar pengesahan.'],
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
    
    public function getLpp() {
        return $this->hasOne(TblMain::className(), ['lpp_id' => 'lpp_id']); 
    }
}
