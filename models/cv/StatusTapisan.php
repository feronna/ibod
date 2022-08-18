<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_status_tapisan".
 *
 * @property int $id
 * @property int $status
 */
class StatusTapisan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_status_tapisan';
    }
    
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status','title','category'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
        ];
    }
}
