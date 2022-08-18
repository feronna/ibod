<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\myidp\UserAccess;
use app\models\myidp\RptStatistikIdpV2;
use kartik\grid\GridView;

echo $this->render('/idp/_topmenu');

error_reporting(0);

$gridColumns = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'Bil',
        'contentOptions' => ['style' => 'width:20px;'],
    ],
    [
        'label' => 'Nama',
        'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'Nama',
        //'value' => function ($data){return ucwords(strtolower($data->biodata->CONm)); }, 
        'value' => function ($data) {
            if (!$data->biodata) {
                return ucwords(strtolower($data->v_co_name));
            } else {
                return ucwords(strtolower($data->biodata->CONm));
            }
        },
    ],
    [
        'label' => 'Jawatan',
        //                'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'Jawatan',
        //                'value' => function ($data){
        //                            return ucwords(strtoupper($data->jawatan->fname));
        //                           },
        'value' => function ($data) {
            return strtoupper($data->sandangan->jawatan->fname);
        },
    ],
    [
        //                'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'JAFPIB',
        //                'value' => function ($data){
        //                            return ucwords(strtoupper($data->department->shortname));
        //                           },
        'value' => function ($model) {
            return RptStatistikIdpV2::findPenempatan($model->icno, $model->tahun, 1);
        },
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Tahun',
        //'headerOptions' => ['style' => 'color:#337ab7'],
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<button type="button" class="btn btn-success btn-sm">' . $model->tahun . '
                                <i class="fa fa-external-link" aria-hidden="true"></i></button>', $url, [
                    'title' => Yii::t('app', 'Papar Profil'),
                    'data-pjax' => 0,
                    'target' => "_blank",
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url = 'profil?staffChosen=' . $model->icno . '&year=' . $model->tahun;
                return $url;
            }
        }
    ],
    //            ['class' => 'yii\grid\ActionColumn',
    //                            'header' => $previousYear,
    //                            //'headerOptions' => ['style' => 'color:#337ab7'],
    //                            'template' => '{view}',
    //                            'buttons' => [
    //                              'view' => function ($url, $model) {
    //                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
    //                                              'title' => Yii::t('app', 'Papar Profil'),
    //                                              'data-pjax' => 0,
    //                                              'target' => "_blank",
    //                                  ]);
    //                              },
    //                            ],
    //                            'urlCreator' => function ($action, $model, $key, $index) {
    //                              if ($action === 'view') {
    //                                  $url ='profil?staffChosen='.$model->ICNO.'&year='.date("Y",strtotime("-1 year"));
    //                                  return $url;
    //                              }
    //                            }
    //            ],
    //            ['class' => 'yii\grid\ActionColumn',
    //                            'header' => $currentYear,
    //                            //'headerOptions' => ['style' => 'color:#337ab7'],
    //                            'template' => '{view}',
    //                            'buttons' => [
    //                              'view' => function ($url, $model) {
    //                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
    //                                              'title' => Yii::t('app', 'Papar Profil'),
    //                                              'data-pjax' => 0,
    //                                              'target' => "_blank",
    //                                  ]);
    //                              },
    //                            ],
    //                            'urlCreator' => function ($action, $model, $key, $index) {
    //                              if ($action === 'view') {
    //                                  $url ='profil?staffChosen='.$model->ICNO.'&year='.date('Y');
    //                                  return $url;
    //                              }
    //                            }
    //            ],

];

$gridColumns2 = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'Bil',
        'contentOptions' => ['style' => 'width:20px;'],
    ],
    [
        'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'Nama',
        'value' => function ($data) {
            return ucwords(strtolower($data->v_co_name));
        },
    ],
    [
        'label' => 'Jawatan',
        //                'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'Jawatan',
        'value' => function ($data) {
            return '(' . strtoupper($data->v_co_gred) . ') ' . strtoupper($data->v_co_jwtn);
        },
    ],
    [
        //                'contentOptions' => ['style' => 'width:400px;'],
        'label' => 'JAFPIB',
        'value' => function ($data) {
            return ucwords(strtoupper($data->v_co_dept_sn));
        },
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Tahun',
        //'headerOptions' => ['style' => 'color:#337ab7'],
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<button type="button" class="btn btn-success btn-sm">' . $model->tahun . '
                                <i class="fa fa-external-link" aria-hidden="true"></i></button>', $url, [
                    'title' => Yii::t('app', 'Papar Profil'),
                    'data-pjax' => 0,
                    'target' => "_blank",
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url = 'profil?staffChosen=' . $model->v_co_icno . '&year=' . $model->tahun;
                return $url;
            }
        }
    ],

];
?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai<h3><span class="label label-primary" style="color: white">Transkrip Tahunan</span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider2,
                    'layout' => "{items}\n{pager}",
                    //                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns2,
                    'showFooter' => false,
                ]);
                ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    //'showHeader' => false,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    //                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'columns' => $gridColumns,
                ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>