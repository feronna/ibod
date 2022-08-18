<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.tblsysemailqueue}}".
 *
 * @property int $id
 * @property string $from_name
 * @property string $from_email
 * @property string $to_name
 * @property string $to_email
 * @property string $subject
 * @property string $message
 * @property int $max_attempts
 * @property int $attempts bilangan percubaan
 * @property int $success 0=default,1=success
 * @property string $date_published tarikh masuk table
 * @property string $last_attempt tarikh percubaan
 * @property string $date_sent tarikh berjaya sent
 */
class Tblsysemailqueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%myidp.tblsysemailqueue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['max_attempts', 'attempts', 'success'], 'integer'],
            [['date_published', 'last_attempt', 'date_sent'], 'safe'],
            [['from_name', 'to_name'], 'string', 'max' => 300],
            [['from_email', 'to_email'], 'string', 'max' => 450],
            [['subject'], 'string', 'max' => 765],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_name' => 'From Name',
            'from_email' => 'From Email',
            'to_name' => 'To Name',
            'to_email' => 'To Email',
            'subject' => 'Subject',
            'message' => 'Message',
            'max_attempts' => 'Max Attempts',
            'attempts' => 'Attempts',
            'success' => 'Success',
            'date_published' => 'Date Published',
            'last_attempt' => 'Last Attempt',
            'date_sent' => 'Date Sent',
        ];
    }
}
