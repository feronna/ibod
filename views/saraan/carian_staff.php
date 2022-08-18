<?php

$js=<<<js
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

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchStaff', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Hasil Carian</strong></h2>
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
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'label' => 'NAMA',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'KP / PASPORT',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->ICNO;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'JAWATAN',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->jawatan->fname;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'JSPIU',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->department->fullname;
                                    },
                                    'format' => 'html',
                                ],             
                                [
                                    'label' => 'JENIS LANTIKAN',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->statusLantikan->ApmtStatusNm;
                                    },
                                    'format' => 'html',
                                ],             
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{view} {view2}',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            $url = Url::to(['saraan/rekod-lpg', 'icno' => $model->ICNO]);
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['class' => 'btn btn-default btn-sm']);

                                        },
                                        'view2' => function ($url, $model) {
                                            $url = Url::to(['saraan/rekod-lpg-v2', 'umsper' => $model->COOldID]);
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span><sup><span class="label label-success">New</span></sup>', $url, ['class' => 'btn btn-default btn-sm']);

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