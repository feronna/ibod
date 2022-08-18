<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.status_permohonan".
 *
 * @property int $id
 * @property string $name
 * @property string $status_desc
 * @property string $label
 */
class StatusMarkah extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.status_markah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'label'], 'required'], 
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
            'label' => 'Label',
        ];
    } 
}
