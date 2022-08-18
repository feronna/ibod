<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_pnl_output".
 *
 * @property int $id
 * @property string $output
 * @property int $sort
 */
class RefPanelType extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_pnl_output';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['output'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'output' => 'Output',
            'sort' => 'Sort',
        ];
    }
}
