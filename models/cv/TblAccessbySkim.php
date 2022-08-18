<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_tbl_access_by_skim".
 *
 * @property int $id
 * @property int $id_access
 * @property int $ads_id
 */
class TblAccessbySkim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_access_by_skim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access', 'ads_id'], 'integer'],
             [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID', 
            'ads_id' => 'Ads ID',
        ];
    }
    
    public function getJenisAkses() {
        return $this->hasOne(\app\models\cv\TblAccess::className(), ['id' => 'access']);
    }
    
    public function getAds() {
        return $this->hasOne(\app\models\cv\TblAds::className(), ['id' => 'ads_id']);
    }
}
