<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">APPLICATION</p> 
        <div class="clearfix"></div>
    </div>
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
                        if ($model->user->jawatancv->svc == 2) {
                            return $model->findJawatan($model->ads->gred_id);
                        } else {
                            return $model->jawatan->fname;
                        }
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Department',
                    'value' => function($model) {
                        return $model->user ? $model->user->department->fullname : ' ';
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Category',
                    'value' => function($model) {
                        return $model->category($model->ads_id);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Info',
                    'value' => function($model) {
                        if ($model->checkJd($model->ICNO)) {
                            $btn = 'btn-default';
                        } else {
                            $btn = 'btn-danger';
                        }

                        if ($model->svc($model->current_gred) == 1) {
                                            return Html::a('RESUME', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->user->ICNO), 'gred_id' => $model->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('CRITERIA', ['criteria-check', 'gred' => $model->ads_id, 'icno' => sha1($model->ICNO), 'pakar' => $model->status_kepakaran], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                                        } else {
                                            return Html::a('RESUME', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('JD', [ 'jd', 'id' => $model->ICNO], ['class' => 'btn-md btn ' . $btn, 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->user->ICNO), 'gred_id' => $model->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('CRITERIA', ['criteria-check-administration', 'icno' => sha1($model->ICNO)], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                                        }
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                        ],
                        [
                            'label' => 'Action',
                            'value' => function($model) {
                                return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['dean-approval', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                                ],
                            ];



                            echo GridView::widget([
                                'dataProvider' => $toVerify,
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
                                    'heading' => '<h2>To Verify</h2>',
                                ],
                            ]);
                            ?>
                        </div>

                        <div class="table-responsive">

                            <?php
                            $gridColumns1 = [
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
                                        return $model->user ? $model->user->department->fullname : ' ';
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'Status',
                                    'value' => function($model) {
                                        if ($model->kj_status == 1) {
                                            return '<span class="label label-success">Success</span>';
                                        } else if ($model->kj_status == 2) {
                                            return '<span class="label label-danger">Failed</span>';
                                        } else {
                                            return;
                                        }
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                                ],
                                [
                                    'label' => 'Comment',
                                    'value' => function($model) {
                                        return $model->kj_ulasan;
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                            [
                    'label' => 'Category',
                    'value' => function($model) {
                        return $model->category($model->ads_id);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                                [
                                    'label' => 'Info',
                                    'value' => function($model) {
                                        if ($model->checkJd($model->ICNO)) {
                                            $btn = 'btn-default';
                                        } else {
                                            $btn = 'btn-danger';
                                        }

                                        if ($model->svc($model->current_gred) == 1) {
                                            return Html::a('RESUME', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->user->ICNO), 'gred_id' => $model->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('CRITERIA', ['criteria-check', 'gred' => $model->ads_id, 'icno' => sha1($model->ICNO), 'pakar' => $model->status_kepakaran], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                                        } else {
                                            return Html::a('RESUME', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('JD', [ 'jd', 'id' => $model->ICNO], ['class' => 'btn-md btn ' . $btn, 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->user->ICNO), 'gred_id' => $model->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('CRITERIA', ['criteria-check-administration', 'icno' => sha1($model->ICNO)], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                                        }
                                    },
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                                        ],
                                    ];



                                    echo GridView::widget([
                                        'dataProvider' => $doneVerify,
                                        'columns' => $gridColumns1,
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
                                            'heading' => '<h2>Done Verify</h2>',
                                        ],
                                    ]);
                                    ?>
        </div>


    </div>
</div>  

