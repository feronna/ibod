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
                        'label' => 'ICNO',
                        'value' => function($model) {
                            return $model->ICNO;
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
                        'label' => 'MULA',
                        'value' => function($model) {
                            return $model->start_date;
                        },
                        'format' => 'raw',
                    ],
                                [
                        'label' => 'TAMAT',
                        'value' => function($model) {
                            return $model->end_date;
                        },
                        'format' => 'raw',
                    ],
                                [
                        'label' => 'TEMPOH',
                        'value' => function($model) {
                            return date_diff(date_create($model->start_date), date_create($model->end_date))->format('%y Tahun, %m Bulan, %d Hari');
                        },
                        'format' => 'raw',
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

