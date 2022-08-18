<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;


?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Tambah Pemotongan Pasangan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
            <p style="color: green">
                Sila nyatakan jumlah dan sekiranya tiada jumlah letak '0' pada ruang yang disediakan.
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


                 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Bayaran/Tanggungan/Potongan<span class="required" style="color:red;">*</span></label>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'jenis_bayaran')->label(false)->widget(Select2::classname(), [
                        'data' => $jenisBayaran,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
           
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Jumlah (RM)<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($model, 'jumlah')->widget(NumberControl::classname(), [
                         'name' => 'jumlah',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => Yii::t('app', 'Contoh: ').'RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                  
                </div>
            </div>
             
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan',['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
</div>