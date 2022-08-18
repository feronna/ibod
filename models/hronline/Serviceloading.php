<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.serviceloading".
 *
 * @property int $ServLoadCd
 * @property string $ServLoadNm
 */
class Serviceloading extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.serviceloading';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ServLoadCd'], 'required'],
            [['ServLoadCd'], 'integer'],
            [['ServLoadNm'], 'string', 'max' => 255],
            [['ServLoadCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ServLoadCd' => 'Serv Load Cd',
            'ServLoadNm' => 'Serv Load Nm',
        ];
    }
}
