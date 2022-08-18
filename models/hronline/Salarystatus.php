<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.salarystatus".
 *
 * @property int $id
 * @property string $name
 * @property string $otherCd
 */
class Salarystatus extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.salarystatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
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
