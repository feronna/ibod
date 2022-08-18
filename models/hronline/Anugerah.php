<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.award".
 *
 * @property string $AwdCd
 * @property string $Awd
 * @property string $AwdCatCd
 * @property string $AwdAbrv
 * @property string $AwdTitleP
 * @property string $AwdTitleL
 * @property string $AwdTitleW
 */
class Anugerah extends \yii\db\ActiveRecord
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
        return 'hronline.award';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AwdCd','Awd'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['StateCd'], 'safe'],
            [['AwdCd'], 'string', 'max' => 7],
            [['Awd'], 'string', 'max' => 255],
            [['AwdCatCd'], 'string', 'max' => 2],
            [['AwdAbrv'], 'string', 'max' => 100],
            [['AwdTitleP', 'AwdTitleL', 'AwdTitleW'], 'string', 'max' => 4],
            [['AwdCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AwdCd' => 'Awd Cd',
            'Awd' => 'Awd',
            'AwdCatCd' => 'Awd Cat Cd',
            'AwdAbrv' => 'Awd Abrv',
            'AwdTitleP' => 'Awd Title P',
            'AwdTitleL' => 'Awd Title L',
            'AwdTitleW' => 'Awd Title W',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
    
}
