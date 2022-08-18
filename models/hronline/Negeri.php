<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.state".
 *
 * @property string $StateCd
 * @property string $State
 * @property string $StateWeekend
 * @property string $CountryCd
 * @property string $StateCdMM
 */
class Negeri extends \yii\db\ActiveRecord
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
        return 'hronline.state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StateCd','State','CountryCd'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['StateCd'], 'string', 'max' => 2],
            [['State'], 'string', 'max' => 255],
            [['StateWeekend'], 'string', 'max' => 1],
            [['CountryCd'], 'string', 'max' => 4],
            [['StateCdMM'], 'string', 'max' => 20],
            [['StateCd'], 'unique'],
            [['isActive'],'integer','max'=>1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'StateCd' => 'State Cd',
            'State' => 'State',
            'StateWeekend' => 'State Weekend',
            'CountryCd' => 'Country Cd',
            'StateCdMM' => 'State Cd Mm',
        ];
    }
    
    public static function dropdown() {   
        static $dropdown;
        if($dropdown === null){
            $models = static::find()->all();
            foreach ($models as $model){
                $dropdown[$model->StateCd] = $model->State;
            }
        }
        return $dropdown;
    }
    
    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd'=>'CountryCd']);
    }
    
    public function getStatus() {
        if($this->isActive){
            return "Aktif";
        }
        return "Tidak Aktif";
    }
}
