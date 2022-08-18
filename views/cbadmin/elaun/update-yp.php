<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
//error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

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

<!--<script>  
        function calElaun(){
            var b = 
                    document.getElementById("tempoh").value;
    
           
//            var x = (Number(a) + Number(b);;
            
           var x = (Number(a) / 30) * Number(b)  ;
            return document.getElementById("p_bayar").value = ""+ x;
        }
         function call() {
             if(document.getElementById("amaun")){
            document.getElementById("p_bayar").value=calElaun();
            
        }
        }
</script> -->


<h5> <strong><center>BAYARAN YURAN PENGAJIAN (BY SEMESTER)</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
      
       <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">SEMESTER:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
 <?php
            echo $form->field($model,'semester')->
            dropDownList(['1' => '1 ',
                          '2' => '2',
                          '3' => '3',
                          '4' => '4',
                          '5' => '5',
                          '6' =>'6',
                          '7' => '7',
                          '8'=> '8'
                
                          
                        ])->label(false);
?>
                </div>
</div>
<div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">AMAUN (RM):<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
                                      <?= $form->field($model, 'amaun')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
</div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUSTIFIKASI:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
                                      <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
</div>
        
  
       
      
         
        
        
         
        
         
        
         

        
        

    </div>
    </div>
</div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




