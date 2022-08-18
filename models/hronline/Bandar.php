<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Negeri;

/**
 * This is the model class for table "hronline.city".
 *
 * @property string $CityCd
 * @property string $City
 * @property string $StateCd
 * @property string $DistrictCd
 */
class Bandar extends \yii\db\ActiveRecord
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
        return 'hronline.city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CityCd','City','StateCd'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['CityCd'], 'string', 'max' => 6],
            [['City'], 'string', 'max' => 255],
            [['StateCd', 'DistrictCd'], 'string', 'max' => 4],
            [['CityCd'], 'unique'],
            [['isActive'],'integer','max'=>1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CityCd' => 'City Cd',
            'City' => 'City',
            'StateCd' => 'State Cd',
            'DistrictCd' => 'District Cd',
        ];
    }
    
    public function getNegeri() {
        $kodnegeri = $this->StateCd;
         $negeri = Negeri::find()->select('State')->where(['StateCd'=>$kodnegeri])->asArray()->one();
         
         return $negeri = $negeri['State']; 
    }
    
    public function getStatus() {
        if($this->isActive){
            return "Aktif";
        }
        return "Tidak Aktif";
    }
}
