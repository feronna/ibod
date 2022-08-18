<?php

namespace app\models\klinikpanel;

use Yii;

/**
 * This is the model class for table "klinikpanel2.medicine".
 *
 * @property int $med_id
 * @property string $medCd
 * @property string $medNm
 * @property string $medPrice
 * @property string $medUnit
 * @property int $med_klinik_id
 * @property string $kegunaan
 */
class RefMedicine extends \yii\db\ActiveRecord
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
        return 'hrm.myhealth_medicine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medPrice'], 'number'],
            [['med_klinik_id'], 'integer'],
            [['medCd', 'medNm', 'kegunaan'], 'string', 'max' => 255],
            [['medUnit'], 'string', 'max' => 155],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'med_id' => 'Med ID',
            'medCd' => 'Med Cd',
            'medNm' => 'Med Nm',
            'medPrice' => 'Med Price',
            'medUnit' => 'Med Unit',
            'med_klinik_id' => 'Med Klinik ID',
            'kegunaan' => 'Kegunaan',
        ];
    }
    
//    public function getNamaUbat()
//    {
//        return $this->hasOne(Tblmedicine::className(), ['tbl_med_id' => 'med_id']);
//    }
}
