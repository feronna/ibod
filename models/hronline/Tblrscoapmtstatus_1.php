<?php

namespace app\models\hronline;

use Yii;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
/**
 * This is the model class for table "hronline.tblrscoapmtstatus".
 *
 * @property string $ICNO
 * @property int $ApmtStatusCd
 * @property string $ApmtStatusStDt
 * @property string $ApmtStatusEndDt
 * @property int $id
 */
class Tblrscoapmtstatus_1 extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblrscoapmtstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'ApmtStatusCd', 'ApmtStatusStDt'], 'required'],
            [['ApmtStatusCd'], 'integer'],
            [['ApmtStatusStDt', 'ApmtStatusEndDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'ApmtStatusCd' => 'Apmt Status Cd',
            'ApmtStatusStDt' => 'Apmt Status St Dt',
            'ApmtStatusEndDt' => 'Apmt Status End Dt',
            'id' => 'ID',
        ];
    }

    
}
