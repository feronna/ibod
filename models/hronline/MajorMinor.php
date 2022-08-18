<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.majorminor".
 *
 * @property string $MajorMinorCd
 * @property string $MajorMinor
 * @property string $MajorMinorStDt
 * @property string $MajorMinorEndDt
 */
class MajorMinor extends \yii\db\ActiveRecord
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
        return 'hronline.majorminor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MajorMinorCd'], 'required'],
            [['MajorMinorCd'], 'string', 'max' => 6],
            [['MajorMinor', 'MajorMinorStDt', 'MajorMinorEndDt'], 'string', 'max' => 255],
            [['MajorMinorCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MajorMinorCd' => 'Major Minor Cd',
            'MajorMinor' => 'Major Minor',
            'MajorMinorStDt' => 'Major Minor St Dt',
            'MajorMinorEndDt' => 'Major Minor End Dt',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
