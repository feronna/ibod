<?php

use yii\grid\GridView;
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
                            return $model->jenama ? ucwords(strtoupper($model->jenama->KETERANGAN)) : '';
                        },
                    ],
                    [
                        'attribute' => 'jenis_kenderaan',
                        'value' => 'jeniskenderaan.Keterangan'
                    ],
                    [
                        'attribute' => 'status_kenderaan',
                        'value' => function($model) {
                            return Html::button(' Status', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['status-kenderaan', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-default btn-sm']) . ' ' . ucwords(strtoupper($model->status_kenderaan));
                        },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Kemaskini',
                                'value' => function($model) {
                                    return Html::a('<i class="fa fa-edit"></i>  Kenderaan', ['kemaskini-kenderaan', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']) . '  ' . Html::a('<i class="fa fa-edit"></i>  Lesen', ['lesen', 'id' => $model->id], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']) . '  ' . Html::a('<i class="fa fa-trash"></i>', ['padam-kenderaan', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                },
                                        'format' => 'raw',
                                        'headerOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'attribute' => 'Tindakan',
                                        'value' => function($model) {
                                            return Html::a('MOHON', ['mohon', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                                        },
                                                'format' => 'raw',
                                            ],
                                        ];
                                    } elseif ($title == 'Semakan Permohonan') {
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
                                            } elseif ($title == 'Arkib Permohonan') {
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
                                                ];
                                            }
                                            ?>
                                            <div class="x_title">
                                                <p style="font-size:18px;font-weight: bold;"><?= strtoupper($title); ?></p> 
                                                <div class="clearfix"></div>
                                            </div> 
                                            <?php
                                            echo GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                'columns' => $gridColumns,
                                                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                            ]);



                                            if ($title == 'Semakan Permohonan') {
                                                ?>
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h2>Status Permohonan</h2> 
                                                        <div class="clearfix"></div>
                                                    </div> 
                                                    <div class="x_content"> 
                                                        <ul>
                                                            <li><span class="label label-warning">PENDING PAYMENT</span> : Status pembayaran secara atas talian belum lengkap.</li> 
                                                            <li><span class="label label-primary">MENUNGGU BAYARAN KAUNTER</span> : Pemohon boleh menjelaskan bayaran dan menuntut pelekat dikaunter Bahagian Keselamatan.</li> 
                                                            <li><span class="label label-success">MENUNGGU PENGAMBILAN</span> : Pemohon boleh menuntut pelekat kenderaan dikauter Bahagian Keselamatan.</li> 
                                                        </ul> 
                                                    </div> 
                                                </div>

                                                <?php
                                            }
                                            ?>

                                        </div> 
                                    </div>
                                </div> 
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
                                                return Html::button(' Status', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['status-kenderaan', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-default btn-sm']) . ' ' . ucwords(strtoupper($model->status_kenderaan));
                                            },
                                                    'format' => 'raw',
                                                ],
                                                [
                                                    'label' => 'Kemaskini',
                                                    'value' => function($model) {
                                                        if ($model->findAkftifPermohonan($model->id)) {
                                                            return;
                                                        } else {
                                                            return Html::a('<i class="fa fa-edit"></i>  Kenderaan', ['kemaskini-kenderaan', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']) . '  ' . Html::a('<i class="fa fa-edit"></i>  Lesen', ['lesen/view'], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']);
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
                                                                    return Html::button('MOHON', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mohon', 'id' => $model->id]), 'class' => 'mapBtn btn btn-primary btn-sm']);
                                                                }
                                                            },
                                                                    'format' => 'raw',
                                                                ],
                                                            ];
                                                            ?>


                                                            <div class="x_panel"> 
                                                                <div class="x_content">    
                                                                    <div class="table-responsive"> 
                                                                        <div class="x_title">
                                                                            <p style="font-size:18px;font-weight: bold;"><?= strtoupper('Permohonan Pelekat Lanjutan/Rosak/Hilang'); ?></p> 
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <?php
                                                                        echo GridView::widget([
                                                                            'dataProvider' => $dataProviderLanjutan,
                                                                            'columns' => $gridColumns,
                                                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                                        ]);
                                                                        ?>
                                                                    </div> 
                                                                </div>
                                                            </div>    
                                                        <?php } ?>
