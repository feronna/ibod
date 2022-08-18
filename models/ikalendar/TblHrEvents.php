<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.hr_events".
 *
 * @property string $event_id
 * @property string $title
 * @property int $venue_id
 * @property string $venue
 * @property string $contact_id
 * @property string $contact
 * @property string $description
 * @property string $category_id
 * @property string $user_id
 * @property string $group_id
 * @property string $status_id
 * @property string $stamp
 * @property string $quick_approve
 * @property int $status
 * @property int $status_awal
 * @property int $Rancang
 * @property int $kpi_id
 * @property string $tarikh_tunda
 * @property int $rasmi 0=Tidak Rasmi,1=Rasmi
 * @property int $semua_staf_terlibat 0=Tidak,1=Semua Terlibat
 * @property int $tmp_id
 * @property string $date_rancang
 */
class TblHrEvents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['venue_id', 'contact_id', 'category_id', 'user_id', 'group_id', 'status_id', 'status', 'status_awal', 'Rancang', 'kpi_id', 'rasmi', 'semua_staf_terlibat', 'tmp_id'], 'integer'],
            [['description'], 'string'],
            [['stamp', 'tarikh_tunda', 'date_rancang'], 'safe'],
            [[
                'status_awal', 'Rancang', 'tarikh_tunda', 'title', 'rasmi', 'group_id', 'category_id',
                // 'venue', 'contact',
                'status'
            ], 'required'],
            [['title', 'venue', 'contact'], 'string', 'max' => 255],
            [['quick_approve'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'title' => 'Title',
            'venue_id' => 'Venue ID',
            'venue' => 'Venue',
            'contact_id' => 'Contact ID',
            'contact' => 'Contact',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
            'status_id' => 'Status ID',
            'stamp' => 'Stamp',
            'quick_approve' => 'Quick Approve',
            'status' => 'Status',
            'status_awal' => 'Status Awal',
            'Rancang' => 'Rancang',
            'kpi_id' => 'Kpi ID',
            'tarikh_tunda' => 'Tarikh Tunda',
            'rasmi' => 'Rasmi',
            'semua_staf_terlibat' => 'Semua Staf Terlibat',
            'tmp_id' => 'Tmp ID',
            'date_rancang' => 'Date Rancang',
        ];
    }

    public function getEventDate()
    {
        return $this->hasOne(TblHrDates::className(), ['event_id' => 'event_id']);
    }

    public function getEventCat()
    {
        return $this->hasOne(RefHrCategories::className(), ['category_id' => 'category_id']);
    }

    public function getEventStat()
    {
        return $this->hasOne(TblHrStatus::className(), ['stats_id' => 'status']);
    }
}
