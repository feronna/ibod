<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.accountname".
 *
 * @property string $AccNmCd
 * @property string $AccNm
 * @property string $AccDesc
 * @property string $ActiveStatusInd
 */
class NamaAkaun extends \yii\db\ActiveRecord
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
        return 'hronline.accountname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AccNmCd'], 'required'],
            [['AccNmCd'], 'string', 'max' => 4],
            [['AccNm', 'AccDesc', 'ActiveStatusInd'], 'string', 'max' => 255],
            [['AccNmCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AccNmCd' => 'Acc Nm Cd',
            'AccNm' => 'Acc Nm',
            'AccDesc' => 'Acc Desc',
            'ActiveStatusInd' => 'Active Status Ind',
        ];
    }
}
