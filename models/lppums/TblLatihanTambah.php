<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_latihan_tamb".
 *
 * @property int $lat_tamb_id
 * @property string $lpp_id
 * @property string $lat_tamb
 * @property string $lat_tamb_mula
 * @property string $lat_tamb_tamat
 * @property string $lat_tamb_tempat
 */
class TblLatihanTambah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_latihan_tamb';
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
            [['lat_tamb_mula', 'lat_tamb_tamat'], 'safe'],
            [['lat_tamb_mula', 'lat_tamb_tamat'], 'required'],
            [['lat_tamb'], 'string', 'max' => 150],
            [['lat_tamb_tempat'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lat_tamb_id' => Yii::t('app', 'Lat Tamb ID'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
            'lat_tamb' => Yii::t('app', 'Lat Tamb'),
            'lat_tamb_mula' => Yii::t('app', 'Tarikh Mula'),
            'lat_tamb_tamat' => Yii::t('app', 'Tarikh Tamat'),
            'lat_tamb_tempat' => Yii::t('app', 'Lat Tamb Tempat'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->lat_tamb = strtoupper($this->lat_tamb);
        $this->lat_tamb_tempat = strtoupper($this->lat_tamb_tempat);
        
        // ...custom code here...
        return true;
    }
}
