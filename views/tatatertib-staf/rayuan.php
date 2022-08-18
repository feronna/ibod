<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$statusLabel = [
        1 => '<span class="label label-success">Telah Dihantar</span>',
        null => '<span class="label label-warning">Belum Dihantar</span>',
];
$statusLabel2 = [
        1 => '<span class="label label-success">BERSALAH</span>',
        2 => '<span class="label label-warning">TIDAK BERSALAH</span>',
];
?>

<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
    
    .hash{
        font-size: 17px;
    }
</style>

<div class="row">
<div class="col-md-12 col-xs-12"> 
   <div class="x_panel">
        <div class="x_title">
            <h2>Rayuan Kakitangan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
<!--            <p style="color: green">
                * Permohonan Pertukaran sekali sahaja.
            </p>-->
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper($biodata->kakitangan->CONm)?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
           
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rayuan?<span class="required" style="color:red;">*</span></label>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($biodata, 'catatan_rayuan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
       


        
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>
