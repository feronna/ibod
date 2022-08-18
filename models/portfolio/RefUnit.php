<?php

namespace app\models\portfolio;
use app\models\portfolio\RefFungsiUnit;
use app\models\portfolio\TblAktiviti;
use app\models\portfolio\TblCartaJabatan;
use Yii;

/**
 * This is the model class for table "hrm.portfolio_ref_unit".
 *
 * @property int $id
 * @property int $jabatan_id
 * @property string $unit_details
 */
class RefUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_ref_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_id'], 'integer'],
            [['unit_details', 'catatan', 'section_id'], 'string', 'max' => 500],
            [['icno'], 'string', 'max' => 12],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jabatan_id' => 'Jabatan ID',
            'unit_details' => 'Unit Details',
        ];
    }
    public function getFungsi()
    {
        return $this->hasMany(RefFungsiUnit::className(), ['unit_id' => 'id']);
    }
    
         public function getSectionID() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section_id']);
    }
      public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    

        public function TugasUtama2($id){
        $model = RefFungsiUnit::find()->where(['unit_id'=>$id])->all();
        $a = '';
        foreach ($model as $key => $model){
             
           $a .=  '<li>' .$model->description; 

//          echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $model->id]).'</td></tr>';
//     
         
        }
        
        return $a;
    }
    
//      public function getFungsiUnit() {
//        return $this->hasOne(TblAktiviti::className(), ['fungsi_id' => 'id']);
//    }
    
//      public function AktivitiFungsi($id){
//        $model = TblAktiviti::find()->where(['fungsi_id'=>$id])->all();
//        $a = '';
//        foreach ($model as $key => $model){
//             
//           $a .=  '<li>' .$model->aktiviti; 
//
////          echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $model->id]).'</td></tr>';
////     
//         
//        }
//        
//        return $a;
//    }
//       public function getSectionCarta()
//    {
//        return $this->hasOne(\app\models\myportfolio\TblPortfolio::className(), ['jabatan_semasa' => 'jabatan_id']);
//    }
    
//    
//      public function getCartaFungsi()
//    {
//        return $this->hasOne(TblCartaJabatan::className(), ['fungsi_id' => 'id']);
//    }
    
        
      public function getCartaSection()
    {
          $icno=Yii::$app->user->getId();
        return $this->hasOne(TblCartaJabatan::className(), ['section' => 'section_id'])->andWhere(['icno' => $icno]);
    }
    
        
      public function getCartaUnit()
    {
          $icno=Yii::$app->user->getId();
        return $this->hasOne(TblCartaJabatan::className(), ['unit_staff' => 'id'])->andWhere(['icno' => $icno]);
    }
    
          public function getCartaJabatan()
    {
       //   $icno=Yii::$app->user->getId();
        return $this->hasOne(\app\models\myportfolio\TblPortfolio::className(), ['icno' => 'icno']);
    }
    
    
}
