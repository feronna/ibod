<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.movemonth".
 *
 * @property string $id
 * @property string $name
 * @property string $otherCd
 */
class Movemonth extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.movemonth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
            [['otherCd'], 'string', 'max' => 10],
            [['id'], 'unique'],
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
            'otherCd' => 'Other Cd',
        ];
    }
}
