<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tmp = 'carian-borang-lpp';
$title = 'Carian borang LPP';

$gridColumns = [
    [

        'label' => 'NAMA',
        'headerOptions' => ['class' => 'text-center'],

        'value' => function ($model) {
            return $model->pyd->CONm;
        },
        'format' => 'html',
    ],
    [

        'label' => 'JAFPIB',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return $model->department->shortname;
        },
    ],
    [

        'label' => 'PPP',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->ppp) ? '-' : $model->ppp->CONm;
        },
        'format' => 'html',
    ],
    [

        'label' => 'PPK',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->ppk) ? '-' : $model->ppk->CONm;
        },
        'format' => 'html',
    ],
    [

        'label' => 'PP',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->ppAll) ? '-' : $model->ppAll->CONm;
        },
        'format' => 'html',
    ],
    [

        'label' => 'MARKAH PPP',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->markahSeluruh) ? '-' : $model->markahSeluruh->markah_PPP;
        },
        'format' => 'html',
    ],
    [

        'label' => 'MARKAH PPK',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->markahSeluruh) ? '-' : $model->markahSeluruh->markah_PPK;
        },
        'format' => 'html',
    ],
    [

        'label' => 'MARKAH PURATA',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function ($model) {
            return is_null($model->markahSeluruh) ? '-' : $model->markahSeluruh->markah_PP;
        },
        'format' => 'html',
    ],
];

?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_carian_borang', ['model' => $searchModel, 'tmp' => $tmp, 'title' => $title]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian Borang LPP: Senarai Pegawai Pentadbiran <?= is_null($searchModel->tahun) ? '' : 'Bagi Tahun Penilaian ' . $searchModel->tahun; ?></strong></h2>

                <div class="pull-right"><?= ExportMenu::widget([
                                            'dataProvider' => $dataProvider,
                                            'columns' => $gridColumns,
                                            'filename' => 'senarai_nama_' . date('Y-m-d'),
                                            'clearBuffers' => true,
                                            'stream' => false,
                                            'folder' => '@app/web/files/lppums/.',
                                            'linkPath' => '/files/lppums/',
                                            'batchSize' => 10,

                                        ]); ?></div>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([



                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [

                                    'label' => 'NAMA',
                                    'headerOptions' => ['class' => 'text-center'],

                                    'value' => function ($model) {
                                        return Html::a('<strong>' . $model->pyd->CONm . '</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id]) . '<br><small>' . $model->department->fullname . '</small>' .
                                            '<br><small>' . $model->gredJawatan->nama . ' ' . $model->gredJawatan->gred;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'JAFPIB',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->department->shortname;
                                    },
                                ],
                                [

                                    'label' => 'PPP',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppp) ? '-' : $model->ppp->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'PPK',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppk) ? '-' : $model->ppk->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'PP',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->ppAll) ? '-' : $model->ppAll->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'MARKAH PPP',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->markahSeluruh) ? '-' : $model->markahSeluruh->markah_PPP;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'MARKAH PPK',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->markahSeluruh) ? '-' : $model->markahSeluruh->markah_PPK;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'MARKAH PURATA',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return is_null($model->markahSeluruh) ? '-' : $model->markahSeluruh->markah_PP;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'JANA BORANG',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{generate}',

                                    'buttons' => [
                                        'generate' => function ($url, $model) {
                                            $url = Url::to(['lppums/generate-borang', 'lpp_id' => $model->lpp_id,]);

                                            if (is_null($model->ppAll)) {
                                                return (($model->PYD_sah == 1) && ($model->PPP_sah == 1) && ($model->PPK_sah == 1))
                                                    ? Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, [
                                                        'title' => 'Generate Borang',
                                                    ])
                                                    : '';
                                            } else {
                                                return (($model->PYD_sah == 1) && ($model->PPP_sah == 1))
                                                    ? Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, [
                                                        'title' => 'Generate Borang',
                                                    ])
                                                    : '';
                                            }
                                        },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>