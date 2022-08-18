<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\cuti\Layak;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use app\models\keselamatan\RefPosKawalan;
use app\models\patrol\RefRoute;
use yii\bootstrap\Modal;
use yii\helpers\Url;

//english title
$model->route_id = Yii::$app->getRequest()->getQueryParam('id');
$this->title = 'Tambah Bit '.(RefPosKawalan::namapos(Yii::$app->getRequest()->getQueryParam('id')));
?>
<?= $this->render('/patrol/_menu') ?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>(<?= $this->title ?>)</strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>

     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Bit</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->field($model, 'bit_name')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false]); ?>
            </div>
        </div>
     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Bit</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->field($model, 'position')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,'placeholder'=> 'Nombor bit, Sila Pastikan tidak sama dengan nombor bit yang sedia ada dan hanya nombor sahaja yang dibenarkan']); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Latitude</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Nombor Bit"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->field($model, 'lat')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,'placeholder'=> 'Nombor bit, Sila Pastikan tidak sama dengan nombor bit yang sedia ada dan hanya nombor sahaja yang dibenarkan']); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Longitude</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Nombor Bit"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->field($model, 'lng')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,'placeholder'=> 'Nombor bit, Sila Pastikan tidak sama dengan nombor bit yang sedia ada dan hanya nombor sahaja yang dibenarkan']); ?>
            </div>
        </div>
        <?= $form->field($model, 'route_id')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>

    
        <div class="form-group">

        </div>

        <div class="ln_solid"></div>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>