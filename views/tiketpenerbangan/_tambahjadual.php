<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>
<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("lanjutanedt").value);
                var pickdt = new Date(document.getElementById("lanjutansdt").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("lanjutanedt")){
            document.getElementById("tempoh").value=GetDays();
        }  
        }
        
</script>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>TAMBAH JADUAL PENERBANGAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
      <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                     <th scope="col" colspan=12"  style="background-color:white;"><center>JADUAL PENERBANGAN YANG DIRANCANG / DITEMPAH
                                         </center></th>

                  <tr>
                      <th scope="col" colspan=12"  style="background-color:lightblue;"><center>PERLEPASAN</th>
                      
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Pilih Kategori:</th>
                     <td colspan="5">  <?= $form->field($terbang, "idTempahan")->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\cbelajar\RefTempahan::find()->all(), 'id', 'jenisTempahan'),  
                                        'options' => ['placeholder' => 'Pilih Kategori Tempahan', 'class' => 'testing form-control col-md-12 col-xs-12',
                                   
                                    ],
                                ])->label(false);
                                    ?>
                     </td> </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi:</th>
                        <td colspan="5">   <?= $form->field($terbang, "dest_berlepas")->textInput(['maxlength' => 400])->label(false); ?>
                        </td> 
                    </tr>
                  
             
                         <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh:</th>
                        <td><?= $form->field($terbang, "tarikh_berlepas")->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?></td>               
                          <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                          <td> <?= $form->field($terbang, "masa_berlepas")->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
// 'timeFormat'=> 'HH:mm:ss',                                               
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
</td> 
                            </tr>
                            <tr>
                        
                     
                    <tr>
                      <th scope="col" colspan=12"  style="background-color:lightblue;"><center>KETIBAAN</th>
                      
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Destinasi:</th>
                        <td colspan="5">   <?= $form->field($terbang, "dest_tiba")->textInput(['maxlength' => 400])->label(false); ?>

</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh:</th>
                        <td><?= $form->field($terbang, "tarikh_tiba")->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?></td>               
                          <th class="col-md-3 col-sm-3 col-xs-12">Masa:</th>
                          <td> <?= $form->field($terbang, "masa_tiba")->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
// 'timeFormat'=> 'HH:mm:ss',                                               
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
</td> 

                            </tr>
                    
                     
                 
                </table>
            </div>
                   
       
       
</div>

        
  
       
      
         
        
        
         
        
         
        
         

        
        

    </div>
    </div>
</div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




