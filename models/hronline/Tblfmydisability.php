<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\JenisKecacatan;
use app\models\hronline\PuncaKecacatan;
use app\models\hronline\Tblkeluarga;
/**
 * This is the model class for table "hronline.tblfmydisability".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $DisabilityTypeCd
 * @property string $DisabilityCauseCd
 * @property string $DisabilityDt
 * @property string $AccidentDt
 * @property string $HealDt
 * @property string $SocialWelfareNo
 * @property string $DrRptNo
 * @property string $filename
 */
class Tblfmydisability extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblfmydisability';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ConferredDt'], 'safe'],
            [['updater'], 'string','max'=>12],
            [['DisabilityTypeCd',], 'string', 'max' => 2],
            [['SocialWelfareNo', 'DrRptNo'], 'string', 'max' => 20],
            [['filename'], 'string', 'max' => 100],
            [['tblfmy_id', 'SocialWelfareNo','DisabilityTypeCd', ], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['deleted'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tblfmy_id' => 'tblfmy id',
            'DisabilityTypeCd' => 'Disability Type Cd',
            'DisabilityCauseCd' => 'Disability Cause Cd',
            'DisabilityDt' => 'Disability Dt',
            'HealDt' => 'Heal Dt',
            'SocialWelfareNo' => 'Social Welfare No',
            'DrRptNo' => 'Dr Rpt No',
            'filename' => 'Filename',
        ];
    }

    public function getJenisKecacatan() {
        return $this->hasOne(JenisKecacatan::className(), ['DisabilityTypeCd'=>'DisabilityTypeCd']);
    }
    
     public function getPuncaKecacatan() {
        return $this->hasOne(PuncaKecacatan::className(), ['DisabilityCauseCd'=>'DisabilityCauseCd']);
    }

    public function getKeluarga(){
        return $this->hasOne(Tblkeluarga::className(), ['id'=>'tblfmy_id']);
    }
    
    public function getJenkecacatan() {
        if($this->jenisKecacatan){
            return $this->jenisKecacatan->DisabilityType;
        }
        return '-';
    }

    public function getSocialwelfareno(){
        if ($this->SocialWelfareNo) {
            return $this->SocialWelfareNo;
        }
        return '-';
    }

    public function getDrrptno(){
        if ($this->DrRptNo) {
            return $this->DrRptNo;
        }
        return '-';
    }

    
    public function getPunkecacatan() {
        if($this->puncaKecacatan){
            return $this->puncaKecacatan->DisabilityCause;
        }
        return '-';
    }
    public function getTarikhkad() {
        if($this->ConferredDt){
            return Yii::$app->MP->Tarikh($this->ConferredDt);   
        }
        return '-';
    }
    public function getDisplayLink() {
        if(!empty($this->filename) && $this->filename != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename));
        }
        return 'File not exist!';
    }

    public function DeleteAllKU($id){
        $model = self::find()->where(['tblfmy_id'=>$id])->all();
        if ($model) {
            foreach ($model as $models) {
                $res = Yii::$app->FileManager->DeleteFile($models->filename);
                if ($res->status == true) {
                    $models->delete();
                }else{
                    $models->deleted = 1;
                    $models->save();
                }
            }
        }
        
        return 0;
    }

    public function DeleteOneKU($id){

        $model = self::find()->where(['id'=>$id])->one();
        $tblfmy_id = $model->tblfmy_id;
        $val = true;
        if ($model) {
            $val = false;
            if(self::DeleteFile($id)){
                $model->delete();
                $val = true;
            }
        }
        
        return array('val'=>$val,'tblfmy_id'=>$tblfmy_id);
    }

    public function DeleteFile($id){
        $model = self::find()->where(['id'=>$id])->one();
        $tblfmy_id = $model->tblfmy_id;

        if ($model) {
            $val = false;
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if ($res->status == true) {
                $val = true;
            }
        }

        return $val;
    }


}
