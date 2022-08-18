<?php

namespace app\models;

use Yii;
use app\models\hronline\StatusPengesahan;

/**
 * This is the model class for table "hronline.tblrscoconfirmstatus".
 *
 * @property string $ICNO
 * @property string $ConfirmStatusCd
 * @property string $ConfirmStatusStDt
 * @property string $id
 */
class TblConfirm extends \yii\db\ActiveRecord
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
        return 'hronline.tblrscoconfirmstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'ConfirmStatusCd', 'ConfirmStatusStDt'], 'required'],
            [['ConfirmStatusStDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['ConfirmStatusCd'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'ConfirmStatusCd' => 'Confirm Status Cd',
            'ConfirmStatusStDt' => 'Confirm Status St Dt',
        ];
    }
    
    public function getId() {
        return $this->ICNO;
    }
    
    public function getStatusPengesahan() {
        return $this->hasOne(StatusPengesahan::className(), ['ConfirmStatusCd' => 'ConfirmStatusCd']);
    }
    
    public function getDisplayStatusPengesahan() {
        $model = StatusPengesahan::find()->where(['ConfirmStatusCd' => $this->ConfirmStatusCd])->one();
        
        return $model->ConfirmStatusNm;
    }
    
     public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    public function getTarikhlantikantetap() {
        return  $this->getTarikh($this->ConfirmStatusStDt);
    }
    
     
}
