<?php

use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\cv\TblAccess;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel">  
    <div class="x_content">    
        <div class="table-responsive">

            <?php
            if ($status == 1) {

                if (TblAccess::isAdminPanelTapisanPen() || TblAccess::isAdminPanelPemilihPen()) {
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Position',
                            'value' => function($model) {
                                return $model->findJawatan($model->gred_id);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Applied (Approve)',
                            'value' => function($model) {
                                return '<b><u><a href=' . Url::to(['list-candidate-filter', 'id' => $model->id, 'status' => 1]) . '> ' . $model->TotalDataSaringan(1, $model->id) . '</a></u></b>';
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                            ];
                        } else { //belum ada access
                                    $gridColumns = [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        [
                                            'label' => 'Position',
                                            'value' => function($model) {
                                                return $model->findJawatan($model->gred_id);
                                            },
                                            'format' => 'raw',
                                        ],
                                    ];
                                }


                                echo GridView::widget([
                                    'dataProvider' => $model,
                                    'columns' => $gridColumns,
                                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                    'beforeHeader' => [
                                        [
                                            'columns' => [],
                                            'options' => ['class' => 'skip-export'] // remove this row from export
                                        ]
                                    ],
                                    'toolbar' => [
                                        [
                                            'content' => '',
                                        ],
//        '{export}',
//        '{toggleData}'
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
                            } else {
                                echo 'No Information.';
                            }
                            ?>
        </div>




    </div>
</div>  

