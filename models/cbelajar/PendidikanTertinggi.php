<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.educationallevel".
 *
 * @property int $HighestEduLevelCd
 * @property string $HighestEduLevel
 * @property int $isActive
 */
class PendidikanTertinggi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbelajar.educationallevel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HighestEduLevelCd'], 'required'],
            [['HighestEduLevelCd', 'isActive'], 'integer'],
            [['HighestEduLevel'], 'string', 'max' => 255],
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
            'isActive' => 'Is Active',
        ];
    }
    
    
    
    
}
