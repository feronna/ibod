<?php

use app\models\esticker\RefJenamaKenderaan;
use app\models\esticker\RefJenisKenderaan;
use app\models\hronline\Campus;
use app\models\hronline\Department;
use app\models\saman\RefKesalahan;
use app\models\saman\SamanKategori;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Saman\SamanOld */
/* @var $form yii\widgets\ActiveForm */

$today = date('Y-m-d');
?>
<?= $this->render('/saman/_menu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Tambah Saman Baharu</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">

                    <div class="saman-old-form">

                        <?php $form = ActiveForm::begin(); ?>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <?= $form->field($model, 'NOSAMAN')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <label>Tarikh Saman</label>
                            <?=
                            DatePicker::widget([
                                'name' => 'date',
                                'value' => $today,
                                'template' => '{input}{addon}',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ],
                                'options' => ['readonly' => 'readonly'],

                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label>Kategori</label>
                            <?=
                            $form->field($model, 'KATEGORI')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(SamanKategori::find()->all(), 'KATEGORIKOD', 'KATEGORI_DESC'),
                                'options' => ['placeholder' => 'Kategori', 'class' => 'form-control col-md-4 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">

                            <?= $form->field($model, 'IDNO')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">

                            <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">

                            <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">

                            <?= $form->field($model, 'NO_KENDERAAN')->textInput(['maxlength' => true,'style' => 'text-transform:capitalize']) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">

                            <?= $form->field($model, 'SIRI_PELEKAT')->textInput(['maxlength' => true,'style' => 'text-transform:capitalize']) ?>
                        </div>

                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <label>Jenis Kenderaan</label>
                            <?=
                            $form->field($model, 'KODJENIS')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(RefJenisKenderaan::find()->all(), 'KODJENIS', 'Keterangan'),
                                'options' => ['placeholder' => 'Jenis Kenderaan', 'class' => 'form-control col-md-4 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <label>Model Kenderaan</label>
                            <?=
                            $form->field($model, 'KODMODEL')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(RefJenamaKenderaan::find()->all(), 'KODMODEL', 'KETERANGAN'),
                                'options' => ['placeholder' => 'Jenis Kenderaan', 'class' => 'form-control col-md-4 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <label>Kampus</label>
                            <?=
                            $form->field($model, 'KODKAMPUS')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name'),
                                'options' => ['placeholder' => 'Kampus', 'class' => 'form-control col-md-4 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">

                            <?= $form->field($model, 'LOKASI')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label>JAFPIB</label>
                            <?=
                            $form->field($model, 'KODJFPIU')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                                'options' => ['placeholder' => 'JAFPIB', 'class' => 'form-control col-md-4 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                        <label>Jumlah Saman (RM)</label>
                            <?= $form->field($model, 'TOTALAMN4')->textInput(['maxlength' => true])->label(false) ?>

                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label>Kod Salah</label>
                            <?= $form->field($model, 'KODSALAH1')->textInput(['maxlength' => true])->label(false) ?>

                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label>Nota</label>
                            <?= $form->field($model, 'NOTA1')->textArea(['maxlength' => true])->label(false) ?>

                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label>Jumlah Kunci (RM)</label>
                            <?= $form->field($model, 'AMNKUNCI')->textInput(['maxlength' => true])->label(false) ?>

                        </div>



                        <div class="form-group" style="text-align:left; float:right;">
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>