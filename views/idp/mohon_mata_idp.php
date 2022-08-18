<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\myidp\Kategori;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpRefPeringkat;
//use kartik\daterange\DateRangePicker;
use dosamigos\datepicker\DateRangePicker;

$this->title = Yii::t('app', 'Permohonan Mata IDP (Individu)');

echo $this->render('/idp/_topmenu');
echo $this->render('/idp/contact');
?>

<div class="rpt-tbl-aduan-create">
    <!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($this->title) ?></h2>
                </div>
                </br>

                <div class="rpt-tbl-aduan-form">

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                    <form class="needs-validation" novalidate>

                        <div class="x_content">

                            <div class="col-md-10 col-sm-10 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kursus / Latihan / Program</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'namaProgram')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi tajuk kursus / latihan / program di sini...', 'disabled' => false))->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Penganjur</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'jenisPenganjur')->label(false)->widget(
                                            Select2::classname(),
                                            [
                                                'data' => [
                                                    '1' => 'Agensi Luar (External Agencies)',
                                                    '2' => 'UMS (JAFPIB/Persatuan/Kesatuan/Kelab)'
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih',
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penganjur</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'namaPenganjur')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh</label>
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
                                        <?= $form->field($model, 'tarikhMula')->widget(DateRangePicker::className(), [
                                            'attributeTo' => 'tarikhTamat',
                                            'labelTo' => 'hingga',
                                            'form' => $form, // best for correct client validation
                                            'language' => 'en',
                                            'size' => 'ms',
                                            'options' => [
                                                'placeholder' => 'Tarikh mula'
                                            ],
                                            'optionsTo' => [
                                                'placeholder' => 'Tarikh tamat'
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

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
                                        // $form->field($model, 'kompetensi')->label(false)->widget(Select2::classname(), [
                                        //     'data' => [
                                        //         '7' => 'KURSUS BERIMPAK TINGGI',
                                        //     ],
                                        //     'options' => [
                                        //         'placeholder' => 'Sila Pilih',
                                        //         'disabled' => true,
                                        //         'value' => '7'
                                        //     ],
                                        // ]);

                                        if ($jobCat == '1') {
                                            $kompetensi = Kategori::find()
                                                ->where(['academic' => '1'])
                                                ->orderBy("kategori_id")
                                                ->all();
                                        } else {
                                            $kompetensi = Kategori::find()
                                                ->where(['admin' => '1'])
                                                ->orderBy("kategori_id")
                                                ->all();
                                        }
                                        $listData = ArrayHelper::map($kompetensi, 'kategori_id', 'kategori_nama');

                                        echo $form->field($model, 'kompetensiPohon')->label(false)->widget(Select2::classname(), [
                                            'data' => $listData,
                                            'options' => ['placeholder' => 'Sila Pilih'],
                                            //'theme' => Select2::THEME_CLASSIC,
                                        ]);



                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Laporan : Apa Yang Telah Anda Pelajari Daripada Latihan Ini</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'laporan')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi pelajaran kursus di sini...', 'disabled' => false))->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Surat Jemputan Menghadiri Latihan (1)</label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($model, 'file1')->fileInput()->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Surat Kelulusan Menghadiri Latihan (2)</label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($model, 'file2')->fileInput()->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Sijil Atau Bukti Penyertaan (3)</label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($model, 'file3')->fileInput()->label(false); ?>
                                    </div>
                                </div>

                                <!-- < if ($model->updated != NULL) { ?>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Daftar <span class="required"></span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            < $form->field($model, 'updated')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                        </div>
                                    </div>
                                <?php //} 
                                ?> -->

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


            </div>
        </div>
    </div>
    <!-- </div> -->
</div>