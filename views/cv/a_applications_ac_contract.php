<?php

use yii\helpers\Url;
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
                    'label' => 'Position',
                    'value' => function($model) {
                        return $model->jawatan->fname;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Total',
                    'value' => function($model) {
                        return '<p style="color:red;"><b>' . $model->TotalAcContract($model->ads_id) . '</p></b>';
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Waiting',
                    'value' => function($model) {
                        return '<p style="color:red;"><b><u><a href=' . Url::to(['list-candidate-wait-contract', 'id' => $model->ads_id]) . '> ' . $model->TotalWaitingContract($model->ads_id) . '</a></u></p></b>';
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Approve',
                            'value' => function($model) {
                                return '<b><u><a href=' . Url::to(['list-candidate-contract', 'id' => $model->ads_id, 'status' => 1]) . '> ' . $model->TotalVerifyContract(2, $model->ads_id, 1) . '</a></u></b>';
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'Reject',
                                    'value' => function($model) {
                                        return '<b><u><a href=' . Url::to(['list-candidate-contract', 'id' => $model->ads_id, 'status' => 2]) . '> ' . $model->TotalVerifyContract(2, $model->ads_id, 2) . '</a></u></b>';
                                    },
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'label' => 'Interview',
                                            'value' => function($model) {
                                                return '<b><u><a href=' . Url::to(['list-candidate-iv-contract', 'id' => $model->ads_id]) . '> ' . $model->TotalIvContract(3, $model->ads_id) . '</a></u></b>';
                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ], 
                                                            ];

                                                            $btn = app\models\cv\StatusTapisan::find()->where(['status' => 1])->andWhere(['category' => 1])->One();
                                                            $btntapisan = 'btn btn-default';
                                                            if ($btn) { 
                                                                    $btntapisan = 'btn btn-success'; 
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
                                                                        'content' =>  
//                                                                        Html::a('<i class="fa fa-plus"></i>', ['add-content'], [
//                                                                            'class' => 'btn btn-default mapBtn',
//                                                                        ])
//                                                                        .Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['aktif-jawatankuasa']), 'class' => 'fa fa-lightbulb-o mapBtn '.$btntapisan.' btn-lg']). ' ' .
//                                                                        Html::a('<i class="glyphicon glyphicon-level-up"></i>', ['file-tapisan'], [
//                                                                            'class' => 'btn btn-default mapBtn',
//                                                                        ]) . ' ' .
//                                                                        Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-kiv']), 'class' => 'fa fa-user-plus mapBtn btn btn-default btn-lg']) . ' ' .
                                                                        Html::a('<i class="fa fa-legal"></i>', ['archive-application-ac'], [
                                                                            'class' => 'btn btn-default mapBtn',
                                                                        ]),
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
                                                                    'heading' => '<h2>Record Application (Contract)</h2>',
                                                                ],
                                                            ]);
                                                            ?>
        </div>




    </div>
</div>  

