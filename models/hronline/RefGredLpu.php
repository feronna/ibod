<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "{{%hrm.lpu_ref_post}}".
 *
 * @property int $id
 * @property string $jawatan
 * @property string $seksyen
 */
class RefGredLpu extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.lpu_ref_post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jawatan', 'seksyen'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jawatan' => 'Jawatan',
            'seksyen' => 'Seksyen',
        ];
    }
}
