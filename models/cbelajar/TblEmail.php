<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.stc_tbl_email_record".
 *
 * @property int $id
 * @property string $from_name
 * @property string $from_email
 * @property string $to_name
 * @property string $to_email
 * @property string $subject
 * @property string $message
 * @property int $success 0=default,1=success
 * @property string $date_published tarikh masuk table
 */
class TblEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_email_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['success'], 'integer'],
            [['date_published'], 'safe'],
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
            'success' => 'Success',
            'date_published' => 'Date Published',
        ];
    }
}
