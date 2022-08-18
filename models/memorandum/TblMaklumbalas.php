<?php

namespace app\models\memorandum;
use app\models\hronline\Tblprcobiodata;
use Yii;
use app\models\memorandum\TblRekod;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\hronline\Department;
/**
 * This is the model class for table "utilities.memo_tbl_maklumbalas".
 *
 * @property int $id
 * @property string $maklumbalas
 */
class TblMaklumbalas extends \yii\db\ActiveRecord
{
    
    public $file;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_maklumbalas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maklumbalas'], 'string'],
            [['doc_name', 'title'], 'string', 'max' => 255],
            [['hashcode'], 'string', 'max' => 150],
            [['file'], 'file', 'maxSize' => 2000 * 1024, 'tooBig' => 'File Limit is 2MB only'],
            [['id_rekod'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maklumbalas' => 'Maklumbalas',
        ];
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
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y H:i:s A");
    }
    
    
       public function getTarikhMaklumbalas() {
        return  $this->getTarikh($this->tarikh_maklumbalas);
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
      public function getTblRekod() {
        return $this->hasOne(TblRekod::className(), ['id' => 'id_rekod']);
    }
        public function TugasUtama($id){
            
        $model = TblMaklumbalas::find()->where(['id_rekod'=>$id])->all();
        $a = '';
        foreach ($model as $model){
             
           $a .= ucwords(strtolower($model->maklumbalas)); 
         
        }
        
        return $a;
    }
    
         public function MaklumbalasJpu($id){
        $model = TblMaklumbalas::find()->where(['id_perkara'=>$id])->all();
        $a = '';
        foreach ($model as $model){
           //   $list = [1 => '<span class="label label-success">DIPERAKUKAN</span>', 0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',];             
                      
           $a .= $model->maklumbalas.
                 Html::a(''  . $model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]).
                              '<br>'.'<br>'.
                              '<strong>'.'Urus Setia JPU :'. '<br>'.$model->kakitangan->CONm.
                                 '<br>'.$model->department->shortname. '<br>'.$model->tarikhMaklumbalas. '</strong>'.
                                 '<br>'.'</strong>'.'<br>';
     
                 //  $model->department->shortname; 
         
        }
        
        return $a;
    }
    
    
       public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
}
