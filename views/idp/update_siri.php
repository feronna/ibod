<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
//use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\myidp\IdpCampus;
use dosamigos\datepicker\DatePicker;
use app\models\myidp\RefStatusSiriLatihan;

echo $this->render('/idp/_topmenu');
/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

/* * * for popover PENCERAMAH & INFO **** */
//$js = <<< 'SCRIPT'
//$(function() {
//    $("body").delegate(".datepicker", "focusin", function(){
//        $(this).datepicker();
//    });
//});
//SCRIPT;
//// Register tooltip/popover initialization javascript
//$this->registerJs($js);
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>
                    <h3><span class="label label-primary" style="color: white">Kemaskini Siri</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Siri : </label>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <?= $form->field($modelSiriLatihan, 'siri')->textInput()->input('readOnlyTextInput', ['readOnly' => true, 'value' => $modelSiriLatihan->siri])->label(false) ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Lokasi : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'lokasi')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Mula: </label>
                    <div class="col-md-3 col-sm-3 col-xs-10">
                        <?=
                        DatePicker::widget([
                            'model' => $modelSiriLatihan,
                            'attribute' => 'tarikhMula',
                            'template' => '{input}{addon}',
                            'options' => [
                                'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                'id' => 'StartDate',
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Akhir: </label>
                    <div class="col-md-3 col-sm-3 col-xs-10">
                        <?=
                        DatePicker::widget([
                            'model' => $modelSiriLatihan,
                            'attribute' => 'tarikhAkhir',
                            'template' => '{input}{addon}',
                            'options' => [
                                'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                'onchange' => 'checkDate()',
                                'id' => 'EndDate',
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Penceramah : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?=
                        // With a model and without ActiveForm
                        Select2::widget([
                            'name' => 'momo',
                            'value' => $penceramah,
                            'id' => 'first',
                            'data' => $allStaf,
                            'options' => ['placeholder' => 'Sila pilih penceramah ...'],
                            'pluginOptions' => [
                                'tags' => true,
                                'maximumInputLength' => 10,
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]);

                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Kampus : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?php

                        //use app\models\IdpCampus;
                        $campus = IdpCampus::find()
                            ->orderBy("campus_name")
                            ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData = ArrayHelper::map($campus, 'campus_id', 'campus_name');

                        echo $form->field($modelSiriLatihan, 'kampusID')->dropDownList(
                            $listData,
                            ['prompt' => 'Select...']
                        )->label(false)  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Kuota : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'kuota')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Status Siri : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?php

                        //use app\models\IdpCampus;
                        $status = RefStatusSiriLatihan::find()
                            ->orderBy("statusDesc")
                            ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData = ArrayHelper::map($status, 'statusDesc', 'statusDesc');

                        echo $form->field($modelSiriLatihan, 'statusSiriLatihan')->dropDownList(
                            $listData,
                            ['prompt' => 'Select...']
                        )->label(false)
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Pautan Latihan Atas Talian : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'linkZoom')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Pautan Bahan Kursus (Google Drive) : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'linkBahan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>