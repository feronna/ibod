<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
?>
 
        <?php echo $this->render('/ptb/_menu'); ?> 

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Lapor Diri</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
             
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
         <div class="table-responsive">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lapor Diri<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                      <?=
                        $form->field($tindakanLapor, 'lapor')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'Ya', 0 => 'Tidak'],
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
               
            </div>
        </div>
        
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lapor Diri<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= DatePicker::widget([
                                'name' => 'tarikh_lapor',
                                'value' => date('d-m-Y'),
                                'template' => '{addon}{input}',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-M-yyyy'
                                ]
                            ]);?>
                        </div>
                    </div>
        


        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>
</div>


