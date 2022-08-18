<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use kartik\mpdf\Pdf;
use app\widgets\TopMenuWidget;

$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
TopMenuWidget::widget(['top_menu' => [18, 44, 45, 51], 'vars' => [
        ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]);
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>
<?= Html::a('Create Tbl Mohontest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Jawatan</strong></h2>
                <div class="clearfix"></div>
            </div>

            <?php
            echo ExportMenu::widget([
                'options' => [
                    'class' => 'table-responsive',
                ],
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'headerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
                    [
                        'label' => 'Nama Pemohon',
                        'value' => 'kakitangan.CONm',
                    ],
                    [
                        'label' => 'Jawatan Dipohon',
                        'value' => 'gredjawatan.fname',
                    ],
                    [
                        'label' => 'J/F/P/I/U',
                        'value' => 'dept.shortname',
                    ],
                    [
                        'label' => 'Tarikh Mohon',
                        'attribute' => 'tarikhmohon',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Unit Ditetapkan',
                        'value' => 'unit',
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'statusLabel',
                        'format' => 'raw',
                    ],
                ],
                'exportConfig' => [// set styling for your custom dropdown list items
                    ExportMenu::FORMAT_CSV => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_EXCEL => false,
                    ExportMenu::FORMAT_EXCEL_X =>
                    [
                        'options' => ['style' => 'float: right; font-size:18px;'],
                        'label' => 'Muat Turun',
                        'fontAwesome' => true,
                        'icon' => ['class' => 'fa fa-file-o'],
                        'config' => [
                            'methods' => [
                                'SetHeader' => ['Permohonan Jawatan'],
                            ]
                        ],
                    ],
                ],
                'clearBuffers' => true,
                'showConfirmAlert' => FALSE,
                'filename' => 'Permohanan Jawatan',
                'asDropdown' => true,
                'dropdownOptions' => [
        'label' => 'Export',
        'class' => 'btn btn-secondary'
    ],
            ]);
            ?>
            <div class="x_content">

                <?=
                GridView::widget([
                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    /*   'filterModel' => $searchModel, */ //to hide the search row
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'kakitangan.CONm',
                        ],
                        [
                            'label' => 'Jawatan Dipohon',
                            'value' => 'gredjawatan.fname',
                        ],
                        [
                            'label' => 'J/F/P/I/U',
                            'value' => 'dept.shortname',
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'attribute' => 'tarikhmohon',
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Unit Ditetapkan',
                            'value' => 'unit',
                        ],
                        [
                            'label' => 'Status',
                            'attribute' => 'statusLabel',
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return Html::button('Peraku', ['id' => 'modalButton', 'value' => Url::to(['perakuan_pegawai_perjawatan', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
                            },
                        ],
                        [
                            'label' => 'View',
                            'format' => 'raw',
                            'value' => function ($data) {

                                return Html::a('<i class="fa fa-eye">', ["openpos/tindakan_pegawai_perjawatan", 'id' => $data->id]);
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>


