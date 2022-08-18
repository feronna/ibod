<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_latihan_perlu".
 *
 * @property string $lat_perlu_id
 * @property string $lpp_id
 * @property string $lat_perlu
 * @property string $lat_sebab_perlu
 */
class TblLatihanPerlu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_latihan_perlu';
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
            [['lat_perlu'], 'string', 'max' => 80],
            [['lat_sebab_perlu'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lat_perlu_id' => Yii::t('app', 'Lat Perlu ID'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
            'lat_perlu' => Yii::t('app', 'Lat Perlu'),
            'lat_sebab_perlu' => Yii::t('app', 'Lat Sebab Perlu'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->lat_perlu = strtoupper($this->lat_perlu);
        $this->lat_sebab_perlu = strtoupper($this->lat_sebab_perlu);
        
        // ...custom code here...
        return true;
    }
}
