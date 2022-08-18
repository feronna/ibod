<?php

namespace app\models;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "vEAttendance".
 *
 * @property int $StaffID
 * @property int $ActivityID
 * @property string $ICNo
 * @property string $NoPer
 * @property string $StaffName
 * @property string $ApprovedDate
 * @property string $Name
 * @property string $OutstationDateTimeStart
 * @property string $OutstationDateTimeEnd
 * @property int $Status
 * @property string $StatusShtName
 * @property string $StatusLgName
 */
class KeluarPejabat extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db3'); // MSSQL database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vEAttendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StaffID'], 'required'],
            [['StaffID', 'ActivityID', 'Status'], 'integer'],
            [['ICNo', 'NoPer', 'StaffName', 'Name', 'StatusShtName', 'StatusLgName'], 'string'],
            [['ApprovedDate','AppliedDate','DateSubmitted', 'OutstationDateTimeStart', 'OutstationDateTimeEnd'], 'safe'],
        ];
    }
    
    public function getProfil() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNo' => 'ICNO']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'StaffID' => 'Staff ID',
            'ActivityID' => 'Activity ID',
            'ICNo' => 'Icno',
            'NoPer' => 'No Per',
            'StaffName' => 'Staff Name',
            'ApprovedDate' => 'Approved Date',
            'Name' => 'Name',
            'OutstationDateTimeStart' => 'Outstation Date Time Start',
            'OutstationDateTimeEnd' => 'Outstation Date Time End',
            'Status' => 'Status',
            'StatusShtName' => 'Status Sht Name',
            'StatusLgName' => 'Status Lg Name',
            'AppliedDate' => 'Tarikh Mohon',
            'DateSubmitted' => 'Tarikh Hantar',
        ];
    }
}
