<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?>  
<div class="x_panel"> 
    <div class="x_content">    
        <div class="table-responsive"> 
            <?php
            if ($title == 'Permohonan Pelekat Baru') {
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'reg_number',
                        'value' => function($model) {
                            $words = str_replace(' ', '', strtolower($model->reg_number));
                            return strtoupper($words);
                        },
                    ],
                    [
                        'attribute' => 'veh_brand',
                        'value' => function($model) {
                            return $model->jenama? ucwords(strtoupper($model->jenama->KETERANGAN)):'';
                        },
                    ],
                    [
                        'attribute' => 'jenis_kenderaan',
                        'value' => 'jeniskenderaan.Keterangan'
                    ],
                    [
                        'attribute' => 'status_kenderaan',
                        'value' => function($model) {
                            return Html::button(' Status', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['status-kenderaan-jabatan', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-default btn-sm']) . ' ' . ucwords(strtoupper($model->status_kenderaan));
                        },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Kemaskini',
                                'value' => function($model) {
                                    return Html::a('<i class="fa fa-edit"></i>  Kenderaan', ['kemaskini-kenderaan-jabatan', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']) . Html::a('<i class="fa fa-trash"></i>', ['padam-kenderaan-jabatan', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                },
                                        'format' => 'raw',
                                        'headerOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'attribute' => 'Tindakan',
                                        'value' => function($model) {
                                            return Html::button('MOHON', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mohon-jabatan', 'id' => $model->id]), 'class' => 'mapBtn btn btn-primary btn-sm']);
                                        },
                                                'format' => 'raw',
                                            ],
                                        ];
                                    } elseif ($title == 'Semakan Permohonan Jabatan') {
                                        $gridColumns = [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'label' => 'No. Kereta',
                                                'value' => function($model) {
                                                    $words = str_replace(' ', '', strtolower($model->kenderaan->reg_number));
                                                    return strtoupper($words);
                                                },
                                            ],
                                            'mohon_date',
                                            [
                                                'label' => 'Jenama',
                                                'value' => function($model) {
                                                    return ucwords(strtoupper($model->kenderaan->jenama->KETERANGAN));
                                                },
                                            ],
                                            [
                                                'label' => 'Jenis Kenderaan',
                                                'value' => 'kenderaan.jeniskenderaan.Keterangan'
                                            ],
                                            [
                                                'label' => 'Status Kenderaan',
                                                'value' => function($model) {
                                                    return ucwords(strtoupper($model->kenderaan->status_kenderaan));
                                                },
                                            ],
                                            [
                                                'label' => 'Status Permohonan',
                                                'value' => function($model) {
                                                    if ($model->status_mohon == 'MENUNGGU KUTIPAN') {
                                                        return '<span class="label label-success">' . ucwords(strtoupper('MENUNGGU PENGAMBILAN')) . '</span>';
                                                    } elseif ($model->status_mohon == 'MENUNGGU BAYARAN KAUNTER') {
                                                        return '<span class="label label-primary">' . ucwords(strtoupper($model->status_mohon)) . '</span>';
                                                    } elseif ($model->status_mohon == 'PENDING PAYMENT') {
                                                        return Html::a('<i class="fa fa-credit-card"></i>  ' . $model->status_mohon, ['payment', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) . '&nbsp;' . Html::a('<i class="fa fa-arrow-circle-right"></i> BATAL', ['batal-permohonan', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data' => [
                                                                        'confirm' => 'Anda yakin ingin batal?',
                                                                        'method' => 'post',
                                                        ]]);
                                                    }
                                                },
                                                        'format' => 'raw',
                                                        'contentOptions' => ['class' => 'text-center'],
                                                        'headerOptions' => ['class' => 'text-center'],
                                                    ],
                                                ];
                                            } elseif ($title == 'Arkib Permohonan Jabatan') {
                                                $gridColumns = [
                                                    ['class' => 'yii\grid\SerialColumn'],
                                                    [
                                                        'label' => 'No. Kereta',
                                                        'value' => function($model) {
                                                            $words = str_replace(' ', '', strtolower($model->kenderaan->reg_number));
                                                            return strtoupper($words);
                                                        },
                                                    ],
                                                    'mohon_date',
                                                    'apply_type',
                                                    'no_siri',
                                                    [
                                                        'label' => 'Tarikh Luput',
                                                        'value' => function($model) {
                                                            return $model->kenderaan->biodata->getTarikh($model->expired_date_1) . ' - ' . $model->kenderaan->biodata->getTarikh($model->expired_date_2);
                                                        },
                                                    ],
//                                                    [
//                                                        'label' => 'Tindakan',
//                                                        'value' => function($model) {
//                                                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['perincian', 'id' => $model->id]), 'class' => 'fa fa-eye mapBtn btn btn-default']);
//                                                        },
//                                                                'format' => 'raw',
//                                                                'contentOptions' => ['class' => 'text-center'],
//                                                                'headerOptions' => ['class' => 'text-center'],
//                                                            ],
                                                ];
                                            }

                                            echo GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                'columns' => $gridColumns,
                                                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                                'beforeHeader' => [
                                                    [
                                                        'columns' => [],
                                                        'options' => ['class' => 'skip-export'] // remove this row from export
                                                    ]
                                                ],
                                                'toolbar' => [
                                                ],
                                                'bordered' => true,
                                                'striped' => false,
                                                'condensed' => false,
                                                'responsive' => true,
                                                'hover' => true,
                                                'panel' => [
                                                    'type' => GridView::TYPE_DEFAULT,
                                                    'heading' => '<h2>' . $title . '</h2>',
                                                ],
                                            ]);



                                            if ($title == 'Semakan Permohonan Jabatan') {
                                                ?>
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h2>Status Permohonan</h2> 
                                                        <div class="clearfix"></div>
                                                    </div> 
                                                    <div class="x_content"> 
                                                        <ul> 
                                                            <li><span class="label label-success">MENUNGGU PENGAMBILAN</span> : Pemohon boleh menuntut pelekat kenderaan dikauter Bahagian Keselamatan.</li> 
                                                        </ul> 
                                                    </div> 
                                                </div>

                                                <?php
                                            }
                                            if ($title == 'Permohonan Pelekat Baru') {
                                                $gridColumns = [
                                                    ['class' => 'yii\grid\SerialColumn'],
                                                    [
                                                        'attribute' => 'reg_number',
                                                        'value' => function($model) {
                                                            $words = str_replace(' ', '', strtolower($model->reg_number));
                                                            return strtoupper($words);
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'veh_brand',
                                                        'value' => function($model) {
                                                            if ($model->jenama) {
                                                                return ucwords(strtoupper($model->jenama->KETERANGAN));
                                                            } else {
                                                                return;
                                                            }
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'jenis_kenderaan',
                                                        'value' => 'jeniskenderaan.Keterangan'
                                                    ],
                                                    [
                                                        'attribute' => 'status_kenderaan',
                                                        'value' => function($model) {
                                                            return Html::button(' Status', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['status-kenderaan-jabatan', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-default btn-sm']) . ' ' . ucwords(strtoupper($model->status_kenderaan));
                                                        },
                                                                'format' => 'raw',
                                                            ],
                                                            [
                                                                'label' => 'Kemaskini',
                                                                'value' => function($model) {
                                                                    if ($model->findAkftifPermohonan($model->id)) {
                                                                        return;
                                                                    } else {
                                                                        return Html::a('<i class="fa fa-edit"></i>  Kenderaan', ['kemaskini-kenderaan-jabatan', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                                                    }
                                                                },
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['class' => 'text-center'],
                                                                    ],
                                                                    [
                                                                        'attribute' => 'Tindakan',
                                                                        'value' => function($model) {

                                                                            if ($model->findAkftifPermohonan($model->id)) {
                                                                                return;
                                                                            } else {
                                                                                return Html::button('MOHON', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mohon-jabatan', 'id' => $model->id]), 'class' => 'mapBtn btn btn-primary btn-sm']);
                                                                            }
                                                                        },
                                                                                'format' => 'raw',
                                                                            ],
                                                                        ];


                                                                        echo GridView::widget([
                                                                            'dataProvider' => $dataProviderLanjutan,
                                                                            'columns' => $gridColumns,
                                                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                                                            'beforeHeader' => [
                                                                                [
                                                                                    'columns' => [],
                                                                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                                                                ]
                                                                            ],
                                                                            'toolbar' => [
                                                                            ],
                                                                            'bordered' => true,
                                                                            'striped' => false,
                                                                            'condensed' => false,
                                                                            'responsive' => true,
                                                                            'hover' => true,
                                                                            'panel' => [
                                                                                'type' => GridView::TYPE_DEFAULT,
                                                                                'heading' => '<h2>Permohonan Pelekat Lanjutan/Rosak/Hilang</h2>',
                                                                            ],
                                                                        ]);
                                                                    }
                                                                    ?>
        </div> 
    </div>
</div>    

