<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\kehadiran\TblYears;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\export\ExportMenu;


$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <div class="x_title">
                <?= Html::a('Add New', ['manage/add'], ['class' => 'btn btn-success']) ?> 

                <div class="clearfix"></div>
            </div>
     
            <div class="pull-left">
                <?php
                $gridColumns = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],
                    //                    'nama',

                    [
                        'attribute' => 'Staff Name',
                        'value' => 'kakitangan.CONm',
                    ],
                    [
                        'attribute' => 'Level',
                        'value' => 'levels',
                    ],
                    [
                        'attribute' => 'user',
                        'value' => 'user',
                    ],
                    [
                        'attribute' => 'title',
                        'value' => 'title',
                    ],
                    [
                        'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} | {delete}',
                        'buttons' => [
                            'update' => function ($url) {
                                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'Update'),
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete?'),
                                    // 'data-method' => 'post', 'data-pjax' => '0',
                                ]);
                            },
                            'delete' => function ($url) {
                                return Html::a('<span class="fa fa-trash-o"></span>', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete?'),
                                    'data-method' => 'post', 'data-pjax' => '0',
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'update') {
                                $url = Url::to(['edit', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['delete', 'id' => $model->id]);
                                return $url;
                            }
                        }
                    ],
                   
                    // [
                    //     'attribute' => 'external',
                    //     // 'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'external'),
                    // ],
                ];

                //     // echo ExportMenu::widget([
                //     //     'dataProvider' => $dataProvider,
                //     //     'columns' => $gridColumns,
                //     //     'clearBuffers' => true,
                //     //     'filename' => 'Senarai Cuti',

                //     // ]

                // );
                ?>
            </div>

            <div class="x_content">
                <?php


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'responsiveWrap' => true,
                    'responsive' => true,
                    'hover' => true,
                    'showFooter' => true,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                    'pjax' => true,
                    'pjaxSettings' => [
                        'neverTimeout' => true,
                    ]
                ]);
                ?>

            </div>
        </div>
    </div>
</div>