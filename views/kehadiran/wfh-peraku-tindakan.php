<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\kehadiran\TblRekod;
use yii\helpers\Url;
?>


<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tindakan Perakuan bekerja dari rumah/Work from Home(WFH)</strong></h2>
            <ul class="nav navbar-right panel_toolbox ">
                <li class="pull-right"><a class="collapse-link "><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model->kakitangan, 'CONm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'full_date')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'tempoh')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>
            

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan/Sebab
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => true])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php
                    echo $form->field($model, 'status')->label(false)
                            ->dropDownList(
                                    ['VERIFIED' => 'DIPERAKUKAN', 'REJECTED' => 'DITOLAK'], // Flat array ('id'=>'label')
                                    ['prompt' => '--Sila Pilih Status Perakuan--']    // options
                    );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Perakuan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'ver_remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar Perakuan', ['class' => 'btn btn-success']) ?>
               </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>