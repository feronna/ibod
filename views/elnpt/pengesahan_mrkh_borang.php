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

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchBorang_1', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengurusan Status Borang</strong></h2>

                <div class="pull-right"><?= ExportMenu::widget([
                                            'dataProvider' => $dataProvider,
                                            'onRenderSheet' => function ($sheet, $grid) {
                                                $sheet->getStyle('J2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                                            },
                                            'columns' => [

                                                [
                                                    'class' => 'yii\grid\SerialColumn',
                                                    'header' => 'BIL',
                                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                //                                [
                                                //                                    'label' => 'NAMA GURU',
                                                //                                    'headerOptions' => ['class'=>'text-center'],
                                                //                                    'value' => function($model) {
                                                //                                        return $model->guru->CONm.'<br>';
                                                //                                    },
                                                //                                    'format' => 'html',
                                                //                                ],
                                                [
                                                    'label' => 'NAMA',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        return $model->guru->CONm;
                                                    },
                                                    'format' => 'html',
                                                ],
                                                [
                                                    'label' => 'GRED',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        return $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
                                                    },
                                                    'format' => 'html',
                                                ],
                                                [
                                                    'label' => 'J/F/P/I/U',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        return $model->deptGuru->fullname;
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
                                                    //'attribute' => 'tahun',
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
                                                    'label' => 'PEER',
                                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        return is_null($model->peer) ? '<font color="maroon"><i>(not set)</i></font>' : $model->peer->CONm;
                                                    },
                                                    'format' => 'html',
                                                ],
                                                [
                                                    'label' => 'PENGESAHAN',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                                                        //                                                    '<span class="label label-success">Active</span>';
                                                        if (($model->markah_sah == 1) and (!is_null($model->markah_sah_datetime))) {
                                                            return '<span class="label label-success">Setuju</span>';
                                                        } else if (($model->markah_sah == 0) and (!is_null($model->markah_sah_datetime))) {
                                                            return '<span class="label label-warning">Tidak Setuju</span>';
                                                        } else {
                                                            return '<span class="label label-default">Belum Setuju</span>';
                                                        }

                                                        //return (($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))) ? '<span class="label label-success">Setuju</span>' : '<span class="label label-warning">Tidak Setuju</span>';
                                                    },
                                                    //'attribute' => 'tahun',
                                                    'format' => 'html',
                                                ],
                                                [
                                                    'label' => 'ALASAN',
                                                    'headerOptions' => ['class' => 'text-center col-md-6'],
                                                    // 'contentOptions' => ['class'=>'text-center'],
                                                    'value' => function ($model) {
                                                        //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                                                        //                                                    '<span class="label label-success">Active</span>';
                                                        if (is_null($model->alasan)) {
                                                            return '';
                                                        } else {
                                                            $arr = [];
                                                            foreach ($model->alasan as $as) {
                                                                array_push($arr, $as->alasan);
                                                            };
                                                            return join("\r", $arr);
                                                        }

                                                        //return (($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))) ? '<span class="label label-success">Setuju</span>' : '<span class="label label-warning">Tidak Setuju</span>';
                                                    },
                                                    //'attribute' => 'tahun',
                                                    // 'format' => 'html',
                                                ],
                                                [
                                                    'label' => 'TARIKH PENGESAHAN',
                                                    'headerOptions' => ['class' => 'text-center1'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        return $model->markah_sah_datetime;
                                                    },
                                                    'format' => 'html',
                                                ],

                                            ],
                                            'filename' => 'laporan_elnpt_akademik_' . date('Y-m-d'),
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
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            //                                [
                            //                                    'label' => 'NAMA GURU',
                            //                                    'headerOptions' => ['class'=>'text-center'],
                            //                                    'value' => function($model) {
                            //                                        return $model->guru->CONm.'<br>';
                            //                                    },
                            //                                    'format' => 'html',
                            //                                ],
                            [
                                'label' => 'NAMA GURU',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    switch ($model->tahun) {
                                        case 2020:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        case 2021:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        case 2022:
                                            $u = 'elnpt3/borang';
                                            break;
                                        default:
                                            $u = 'elnpt/maklumat-guru';
                                    }

                                    $url = Url::to([$u, 'lppid' => $model->lpp_id]);
                                    return Html::a('<strong>' . $model->guru->CONm . '</strong>', $url) . '<br><small>' . $model->deptGuru->fullname . '</small>' .
                                        '<br><small>' . $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
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
                                //'attribute' => 'tahun',
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
                                'label' => 'PEER',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->peer) ? '<font color="maroon"><i>(not set)</i></font>' : $model->peer->CONm;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PENGESAHAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                                    //                                                    '<span class="label label-success">Active</span>';
                                    if (($model->markah_sah == 1) and (!is_null($model->markah_sah_datetime))) {
                                        return '<span class="label label-success">Setuju</span>';
                                    } else if (($model->markah_sah == 0) and (!is_null($model->markah_sah_datetime))) {
                                        return '<span class="label label-warning">Tidak Setuju</span>';
                                    } else {
                                        return '<span class="label label-default">Belum Setuju</span>';
                                    }

                                    //return (($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))) ? '<span class="label label-success">Setuju</span>' : '<span class="label label-warning">Tidak Setuju</span>';
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'label' => 'ALASAN',
                                'headerOptions' => ['class' => 'text-center col-md-6'],
                                // 'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                                    //                                                    '<span class="label label-success">Active</span>';
                                    if (is_null($model->alasan)) {
                                        return '';
                                    } else {
                                        $arr = [];
                                        foreach ($model->alasan as $as) {
                                            array_push($arr, $as->alasan);
                                        };
                                        return join('<br><hr>', $arr);
                                    }

                                    //return (($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))) ? '<span class="label label-success">Setuju</span>' : '<span class="label label-warning">Tidak Setuju</span>';
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'label' => 'TARIKH PENGESAHAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->markah_sah_datetime;
                                },
                                'format' => 'html',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'RESET SEMAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{reset}',
                                'buttons' => [
                                    'reset' => function ($url, $model) {
                                        $url = Url::to(['elnpt/reset-semakan', 'lppid' => $model->lpp_id]);
                                        return Html::button(
                                            '<span class="glyphicon glyphicon-repeat"></span>',
                                            [
                                                'class' => 'btn btn-default btn-sm',
                                                'onclick' => "
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: '" . $url . "',
                                                                     
                                                                    success: function(result) {
                                                                        if(result == 1) {
                                                                             setTimeout(function(){
                                                                                location.reload(); // then reload the page.(3)
                                                                           }, 1); 
                                                                        } else {
                                                                        }
                                                                    }, 
                                                                    error: function(result) {
                                                                        console.log(\"Ada Error\");
                                                                    }
                                                                });
                                                            "

                                            ]
                                        );
                                    },
                                ],
                            ],
                            //                                [
                            //                                        'label' => 'TAHUN PENILAIAN',
                            //                                        'headerOptions' => ['class'=>'text-center col-md-2'],
                            //                                        'contentOptions' => ['class'=>'text-center'],
                            //                                        'value' => function($model) {
                            //                                            return Html::a('<b>'.$model->tahun.'</b>', ['elnpt/maklumat-guru', 'lppid' => $model->lpp_id]);
                            //                                        },
                            //                                        //'attribute' => 'tahun',
                            //                                        'format' => 'html',
                            //                                ],
                            //                                [
                            //                                        'label' => 'TAHUN PENILAIAN',
                            //                                        'headerOptions' => ['class'=>'text-center col-md-2'],
                            //                                        'contentOptions' => ['class'=>'text-center'],
                            //                                        'value' => function($model) {
                            //                                            return Html::a('<b>'.$model->tahun.'</b>', ['elnpt/maklumat-guru', 'lppid' => $model->lpp_id]);
                            //                                        },
                            //                                        //'attribute' => 'tahun',
                            //                                        'format' => 'html',
                            //                                ],                
                            //                                [
                            //                                    'class' => 'yii\grid\ActionColumn',
                            //                                    'header' => 'TINDAKAN',
                            //                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                            //                                    'contentOptions' => ['class'=>'text-center'],
                            //                                    'template' => '{buka} {padam}',
                            //                                    'buttons' => [
                            //                                        'padam' => function ($url, $model) {
                            //                                            $url = Url::to(['elnpt/delete-lpp', 'lppid' => $model->lpp_id]);
                            //                                            return Html::button('<span class="glyphicon glyphicon-remove-circle"></span>', 
                            //                                                    [
                            //                                                        'class' => 'btn btn-default btn-sm',
                            //                                                        'onclick' => "
                            //                                                            $.ajax({
                            //                                                                type: 'POST',
                            //                                                                url: '".$url."',
                            //
                            //                                                                success: function(result) {
                            //                                                                    if(result == 1) {
                            //                                                                         setTimeout(function(){
                            //                                                                            location.reload(); // then reload the page.(3)
                            //                                                                       }, 1); 
                            //                                                                    } else {
                            //                                                                    }
                            //                                                                }, 
                            //                                                                error: function(result) {
                            //                                                                    console.log(\"Ada Error\");
                            //                                                                }
                            //                                                            });
                            //                                                        ",
                            //                                                        'title'=>Yii::t('app', 'Delete Borang'),
                            //
                            //                                                    ]);
                            //
                            //                                        },
                            //                                        'buka' => function ($url, $model) {
                            //                                            $url = Url::to(['elnpt/open-lpp', 'lppid' => $model->lpp_id]);
                            //                                            return Html::button('<span class="glyphicon glyphicon-ok-circle"></span>', 
                            //                                                    [
                            //                                                        'class' => 'btn btn-default btn-sm',
                            //                                                        'onclick' => "
                            //                                                            $.ajax({
                            //                                                                type: 'POST',
                            //                                                                url: '".$url."',
                            //
                            //                                                                success: function(result) {
                            //                                                                    if(result == 1) {
                            //                                                                         setTimeout(function(){
                            //                                                                            location.reload(); // then reload the page.(3)
                            //                                                                       }, 1); 
                            //                                                                    } else {
                            //                                                                    }
                            //                                                                }, 
                            //                                                                error: function(result) {
                            //                                                                    console.log(\"Ada Error\");
                            //                                                                }
                            //                                                            });
                            //                                                        ",
                            //                                                        'title'=>Yii::t('app', 'Delete Borang'),
                            //
                            //                                                    ]);
                            //
                            //                                        },        
                            //                                    ],
                            //                                ],           
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>