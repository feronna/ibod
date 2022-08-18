<?php


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
$tmp = 'buka-pengisian-borang';
$title = 'Carian borang LPP untuk dibuka bagi tujuan pengisian PYD';
?>

<?= $this->render('_carian_borang', ['model' => $searchModel, 'tmp' => $tmp, 'title' => $title]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian Borang LPP: Senarai Pegawai Pentadbiran <?= is_null($searchModel->tahun) ? '' : 'Bagi Tahun Penilaian '.$searchModel->tahun ;?></strong></h2>
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
                                        return $model->pyd->CONm.'<br><small>'.$model->department->fullname.'</small>'.
                                                '<br><small>'.$model->gredJawatan->nama.' '.$model->gredJawatan->gred;
                                    }, 
                                            'format' => 'html',
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'JAFPIB',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->department->shortname;
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'MOHON BUKA PENGISIAN BORANG',
                                    'headerOptions' => ['class'=>'text-center col-md-3'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{create}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'create' => function ($url, $model) {
                                            if(!is_null($model->requestLog)) {
                                                return 'Sedang dibuka';
                                            }else {
                                                $url = Url::to(['lppums/buka-borang', 'lppid' => $model->lpp_id,]);
                                                return Html::a('<strong>Buka</strong>', $url, [
                                                    'title' => 'Buka borang',
                                                ]);
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