<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\daterange\DateRangePicker;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\system_core\TblAnnouncements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-announcements-form">

    <?php //$form = ActiveForm::begin(); 
    ?>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data']]); ?>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'tag'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="8 character only e.g : LNPT,STARS,GENERAL"></i>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?= $form->field($model, 'tag')->textInput(['maxlength' => true])->label(false); ?>
        </div>

    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'title'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tajuk"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false); ?>
        </div>

    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'content'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="kandungan Announcement"></i>
        </label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <?= $form->field($model, 'content')->widget(TinyMce::className(), [
                'options' => ['rows' => 20],
                'language' => 'en',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ])->label(false); ?>
        </div>

    </div>


    <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh (Mula - Tamat)
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="paparan maklumat start_date hingga end_date"></i>
        </label>

        <div class="col-sm-5">
            <?php
            echo DateRangePicker::widget([
                'model' => $model,
                'attribute' => 'full_dt',
                //                    'useWithAddon'=>true,
                'convertFormat' => true,
                'startAttribute' => 'start_dt',
                'endAttribute' => 'end_dt',
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd/m/Y',
                        'separator' => ' to '
                    ],
                    'opens' => 'left',
                ]
            ]);
            ?>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'crawler'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Samaada perlu d paparkan di crawler atau tidak... crawler yang gerak2 tu"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'crawler')->widget(SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'On',
                    'offText' => 'Off',
                    'size' => 'small',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ])->label(false)
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Enable = Paparkan || Disabled = tidak dipaparkan"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?=
            $form->field($model, 'status')->widget(SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'Enable',
                    'offText' => 'Disable',
                    'size' => 'small',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ])->label(false)
            ?>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'image'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Paparan Infografik"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php echo $model->image; ?>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::a('<span class="fa fa-arrow-left"></span>&nbsp;Kembali', ['admin/announcement-list'], $options = ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="fa fa-save"></span>&nbsp;Simpan', ['class' => 'btn btn-primary pull-right']) ?>
        <?= Html::resetButton('<span class="fa fa-undo"></span>&nbsp;Reset', ['class' => 'btn btn-danger pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>