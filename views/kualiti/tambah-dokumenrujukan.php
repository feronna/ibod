<?php

use app\models\hronline\Department;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="col-md-12">
</div>


<div class="kualiti-create">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Tambah Dokumen Rujukan</strong></h2>
            <div class="clearfix"></div>
        </div>

        <!-- <div class="col-md-12 col-xs-12"> -->
        <div class="x_panel">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">



                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Prosedur / Kod Dokumen<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'no_prosedur')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Prosedur / Nama Dokumen<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'tajuk_prosedur')->textarea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB<span class="required" style="color:red;">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'jfpib')->widget(Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                                'options' => [
                                    'placeholder' => '', 'class' => 'form-control col-md-7 col-xs-12',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12">Muatnaik Dokumen<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'file')->fileInput()->label(false); ?>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>