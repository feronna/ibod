<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.status_iv_kehadiran".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property string $label
 */
class KehadiranTemuduga extends \yii\db\ActiveRecord
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
        return 'ejobs.status_iv_kehadiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['desc'], 'string'],
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
            'desc' => 'Desc',
            'label' => 'Label',
        ];
    }
}
