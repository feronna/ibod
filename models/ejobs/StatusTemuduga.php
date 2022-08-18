<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.status_temuduga".
 *
 * @property int $id
 * @property string $name
 * @property string $status_desc
 * @property string $label
 */
class StatusTemuduga extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.status_iv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'status_desc', 'label'], 'required'],
            [['id'], 'integer'],
            [['status_desc'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['label'], 'string', 'max' => 20],
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
            'status_desc' => 'Status Desc',
            'label' => 'Label',
        ];
    }
}
