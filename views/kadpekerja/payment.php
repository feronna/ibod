<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

  
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Pembayaran</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'CONm')->textInput(['disabled' => true])->label(false); ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <?php // Html::a('<i class="fa fa-edit"></i>', ['biodata/kemaskini'], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'COHPhoneNo')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Emel: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'COEmail')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
         <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Permohonan : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?php // $form->field($permohonan, 'card_type')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jumlah (RM): <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?php // $form->field($invoice, 'amount')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Bayaran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?php
//                    if ($invoice->payment_method) {
//                       echo $form->field($invoice, 'payment_method')->textInput(['disabled' => true])->label(false);
//                    } else {
//                        echo $form->field($invoice, 'payment_method')->radioList(array('FPX' => 'FPX', 'CREDIT_CARD' => 'CREDIT_CARD'))->label(false);
//                    }
                    ?>

                </div>
            </div>
        </div>


        <div class="form-group text-center">
            <div class="row">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('BAYAR', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>   
        <?php ActiveForm::end(); ?>

    </div>
</div> 
