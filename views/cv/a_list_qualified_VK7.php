<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\cv\TblAccess;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">CHECK QUALIFIED - (DS54) Profesor Madya To (VK7) Profesor Gred Khas C</p>
        <p align="right">

            <?= Html::a('Back', ['applications'], ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <div class="table-responsive">

            <?php
            if (TblAccess::isAdminAcademic()) {
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'], 
                    [
                        'label' => 'Name',
                        'value' => function ($model) {
                            return ucwords(strtolower($model->user->CONm));
                        },
                        'format' => 'raw',
                    ], 
                    [
                        'label' => 'Department',
                        'value' => function ($model) {
                            return $model->user->department ? $model->user->department->shortname : ' ';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Umum',
                        'value' => function ($model) {
                            return $model->K1 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Penyelidikan',
                        'value' => function ($model) {
                            return $model->K2 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Penerbitan',
                        'value' => function ($model) {
                            return $model->K3 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Pengajaran',
                        'value' => function ($model) {
                            return $model->K4 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Penyeliaan',
                        'value' => function ($model) {
                            return $model->K5 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Sanjungan',
                        'value' => function ($model) {
                            return $model->K6 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Khidmat',
                        'value' => function ($model) {
                            return $model->K7 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Perundingan',
                        'value' => function ($model) {
                            return $model->K8 == 1 ? 'PASS': 'FAIL';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Percent',
                        'value' => function ($model) {
                            return Html::a($model->percent, ['criteria-check', 'gred' => 10, 'icno' => sha1($model->user->ICNO)], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
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
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                ]);
            }
            ?>



