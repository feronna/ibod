<?php

namespace app\models\myportfolio;
use app\models\myportfolio\TblTugasUtama;
use Yii;
use yii\helpers\Html;
use app\models\myportfolio\RefAkauntabiliti;
error_reporting(0);
/**
 * This is the model class for table "myportfolio.tbl_akauntabiliti".
 *
 * @property int $id
 * @property string $icno
 * @property string $akauntabiliti
 * @property int $portfolio_id
 */
class TblAkauntabiliti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_akauntabiliti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['description'], 'string'],
            [['kata_kerja','object','description'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'description' => 'Akauntabiliti',
            'portfolio_id' => 'Portfolio ID',
            'kata_kerja' => 'kata kerja',
            'object' => 'object'
        ];
    }
    
   public function getRefAkauntabiliti() {
        return $this->hasOne(RefAkauntabiliti::className(), ['id' => 'kata_kerja']);
    }
    
        public function refAkauan($id){
        $model = TblAkauntabiliti::find()->where(['id'=>$id])->all();
        $refAkauan = '';
        foreach ($model as $model){
             
           $refAkauan .= '<li>' .$model->kata_kerja;

//          echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $model->id]).'</td></tr>';
//     
         
        }
        
        return $refAkauan;
    }
    
    public function TugasUtama3($id){
        $model = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();
        $a = '';
        foreach ($model as $model){
             
           $a .= '<li>' .ucwords(strtolower($model->description)); 

//          echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $model->id]).'</td></tr>';
//     
         
        }
        
        return $a;
    }
  
  public function TugasUtama($id){
        $model = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();
      
        foreach ($model as $models){ 
       
        echo'<li>' .ucwords(strtolower($models->description)); 
//        echo "&nbsp"; echo "&nbsp"; echo "&nbsp"; echo "&nbsp"; echo "&nbsp"; echo "&nbsp";
      
        echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $models->id]);
        echo '|';
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

  public function TugasUtama2($id){
      $model = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();
      $portfolio_id = $this->portfolio_id;
        foreach ($model as $models){ 
       
       
        echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-tugas', 'id' => $models->id, 'portfolio_id' => $portfolio_id, 'akauntabiliti_id' => $models->akauntabiliti_id ]);   echo "\n" ;
        echo '|' ;  echo "\n";
        echo Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-tugas', 'id' => $models->id, 'portfolio_id' => $portfolio_id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ;
           
           echo'<br>';
         
        }
        
        return $model;
    }
}
