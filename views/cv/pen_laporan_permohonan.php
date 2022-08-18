<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\export\ExportMenu;
ini_set('max_execution_time', '0');
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel"> 
        <div class="x_content">  


            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'UMSPER',
                        'value' => function($model) {
                            return $model->biodata->COOldID;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'NAMA',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'JFPIU',
                        'value' => function($model) {
                            return $model->biodata->department->shortname;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'JAWATAN DIPOHON',
                        'value' => function($model) {
                            return $model->ads->jawatanCv->fname;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'TEMPOH BERKHIDMAT DI UMS (TETAP)',
                        'value' => function($model) {
                            return $model->biodata->servPeriodPermanent;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'TEMPOH DI GRED SEMASA',
                        'value' => function($model) {
                            return $model->biodata->servPeriodCPosition;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '10 (LNPT)',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(10, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(10, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '9',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(9, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(9, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '8',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(8, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(8, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '7',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(7, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(7, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '6',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(6, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(6, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '5',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(5, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(5, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '4',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(4, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(4, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '3',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(3, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(3, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '2',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(2, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(2, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '1',
                        'value' => function($model) {
                            return '(' . $model->biodata->markahlnptCVpen(1, 'Tahun') . ') - ' . $model->biodata->markahlnptCVpen(1, 'Markah');
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'PURATA (3 TAHUN)',
                        'value' => function($model) {
                            if (empty($model->biodata->markahlnptCVpen(3, 'Markah'))) {
                                $avg = number_format(($model->biodata->markahlnptCVpen(2, 'Markah') * 0.2) + ($model->biodata->markahlnptCVpen(1, 'Markah') * 0.35), 2, '.', '');
                            } else {
                                $avg = number_format(($model->biodata->markahlnptCVpen(3, 'Markah') * 0.2) + ($model->biodata->markahlnptCVpen(2, 'Markah') * 0.35) + ($model->biodata->markahlnptCVpen(1, 'Markah') * 0.45), 2, '.', '');
                            }


                            if ($avg < 80) {
                                return '<span class="required" style="color:red;">**</span>' . $avg;
                            } else {
                                return $avg;
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'TATATERTIB',
                        'value' => function($model) {
                            if ($model->appInfo->tatatertib_status == 1) {
                                return "Tidak";
                            } else {
                                return "Ya";
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'KILANAN',
                        'value' => function($model) {
                            return '';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'KEBERHUTANGAN SERIUS',
                        'value' => function($model) {
                            return '';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '2018 (IDP)',
                        'value' => function($model) {
                            $model = $model->biodata->getIdpMinimum($model->ICNO, '2018');
                            return $model ? $model->jum_mata_dikira : '-';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '2019',
                        'value' => function($model) {
                            $model = $model->biodata->getIdpMinimum($model->ICNO, '2019');
                            return $model ? $model->jum_mata_dikira : '-';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => '2020',
                        'value' => function($model) {
                            $model = $model->biodata->getIdpMinimum($model->ICNO, '2020');
                            return $model ? $model->jum_mata_dikira : '-';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'LEWAT',
                        'value' => function($model) {
                            return $model->biodata->kehadiran('2021', 1);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'KELUAR AWAL',
                        'value' => function($model) {
                            return $model->biodata->kehadiran('2021', 2);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'TIDAK LENGKAP',
                        'value' => function($model) {
                            return $model->biodata->kehadiran('2021', 3);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'TIADA REKOD KEHADIRAN',
                        'value' => function($model) {
                            return $model->biodata->kehadiran('2021', 4);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'LUAR UMS',
                        'value' => function($model) {
                            return $model->biodata->kehadiran('2021', 5);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'JUMLAH',
                        'value' => function($model) {
                            return ($model->biodata->kehadiran('2021', 1) + $model->biodata->kehadiran('2021', 2) + $model->biodata->kehadiran('2021', 3) + $model->biodata->kehadiran('2021', 4) + $model->biodata->kehadiran('2021', 5));
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'STATUS KJ',
                        'value' => function($model) {
                            if ($model->kj_status == 1) {
                                return 'Ya';
                            } else if ($model->kj_status == 2) {
                                return 'Tidak';
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'CATATAN KJ',
                        'value' => function($model) {
                            return $model->kj_ulasan;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                ];
                echo ExportMenu::widget([
                    'dataProvider' => $permohonan,
                    'columns' => $gridColumns
                ]);


                echo GridView::widget([
                    'dataProvider' => $permohonan,
                    'columns' => $gridColumns,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
//                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                        '{export}',
//                        '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Laporan Permohonan (Kenaikan Pangkat Pentadbiran)</h2>',
                    ],
                ]);
                ?>
            </div>


        </div>
    </div>  

</div>  

