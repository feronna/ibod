<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.country".
 *
 * @property string $CountryCd
 * @property string $Country
 * @property int $StudyExtPeriod
 * @property string $CountryCdMM
 */
class Negara extends \yii\db\ActiveRecord
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
        return 'hronline.country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountryCd'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['StudyExtPeriod'], 'integer'],
            [['CountryCd'], 'string', 'max' => 3],
            [['Country'], 'string', 'max' => 255],
            [['CountryCdMM'], 'string', 'max' => 20],
            [['CountryCd'], 'unique','message'=>'Kod ini telah wujud'],
            [['isActive'],'integer','max'=>1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CountryCd' => 'Country Cd',
            'Country' => 'Country',
            'StudyExtPeriod' => 'Study Ext Period',
            'CountryCdMM' => 'Country Cd Mm',
        ];
    }
    
    public function getNegeri() {
        return $this->hasMany(Negeri::className(), ['CountryCd'=>'CountryCd']);
    }

    public function getLatestInstCd() {
        return $this->hasOne(Institut::className(), ['InstLocation'=>'CountryCd'])->orderBy(['InstCd'=>SORT_ASC]);
    }
    
    public function getStatus() {
        if($this->isActive){
            return "Aktif";
        }
        return "Tidak Aktif";
    }
    
}
