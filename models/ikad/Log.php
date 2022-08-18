<?php

namespace app\models\ikad;

use Yii;

/**
 * This is the model class for table "ikad.ikad_log".
 *
 * @property int $id
 * @property int $mohon_id ref to tbl_mohon
 * @property string $icno session_id
 * @property string $action action taken exm:apply,approve
 * @property string $datetime date action taken
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.ikad_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mohon_id'], 'integer'],
            [['action'], 'string'],
            [['datetime'], 'safe'],
            [['icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mohon_id' => 'Mohon ID',
            'icno' => 'Icno',
            'action' => 'Action',
            'datetime' => 'Datetime',
        ];
    }
}
