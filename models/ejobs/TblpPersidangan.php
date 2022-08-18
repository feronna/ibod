<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_persidangan".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $PaperworkTitle
 * @property string $ConferenceTitle
 * @property string $Place
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Role
 * @property string $ConfLevel
 */
class TblpPersidangan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_persidangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'PaperworkTitle', 'ConferenceTitle', 'Place', 'StartDate', 'EndDate', 'Role', 'ConfLevel'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['PaperworkTitle', 'ConferenceTitle', 'Place'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['Role', 'ConfLevel'], 'string', 'max' => 50],
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
            'PaperworkTitle' => 'Paperwork Title',
            'ConferenceTitle' => 'Conference Title',
            'Place' => 'Place',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Role' => 'Role',
            'ConfLevel' => 'Conf Level',
        ];
    }
    
    public function Tarikh($bulan){
        
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
     
}
