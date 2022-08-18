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
            <h2><strong><i class="fa fa-list"></i> Kemaskini Manual Kualiti</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'kategori_id')->widget(Select2::classname(), [
                        'data' => ['1' => 'Manual Kualiti', '2' => 'Prosedur Khusus', '3' => 'Prosedur Umum', '4' => 'Dokumen Rujukan', '5' => 'Borang'],
                        'options' => ['placeholder' => 'Pilih Jenis Carian'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                    </div>
                </div>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Muatnaik Dokumen<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?php
                        if (empty($model->file)) {
                            echo $form->field($model, 'tempFile')->fileInput(['maxlength' => true])->label(false);
                        } else {
                            echo Html::a(Yii::$app->FileManager->NameFile($model->file), Yii::$app->FileManager->DisplayFile($model->file), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->msiso_id, 'title' => 'file'], ['class' => 'btn btn-danger btn-sm']);
                        }
                        ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <!-- <button class="btn btn-primary" type="reset">Reset</button> -->
                        <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Kembali', ['view-manual', 'id' => $model->msiso_id], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>