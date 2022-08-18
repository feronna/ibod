<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.appointmentstatus".
 *
 * @property int $ApmtStatusCd
 * @property string $ApmtStatusNm
 * @property string $ApmtStatusCdMM
 */
class StatusLantikan extends \yii\db\ActiveRecord
{
    public $_totalCount;
    public $_totalAktif;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.appointmentstatus';
    }

    public function rules()
    {
        return [
            [['ApmtStatusCd'], 'required'],
            [['ApmtStatusCd'], 'integer'],
            [['ApmtStatusNm'], 'string', 'max' => 255],
            [['ApmtStatusCdMM'], 'string', 'max' => 20],
            [['ApmtStatusCd'], 'unique'],
            [['grpApmtStatusNm'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ApmtStatusCd' => 'Apmt Status Cd',
            'ApmtStatusNm' => 'Apmt Status Nm',
            'ApmtStatusCdMM' => 'Apmt Status Cd Mm',
        ];
    }

    public function getBiodata(){
        return $this->hasMany(Tblprcobiodata::className(), ['statLantikan' => 'ApmtStatusCd']);
    }
}
