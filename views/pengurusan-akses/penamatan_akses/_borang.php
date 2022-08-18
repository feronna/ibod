<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;

$this->title = 'Penamatan Akses';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= " KEMASKINI SENARAI SEMAK PENAMATAN AKSES PENGGUNA" ?></h4>
        <div class="clearfix"></div>
    </div>
</br>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
    <div class="row">
   
        <?= DetailView::widget([
            'options' => ['class' => 'table table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'MAKLUMAT PENGGUNA',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'IC / Passport No',
                    'attribute' => 'icno',
                ],
                [
                    'label' => 'NAMA',
                    'attribute' =>  'nama',
                ],

                [
                    'label' => 'JFPIB',
                    'attribute' =>  'jfpib',
                ],
                [
                    'label' => 'SEBAB PERUBAHAN',
                    'attribute' => 'sebab_perubahan',
                ],
                [
                    'label' => 'TARIKH KUATKUASA',
                    'value' => function ($model) {
                        return Yii::$app->MP->Tarikh($model->tarikh_kuatkuasa);
                    },
                ],
                [
                    'label' => 'UNTUK KEGUNAAN KETUA JFPIB',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'CATATAN',
                    'value' => $form->field($model, 'catatan_ketua')->textarea(['placeholder'=>'Tuliskan catatan...','maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false),
                    'format' => 'raw',
                ],
                [
                    'label' => 'TANDATANGAN',
                    'value' =>  ' ',
                ],

                [
                    'label' => 'TARIKH',
                    'value' =>  Yii::$app->MP->Tarikh(date('Y-m-d')),
                ],

            ],
        ]); ?>
    </div>
    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table  table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'UNTUK KEGUNAAN PENTADBIR KESELAMATAN / PENTADBIR PENGKALAN DATA / PUSAT DATA ',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'AKSES KE PELAYAN',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' =>  $form->field($model, 'status_pelayan')->label(false)->widget(Select2::classname(), [
                        'data' => ['1'=>'Sudah Selesai','0'=>'Belum Selesai'],
                        'options' => ['placeholder' => 'Pilih..', ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'format' => 'raw',
                ],
                [
                    'label' => 'PENERANGAN',
                    'value' => $form->field($model, 'penerangan_pelayan')->textarea(['placeholder'=>'Tuliskan catatan...','maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false),
                    'format' => 'raw',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'value' =>  ' ',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tt_pelayan',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]),
                    'format' => 'raw',
                ],

                [
                    'label' => 'AKSES KE PENGKALAN DATA',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' =>  $form->field($model, 'status_pd')->label(false)->widget(Select2::classname(), [
                        'data' => ['1'=>'Sudah Selesai','0'=>'Belum Selesai'],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'format' => 'raw',
                ],
                [
                    'label' => 'PENERANGAN',
                    'value' => $form->field($model, 'penerangan_pd')->textarea(['placeholder'=>'Tuliskan catatan...','maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false),
                    'format' => 'raw',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'value' =>  ' ',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tt_pd',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]),
                    'format' => 'raw',
                ],

                [
                    'label' => 'AKSES KE SISTEM APLIKASI',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' =>  $form->field($model, 'status_sa')->label(false)->widget(Select2::classname(), [
                        'data' => ['1'=>'Sudah Selesai','0'=>'Belum Selesai'],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'format' => 'raw',
                ],
                [
                    'label' => 'PENERANGAN',
                    'value' => $form->field($model, 'penerangan_sa')->textarea(['placeholder'=>'Tuliskan catatan...','maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false),
                    'format' => 'raw',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'value' =>  ' ',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tt_sa',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]),
                    'format' => 'raw',
                ],

                [
                    'label' => 'AKSES FIZIKAL',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' =>  $form->field($model, 'status_fizikal')->label(false)->widget(Select2::classname(), [
                        'data' => ['1'=>'Sudah Selesai','0'=>'Belum Selesai'],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'format' => 'raw',
                ],
                [
                    'label' => 'PENERANGAN',
                    'value' => $form->field($model, 'penerangan_fizikal')->textarea(['placeholder'=>'Tuliskan catatan...','maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false),
                    'format' => 'raw',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'value' =>  ' ',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tt_fizikal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]),
                    'format' => 'raw',
                ],

            ],
        ]); ?>
    </div>
    <div class="text-center">
    <?= Html::a('Kembali', ['penamatan-akses'],  ['class' => 'btn btn-primary']) ?>
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>

