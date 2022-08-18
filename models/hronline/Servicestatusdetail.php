<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.servicestatusdetail".
 *
 * @property int $id
 * @property string $name
 * @property int $ServStatusCd
 */
class Servicestatusdetail extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.servicestatusdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'ServStatusCd'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'ServStatusCd' => 'Serv Status Cd',
        ];
    }
}
