<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use kartik\number\NumberControl;

error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<h5> <strong><center>REKOD PERGERAKAN GAJI</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
            
 <div class="form-group">
     <label class="control-label col-md-3 col-sm-3 col-xs-12">GAJI POKOK ASAL:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12"  value="<?= $nd->kakitangan->gajiBasic;?>" disabled="">

            </div>
            </div>
        
         
        <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS KGT:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($nd,'statuss')->
            dropDownList(['Telah diberi pergerakan gaji 1 KGT' => 'Telah diberi pergerakan gaji 1 KGT ',
                          'Belum diberi pergerakan gaji 1 KGT' => 'Belum diberi pergerakan gaji 1 KGT', 
                         
                        ],['prompt'=>'Pilih Status KGT'])->label(false);
?>
     
            </div>
            </div>
        <div class="form-group">
     <label class="control-label col-md-3 col-sm-3 col-xs-12"> <B>NILAI 1 KGT</b>:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?=
                    $form->field($nd, 'nilai_kgt')->widget(NumberControl::classname(), [
                         'name' => 'nilai_kgt',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
            </div>
            </div>
        <div class="form-group">
     <label class="control-label col-md-3 col-sm-3 col-xs-12">GAJI POKOK BAHARU:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12"  value="RM<?= ($nd->kakitangan->gajiBasic2) + ($nd->nilai_kgt * 3);?>" disabled="" >

            </div>
            </div>
         <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">PERATUSAN BIW:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
            echo $form->field($nd,'status_kgt')->
            dropDownList(['12.5' => '12.5% - RM6,289.14 dan ke atas ',
                          '15.0' => '15.0% - RM4,029.64 - RM6,289.13',
                          '17.5' => '17.5% - RM2,015.74 - RM4,029.63',
                          '20.0' => '20.0% - RM1,329.74 - RM2,015.73',
                          '22.5' => '22.5% - RM951.35 - RM1,329.73',
                          '25.0' => '25.0% - RM951.34 ke bawah'
                         
                        ],['prompt'=>'Pilih peratusan gaji yang diterima'])->label(false);
?>
     
            </div>
            </div>
        
         
        
        
        
        
        
       
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?= $form->field($nd, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>


            </div>
            </div>
        
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         <!-- <div class="ln_solid"></div> -->
            
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
    <script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>