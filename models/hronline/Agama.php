<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.religion".
 *
 * @property string $ReligionCd
 * @property string $Religion
 * @property string $ReligionCdMM
 */
class Agama extends \yii\db\ActiveRecord
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
        return 'hronline.religion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ReligionCd','Religion'], 'required'],
            [['ReligionCd'], 'string', 'max' => 2],
            [['Religion'], 'string', 'max' => 255],
            [['ReligionCdMM'], 'string', 'max' => 20],
            [['ReligionCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ReligionCd' => 'Religion Cd',
            'Religion' => 'Religion',
            'ReligionCdMM' => 'Religion Cd Mm',
            'isActive' => 'Status',
        ];
    }
}
