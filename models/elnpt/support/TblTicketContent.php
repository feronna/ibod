<?php

namespace app\models\elnpt\support;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_ticket_content".
 *
 * @property int $id
 * @property int $ticket_id
 * @property string $title
 * @property string $content
 * @property string $filename
 * @property string $filehash
 * @property string $ICNO
 * @property string $created_at
 * @property string $updated_at
 */
class TblTicketContent extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_ticket_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['filename'], 'string', 'max' => 1000],
            [['filehash'], 'string', 'max' => 150],
            [['ICNO'], 'string', 'max' => 12],
            [['file'], 'file', 'extensions' => ['jpg', 'png'], 'maxSize' => 1024 * 1024 * 5],
            [['title', 'content', 'created_at', 'ICNO'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'title' => 'Title',
            'content' => 'Content',
            'filename' => 'Filename',
            'filehash' => 'Filehash',
            'ICNO' => 'Icno',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
