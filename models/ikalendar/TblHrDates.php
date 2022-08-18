<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.hr_dates".
 *
 * @property string $event_id
 * @property string $date
 * @property string $end_date
 * @property int $tmp_id
 */
class TblHrDates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_dates';
    }

    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["event_id"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'tmp_id'], 'integer'],
            [['date', 'end_date'], 'safe'],
            [['event_id', 'date', 'end_date'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'date' => 'Date',
            'end_date' => 'End Date',
            'tmp_id' => 'Tmp ID',
        ];
    }
}
