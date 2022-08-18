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

                if (TblAccess::isAdminPanelTapisan()||TblAccess::isExternalUner()) {
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
                            'label' => 'Applied',
                            'value' => function($model) {
                                return '<b><u><a href=' . Url::to(['list-candidate', 'id' => $model->ads_id, 'status' => 1]) . '> ' . $model->TotalVerify(2, $model->ads_id, 1) . '</a></u></b>';
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center', 'width' => '120px'],
                                ],
                                [
                                    'label' => 'Waiting',
                                    'value' => function($model) {
                                        return '<p style="color:red;"><b><u><a href=' . Url::to(['list-candidate-wait', 'id' => $model->ads_id]) . '> ' . $model->TotalWaiting($model->ads_id) . '</a></u></p></b>';
                                    },
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'label' => 'Additional candidate',
                                            'value' => function($model) {
                                                return '<b><u><a href=' . Url::to(['list-candidate-kiv', 'id' => $model->ads_id]) . '> ' . $model->TotalVerifyKiv($model->ads_id) . '</a></u></b>';
                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                [
                                                    'label' => 'Total',
                                                    'value' => function($model) {
                                                        return ' <b><u><a href=' . Url::to(['list-candidate-jawatankuasa', 'gred' => $model->ads_id]) . '> ' . ($model->TotalVerify(2, $model->ads_id, 1) + $model->TotalWaiting($model->ads_id) + $model->TotalVerifyKiv($model->ads_id)) . '</a></u></b> ';
                                                    },
                                                            'format' => 'raw',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                        ],
                                                        [
                                                            'label' => 'File',
                                                            'value' => function($model) {
                                                                $f = app\models\cv\TblFileTapisan::find()->where(['jawatan_id' => $model->jawatan->id])->orderBy(['added_at' => SORT_DESC])->one();
                                                                if ($f) {
                                                                    if ($f->file) {
                                                                        return Html::a(Yii::$app->FileManager->NameFile($f->file), Yii::$app->FileManager->DisplayFile($f->file), ['target' => '_blank']);
                                                                    } else {
                                                                        return '';
                                                                    }
                                                                } else {
                                                                    return '';
                                                                }
                                                            },
                                                                    'format' => 'raw',
                                                                    'contentOptions' => ['class' => 'text-center', 'width' => '250px'],
                                                                    'pageSummary' => true
                                                                ],
                                                            ];
                                                        } elseif (TblAccess::isAdminPanelPemilih()||TblAccess::isExternalUner()) {
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
                                                                        return ' <b><u><a href=' . Url::to(['list-candidate-jawatankuasa', 'gred' => $model->ads_id]) . '> ' . ($model->TotalVerify(2, $model->ads_id, 1) + $model->TotalWaiting($model->ads_id) + $model->TotalVerifyKiv($model->ads_id)) . '</a></u></b> ';
                                                                    },
                                                                            'format' => 'raw',
                                                                            'contentOptions' => ['class' => 'text-center'],
                                                                        ],
                                                                        [
                                                                            'label' => 'File',
                                                                            'value' => function($model) {
                                                                                $f = app\models\cv\TblFileTapisan::find()->where(['jawatan_id' => $model->jawatan->id])->orderBy(['added_at' => SORT_DESC])->one();
                                                                                if ($f) {
                                                                                    if ($f->file) {
                                                                                        return Html::a(Yii::$app->FileManager->NameFile($f->file), Yii::$app->FileManager->DisplayFile($f->file), ['target' => '_blank']);
                                                                                    } else {
                                                                                        return '';
                                                                                    }
                                                                                } else {
                                                                                    return '';
                                                                                }
                                                                            },
                                                                                    'format' => 'raw',
                                                                                    'contentOptions' => ['class' => 'text-center', 'width' => '250px'],
                                                                                    'pageSummary' => true
                                                                                ],
                                                                            ];
                                                                        } else { //belum ada access
                                                                            $gridColumns = [
                                                                                ['class' => 'yii\grid\SerialColumn'],
                                                                                [
                                                                                    'label' => 'Position',
                                                                                    'value' => function($model) {
                                                                                        return $model->jawatan->fname;
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

