<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
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


<h5> <strong><center>PELANJUTAN TEMPOH CUTI BELAJAR</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
      
       <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">PELANJUTAN KALI-KE:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
 <?php
            echo $form->field($model,'idLanjutan')->
            dropDownList(['1' => 'PERTAMA ',
                          '2' => 'KEDUA',
                          '3' => 'KETIGA',
                          
                        ])->label(false);
?>
                </div>
</div>
<div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MULA PELANJUTAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
<?= $form->field($model, 'lanjutansdt')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'lanjutansdt' ]])->label(false);?>
                </div>
</div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT PELANJUTAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
<?= $form->field($model, 'lanjutanedt')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'lanjutanedt' ]])->label(false);?>
                </div>
</div>
  
       
      
         
          <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TEMPOH:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <?= $form->field($model, 'tempoh')->textInput(['maxlength' => true, 'onchange' => 'call()','id' => 'tempoh', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    

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




