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

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */

$this->title = Yii::t('app', 'Borang Tambah Kursus Dalaman');
$title_update = 'Borang Kemaskini Kursus Dalaman';

echo $this->render('/idp/_topmenu');
//echo $this->render('/aduan/contact');
?>

<div class="rpt-tbl-aduan-create">
    <!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?php
                        if ($status == '1') {
                            echo $this->title;
                        } else {
                            echo $title_update;
                        }
                        ?></h2>
                </div>
                </br>

                <div class="rpt-tbl-aduan-form">

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                    <form class="needs-validation" novalidate>

                        <div class="x_content">

                            <div class="col-md-10 col-sm-10 col-xs-12">

                                <!-- <center>< Html::img('@web/images/bkums.png', [
                            // 'width' => '450px',
                            // 'height' => '450px'
                        ]) ?></center> -->

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pemilik Modul <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'penggubalModul')->label(false)->widget(Select2::classname(), [
                                            'data' => $model->getDeptList(),
                                            'options' => [
                                                'placeholder' => 'Sila Pilih',
                                                //'value' => '158'
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],

                                        ]);
                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Kursus / Latihan : <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'tajukLatihan')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Sinopsis Kursus
                                        <!-- <span class="required" style="color:red;">*</span> -->
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">

                                        <?= $form->field($model, 'sinopsisKursus')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi sinopsis kursus di sini', 'disabled' => false))->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Ditawarkan <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'tahunTawaran')->label(false)->widget(
                                            Select2::classname(),
                                            [
                                                'data' => $model->getYearsList(),
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih',
                                                    'value' => date('Y')
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,

                                                ],
                                                //'theme' => Select2::THEME_CLASSIC,
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kumpulan Jawatan <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'kategoriJawatanID')->label(false)->widget(
                                            Select2::classname(),
                                            [
                                                'data' => [
                                                    'Akademik' => 'AKADEMIK',
                                                    'Pentadbiran' => 'PENTADBIRAN',
                                                    'Terbuka' => 'TERBUKA',
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih'
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                //'theme' => Select2::THEME_CLASSIC,
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peringkat <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'kategori_latihan')->label(false)->widget(
                                            Select2::classname(),
                                            [
                                                'data' => ArrayHelper::map(IdpRefPeringkat::find()->orderBy("id")->all(), 'id', 'nama'),
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih',
                                                    'value' => $model->kategori_latihan
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                //'theme' => Select2::THEME_CLASSIC,
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kluster Kursus <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php

                                        $kluster = KlusterKursus::find()
                                            ->orderBy("kluster_nama")
                                            ->all();

                                        $listData = ArrayHelper::map($kluster, 'kluster_id', function ($model) {
                                            $a = $model['kluster_nama'] . ' [' . $model->longcatk . '] [' . $model->longcatj . ']';
                                            return $a;
                                        });

                                        echo $form->field($model, 'klusterID')->label(false)->widget(
                                            Select2::classname(),
                                            [
                                                'data' => $listData,
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih',
                                                    'class' => 'form-control col-md-7 col-xs-12'
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                //'theme' => Select2::THEME_CLASSIC,
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi <span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'kompetensi')->label(false)->widget(Select2::classname(), [
                                            'data' => ArrayHelper::map(Kategori::find()->orderBy("kategori_id")->all(), 'kategori_id', 'kategori_nama'),
                                            'options' => [
                                                'placeholder' => 'Sila Pilih',
                                                'disabled' => false
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>

                                <?php if ($model->updated != NULL) { ?>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kursus Ditambah / Dikemaskini <span class="required"></span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?= $form->field($model, 'updated')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled', 'value' =>  Yii::$app->formatter->asDate($model->updated, 'php:d-m-Y H:i:s')])->label(false); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($model->updated_by != NULL) { ?>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Penambah / Pengemaskini Kursus <span class="required"></span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?= $form->field($model, 'updated_by')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled', 'value' => $model->pengemaskini->CONm])->label(false);?>
                                        </div>
                                    </div>
                                <?php } ?>

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

                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function() {
                            'use strict';
                            window.addEventListener('load', function() {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                var forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                var validation = Array.prototype.filter.call(forms, function(form) {
                                    form.addEventListener('submit', function(event) {
                                        if (form.checkValidity() === false) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add('was-validated');
                                    }, false);
                                });
                            }, false);
                        })();
                    </script>

                </div>


            </div>
        </div>
    </div>
    <!-- </div> -->
</div>