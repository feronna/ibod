<?php

namespace app\models\notifications;

use Yii;

/**
 * This is the model class for table "dbo.VaccinationAppointment".
 *
 * @property string $name
 * @property string $icno
 * @property int $age
 * @property int $sex
 * @property string $phoneNo
 * @property string $state
 * @property string $district
 * @property string $facilityCode1
 * @property string $vacLocation1
 * @property string $vacDate1
 * @property string $vacTime1
 * @property string $facilityCode2
 * @property string $vacLocation2
 * @property string $vacDate2
 * @property string $vacTime2
 * @property string $timestamp
 * @property string $setBy
 * @property string $status
 */
class TblVaccinationAppointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.VaccinationAppointment';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db12');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['age', 'sex'], 'integer'],
            [['vacDate1', 'vacDate2'], 'safe'],
            [['name', 'vacLocation1', 'vacLocation2'], 'string', 'max' => 250],
            [['icno', 'phoneNo', 'state', 'facilityCode1', 'vacTime1', 'facilityCode2', 'vacTime2', 'timestamp', 'status'], 'string', 'max' => 50],
            [['district', 'setBy'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'icno' => 'Icno',
            'age' => 'Age',
            'sex' => 'Sex',
            'phoneNo' => 'Phone No',
            'state' => 'State',
            'district' => 'District',
            'facilityCode1' => 'Facility Code1',
            'vacLocation1' => 'Vac Location1',
            'vacDate1' => 'Vac Date1',
            'vacTime1' => 'Vac Time1',
            'facilityCode2' => 'Facility Code2',
            'vacLocation2' => 'Vac Location2',
            'vacDate2' => 'Vac Date2',
            'vacTime2' => 'Vac Time2',
            'timestamp' => 'Timestamp',
            'setBy' => 'Set By',
            'status' => 'Status',
        ];
    }
}
