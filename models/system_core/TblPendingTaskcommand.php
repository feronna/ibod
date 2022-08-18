<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_pending_taskcommand".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $command
 * @property string $added_by
 */
class TblPendingTaskcommand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_pending_taskcommand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'icon'], 'string', 'max' => 255],
            [['url', 'command'], 'string', 'max' => 500],
            [['added_by'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'command' => 'Command',
            'added_by' => 'Added By',
        ];
    }
}
