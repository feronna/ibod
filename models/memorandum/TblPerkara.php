<?php

namespace app\models\memorandum;

use Yii;
use app\models\memorandum\TblTindakan;
use app\models\memorandum\TblRekod;
use yii\helpers\Html;
use app\models\memorandum\TblMaklumbalasPtj;
use app\models\hronline\Department;
/**
 * This is the model class for table "utilities.memo_tbl_perkara".
 *
 * @property int $id
 * @property int $id_rekod
 * @property int $dept_id
 * @property string $perkara
 * @property string $updated
 * @property string $updated_by
 */
class TblPerkara extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_perkara';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rekod'], 'integer'],
            [['perkara'], 'string'],
            [['updated'], 'safe'],
            [['updated_by'], 'string', 'max' => 15],
            [['dept_id'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
        
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rekod' => 'Id Rekod',
            'dept_id' => 'Dept ID',
            'perkara' => 'Perkara',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    
         public function getTblRekod() {
        return $this->hasOne(TblRekod::className(), ['id' => 'id_rekod']);
    }
    
//       public function getPerkara() {
//        return $this->hasOne(TblPerkara::className(), ['id_rekod' => 'id']);
//    }
//    
//        public function SubjekPerkara($id){
//        $model = TblPerkara::find()->where(['id_rekod'=>$id])->all();
//        $a = '';
//        foreach ($model as $model){
//           $a .= $model->perkara; 
//         
//        }
//        
//        return $a;
//    }
//    
    
    public function TindakanJafpib2($id){
      $model = TblTindakan::find()->where(['id_perkara' => $id])->all();
        foreach ($model as $models){ 
       
       
        echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $models->id, 'id_rekod' => $models->id_rekod ]);   echo "\n" ;
        echo '|' ;  echo "\n";
        echo Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-tugas', 'id' => $models->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ;
           
           echo'<br>';
         
        }
        
        return $model;
    }
    
    
        public function TindakanPenyeliaJafpib($id){
        $model = TblTindakan::find()->where(['id_perkara' => $id])->all();
        $a = '';
        foreach ($model as $model){
           $a .= '<br>'.$model->penyelia2->CONm ;
         
        }
        
         return $a;
     }
     
         public function TindakanPerakuJafpib($id){
        $model = TblTindakan::find()->where(['id_perkara' => $id])->all();
        $a = '';
        foreach ($model as $model){
           $a .=  '<br>'.$model->pegawaiPeraku->CONm ;
         
        }
        
         return $a;
     }
     
     
        public function TindakanPemakluman($id){
        $model = TblMakluman::find()->where(['id_perkara' => $id])->all();
        $a = '';
        foreach ($model as $model){
           $a .=  '<br>'.$model->kakitangan->CONm ;
         
        }
        
         return $a;
     }
     
     
       public function getTblMaklumbalasPtj() {
        return $this->hasOne(TblMaklumbalasPtj::className(), ['id_rekod' => 'id_rekod']);
    }
         
       public function getTblMaklumbalasPtj2() {
        return $this->hasOne(TblMaklumbalasPtj::className(), ['id_perkara' => 'id']);
    }
         public function getPenyeliaPtj() {
        return $this->hasOne(TblTindakan::className(), ['id_rekod' => 'id_rekod']);
    }
         public function getPenyeliaPtj2() {
        return $this->hasOne(TblTindakan::className(), ['id_perkara' => 'id']);
    }
    
    public function getDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'dept_id']);
    }
    
        public function getPemakluman() {
        return $this->hasOne(TblMakluman::className(), ['id_perkara' => 'id']);
    }
    
       public function getTblMaklumbalasUrussetia() {
        return $this->hasOne(TblMaklumbalas::className(), ['id_perkara' => 'id']);
    }
    
    
      public function SenaraiTindakan($id){            
        $model = TblTindakan::find()->where(['id_perkara'=>$id])->all();
        $a = '';
        foreach ($model as $model){
             
           $a .= '<li>'.strtoupper($model->penyelia2->CONm). '<br>'. $model->penyelia2->department->shortname
                   . '<br>' . $model->penyelia2->jawatan->nama . ' ' . 'Gred' . ' ' . '(' . $model->penyelia2->jawatan->gred. ')'; 
         
        }
        
        return $a;
    }
}
