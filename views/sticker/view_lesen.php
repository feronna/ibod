<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>
<?= $this->render('menu') ?> 
    <div class="x_panel"> 
        <div class="x_content">  
            <div class="table-responsive">
                <?php
                $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'No. Lesen',
                'value' => function($model) {
                    return $model->LicNo;
                }, 
            ],
            [
                'label' => 'Jenis Lesen',
                'value' => function($model) {
                    return $model->jenlesen;
                },
            ],
            [
                'label' => 'Kelas Lesen',
                'value' => function($model) {
                    return $model->kellesen;
                },
            ],
            [
                'label' => 'Tarikh Dikeluarkan',
                'value' => function($model) {
                    return $model->firstLicIssuedDt;
                },
            ],
            [
                'label' => 'Tarikh Luput',
                'value' => function($model) {
                    return $model->licExpiryDt;
                },
            ],
            [
                'label' => 'Yuran Pembaharuan',
                'value' => function($model) {
                    return $model->LicRnwlFee;
                },
            ],
            [
                'label' => 'Tindakan',
                'value' => function($model) {
                    return Html::a('<i class="fa fa-edit"></i>', ['lesen/update', 'id' => $model->licId],['class' =>'btn btn-default btn-sm']) . ' ' . Html::a('<i class="fa fa-trash"></i>', ['delete-lesen', 'id' => $model->licId],['class' =>'btn btn-default btn-sm'], [
                                'data' => [
                                    'confirm' => 'Anda ingin Membuang Rekod ini?',
                                    'method' => 'post',
                                ],
                    ]);
                },
                          'format' => 'raw',
                    ],
                        ];

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
                                                [
                                                    'content' =>
                                                    Html::a('Kemaskini Lesen', ['lesen/view'], ['class' => 'btn btn-primary btn-sm']),
                                                ], 
                                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>REKOD LESEN</h2>',
                            ],
                        ]);
                        ?>
            </div>

        </div>
    </div> 