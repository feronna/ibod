<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use app\models\myidp\Kategori;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpRefPeringkat;
use app\models\hronline\Tblprcobiodata;
use dosamigos\datepicker\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */

$this->title = Yii::t('app', 'Borang Permohonan Permit Banner / Bunting / Poster');
$title_update = 'Borang Kemaskini Permohonan Permit Banner / Bunting / Poster';

?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <form class="needs-validation" novalidate>

        <div class="x_content">

            <div class="col-md-10 col-sm-10 col-xs-12">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Tujuan Pemasangan
                        <!-- <span class="required" style="color:red;">*</span> -->
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <?= $form->field($model_event, 'event_name')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi tujuan pemasangan di sini', 'disabled' => 'disabled'))->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pemasangan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php // Client validation of date-ranges when using with ActiveForm
                        // $form = ActiveForm::begin([
                        //     'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
                        // ]);
                        // echo '<label class="form-label">';
                        // echo DatePicker::widget([
                        //     'model' => $model,
                        //     'attribute' => 'tarikhMula',
                        //     'attribute2' => 'tarikhTamat',
                        //     'options' => ['placeholder' => 'Tarikh mula'],
                        //     'options2' => ['placeholder' => 'Tarikh tamat'],
                        //     'type' => DatePicker::TYPE_RANGE,
                        //     'form' => $form,
                        //     'pluginOptions' => [
                        //         'format' => 'yyyy-mm-dd',
                        //         'autoclose' => true,
                        //     ]
                        // ]);

                        // ActiveForm::end();
                        ?>
                        <?= $form->field($model, 'date_start')->widget(DateRangePicker::className(), [
                            'attributeTo' => 'date_end',
                            'labelTo' => 'hingga',
                            'form' => $form, // best for correct client validation
                            'language' => 'en',
                            'size' => 'ms',
                            'options' => [
                                'placeholder' => 'Tarikh pemasangan',
                                'disabled' => $status != 1 ? true : false
                            ],
                            'optionsTo' => [
                                'placeholder' => 'Tarikh pembukaan',
                                'disabled' => $status != 1 ? true : false
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'orientation' => 'bottom'
                                //'minView' => 0, /** don't know what this is for */
                                //'daysOfWeekDisabled' => false
                                //'daysOfWeekDisabled' => '0,6'
                            ]
                        ])->label(false); ?>
                    </div>
                </div>

<!--                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi Pemasangan <span class="required"></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php
                        // $form->field($model, 'kompetensi')->label(false)->widget(Select2::classname(), [
                        //     'data' => ArrayHelper::map(Kategori::find()->orderBy("kategori_id")->all(), 'kategori_id', 'kategori_nama'),
                        //     'options' => [
                        //         'placeholder' => 'Sila Pilih',
                        //         'disabled' => false
                        //     ],
                        //     'pluginOptions' => [
                        //         'allowClear' => true
                        //     ],
                        // ]);
                        ?>
                    </div>
                </div>-->

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <button class="btn btn-primary" type="submit">Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
                            <?php
                            //  Html::a(Yii::t('app', 'Hapus'), ['delete', 'id' => $model->kursusLatihanID], [
                            //     'class' => 'btn btn-danger',
                            //     'data' => [
                            //         'confirm' => Yii::t('app', 'Adakah anda pasti anda ingin menghapuskan rekod aduan ini?'),
                            //         'method' => 'post',
                            //     ],
                            // ]) 
                            ?>

                            <?= Html::resetButton('Batal', ['class' => 'btn btn-primary']) ?>
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </form>

    <?php ActiveForm::end(); ?>

</div>