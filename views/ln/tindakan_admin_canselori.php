<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
?>
<?php
Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("date_to").value);
                var pickdt = new Date(document.getElementById("date_from").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("date_to")){
            document.getElementById("days").value=GetDays();
        }  
        }
</script>
<div style="display: <?php echo $displaytempoh;?>"> 
    <div class="x_panel"> 
          
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pergi</label>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'date_from')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                    'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'date_from' ]])->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Balik</label>   
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <?= $form->field($model, 'date_to')->widget(DatePicker::className(),
                      ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                      'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'date_to' ]])->label(false);?>   
            </div>
        </div> 
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh(Hari)</label>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    
            </div>  
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tujuan:<span class="required" style="color:red;">*</span></label>        
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <?= $form->field($model, 'tujuan')->textArea(['maxlength' => true, 'placeholder' => 'Nama seminar yang dihadiri']) ->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true, 'placeholder' => 'Tempat seminar yang dihadiri']) ->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Peruntukan:<span class="required" style="color:red;">*</span></label>        
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'kod_peruntukan_cn')->textArea(['maxlength' => true, 'placeholder' => 'Kod peruntukan . Cth: GKP003-SG-2016']) ->label(false);?>
            </div>
        </div>
        
    <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
        Sila isi ulasan anda seperti contoh berikut untuk kegunaan surat yang akan dijana oleh pengguna. *Cth: PERMOHONAN DITERIMA SETELAH AKTIVITI/PERJALANAN TELAH BERLANGSUNG
    </div>
    <br><br>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_admin')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                <a style="color: green; font-weight: bold"><?php echo $message;?></a>
            </div>
        </div>
    </div> 
</div>
            <?php ActiveForm::end(); 
            Pjax::end();?>
