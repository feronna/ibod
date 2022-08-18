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
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tmp = 'reset-borang-lpp';
$title = 'Carian borang LPP untuk direset';
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_carian_borang', ['model' => $searchModel, 'tmp' => $tmp, 'title' => $title]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian Borang LPP Untuk Direset: Senarai Pegawai Pentadbiran <?= is_null($searchModel->tahun) ? '' : 'Bagi Tahun Penilaian '.$searchModel->tahun ;?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
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
                                   //'attribute' => 'CONm',
                                    'label' => 'NAMA',
                                    'headerOptions' => ['class'=>'column-title'],
                                    'value' => function($model) {
                                        return Html::a('<strong>'.$model->pyd->CONm.'</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id]).'<br><small>'.$model->department->fullname.'</small>'.
                                                '<br><small>'.$model->gredJawatan->nama.' '.$model->gredJawatan->gred;
                                    }, 
                                            'format' => 'html',
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'JAFPIB',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->department->shortname;
                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'STATUS',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return 'PYD : '.(is_null($model->PYD_sah_datetime) ? '<i>Belum Sah</i>' : $model->PYD_sah_datetime.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>').'<br>'
                                                .'PPP : '.(is_null($model->PPP_sah_datetime) ? '<i>Belum Sah</i>' : $model->PPP_sah_datetime.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>').'<br>'
                                                .'PPK : '.(is_null($model->PPK_sah_datetime) ? '<i>Belum Sah</i>' : $model->PPK_sah_datetime.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>').'<br>';
                                    },
                                            'format' => 'raw',
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'RESET',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        $url = Url::to(['lppums/reset-borang', 'lppid' => $model->lpp_id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    },
                                            'format' => 'raw',
                                ],            
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'header' => 'BUKA PENGISIAN BORANG',
//                                    'headerOptions' => ['class'=>'text-center col-md-1'],
//                                    'contentOptions' => ['class'=>'text-center'],
//                                    'template' => '{create}',
//                                    //'header' => 'TINDAKAN',
//                                    'buttons' => [
//                                        'create' => function ($url, $model) {
//                                            if(!is_null($model->requestLog)) {
//                                                return 'Sedang dibuka';
//                                            }else {
//                                                $url = Url::to(['lppums/buka-pengisian-borang', 'lppid' => $model->lpp_id,]);
//                                                return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', $url, [
//                                                    'title' => 'Buka borang',
//                                                ]);
//                                            }
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
</div>

<?php
                            Modal::begin([
                                'header' => 'Reset Pengisian Borang LPP',
                                'id' => 'modal',
                                'size' => 'modal-lg',
                            ]);
                            echo "<div id='modalContent'></div>";
                            Modal::end();
                    ?>