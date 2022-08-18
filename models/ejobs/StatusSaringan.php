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
class StatusSaringan extends \yii\db\ActiveRecord
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
        return 'ejobs.status_saringan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['name', 'status_desc', 'label'], 'required'],
            [['status_desc'], 'string'],
            [['name'], 'string', 'max' => 50], 
            [['status_for'], 'safe'],
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
        ];
    }
}