<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Program Vaksinasi';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">
    <div class="x_panel">
        <h4><?= "MAKLUMAT VAKSIN" ?></h4>
        <div class="clearfix"></div>
        <div class="x_panel">
        <p>
            <?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            <?php // Html::a('Kemaskini', ['update-status-vaksinasi'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Kemaskini', ['kemaskini-sv'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="row">

            <?= DetailView::widget([
                'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'IC / Passport No',
                        'attribute' => 'icno',
                    ],
                    [
                        'label' => 'ID MySejahtera',
                        'value' =>  $model->biodata ?  $model->biodata->mySejahteraId : '<span class="label label-primary">Sila kemaskini ID MySejahtera anda.</span>',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Telah Menerima Vaksin',
                        'value' => function ($model) {

                            switch ($model->status_vaksin) {
                                case '1':
                                    $status = 'Sudah Terima';
                                    break;
                                case '0':
                                    $status = 'Belum Terima';
                                    break;

                                default:
                                    $status = 'Sila kemaskini';
                                    break;
                            }
                            return $status;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Sebab Belum Terima Vaksin',
                        'value' => function ($model) {

                            switch ($model->sebab_belum_terima) {
                                case '1':
                                    $status = 'Tidak Layak';
                                    break;
                                case '2':
                                    $status = 'Menolak';
                                    break;
                                case '3':
                                    $status = 'Belum Dapat Temujanji';
                                    break;

                                default:
                                    $status = 'Sila Kemaskini';
                                    break;
                            }
                            return $status;
                        },
                        'format' => 'raw',
                        'visible' => $model->status_vaksin == 0 ? true : false,
                    ],
                    [
                        'label' => 'Status Vaksin Dos Pertama',
                        'attribute' => function ($model) {
                            return $model->terima_dos1 === 1 ? '<span class="label label-success" style="font-size:12px">Telah Disuntik Vaksin Pertama</span>' : '<span class="label label-danger" style="font-size:12px">Belum Disuntik Dos Pertama</span>';
                        },
                        'format' => 'raw',
                        'visible' => $model->status_vaksin == 1 ? true : false,
                    ],
                    [
                        'label' => 'Status Vaksin Dos Kedua',
                        'attribute' => function ($model) {
                            return $model->terima_dos2 === 1 ? '<span class="label label-success" style="font-size:12px">Telah Disuntik Vaksin Kedua</span>' : '<span class="label label-danger" style="font-size:12px">Belum Disuntik Dos Kedua</span>';
                        },
                        'format' => 'raw',
                        'visible' => $model->status_vaksin == 1 ? true : false,
                    ],
                    [
                        'label' => 'Status Dos Penggalak',
                        'attribute' => function ($model) {
                            return $model->terima_penggalak === 1 ? '<span class="label label-success" style="font-size:12px">Telah Terima Dos Penggalak</span>' : '<span class="label label-danger" style="font-size:12px">Belum Terima Dos Penggalak</span>';
                        },
                        'format' => 'raw',
                        'visible' => $model->terima_penggalak == 1 ? true : false,
                    ],
                    [
                        'label' => 'Catatan',
                        'value' => $model->catatan ? $model->catatan : 'Tidak Berkaitan',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Sijil Digital',
                        'value' => $model->displayLink,
                        'format' => 'raw',
                        'visible' => $model->status_vaksin == 1 ? true : false,
                    ],
                    [
                        'label' => 'Lampiran',
                        'value' => $model->displayLinkLampiran,
                        'format' => 'raw',
                        'visible' => $model->status_vaksin == 0 && in_array($model->sebab_belum_terima, [1, 2]) ? true : false,
                    ],
                ],
            ]); ?>
        </div>

        <div class="row">
            <h4><?= "Maklumat Vaksin Dos Pertama" ?></h4>
            <div class="clearfix"></div>
            <?php
            if ($dos1 && $model->status_vaksin == 1) {
                echo DetailView::widget([
                    'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                    'model' => $dos1,
                    'attributes' => [
                        [
                            'label' => 'Bilangan Dos',
                            'value' => 'Dos Pertama',
                        ],
                        [
                            'label' => 'Tarikh Terima Vaksin',
                            'attribute' =>  'tarikh_vaksin',
                        ],
                        [
                            'label' => 'Jenis Vaksin',
                            'value' => $dos1->jenisVaksin ? $dos1->jenisVaksin->nama_vaksin : 'no set',
                        ],
                        [
                            'label' => 'Tempat Vaksin',
                            'attribute' => 'tempat_vaksin',
                        ],
                        [
                            'label' => 'Batch Vaksin',
                            'attribute' => 'batch_vaksin',
                        ],

                    ],
                ]);
            } else {
                echo '<span class="label label-danger" style="font-size:12px">Maklumat Belum Dikemaskini</span>';
            }
            ?>
        </div>

        <div class="row">
            <h4><?= "Maklumat Vaksin Dos Kedua" ?></h4>
            <div class="clearfix"></div>
            <?php
            if ($dos2 && $model->status_vaksin == 1) {
                //echo Html::a('Kemaskini Vaksin Dos Kedua', ['kemaskini-dos-kedua'], ['class' => 'btn btn-warning']);
                echo DetailView::widget([
                    'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                    'model' => $dos2,
                    'attributes' => [
                        [
                            'label' => 'Bilangan Dos',
                            'value' => 'Dos Kedua',
                        ],
                        [
                            'label' => 'Tarikh Terima Vaksin',
                            'attribute' =>  'tarikh_vaksin',
                        ],
                        [
                            'label' => 'Jenis Vaksin',
                            'value' => $dos2->jenisVaksin ? $dos2->jenisVaksin->nama_vaksin : '(not set)',
                        ],
                        [
                            'label' => 'Tempat Vaksin',
                            'attribute' => 'tempat_vaksin',
                        ],
                        [
                            'label' => 'Batch Vaksin',
                            'attribute' => 'batch_vaksin',
                        ],

                    ],
                ]);
            } else {
                echo '<span class="label label-danger" style="font-size:12px">Maklumat Belum Dikemaskini</span>';
            }

            ?>

        </div>
        </div>
    </div>
    <div class="x_title">
        <div class="clearfix"></div>
    </div>
    <div class="x_panel">
            <h4><?= "MAKLUMAT DOS PENGGALAK" ?></h4>
            <div class="clearfix"></div>
        <div class="x_panel">
            <div class="row">
                <?php
                if ($dospenggalak) {
                    echo Html::a('Kemaskini Dos Penggalak', ['kemaskini-dos-penggalak'], ['class' => 'btn btn-warning']);
                    echo DetailView::widget([
                        'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                        'model' => $dospenggalak,
                        'attributes' => [
                            [
                                'label' => 'Tarikh Terima Dos',
                                'attribute' =>  'tarikh_dos',
                            ],
                            [
                                'label' => 'Jenis Dos',
                                'value' => 'Dos Penggalak',
                            ],
                            [
                                'label' => 'Tempat Terima Dos',
                                'attribute' => 'tempat_dos',
                            ],
                            [
                                'label' => 'Catatan',
                                'attribute' => 'catatan',
                            ],

                        ],
                    ]);
                } else {
                    echo '<span class="label label-danger" style="font-size:12px">Maklumat Belum Dikemaskini</span>';
                }

                ?>

            </div>
        </div>

    </div>