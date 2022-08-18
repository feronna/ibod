<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;

$gridColumn = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'BIL',
        'headerOptions' => ['class' => 'text-center col-md-1'],
        'contentOptions' => ['class' => 'text-center'],
    ],
    [
        'label' => 'NAMA STAF',
        'headerOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return Html::a('<strong>' . $model->pyd->CONm . '</strong>', Url::to(['lppums/bahagian1', 'lpp_id' => $model->lpp_id])) . '<br><small>' . $model->department->fullname . '</small>' .
                '<br><small>' . $model->gredJawatan->nama . ' ' . $model->gredJawatan->gred;
        },
        'format' => 'html',
    ],
    [
        'label' => 'TAHUN PENILAIAN',
        'headerOptions' => ['class' => 'text-center col-md-1'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return $model->tahun;
        },

        'format' => 'html',
    ],
    [
        'label' => 'PPP',
        'headerOptions' => ['class' => 'text-center col-md-2'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->ppp) ? '<font color="maroon"><i>(not set)</i></font>' : $model->ppp->CONm;
        },
        'format' => 'html',
    ],
    [
        'label' => 'PPK',
        'headerOptions' => ['class' => 'text-center col-md-2'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->ppk) ? '<font color="maroon"><i>(not set)</i></font>' : $model->ppk->CONm;
        },
        'format' => 'html',
    ],
    [
        'label' => 'MARKAH',
        'headerOptions' => ['class' => 'text-center col-md-1'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {


            return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PP;
        },

        'format' => 'html',
    ],
    [
        'label' => 'CATATAN',
        'headerOptions' => ['class' => 'text-center col-md-1'],

        'value' => function ($model) {
            return $model->catatan;
        },

        'format' => 'html',
    ],
    [
        'label' => 'STATUS PENILAIAN',
        'headerOptions' => ['class' => 'text-center col-md-1'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return empty($model->PP_ALL) ? (($model->PPP_sah == 1 &&
                $model->PPK_sah == 1) ? 'Selesai<br/><i class="fa fa-check-circle" style="font-size:24px;color:green"></i>' :
                'Belum Selesai<br/><i class="fa fa-close" style="font-size:24px;color:red"></i>')
                : (($model->PPP_sah == 1) ? 'Selesai<br/><i class="fa fa-check-circle" style="font-size:24px;color:green"></i>' :
                    'Belum Selesai<br/><i class="fa fa-close" style="font-size:24px;color:red"></i>');
        },
        'format' => 'html',
    ],
];


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tmp = 'penetap-markah-borang';
$title = 'Carian Borang';
?>

<?= $this->render('_menuUtama'); ?>

<?= $this->render('_carian_borang', ['model' => $searchModel, 'tmp' => $tmp, 'title' => $title]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Markah Staff</strong></h2>
                <div class="pull-right">
                    <?php
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumn,
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            //                        ExportMenu::FORMAT_HTML => false
                        ],
                        'filename' => 'senarai_penilai'
                    ]);
                    ?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'pager' => [
                            'class' => \kop\y2sp\ScrollPager::className(),
                            'container' => '.grid-view tbody',
                            'triggerOffset' => 10,
                            'item' => 'tr',
                            'paginationSelector' => '.grid-view .pagination',
                            'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumn,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>