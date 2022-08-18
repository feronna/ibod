<?php

namespace app\models\vhrms;

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
class VwStaffProfile extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db4'); // MSSQL database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Vw_staff_Profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sm_staff_id','sm_ic_no'], 'string'],
        ];
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
        ];
    }
}