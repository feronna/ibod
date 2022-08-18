<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.licenseclass".
 *
 * @property string $LicClassCd
 * @property string $LicClass
 */
class KelasLesen extends \yii\db\ActiveRecord
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
        return 'hronline.licenseclass';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LicClassCd'], 'required'],
            [['LicClassCd'], 'string', 'max' => 3],
            [['LicClass'], 'string', 'max' => 255],
            [['LicClassCd'], 'unique'],
            [['LicStickerType'], 'safe'], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LicClassCd' => 'Lic Class Cd',
            'LicClass' => 'Lic Class',
        ];
    }
}
