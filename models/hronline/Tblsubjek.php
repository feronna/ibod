<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Gred;
use app\models\hronline\Subjek;
use app\models\hronline\Tblpendidikan;

/**
 * This is the model class for table "hronline.tblsubject".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $EduLevel_id
 * @property int $Subject_id
 * @property int $Grade_id
 */
class Tblsubjek extends \yii\db\ActiveRecord
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
        return 'hronline.tblsubject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EduLevel_id', 'Subject_id', 'Grade_id'], 'integer'],
            [['Subject_id', 'Grade_id'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['ICNO'], 'string', 'max' => 12],
            [['ICNO','EduLevel_id','Subject_id'],'unique','targetAttribute'=>['ICNO','EduLevel_id','Subject_id'],'message'=>'Subjek telah wujud'],
            [['Edu_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'EduLevel_id' => 'Edu Level ID',
            'Subject_id' => 'Subject ID',
            'Grade_id' => 'Grade ID',
        ];
    }
    
    public function getGrade() {
        return $this->hasOne(gred::className(), ['id'=>'Grade_id']);
    }
    public function getSubject() {
        return $this->hasOne(subjek::className(), ['id'=>'Subject_id']);
    }
    public function getPendidikan() {
        return $this->hasMany(Tblpendidikan::className(), ['id'=>'Edu_id']);
    }
    public function getGred() {
        if($this->grade){
            return $this->grade->grade;
        }
        return '-';
    }
    public function getSubjek() {
        if($this->subject){
            return $this->subject->EduSubjek;
        }
        return '-';
    }
     
    
}
