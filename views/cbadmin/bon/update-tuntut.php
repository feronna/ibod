<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;


?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI MAKLUMAT TUNTUTAN GANTIRUGI</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
        <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
  <?php
            echo $form->field($model,'jenis_tuntutan')->
            dropDownList(['1' => 'Doktor Falsafah (Phd) ',
                          '200' => 'Pasca Kedoktoran', 
                          '102'=>'Sub Kepakaran',
                          '20'=> 'Sarjana',
                          '202' => 'Sarjana Kepakaran',
                          '99' =>'Cuti Sabatikal',
                          '999' =>'Latihan Industri',
                        ],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>          </div>
        </div>
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">PERKARA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'perkara')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
       <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH PENGAJIAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'j_cb')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'c1')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH GANTIRUGI SECARA PRO RATA:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'j_gantirugi')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
        
        

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
</div>
