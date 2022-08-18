<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.familystatus".
 *
 * @property string $FmyStatusCd
 * @property string $FmyStatus
 */
class StatusPekerjaanAhliKeluarga extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.familystatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FmyStatusCd'], 'required'],
            [['FmyStatusCd'], 'string', 'max' => 2],
            [['FmyStatus'], 'string', 'max' => 255],
            [['FmyStatusCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FmyStatusCd' => 'Fmy Status Cd',
            'FmyStatus' => 'Fmy Status',
        ];
    }
}
