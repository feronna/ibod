<?php

namespace app\models\portfolio;
use app\models\portfolio\RefUnit;
use Yii;

use yii\helpers\Html;
/**
 * This is the model class for table "hrm.portfolio_ref_fungsi_unit".
 *
 * @property int $id
 * @property int $unit_id
 * @property string $description
 * @property string $icno
 */
class RefFungsiUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_ref_fungsi_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','unit_id'], 'integer'],
            [['description'], 'string'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'description' => 'Description',
            'icno' => 'Icno',
        ];
    }
    
        
      public function getFungsiUnit() {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }
    
       public function getMyjdKakitangan() {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }
    
          public function AktivitiFungsi($id){
        $model = TblAktiviti::find()->where(['fungsi_id'=>$id])->all();
        $a = '';
        foreach ($model as $model){
             
        //   $a .=  '<li>' .$model->aktiviti; 
        echo'<li>' .ucwords(strtolower($model->aktiviti)); 

           
        }
        
        return $a;
    }
    
             public function AktivitiFungsi2($id){
        $model = TblAktiviti::find()->where(['fungsi_id'=>$id])->all();
        $a = '';
        foreach ($model as $model){

       echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
         echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-aktiviti-fungsi', 'id' => $model->id, 'myjd_id' => $model->myjd_id]);
        echo '|';
        echo Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-aktiviti-fungsi', 'id' => $model->id, 'myjd_id' => $model->myjd_id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ;
           
           echo'<br>';
           
        }
        
        return $a;
    }
    
}
