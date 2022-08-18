<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\NamaBahasa;
use app\models\hronline\TahapKemahiranBahasa; 
use app\models\hronline\Tblbahasa;

class TblpBahasa extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $file ;
    
    public static function tableName()
    {
        return 'ejobs.tbl_bahasa';
    }
 
    public function rules()
    {
        return [
            [['ICNO', 'LangCd', 'LangSkillCert', 'LangSkillOral', 'LangSkillWritten'], 'required', 'message'=>'Required'],
            [['LangSkillCert'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['LangSkillOral', 'LangSkillWritten'], 'string', 'max' => 1],
            [['LangCd'], 'string', 'max' => 2],
            [['ICNO', 'LangCd'], 'unique', 'targetAttribute' => ['ICNO', 'LangCd']],
            [['FileBahasa'], 'safe'],
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'LangSkillOral' => 'Kemahiran Lisan',
            'LangCd' => 'Nama Bahasa',
            'LangSkillWritten' => 'Kemahiran Menulis',
            'LangSkillCert' => 'Status Pengiktirafan',
            'id' => 'ID',
        ];
    }
    
    public function getNamaBahasa(){
        return $this->hasOne(NamaBahasa::className(), ['LangCd' => 'LangCd']); 
    }
    
    public function getTahapKemahiranBahasaOral(){
        return $this->hasOne(TahapKemahiranBahasa::className(), ['LangProficiencyCd' => 'LangSkillOral']); 
    }
    
    public function getTahapKemahiranBahasaWritten(){
        return $this->hasOne(TahapKemahiranBahasa::className(), ['LangProficiencyCd' => 'LangSkillWritten']); 
    }
    
    public function getCertStatus() {
        if($this->LangSkillCert==1){
            return 'Ya';
        }else{
            return 'Tiada';
        }
    }
    
    public function TahapKemahiran($id) {
        if($id==1){
            return 100;
        }else if($id==2){
            return 80;
        }
        else if($id==3){
            return 40;
        }else{
            return 0;
        }
    }
    
    public function LaporDiri($ICNO) {
        $model = TblpBahasa::findAll(['ICNO'=>$ICNO]);
        $simpan = new Tblbahasa();
        
        if($model){
            foreach ($model as $model){
                $simpan->ICNO = $model->ICNO;
                $simpan->LangSkillOral = $model->LangSkillOral;
                $simpan->LangCd = $model->LangCd;
                $simpan->LangSkillWritten = $model->LangSkillWritten;
                $simpan->LangSkillCert = $model->LangSkillCert; 
                $simpan->save(false);
            }
        } 
    } 
}
