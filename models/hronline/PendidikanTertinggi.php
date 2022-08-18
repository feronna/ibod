<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.educationallevel".
 *
 * @property int $HighestEduLevelCd
 * @property string $HighestEduLevel
 * @property string $HighestEduLevelBI
 * @property string $HighestEduLevelInd
 * @property string $EduLevelNm
 * @property string $EduLevelNmBI
 * @property int $HighestEduLevelRank
 * @property string $HighestEduLevelCdMM
 */
class PendidikanTertinggi extends \yii\db\ActiveRecord
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
        return 'hronline.educationallevel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HighestEduLevelCd'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['HighestEduLevelCd', 'HighestEduLevelRank'], 'integer'],
            [['HighestEduLevel', 'HighestEduLevelBI', 'EduLevelNm', 'EduLevelNmBI'], 'string', 'max' => 255],
            [['HighestEduLevelInd'], 'string', 'max' => 6],
            [['HighestEduLevelCdMM'], 'string', 'max' => 20],
            [['HighestEduLevelCd'], 'unique'],
            [['newEduRank'],'integer'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'HighestEduLevel' => 'Highest Edu Level',
            'HighestEduLevelBI' => 'Highest Edu Level Bi',
            'HighestEduLevelInd' => 'Highest Edu Level Ind',
            'EduLevelNm' => 'Edu Level Nm',
            'EduLevelNmBI' => 'Edu Level Nm Bi',
            'HighestEduLevelRank' => 'Highest Edu Level Rank',
            'HighestEduLevelCdMM' => 'Highest Edu Level Cd Mm',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak Aktif";
    }
}
