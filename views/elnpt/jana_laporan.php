<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

$gridColumns = [
//    ['class' => 'yii\grid\SerialColumn'],
    [
        'label' => 'NAMA',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->CONm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'UMSPER',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->COOldID;

        },
        'format' => 'html',
    ],
    [
        'label' => 'GRED',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->jawatan->gred;

        },
        'format' => 'html',
    ],
    [
        'label' => 'JAWATAN',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->jawatan->nama;

        },
        'format' => 'html',
    ], 
    [
        'label' => 'JFPIU',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->department->fullname;

        },
        'format' => 'html',
    ],
    [
        'label' => 'KUMPULAN',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->jawatan->skimPerkhidmatan->name;

        },
        'format' => 'html',
    ],
    [
        'label' => 'STATUS',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->serviceStatus->ServStatusNm;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'LANTIKAN',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->statusLantikan->ApmtStatusNm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH LANTIKAN',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->startDateLantik;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH SANDANGAN',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->startDateSandangan;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH STATUS',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->guru->startDateStatus;

        },
        'format' => 'html',
    ],
    [
        'label' => 'NAMA PPP',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return is_null($model->ppp) ? null : $model->ppp->CONm;

        },
        'format' => 'html',
    ], 
    [
        'label' => 'NAMA PPK',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return is_null($model->ppk) ? null : $model->ppk->CONm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'NAMA PEER',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return is_null($model->peer) ? null : $model->peer->CONm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH SAH DATETIME',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->PYD_sah_datetime;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'MARKAH PPP',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah_ppp;

        },
        'format' => 'html',
    ],
    [
        'label' => 'MARKAH PPK',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah_ppk;

        },
        'format' => 'html',
    ], 
    [
        'label' => 'MARKAH PEER',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah_peer;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'MARKAH PURATA',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah;

        },
        'format' => 'html',
    ],
    [
        'label' => 'BULAN PGT',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->bulanPgt->SalMoveMth;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'CATATAN',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->catatan;

        },
        'format' => 'html',
    ],            
//    ['class' => 'yii\grid\ActionColumn'],
];


/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchBorang', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Hasil Carian</strong></h2><div  class="pull-right"><?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'filename' => 'laporan_elnpt_akademik_'.date('Y-m-d'),
                'clearBuffers' => true,
                'stream' => false,
                'folder' => '@app/web/files/elnpt/.',
                'linkPath' => '/files/elnpt/',
                'batchSize' => 10,
//                'deleteAfterSave' => true
            ]); ?></div>
            <div class="clearfix"></div>
            
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
                            'pager' => [
                                'class' => \kop\y2sp\ScrollPager::className(),
                                'container' => '.grid-view tbody',
                                'triggerOffset' => 10,
                                'item' => 'tr',
                                'paginationSelector' => '.grid-view .pagination',
                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                             ],
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns
                        ]);
                    ?>
                </div>
        </div>
    </div>
    </div>
</div>       