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
            <h2><strong>Pembetulan Pegawai Penilai (PPP, PPK, PEER)</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                    <?php
                        Modal::begin([
                            'header' => 'Pembetulan Penilai',
                            'id' => 'modal',
                            'size' => 'modal-md',
                        ]);
                        echo "<div id='modalContent'></div>";
                        Modal::end();
                    ?>
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
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
                                    'label' => 'GURU',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return Html::a('<strong>'.$model->guru->CONm.'</strong>', Url::to(['elnpt/maklumat-guru', 'lppid' => $model->lpp_id])).'</b><br><small>'.$model->deptGuru->fullname.'</small>'.
                                                '<br><small>'.$model->gredGuru->nama.' '.$model->gredGuru->gred;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPP',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->ppp) ? '<span class="label label-warning">Belum Set</span>' :
                                        '<b>'.$model->ppp->CONm.'</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPK',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->ppk) ? '<span class="label label-warning">Belum Set</span>' :
                                        '<b>'.$model->ppk->CONm.'</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PEER',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->peer) ? '<span class="label label-warning">Belum Set</span>' :
                                        '<b>'.$model->peer->CONm.'</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'CATATAN',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->catatan) ? '' : $model->catatan;
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ], 
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{reset}',
                                    'buttons' => [
                                        'reset' => function ($url, $model) {
                                            $url = Url::to(['elnpt/kemaskini-pegawai-penilai', 'lpp_id' => $model->lpp_id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);

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