<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\export\ExportMenu;


$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenuWidget::widget(['top_menu' => [18, 44, 45, 51], 'vars' => [
    ['label' => ''],
    //    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);      
?>

 <?php
    // echo ExportMenu::widget([
    //     'options' => [
    //         'class' => 'table-responsive',
    //     ],
    //     'dataProvider' => $dataProviders,
    //     'columns' => [
    //         [
    //             'class' => 'kartik\grid\SerialColumn',
    //             'headerOptions' => [
    //                 'style' => 'display: none;',
    //             ]
    //         ],
    //         [
    //             'label' => 'Nama Pemohon',
    //             'value' => 'kakitangan.CONm',
    //         ],
    //         [
    //             'label' => 'Jawatan Dipohon',
    //             'value' => 'gredjawatan.fname',
    //         ],
    //         [
    //             'label' => 'J/F/P/I/U',
    //             'value' => 'dept.shortname',
    //         ],
    //         [
    //             'label' => 'Tarikh Mohon',
    //             'attribute' => 'tarikhmohon',
    //             'format' => 'raw',
    //         ],
    //         [
    //             'label' => 'Unit Ditetapkan',
    //             'value' => 'unit',
    //         ],
    //         [
    //             'label' => 'Status',
    //             'attribute' => 'statusLabel',
    //             'format' => 'raw',
    //         ],
    //     ],
    //     'exportConfig' => [ // set styling for your custom dropdown list items
    //         ExportMenu::FORMAT_CSV => false,
    //         ExportMenu::FORMAT_TEXT => false,
    //         ExportMenu::FORMAT_HTML => false,
    //         ExportMenu::FORMAT_PDF => TRUE,
    //         ExportMenu::FORMAT_EXCEL_X => false,
    //         ExportMenu::FORMAT_EXCEL =>
    //         [
    //             'options' => ['style' => 'float: left; font-size:18px;'],
    //             'label' => '<i class="fa fa-arrow-circle-down"></i> Muat Turun',
    //             'icon' => 'floppy-remove',
    //             'iconOptions' => ['class' => 'text-success'],
    //         ],
    //     ],

    //     'showConfirmAlert' => FALSE,
    //     'filename' => 'Permohonan Jawatan',
    //     'asDropdown' => true,
    //     'showColumnSelector' => false,
    //     'dropdownOptions' => [
    //         'label' => 'Muat Turun Excel',
    //         'class' => 'btn btn-secondary'
    //     ]
    // ]);
    ?>
<?=

GridView::widget([
    'options' => [
        'class' => 'table-responsive',
    ],
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        if ($model) {
            return ['class' => 'info'];
        }
    },
    /*   'filterModel' => $searchModel, */ //to hide the search row
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'label' => 'Nama Pemohon',
            'value' => 'kakitangan.CONm',
            'format' => 'raw',
            //            'headerOptions' => ['class' => 'text-center'],
            //            'contentOptions' => ['class' => 'text-center'],
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'label' => 'J/F/P/I/U shortname',
            'value' => 'dept.shortname',
            'format' => 'raw',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            //            'headerOptions' => ['class' => 'text-center'],
            //            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'label' => 'J/F/P/I/U fullname',
            'value' => 'dept.fullname',
            'format' => 'raw',
            //            'headerOptions' => ['class' => 'text-center'],
            //            'contentOptions' => ['class' => 'text-center'],
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
        [
            'label' => 'View',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a('<i class="fa fa-eye">', ["openpos/s_permohonan_diperaku", 'id' => $data->icno]);
                // return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['tindakan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-eye mapBtn']);
            },
            //            'headerOptions' => ['class' => 'text-center'],
            //            'contentOptions' => ['class' => 'text-center'],
            'vAlign' => 'middle',
            'hAlign' => 'center',
        ],
    ],
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'resizableColumns' => true,
    'responsive' => false,
    'responsiveWrap' => false,
    'hover' => true,
    'floatHeader' => true,
    'floatHeaderOptions' => [
        'position' => 'absolute',
    ],
]);
?>
