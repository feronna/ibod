<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.user_access".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $access
 */
class UserAccess extends \yii\db\ActiveRecord
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
        return 'ejobs.user_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'access'], 'integer'],
            [['ICNO', 'access'], 'required'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'access' => 'Access',
        ];
    }
}
