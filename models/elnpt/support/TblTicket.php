<?php

namespace app\models\elnpt\support;

use app\models\elnpt\TblMain;
use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_ticket".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $category_id
 * @property string $title
 * @property int $status
 * @property int $priority
 * @property string $created_at
 */
class TblTicket extends \yii\db\ActiveRecord
{
    const PRIORITY_LOW = 0;
    const PRIORITY_MIDDLE = 10;
    const PRIORITY_HIGH = 20;

    const STATUS_OPEN = 0;
    const STATUS_WAITING = 10;
    const STATUS_CLOSED = 100;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'title', 'category_id', 'status', 'priority', 'created_at'], 'required'],
            [['lpp_id', 'category_id', 'status', 'priority'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            // ['status', 'default', 'value' => 0],
            // [['priority'], 'default', 'value' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'category_id' => 'Category',
            'title' => 'Title',
            'status' => 'Status',
            'priority' => 'Priority',
            'created_at' => 'Created At',
        ];
    }

    public function getBorang()
    {
        return $this->hasOne(TblMain::className(), ['lpp_id' => 'lpp_id']);
    }

    public function ticketStatus()
    {
        switch ($this->status) {
            case 0:
                return '<span class="label label-primary">OPEN</span>';
                break;
            case 10:
                return '<span class="label label-warning">WAITING</span>';
                break;
            case 100:
                return '<span class="label label-success">CLOSED</span>';
                break;
            default:
                return '<span class="label label-danger">ERROR</span>';
        }
    }

    public function ticketCategory()
    {
        switch ($this->category_id) {
            case 1:
                return 'Bug';
                break;
            case 2:
                return 'Feature Request';
                break;
            case 3:
                return 'General';
                break;
            case 4:
                return 'How To>';
                break;
            case 5:
                return 'Technical Issue';
                break;
            default:
                return 'Error';
        }
    }

    public function ticketPriority()
    {
        switch ($this->priority) {
            case 0:
                return '<span class="label label-primary"<strong>LOW</span>';
                break;
            case 10:
                return '<span class="label label-info"<strong>MIDDLE</span>';
                break;
            case 100:
                return '<span class="label label-warning"<strong>HIGH</span>';
                break;
            default:
                return '<span class="label label-danger"<strong>ERROR</span>';
        }
    }

    public function formName()
    {
        return '';
    }
}
