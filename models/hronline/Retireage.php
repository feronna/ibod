<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.retireage".
 *
 * @property string $RetireAgeCd
 * @property string $RetireAgeDesc
 */
class Retireage extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.retireage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RetireAgeCd', 'RetireAgeDesc', 'Name'], 'string', 'max' => 510],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'RetireAgeCd' => 'Retire Age Cd',
            'RetireAgeDesc' => 'Retire Age Desc',
        ];
    }
}
