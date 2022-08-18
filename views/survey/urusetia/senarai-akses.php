<?php

use app\models\hronline\Department;
use app\models\survey\TblAkses;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

error_reporting(0);
?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

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
                <?= Html::a('<i class="fa fa-plus"></i>&nbsp;Tambah Akses', ['create-akses', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
                <br><br>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        'columns' => [

                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil.',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'format' => 'raw',
                                'label' => 'Nama Pemohon',
                                'value' => function ($data) {
                                    return $data->kakitangan->displayTitleName;
                                },
                                'filter' => Select2::widget([
                                    'name' => 'icno',
                                    'value' => $icno,
                                    'data' => ArrayHelper::map(TblAkses::find()->where([])->all(), 'icno', 'kakitangan.CONm'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'left',
                            ],
                            [
                                'format' => 'raw',
                                'label' => 'JFPIB',
                                'value' => function ($data) {
                                    return $data->kakitangan->department->fullname;
                                },
                                'filter' => Select2::widget([
                                    'name' => 'dept_id',
                                    'value' => $dept_id,
                                    'data' => ArrayHelper::map(Department::find()->where([])->all(), 'id', 'fullname'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'left',
                            ],
                            [
                                'format' => 'raw',
                                'label' => 'Jenis Akses',
                                'value' => function ($data) {
                                    return $data->jenisAkses;
                                },
                                'filter' => Select2::widget([
                                    'name' => 'akses',
                                    'value' => $akses,
                                    'data' => ['1' => 'Urusetia Induk', '2' => 'Urusetia JFPIB'],
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'left',
                            ],
                            [
                                'label' => 'Update',
                                'value' => function ($model) {
                                    return Html::a('<i class="fa fa-pencil"></i>', ['update-akses', 'id' => $model->id], ['class' => 'btn btn-sm btn-warning']);
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],
                            [
                                'label' => 'Delete',
                                'value' => function ($model) {

                                    return Html::a('<i class="fa fa-trash-o"></i>', ['delete-akses', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Anda pasti untuk buang akses ini?',
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