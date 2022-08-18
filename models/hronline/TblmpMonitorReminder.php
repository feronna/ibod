<?php

namespace app\models\hronline;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "hronline.tblmp_monitor_reminder".
 *
 * @property int $id
 * @property int $mp_type 1=paspot;2=permit
 * @property string $icno
 * @property string $name
 * @property string $entry_dt date first keyin in this table
 * @property int $reminder_type 0=no noty sent;1=no valid data;2=no data at all
 * @property int $reminder_counter how often user receive notification
 * @property int $reminder_status 0=inactive;1=active
 * @property string $alter_dt date of any changes
 */

class TblmpMonitorReminder extends \yii\db\ActiveRecord
{

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.tblmp_monitor_reminder';
    }

    public function rules()
    {
        return [
            [['mp_type', 'icno'], 'required'],
            [['mp_type', 'reminder_type', 'reminder_counter', 'reminder_status'], 'integer'],
            [['entry_dt', 'alter_dt', 'mp_effective_dt', 'mp_expiry_dt'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 255],
            [['reminder_reason','reminder_title'], 'string', 'max' => 1000],
            [['from+_action'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mp_type' => 'Mp Type',
            'icno' => 'Icno',
            'name' => 'Name',
            'entry_dt' => 'Entry Dt',
            'reminder_type' => 'Reminder Type',
            'reminder_counter' => 'Reminder Counter',
            'reminder_status' => 'Reminder Status',
            'alter_dt' => 'Alter Dt',
            'mp_effective_dt' => 'mp_effective_dt',
            'mp_expiry_dt' => 'mp_expiry_dt',
        ];
    }

}
