<?php

namespace app\models\ejobs;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Kampus;
use Yii;

/**
 * This is the model class for table "ejobs.tbl_lain2".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $status_merantau
 * @property int $status_berpindah 
 * @property string $exp_gaji
 * @property string $tarikh_mula_bekerja
 */
class TblpLain2 extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $cawangan = [];
    public $taraf_jawatan = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_lain2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cawangan','taraf_jawatan','ICNO', 'status_merantau', 'status_berpindah', 'exp_gaji', 'tarikh_mula_bekerja'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['status_merantau', 'status_berpindah'], 'integer'],
            [['exp_gaji'], 'number'],
            [['tarikh_mula_bekerja'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
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
            'status_merantau' => 'Status Merantau',
            'status_berpindah' => 'Status Berpindah', 
            'exp_gaji' => 'Exp Gaji',
            'tarikh_mula_bekerja' => 'Tarikh Mula Bekerja',
        ];
    }
    
     public function Status($id) {
        if($id==1){
            return 'Ya';
        }else{
            return 'Tiada';
        }
    }
    
    public function TarafJawatan($id){
        $model = StatusLantikan::findOne(['ApmtStatusCd' => $id]);
        
        return $model->ApmtStatusNm;
    }
    
    public function Cawangan($id){
        $model = Kampus::findOne(['campus_id' => $id]);
        
        return $model->campus_name;
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
