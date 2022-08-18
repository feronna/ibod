<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\kehadiran\TblRekod;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
?>


<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tindakan Kelulusan bekerja dari rumah/Work from Home(WFH)</strong></h2>
            <ul class="nav navbar-right panel_toolbox ">
                <li class="pull-right"><a class="collapse-link "><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'icno'); ?>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model->kakitangan, 'CONm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'full_date'); ?>
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'full_date')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'tempoh'); ?>
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'tempoh')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'remark'); ?>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model, 'remark')->widget(TinyMce::className(), [
                            'options' => ['rows' => 10],
                            'language' => 'en',
                            'clientOptions' => [
                                'readonly' => 1,
                                'plugins' => [
                                    // "advlist autolink lists link charmap print preview anchor",
                                    // "searchreplace visualblocks code fullscreen",
                                    // "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "",
                            ]
                        ])->label(false); ?>
                    </div>
                </div>
            </div>
            

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'file'); ?>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                    if ($model->doc_name) {
                        echo Html::a('<i class="fa fa-search"></i>&nbsp;' . $model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank', 'class' => 'btn btn-success']);
                    } else {
                        echo 'Not Available';
                    }
                    ?>
                </div>
            </div>

            <hr>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php
                    echo $form->field($model, 'status')->label(false)
                        ->dropDownList(
                            ['APPROVED' => 'DILULUSKAN', 'REJECTED' => 'DITOLAK'], // Flat array ('id'=>'label')
                            ['prompt' => '--Sila Pilih Status Kelulusan--']    // options
                        );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Kelulusan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'app_remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>