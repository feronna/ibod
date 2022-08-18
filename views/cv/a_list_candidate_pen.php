<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\cv\TblAccess;

$request = Yii::$app->request;
if(TblAccess::isAdminPanelTapisanPen() || TblAccess::isAdminPanelPemilihPen()){
    $url = 'jawatankuasa-pentadbiran';
}else{
    $url = 'applications';
}

?> 
<?= $this->render('menu') ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">APPLICATION - <?= $gred; ?></p>
        <p align="right">
            <?php if (TblAccess::isAdminAcademic() || TblAccess::isAdminPanel()) { ?>
                <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>
            <?php } ?>
            <?= Html::a('Back', [$url], ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <div class="table-responsive">

            <?php
            if(TblAccess::isAdminPanelTapisanPen() || TblAccess::isAdminPanelPemilihPen()){
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
                    'label' => 'Current Position',
                    'value' => function($model) {
                        return $model->user->jawatan->fname;
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Department',
                    'value' => function($model) {
                        return $model->user->department ? $model->user->department->fullname : ' ';
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Dean Status',
                    'value' => function($model) {
                        return $model->getStatusKj($model->id);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Comment',
                    'value' => function($model) {
                        return Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kj-comment', 'id' => $model->id]), 'class' => 'fa fa-eye mapBtn btn btn-default btn-lg']);
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Details',
                            'value' => function($model) {
                                if ($model->checkJd($model->ICNO)) {
                                    $btn = 'btn-default';
                                } else {
                                    $btn = 'btn-danger';
                                }
                                return Html::a('RESUME', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('JD', [ 'jd', 'id' => $model->ICNO], ['class' => 'btn-md btn ' . $btn, 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->user->ICNO), 'gred_id' => $model->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']).Html::a('CRITERIA', [ 'criteria-check-administration', 'icno' => sha1($model->ICNO)], ['class' => 'btn-md btn ' . $btn, 'target' => '_blank']);
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center', 'width' => '250px'],
                                ], 
                                    ];
            }else{
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
                    'label' => 'Current Position',
                    'value' => function($model) {
                        return $model->user->jawatan->fname;
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Department',
                    'value' => function($model) {
                        return $model->user->department ? $model->user->department->fullname : ' ';
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Dean Status',
                    'value' => function($model) {
                        return $model->getStatusKj($model->id);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Comment',
                    'value' => function($model) {
                        return Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kj-comment', 'id' => $model->id]), 'class' => 'fa fa-eye mapBtn btn btn-default btn-lg']);
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Details',
                            'value' => function($model) {
                                if ($model->checkJd($model->ICNO)) {
                                    $btn = 'btn-default';
                                } else {
                                    $btn = 'btn-danger';
                                }
                                return Html::a('RESUME', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('JD', [ 'jd', 'id' => $model->ICNO], ['class' => 'btn-md btn ' . $btn, 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->user->ICNO), 'gred_id' => $model->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']).Html::a('CRITERIA', ['criteria-check-administration', 'icno' => sha1($model->ICNO)], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center', 'width' => '250px'],
                                ],
                                [
                                    'label' => 'Action',
                                    'value' => function($model) {
                                        if (empty($model->admin_ICNO)) {
                                            return Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['admin-approval', 'id' => $model->id]), 'class' => 'fa fa-envelope mapBtn btn btn-default btn-md']);
                                        } else {
                                            return $model->getStatusAdminPentadbiran($model->id);
                                        }
                                    },
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                    ];
            }

                                    echo GridView::widget([
                                        'dataProvider' => $Verify,
                                        'columns' => $gridColumns,
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
                                    ]);
                                    ?>
        </div>




    </div>
</div>  






