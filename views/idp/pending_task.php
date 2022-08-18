<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\myidp\BorangPenilaianLatihan;
use app\models\myidp\PermohonanKursusLuar;
use app\models\myidp\PermohonanMataIdpIndividu;
use app\models\myidp\UserAccess;
error_reporting(0);
echo $this->render('/idp/_topmenu');

$colorPluginOptions =  [
    'showPalette' => true,
    'showPaletteOnly' => true,
    'showSelectionPalette' => true,
    'showAlpha' => false,
    'allowEmpty' => false,
    'preferredFormat' => 'name',
    'palette' => [
        [
            "white", "black", "grey", "silver", "gold", "brown", 
        ],
        [
            "red", "orange", "yellow", "indigo", "maroon", "pink"
        ],
        [
            "blue", "green", "violet", "cyan", "magenta", "purple", 
        ],
    ]
];

$gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'36px',
        'pageSummary'=>'Jumlah',
        'pageSummaryOptions' => ['colspan' => 2],
        'header'=>'',
        'headerOptions'=>['class'=>'kartik-sheet-style']
    ],
    [
        //'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'task_submenu',
        'header' => 'Tindakan', 
        'pageSummary' => 'Jumlah',
        'vAlign' => 'middle',
        'width' => '210px',
        // 'readonly' => function($model, $key, $index, $widget) {
        //     return (!$model->status); // do not allow editing of inactive records
        // },
        // 'editableOptions' =>  function ($model, $key, $index) use ($colorPluginOptions) {
        //     return [
        //         'header' => 'Name', 
        //         'size' => 'md',
        //         'afterInput' => function ($form, $widget) use ($model, $index, $colorPluginOptions) {
        //             return $form->field($model, "color")->widget(\kartik\color\ColorInput::classname(), [
        //                 'showDefaultPalette' => false,
        //                 'options' => ['id' => "color-{$index}"],
        //                 'pluginOptions' => $colorPluginOptions,
        //             ]);
        //         }
        //     ];
        // }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Bilangan', 
        // 'dropdown' => $this->dropdown,
        // 'dropdownOptions' => ['class' => 'float-right'],
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                if ($model->task_id == '2'){
                    return Html::a(
                        PermohonanKursusLuar::totalPendingAkademik(),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '3'){
                    return Html::a(
                        PermohonanKursusLuar::totalPendingPentadbiran(),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '4'){
                    return Html::a(
                        PermohonanKursusLuar::totalPendingSurat(1),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '5'){
                    return Html::a(
                        PermohonanKursusLuar::totalPendingSurat(2),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '6'){
                    return Html::a(
                        PermohonanKursusLuar::totalPending(3),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '7'){
                    return Html::a(
                        PermohonanKursusLuar::totalPending(1),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '8'){
                    return Html::a(
                        PermohonanKursusLuar::totalPending(220),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '9'){
                    return Html::a(
                        PermohonanKursusLuar::totalPending(20),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '10'){
                    return Html::a(
                        PermohonanKursusLuar::totalPendingSurat(11),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '11'){
                    return Html::a(
                        PermohonanKursusLuar::totalPendingSurat(22),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '12'){
                    return Html::a(
                        PermohonanMataIdpIndividu::totalPending(UserAccess::getPegawai(), 22),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '13'){
                    return Html::a(
                        PermohonanMataIdpIndividu::totalPending(UserAccess::getPegawai(), 2),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '14'){
                    return Html::a(                       
                        PermohonanKursusLuar::totalPending(221),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '15'){
                    return Html::a(
                        PermohonanKursusLuar::totalPending(21),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '16'){
                    return Html::a(
                        PermohonanMataIdpIndividu::totalPending(UserAccess::getKetuaSektor(), 3),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                } elseif ($model->task_id == '17'){
                    return Html::a(
                        PermohonanMataIdpIndividu::totalPending(UserAccess::getKetuaSektor(), 4),
                        $url, 
                        [
                            'title' => 'Papar',
                            'data-pjax' => '0',
                            'target' => "_blank"
                        ]
                    );

                }
            },
        ],
        //'urlCreator' => function($action, $model, $key, $index) { return '#'; },
        'urlCreator' => function ($action, $model, $key, $index) {

            $url = '';

            if ($model->task_id == '2'){
                $url = 'semakan-kursus-luar-akademik';

            } elseif ($model->task_id == '3'){
                $url = 'semakan-kursus-luar-pentadbiran';

            } elseif ($model->task_id == '4'){
                $url = 'semakan-surat-kursus-luar-akademik';

            } elseif ($model->task_id == '5'){
                $url = 'semakan-surat-kursus-luar-pentadbiran';

            } elseif ($model->task_id == '6'){
                $url = 'semakan-bsmm';

            } elseif ($model->task_id == '7'){
                $url = 'semakan-bsm';

            } elseif ($model->task_id == '8'){
                $url = 'semakan-kursus-luar-akademik';

            } elseif ($model->task_id == '9'){
                $url = 'semakan-kursus-luar-pentadbiran';

            } elseif ($model->task_id == '10'){
                $url = 'semakan-surat-kursus-luar-akademik';

            } elseif ($model->task_id == '11'){
                $url = 'semakan-surat-kursus-luar-pentadbiran';

            } elseif ($model->task_id == '12'){
                $url = 'pengesahan-bsm-akademik';

            } elseif ($model->task_id == '13'){
                $url = 'pengesahan-bsm';

            } elseif ($model->task_id == '14'){
                $url = 'semakan-kursus-luar-akademik';
                
            } elseif ($model->task_id == '15'){
                $url = 'semakan-kursus-luar-pentadbiran';

            } elseif ($model->task_id == '16'){
                $url = 'kelulusan-bsm-akademik';

            } elseif ($model->task_id == '17'){
                $url = 'kelulusan-bsm';    
            }

            return $url;
        },
        'viewOptions' => ['title' => 'This will launch the book details page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
        // 'updateOptions' => ['title' => 'This will launch the book update page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
        // 'deleteOptions' => ['title' => 'This will launch the book delete action. Disabled for this demo!', 'data-toggle' => 'tooltip'],
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
];


?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div>
                <h3><span class="label label-primary" style="color: white">UNIT LATIHAN & PEMBANGUNAN PROFESIONAL</span></h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_title">
                <h2><strong><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="label label-success" style="color: white"><?= $title; ?></span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
<div class="row">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
        // 'panel' => [
        //     'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Tindakan Urusetia</h3>',
        //     'type'=>'info',
        //     // 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        //     // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        //     'footer' => false
        // ],
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],

    ]); ?>

</div>
     </div> <!-- x_content -->
        </div>
    </div>
</div>

<!-- <div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="label label-success" style="color: white">Tindakan Pegawai</span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
<div class="row">

< GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
        // 'panel' => [
        //     'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Tindakan Urusetia</h3>',
        //     'type'=>'info',
        //     // 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        //     // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        //     'footer' => false
        // ],
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],

    ]); ?>

</div>
     </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="label label-success" style="color: white">Tindakan Sektor</span></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
<div class="row">

< GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
        // 'panel' => [
        //     'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Tindakan Urusetia</h3>',
        //     'type'=>'info',
        //     // 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        //     // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        //     'footer' => false
        // ],
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],

    ]); ?>

</div>
     </div>
        </div>
    </div>
</div> -->