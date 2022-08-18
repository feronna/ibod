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

<?php // echo $this->render('_search', ['model' => $searchModel]);      
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian/<i>Search</i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?= Html::beginForm(['ph-list'], 'GET'); ?>

        <?php echo Html::dropDownList('year', $year,$data, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
        <br>
        <br>

        <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
        <?= Html::endForm(); ?>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbsp;</strong></h2>

                <div class="clearfix"></div>
            </div>
            <?= Html::a('Add New Public Holiday', ['cuti/admin/creates'], ['class' => 'btn btn-success']) ?> 
            <?= Html::a('Copy From Last Year Public Holiday', ['cuti/admin/copy-ph','id'=>$year], ['class' => 'btn btn-warning','data-confirm'=>'Adakah anda pasti untuk Salin Cuti Umum daripada Tahun '.$year.'?']) ?> 
            <p style="color:red;"> Sekiranya Cuti Tersebut Hanya atau Sabah / Wilayah Nombor "1" akan ada di dalam senarai  </p>

            <div class="pull-left">
                <?php
                $gridColumns = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],
                    //                    'nama',

                    [
                        'attribute' => 'Nama Cuti',
                        'value' => 'nama_cuti',
                    ],
                    [
                        'attribute' => 'Tarikh Cuti',
                        'value' => 'tarikh_cuti',
                    ],
                    [
                        'attribute' => 'Sabah Sahaja',
                        'value' => 'sabah_sahaja',

                    ],
                    [
                        'attribute' => 'Wilayah Sahaja',
                        'value' => 'wilayah_sahaja',

                    ],
                    [
                        'attribute' => 'Catatan',
                        'value' => 'Catatan',

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
                                $url = Url::to(['cuti/admin/update-ph', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['cuti/admin/delete-ph', 'id' => $model->id]);
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