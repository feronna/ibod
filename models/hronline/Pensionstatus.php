<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.pensionstatus".
 *
 * @property string $PsnStatusCd
 * @property string $PsnStatusNm
 */
class Pensionstatus extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.pensionstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PsnStatusCd'], 'required'],
            [['PsnStatusCd'], 'string', 'max' => 6],
            [['PsnStatusNm'], 'string', 'max' => 255],
            [['PsnStatusCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PsnStatusCd' => 'Psn Status Cd',
            'PsnStatusNm' => 'Psn Status Nm',
        ];
    }
}
