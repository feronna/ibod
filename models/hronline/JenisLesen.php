<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.license".
 *
 * @property string $LicCd
 * @property string $LicType
 */
class JenisLesen extends \yii\db\ActiveRecord
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
        return 'hronline.license';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LicCd'], 'required'],
            [['LicCd'], 'string', 'max' => 2],
            [['LicType'], 'string', 'max' => 255],
            [['LicCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LicCd' => 'Lic Cd',
            'LicType' => 'Lic Type',
        ];
    }
}
