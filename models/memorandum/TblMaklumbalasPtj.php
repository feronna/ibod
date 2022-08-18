<?php

namespace app\models\memorandum;
use app\models\hronline\Tblprcobiodata;
use Yii;
use app\models\hronline\Department;
use app\models\memorandum\TblTetapan;
use app\models\memorandum\TblPerkara;
use app\models\memorandum\TblTindakan;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * This is the model class for table "utilities.memo_tbl_maklumbalas_ptj".
 *
 * @property int $id
 * @property string $maklumbalas_ptj
 */
class TblMaklumbalasPtj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    
    public static function tableName()
    {
        return 'utilities.memo_tbl_maklumbalas_ptj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maklumbalas_ptj'], 'string'],
            [['id_rekod'], 'integer'],
            [['doc_name', 'title'], 'string', 'max' => 255],
            [['hashcode'], 'string', 'max' => 150],
            [['file'], 'file', 'maxSize' => 2000 * 1024, 'tooBig' => 'File Limit is 2MB only'],
            [['perakuan_kj','maklumbalas_ptj','status_kj'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maklumbalas_ptj' => 'Maklumbalas Ptj',
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
       if($this->tarikh_maklumbalas_ptj != null){
        return  $this->getTarikh($this->tarikh_maklumbalas_ptj);
       }else{
           return '';
       }
    }
    
        public function getTarikhPerakuan() {
       if($this->tarikh_perakuan != null){
        return  $this->getTarikh($this->tarikh_perakuan);
       }else{
           return '';
       }
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
//     public function getnamaChief() {
//        return $this->hasOne(Department::className(), ['chief' => 'kj']);
//    }
//    
      public function getTblRekod() {
        return $this->hasOne(TblRekod::className(), ['id' => 'id_rekod']);
    }
    
    public function getPegawaiPeraku() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'kj']);
    }

     public function getTblPerkara() {
        return $this->hasOne(TblPerkara::className(), ['id' => 'id_perkara']);
    }
    
           public function getPenyeliaPtj() {
        return $this->hasOne(TblTindakan::className(), ['id_rekod' => 'id_rekod']);
    }
         public function getPenyeliaPtj2() {
        return $this->hasOne(TblTindakan::className(), ['id_perkara' => 'id']);
    }
    
        public function MaklumbalasJafpib($id){
        $model = TblMaklumbalasPtj::find()->where(['id_perkara'=>$id])->all();
        $a = '';
        foreach ($model as $model){
              $list = [1 => '<span class="label label-success">DIPERAKUKAN</span>', 0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',];             
                      
           $a .= $model->maklumbalas_ptj.
                 Html::a(''  . $model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]).
                              '<br>'.'<br>'.
                              '<strong>'.'Urus Setia JAFPIB :'. '<br>'.$model->kakitangan->CONm.
                                 '<br>'.$model->department->shortname. '<br>'.$model->tarikhMaklumbalas. '</strong>'.
                                 '<br>'.'<br>'.'<br>'.  $list[$model->status_kj].
                                          '<br>'.'<br>'.
                                 
                                '<strong>'. 'Pegawai Peraku:'.'<br>'. $model->pegawaiPeraku->CONm.
                                 '<br>'.$model->department->shortname. '<br>'.$model->tarikhPerakuan.'</strong>'.'<br>';
                
                   
                 //  $model->department->shortname; 
         
        }
        
        return $a;
    }
    
       
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
      public function getUrussetiaJpu() {
        return $this->hasOne(TblMaklumbalas::className(), ['id_perkara' => 'id_perkara']);
    }
    
        public static function totalPendingTask($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
            $total = count($model = TblMaklumbalasPtj::find()->where(['kj' => $icno, 'status_kj' => 0])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    
    
    
//    
//            public static function totalPendingTaskPenyelia($icno) {
//
//        $total = 0;
////    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
////     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
//// }
////        if ($model) {
////            $total = count($model);
////        }
//        
////         else{
//            $total = count($model = TblMaklumbalasPtj::find()->where(['icno' => $icno])->all());
////        }
//        if ($total > 0) {
//                return  $total;
//            }
//        else {
//                return '';
//        }
//    }
    
    
    
}
