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
                var dropdt = new Date(document.getElementById("dt_nbayar").value);
                var pickdt = new Date(document.getElementById("dt_sbayar").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("dt_nbayar")){
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


<h5> <strong><center>PROSES PEMBAYARAN ELAUN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       
<div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JENIS ELAUN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
<?= $form->field($model, 'jenis_elaun')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(app\models\cbelajar\RefElaun::find()->orderBy(['id' => SORT_DESC,])->all(), 'id', 'elaun'),
                        'options' => [
                            'placeholder' => 'Pilih Elaun'],
                    ])->label(false); ?>
                </div>
</div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">BAYARAN OLEH:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
                     <?php
            echo $form->field($model,'bayaran')->
            dropDownList(['KPT' => 'KEMENTERIAN PENGAJIAN TINGGI ',
                          'UMS' => 'UNIVERSITI MALAYSIA SABAH', 
                          
                        ],['prompt'=>'Dibayar Oleh'])->label(false);
?>
                </div>
</div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">AMAUN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                       <?= $form->field($model, 'amaun')->textInput(['maxlength' => true,'onchange' => 'call()', 'id' => 'amaun',  'rows' => 4])->label(false); ?>

                </div>
            </div>
      
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MULA BAYAR:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'dt_sbayar')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'dt_sbayar' ]])->label(false);?>
                </div>
            </div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT BAYAR:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'dt_nbayar')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'dt_nbayar' ]])->label(false);?>
                </div>
            </div>
          <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TEMPOH:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <?= $form->field($model, 'tempoh')->textInput(['maxlength' => true, 'onchange' => 'call()','id' => 'tempoh', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    

                </div>
            </div>
         
        
         
        
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                       <?= $form->field($model, 'catatan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>

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




