<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kop\y2sp\ScrollPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */

$this->registerJs("
document.getElementById('btn_refresh').addEventListener('click', refresh, false);

function refresh()
{
    $.pjax.reload({
        container:'#grid_report',
        timeout:60000,
    })
}
");

function relative_date($time)
{
    $today = strtotime(date('M j, Y'));
    $reldays = ($time - $today) / 86400;
    if ($reldays >= 0 && $reldays < 1) {
        return 'Today';
    } else if ($reldays >= 1 && $reldays < 2) {
        return 'Tomorrow';
    } else if ($reldays >= -1 && $reldays < 0) {
        return 'Yesterday';
    }
    if (abs($reldays) < 7) {
        if ($reldays > 0) {
            $reldays = floor($reldays);
            return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');
        } else {
            $reldays = abs(floor($reldays));
            return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';
        }
    }
    if (abs($reldays) < 182) {
        return date('l, j F', $time ? $time : time());
    } else {
        return date('l, j F, Y', $time ? $time : time());
    }
}

?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchBorang_2', ['model' => $searchModel, 'action' => Url::to(['elnpt/pengurusan-cadangan-apc'])]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Jana</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'grid_report']); ?>
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'dataProvider' => $listDownloads,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'NAMA',
                                'headerOptions' => ['class' => 'text-center'],
                                'attribute' => 'file_name',
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'USER',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->createUser->CONm;
                                }
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'DATE CREATED',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return relative_date(strtotime($model->created_dt));
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{download} {delete}',
                                //'header' => 'TINDAKAN',
                                'buttons' => [
                                    'download' => function ($url, $model) use ($uapi) {
                                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $uapi->DisplayFile($model->filehash, true), ['title' => 'Download']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['elnpt/delete-file', 'filehash' => $model->filehash]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Adakah anda pasti?']);
                                    },
                                ],
                            ]
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>

                <p>
                    Sila tekan butang
                    <?=
                    Html::button(
                        '<span class="glyphicon glyphicon-refresh"></span>',
                        [
                            'id' => 'btn_refresh',
                            'class' => 'btn btn-default btn-sm',
                        ]
                    );
                    ?>
                    untuk <i>refresh</i> semula senarai di atas.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian</strong></h2> <?= Html::a('<i class="fa fa-download"> Muat turun Laporan</i>', ['elnpt/generate-laporan-apc', 'tahun' => Yii::$app->request->get('tahun')], ['class' => 'btn btn-default btn-sm pull-right']); ?>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <?php
                Modal::begin([
                    'header' => 'Cadangan APC',
                    'id' => 'modal',
                    'size' => 'modal-md',
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
                ?>
                <p><strong>PYD dengan markah julat 85 hingga 100 bagi Tahun Penilaian <?= Yii::$app->request->get('tahun'); ?></strong></p>
                <p><i>* Klik column NAMA / NO IC, MARKAH LNPT untuk mengubah susunan data.</i></p>
                <?php Pjax::begin(['id' => 'my_pjax']); ?>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        // 'pager' => [
                        //     'class' => ScrollPager::className(),
                        //     'container' => '.grid-view tbody',
                        //     'triggerOffset' => 10,
                        //     'item' => 'tr',
                        //     'paginationSelector' => '.grid-view .pagination',
                        //     'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                        //     // 'enabledExtensions' => [
                        //     //     ScrollPager::EXTENSION_TRIGGER,
                        //     //     ScrollPager::EXTENSION_SPINNER,
                        //     //     ScrollPager::EXTENSION_NONE_LEFT,
                        //     //     ScrollPager::EXTENSION_PAGING,
                        //     // ],
                        //     'eventOnScroll' => 'function() {
                        //             $(\'.modalButton\').on(\'click\', function () {
                        //                 $(\'#modal\').modal(\'show\')
                        //                         .find(\'#modalContent\')
                        //                         .load($(this).attr(\'value\'));
                        //             });
                        //         }',
                        // ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            // [
                            //         'label' => 'TAHUN PENILAIAN',
                            //         'headerOptions' => ['class'=>'text-center col-md-1'],
                            //         'contentOptions' => ['class'=>'text-center'],
                            //         'value' => function($model) {
                            //             return $model->tahun;
                            //         },
                            //         //'attribute' => 'tahun',
                            //         'format' => 'html',
                            // ],            
                            [
                                'label' => 'NAMA / NO IC',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return '' . $model->guru->CONm . '<br><strong>(' . $model->PYD . ')</strong>';
                                },
                                'format' => 'html',
                                'attribute' => '`g`.`CONm`',
                            ],
                            [
                                'label' => 'GRED JAWATAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return '<strong>' . $model->gredGuru->gred . '</strong><br>' . $model->gredGuru->nama . '';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JFPIU',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->deptGuru->shortname;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'MARKAH LNPT',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->markahAll) ? '' : '<strong>' . $model->markahAll->markah . '</strong>';
                                },
                                'format' => 'html',
                                'attribute' => '`m`.`markah`',
                            ],
                            [
                                'label' => 'TARIKH LANTIKAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->sandangan2) ? '' : $model->sandangan2->start_date;
                                },
                            ],
                            [
                                'label' => 'TARIKH NAIK PANGKAT',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->sandangan) ? '' : $model->sandangan->latest_start_date;
                                },
                            ],
                            [
                                'label' => 'APC',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->apc) ? '' : date('Y', strtotime($model->apc->last_date_awd));
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'APT',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->apt) ? '' : date('Y', strtotime($model->apt->last_date_awd));
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'CATATAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    if (is_null($model->cdg)) {
                                        return '';
                                    } else {
                                        $arr = [];
                                        if ($model->cdg->cadang == 1)
                                            array_push($arr, '<font color=blue>Cadangan APC ' . $model->tahun . '</font>');
                                        if ($model->cdg->panel == 1)
                                            array_push($arr, '<font color=red>Cadangan Panel ' . $model->tahun . '</font>');

                                        return join('<br>', $arr);
                                    }
                                },
                                'format' => 'html',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{reset} {delete}',
                                'buttons' => [
                                    'reset' => function ($url, $model) {
                                        $url = Url::to(['elnpt/cadangan-apc', 'lpp_id' => $model->lpp_id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    },
                                    'delete' => function ($url, $model) {
                                        if (is_null($model->cdg)) {
                                            return '';
                                        } else {
                                            return Html::a('<i class="fa fa-trash"></i>', ['elnpt/buang-cadangan-apc', 'lpp_id' => $model->lpp_id], ['class' => 'btn btn-danger btn-xs']);
                                        }
                                    },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>