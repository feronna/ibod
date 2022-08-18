<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Negara */

$this->title = 'Tambah Negara';
?>
<div class="negara-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="negara-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">ID: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'CountryCd')->textInput(['maxlength' => true],['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="countryname">Nama Negara: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'Country')->textInput(['maxlength' => true],['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StudyExtPeriod">Study Ext Period: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'StudyExtPeriod')->textInput(['maxlength' => true],['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CountryCdMM">Country Cd MM: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'CountryCdMM')->textInput(['maxlength' => true],['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Status: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'isActive')->checkbox(['label'=>'Tanda jika aktif','value'=>1,'uncheck'=>0])->label(false) ?>
        </div>
        </div>

            
        </div>
    </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a( 'Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
