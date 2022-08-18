<?php

use yii\helpers\Html;
use kartik\grid\GridView;

error_reporting(0);
?>
<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Html::a('<i class="fa fa-plus"></i>&nbsp;Tambah Tahun/Fasa', ['create-tahun'], ['class' => 'btn btn-primary']); ?>
                <br><br>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => false,
                        'columns' => [

                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil.',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            'tahun',
                            'fasa',
                            [
                                'label' => 'Status',
                                'value'=>'statusText',
                                'format'=>'raw',
                            ],
                            [
                                'label' => 'Papar Statistik',
                                'value'=>'paparText',
                                'format'=>'raw',
                            ],
                            'start_dt',
                            [
                                'label' => 'Update',
                                'value' => function ($model) {
                                    return Html::a('<i class="fa fa-pencil"></i>', ['update-tahun', 'id' => $model->id], ['class' => 'btn btn-sm btn-warning']);
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],
                            [
                                'label' => 'Delete',
                                'value' => function ($model) {

                                    return Html::a('<i class="fa fa-trash-o"></i>', ['delete-tahun', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure?',
                                        'method' => 'post',
                                    ],
                                    
                                    
                                    ]);
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],

                        ],

                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['position' => 'absolute'],
                        'resizableColumnsOptions' => ['resizeFromBody' => true]

                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>