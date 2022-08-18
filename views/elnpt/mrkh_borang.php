<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;

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
                <h2><strong>Pengurusan Status Borang</strong></h2>
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
                                'label' => 'MARKAH',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                                    //                                                    '<span class="label label-success">Active</span>';
                                    return (is_null($model->markahAll)) ? '0' : $model->markahAll->markah;
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'label' => 'CATATAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                //'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    //                                            return ($model->is_deleted == 1) ? '<span class="label label-default">Deleted</span>' : 
                                    //                                                    '<span class="label label-success">Active</span>';
                                    return $model->catatan;
                                },
                                //'attribute' => 'tahun',
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS PENILAIAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->PPP_sah == 1 &&
                                        $model->PPK_sah == 1 &&
                                        $model->PEER_sah == 1) ? '<i class="fa fa-check-circle" style="font-size:24px;color:green"></i>' :
                                        '<i class="fa fa-close" style="font-size:24px;color:red"></i>';
                                },
                                'format' => 'html',
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