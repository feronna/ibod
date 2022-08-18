<?php

namespace app\models\lppums;

use Yii;

use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrm.lppums_tbl_sumbangan_tandatangan".
 *
 * @property int $sumbangan_tt_id
 * @property string $lpp_id
 * @property string $sumbangan_tt
 * @property string $sumbangan_tt_date
 */
class TblSumbanganTt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_sumbangan_tandatangan';
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
            [['lpp_id'], 'integer'],
            [['sumbangan_tt_date'], 'safe'],
            [['sumbangan_tt'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sumbangan_tt_id' => Yii::t('app', 'Sumbangan Tt ID'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
            'sumbangan_tt' => Yii::t('app', 'Sumbangan Tt'),
            'sumbangan_tt_date' => Yii::t('app', 'Sumbangan Tt Date'),
        ];
    }
    
    public function getPyd() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'sumbangan_tt']);
    }
}
