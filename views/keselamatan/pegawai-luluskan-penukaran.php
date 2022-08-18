<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Keselamatan\TblKesalahan;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pemohon : 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $form->field($model->pemohon, 'CONm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penganti : 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $form->field($model->penganti, 'CONm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengesahan <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?php
                            echo $form->field($model, 'status_pelulus')->label(false)
                                    ->dropDownList(
                                            ['L' => 'DITERIMA', 'TL' => 'TIDAK DITERIMA'], // Flat array ('id'=>'label')
                                            ['prompt' => '--Sila Pilih Pengesahan--']    // options
                            );
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan<span class="required">:</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'catatan_pelulus')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                        </div>
                    </div>     
                    
                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?= Html::submitButton('Hantar Pengesahan', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
