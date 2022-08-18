<?php

namespace app\models\memorandum;

use Yii;
use app\models\memorandum\TblMaklumbalas;
use app\models\memorandum\TblMaklumbalasPtj;
use app\models\memorandum\TblMakluman;
use app\models\hronline\Tblprcobiodata;
use app\models\memorandum\TblPerkara;
use app\models\memorandum\TblTindakan;
use yii\helpers\Html;

/**
 * This is the model class for table "utilities.memo_tbl_rekod".
 *
 * @property int $id
 * @property string $bil_jpu
 * @property string $perkara
 * @property string $tarikh_rekod
 * @property int $id_maklumbalas
 * @property int $id_maklumabalas_ptj
 * @property string $status
 */
class TblRekod extends \yii\db\ActiveRecord
{
       public $parent_order;
      public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perkara'], 'string'],
            [['tarikh_rekod', 'dept_id', 'penyelia'], 'safe'],
            [['bil_jpu'], 'string', 'max' => 100],
            [['status', 'tahun'], 'string', 'max' => 50],
            [['doc_name', 'title'], 'string', 'max' => 255],
            [['hashcode'], 'string', 'max' => 150],
            [['file'], 'file', 'maxSize' => 2000 * 1024, 'tooBig' => 'File Limit is 2MB only'],
            [['bil_jpu','perkara','tarikh_rekod', 'kali_ke',  'tarikh_tamat'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
             ['parent_order', 'safe']
            
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bil_jpu' => 'Bil Jpu',
            'perkara' => 'Perkara',
            'tarikh_rekod' => 'Tarikh Rekod',
            'id_maklumbalas' => 'Id Maklumbalas',
            'id_maklumabalas_ptj' => 'Id Maklumabalas Ptj',
            'status' => 'Status',
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
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    
       public function getTarikhRekod() {
        return  $this->getTarikh($this->tarikh_rekod);
    }
    
      public function getTarikhTamat() {
        return  $this->getTarikh($this->tarikh_tamat);
    }
    
    
       public function getStatusMemorandum() {
        
//        if ($this->status == '1') {
//            return '<span class="label label-info">REKOD BAHARU</span>';
//        }
        if ($this->status == '1') {
            return '<span class="label label-success">SELESAI</span>';
        }
         else {      
            return '<span class="label label-danger">BELUM SELESAI</span>';
        
        }
    }
    
    
        public function TugasUtama($id){
            
        $model = TblMaklumbalas::find()->where(['id_rekod'=>$id])->all();
        $a = '';
        foreach ($model as $model){
             
           $a .= ucwords(strtolower($model->maklumbalas)); 
         
        }
        
        return $a;
    }
    
    
        public function TugasUtama2($id){
        $model = TblMaklumbalasPtj::find()->where(['id_rekod'=>$id])->all();
        $a = '';
        foreach ($model as $model){
             
           $a .= ucwords(strtolower($model->maklumbalas_ptj)); 
         
        }
        
        return $a;
    }
    
//        public function PerakuanPegawai2($id){
//        $model = TblMaklumbalasPtj::find()->where(['id_rekod'=>$id])->all();
//        $a = '';
//        foreach ($model as $model){
//             
//           $a .= '<li>'.ucwords(strtolower($model->perakuan_kj)); 
//         
//        }
//        
//        return $a;
//    }
    
        
     public function getTblMaklumbalas() {
        return $this->hasOne(TblMaklumbalas::className(), ['id_rekod' => 'id']);
    }
    
       public function getTblMaklumbalasPtj() {
        return $this->hasOne(TblMaklumbalasPtj::className(), ['id_rekod' => 'id']);
    }
    
      public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
      public static function listofyear() {
       return self::find()->select('tahun')->distinct()->all();
    }
    
     public static function totalselesai($year){
        return self::find()->where(['status' => 1,'tahun' => $year])->count();
    }
    
    public static function totalbelumselesai($year){
       return self::find()->where(['status' => 0,'tahun' => $year])->count();
    }
    
    public static function averageindex($year) {
     //  $model = self::find()->where(['tahun' => $year]);
       return self::find()->where(['tahun' => $year])->count();
    }
    
        public function getKakitanganPtj() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['DeptID' => 'dept_id']);
    }
 
        public function getPenyeliaPtj() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'penyelia']);
    }
    
       public function getTblRekod() {
        return $this->hasOne(TblMaklumbalasPtj::className(), ['id_rekod' => 'id']);
    }
    
      public function getDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'dept_id']);
    }
    
          public function getPemakluman() {
        return $this->hasOne(TblMakluman::className(), ['id_rekod' => 'id']);
    }
    
        public function getPegawaiPeraku() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pegawai_peraku']);
    }
    public function countBelumSelesai($kumpulan, $category) {

        $count = 0;
        $memo = TblRekod::find()->where(['status' => 0])->all();

        foreach ($memo as $l) {
            $i[] = $l->penyelia;
        }
        
      
        if ($category == 0) { //keseluruhan
             $count = TblRekod::find()
//                    ->joinWith('pengajianLulus')
                   ->andWhere(['dept_id' => $kumpulan])
                    ->andWhere(['status'=>0])
                    ->count();
        }
        
        return $count;
    }
     public function countSelesai($kumpulan, $category) {

        $count = 0;
        $memo = TblRekod::find()->where(['status' => 0])->all();

        foreach ($memo as $l) {
            $i[] = $l->penyelia;
        }
        
      
        if ($category == 0) { //keseluruhan
             $count = TblRekod::find()
//                    ->joinWith('pengajianLulus')
                   ->andWhere(['dept_id' => $kumpulan])
                    ->andWhere(['status'=>1])
                    ->count();
        }
        
        return $count;
    }
      
        public function getPerkara2() {
        return $this->hasOne(TblPerkara::className(), ['id_rekod' => 'id']);
    }
    
   
    
}
