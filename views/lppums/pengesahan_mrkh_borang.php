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
use yii\db\Expression;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
$url = \yii\helpers\Url::to(['name-list']);
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Carian Borang</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left'], 'action' => ['lppums/pengesahan-markah-borang']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            
                            $form->field($searchModel, 'PYD')->widget(Select2::classname(), [
                                // 'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                //         //->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                //         //->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                //         ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'options' => [
                                    'placeholder' => 'Pilih Staff', 
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    //'id' => 'ppp_',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $url,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term, page:params.page || 1}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                ],
                            ])->label(false);
                        ?>
                    </div>
                </div>
            
                <?php if ($this->context->action->id != 'penetap-pantau-pergerakan-borang') { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'jspiu')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\hronline\Department::find()
//                                        ->innerJoin(['a' => 'elnpt.tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                        ->orderBy(['fullname' => SORT_ASC,])
                                        ->all(), 'id', 'fullname'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Cari JFPIU', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <?php } ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\lppums\TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengesahan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($searchModel, 'sah_markah')->label(false)->widget(Select2::classname(), [
//                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'data' => [
                                    '1' => 'SETUJU',
                                    '2' => 'TIDAK SETUJU',
                                    '3' => 'BELUM SETUJU',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Pengesahan', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pengesahan Markah Borang</strong></h2>

            <div  class="pull-right"><?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'onRenderSheet'=>function($sheet, $grid){
                    $sheet->getStyle('I2:'.$sheet->getHighestColumn().$sheet->getHighestRow())->getAlignment()->setWrapText(true);
                },
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'BIL',
                        'headerOptions' => ['class'=>'text-center col-md-1'],
                        'contentOptions' => ['class'=>'text-center'],
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
                        'headerOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
                            return $model->pyd->CONm;
                            
                        },
                        'format' => 'html',
                    ],
                    [
                        'label' => 'JAWATAN',
                        'headerOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
                            return $model->gredJawatan->nama.' '.$model->gredJawatan->gred;
                            
                        },
                        'format' => 'html',
                    ],
                    [
                        'label' => 'J/F/P/I/U',
                        'headerOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
                            return $model->department->fullname;
                            
                        },
                        'format' => 'html',
                    ],
                    [
                            'label' => 'TAHUN PENILAIAN',
                            'headerOptions' => ['class'=>'text-center col-md-1'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->tahun;
                            },
                            //'attribute' => 'tahun',
                            'format' => 'html',
                    ],
                    [
                        'label' => 'PPP',
                        'headerOptions' => ['class'=>'text-center col-md-2'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
                            return is_null($model->ppp) ? '<font color="maroon"><i>(not set)</i></font>' : $model->ppp->CONm;
                        },
                        'format' => 'html',
                    ],
                    [
                        'label' => 'PPK',
                        'headerOptions' => ['class'=>'text-center col-md-2'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
                            return is_null($model->ppk) ? '<font color="maroon"><i>(not set)</i></font>' : $model->ppk->CONm;
                        },
                        'format' => 'html',
                    ],               
                    [
                            'label' => 'PENGESAHAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
//                                                    '<span class="label label-success">Active</span>';
                                if(($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))){
                                    return '<span class="label label-success">Setuju</span>';
                                }else if (($model->markah_sah == 0) AND (!is_null($model->markah_sah_datetime))){
                                    return '<span class="label label-warning">Tidak Setuju</span>';
                                }else{
                                    return '<span class="label label-default">Belum Setuju</span>';
                                }

                                //return (($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))) ? '<span class="label label-success">Setuju</span>' : '<span class="label label-warning">Tidak Setuju</span>';
                            },
                            //'attribute' => 'tahun',
                            'format' => 'html',
                    ],
                    [
                            'label' => 'ALASAN',
                            'headerOptions' => ['class'=>'text-center col-md-6'],
                            // 'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
        //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
        //                                                    '<span class="label label-success">Active</span>';
                                if(is_null($model->alasan)) {
                                    return '';
                                }else {
                                    $arr = [];
                                    foreach($model->alasan as $as) {
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
                        'headerOptions' => ['class'=>'text-center1'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
                            return $model->markah_sah_datetime;
                        },
                        'format' => 'html',
                    ],

                ],
                'filename' => 'laporan_elnpt_pentadbiran_'.date('Y-m-d'),
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
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
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
                                    'headerOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return Html::a('<strong>'.$model->pyd->CONm.'</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id]).'<br><small>'.$model->department->fullname.'</small>'.
                                                            '<br><small>'.$model->gredJawatan->nama.' '.$model->gredJawatan->gred;
                                        
                                    },
                                    'format' => 'html',
                                ],
                                [
                                        'label' => 'TAHUN PENILAIAN',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return $model->tahun;
                                        },
                                        //'attribute' => 'tahun',
                                        'format' => 'html',
                                ],
                                [
                                    'label' => 'PPP',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->ppp) ? '<font color="maroon"><i>(not set)</i></font>' : $model->ppp->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPK',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->ppk) ? '<font color="maroon"><i>(not set)</i></font>' : $model->ppk->CONm;
                                    },
                                    'format' => 'html',
                                ],               
                                [
                                        'label' => 'PENGESAHAN',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
            //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
            //                                                    '<span class="label label-success">Active</span>';
                                            if(($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))){
                                                return '<span class="label label-success">Setuju</span>';
                                            }else if (($model->markah_sah == 0) AND (!is_null($model->markah_sah_datetime))){
                                                return '<span class="label label-warning">Tidak Setuju</span>';
                                            }else{
                                                return '<span class="label label-default">Belum Setuju</span>';
                                            }
            
                                            //return (($model->markah_sah == 1) AND (!is_null($model->markah_sah_datetime))) ? '<span class="label label-success">Setuju</span>' : '<span class="label label-warning">Tidak Setuju</span>';
                                        },
                                        //'attribute' => 'tahun',
                                        'format' => 'html',
                                ],
                                [
                                        'label' => 'ALASAN',
                                        'headerOptions' => ['class'=>'text-center col-md-6'],
                                        // 'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                    //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                    //                                                    '<span class="label label-success">Active</span>';
                                            if(is_null($model->alasan)) {
                                                return '';
                                            }else {
                                                $arr = [];
                                                foreach($model->alasan as $as) {
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
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->markah_sah_datetime;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'RESET SEMAKAN',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{reset}',
                                    'buttons' => [
                                        'reset' => function ($url, $model) {
                                            $url = Url::to(['lppums/reset-semakan', 'lppid' => $model->lpp_id]);
                                            return Html::button('<span class="glyphicon glyphicon-repeat"></span>', 
                                                    [
                                                        'class' => 'btn btn-default btn-sm',
                                                        'onclick' => "
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: '".$url."',
                                                                     
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
                                                        
                                                        ]);

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