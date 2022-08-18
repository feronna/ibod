<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?> 
    <div class="x_panel">  
        <div class="x_content">   
            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'UMSPER',
                        'value' => function($model) {
                            return $model->user->COOldID;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Name',
                        'value' => function($model) {
                            return ucwords(strtolower($model->user->CONm));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Position Applied',
                        'value' => function($model) {
                            return $model->jawatan->fname;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Department',
                        'value' => function($model) {
                            return $model->user->penempatan ? $model->user->penempatan->department->fullname : ' ';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Kj Status',
                        'value' => function($model) {
                            return $model->getStatusKj($model->id);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ], 
                        ];



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
//                                '{export}',
//                                '{toggleData}'
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>APPLICATION '.$title.'</h2>',
                            ],
                        ]);
                        ?>
            </div>
             
        </div>
    </div>  
 

