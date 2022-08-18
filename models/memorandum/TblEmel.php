<?php

namespace app\models\memorandum;

use Yii;

/**
 * This is the model class for table "utilities.memo_tbl_emel".
 *
 * @property int $id
 * @property string $from_name
 * @property string $from_email
 * @property string $to_name
 * @property string $to_email
 * @property string $subject
 * @property string $message
 * @property int $success
 * @property string $date_published
 */
class TblEmel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_emel';
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
            [['from_name', 'from_email', 'to_name', 'to_email', 'subject'], 'string', 'max' => 255],
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
