<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
/**
 * This is the model class for table "hronline.umsper".
 *
 * @property int $Id
 * @property string $ICNO
 * @property int $JobId
 * @property int $DeptId
 * @property int $campus_id
 * @property string $COOldID
 * @property string $StartDate
 * @property string $COOldIDDt
 * @property string $COOldIDNo
 */
class Umsper extends \yii\db\ActiveRecord
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
        return 'hronline.umsper';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JobId', 'DeptId', 'campus_id'], 'integer'],
            [['StartDate'], 'safe'],
            [['ICNO', 'COOldID'], 'string', 'max' => 12],
            [['COOldIDDt'], 'string', 'max' => 6],
            [['COOldIDNo'], 'string', 'max' => 5],
            [['JobId', 'DeptId', 'campus_id','ICNO', 'COOldID','COOldIDNo','COOldIDDt'], 'required', 'on' => 'baru'],
            [['ICNO'], 'required', 'on' => 'test'],
            [['COOldIDNo'],'unique', 'when' => function($model){     
                return self::notSamePerson($model->COOldIDNo, $model->ICNO);
            }, 'on' => 'baru'],
            [['JobId', 'DeptId', 'campus_id','ICNO', 'COOldID','COOldIDNo','COOldIDDt'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'ICNO' => 'Icno',
            'JobId' => 'Job ID',
            'DeptId' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'COOldID' => 'Co Old ID',
            'StartDate' => 'Start Date',
            'COOldIDDt' => 'Co Old Id Dt',
            'COOldIDNo' => 'Co Old Id No',
        ];
    }

    private function notSamePerson($COOldIDNo, $ICNO){
        if(self::find()->where(['COOldIDNo' => $COOldIDNo])->exists()){
            if ($ICNO != self::find()->where(['COOldIDNo' => $COOldIDNo])->one()->ICNO){
                return true;
            }
        }
        return false;
    }
    
         public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
       public function getKakitangans() {
        return $this->hasOne(Tblkeluarga::className(), ['FamilyId' => 'ICNO'])->where(['RelCd' => [02, 01]]);
    }

}
