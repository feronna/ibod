<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.jobstatus".
 *
 * @property int $jobstatus_id
 * @property string $jobstatus_desc
 */
class Jobstatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.jobstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobstatus_desc'], 'required'],
            [['jobstatus_desc'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jobstatus_id' => 'Jobstatus ID',
            'jobstatus_desc' => 'Jobstatus Desc',
        ];
    }
}
