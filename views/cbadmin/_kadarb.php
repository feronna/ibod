<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered" >
                            <thead>
                 
                     
                   
                    
                    
                    <tr  id="b" style="display: none"> 
                        <th style="width:10%" align="right">JENIS ELAUN</th>
                        <td style="width:20%">      <td style="width:20%">      <?= $form->field($model, 'jenis_elaun_b')->widget(Select2::classname(), 
                        ['data' => 
                            ArrayHelper::map(app\models\cbelajar\RefTblElaunA::find()->WHERE(['jenis_kadar'=>"B"])->
                                    orderBy(['id' => SORT_ASC,])->all(), 'id', 'nama_elaun'),
                        
                            'options' => [
                            'placeholder' => 'Pilih Jenis Elaun','class' => 'form-control col-md-7 col-xs-12'],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                             'multiple' => true
                        ],
                    ])->label(false); ?></td></td>
                       
                    </tr>
                    
                   
                   
 
                    
                    
                     
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div>
                    
    


         
        
        
        




        
  

<?php ActiveForm::end(); ?>








