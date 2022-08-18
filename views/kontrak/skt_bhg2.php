<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

// as a widget
?>

<?= $this->render('_menuskt', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian II - Kajian Semula Sasaran Kerja Tahunan Pertengahan Tahun</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    
                    <?php
                        Modal::begin([
                            'header' => 'Tambah / Kemaskini Rekod',
                            'id' => 'modal',
                            'size' => 'modal-lg',
                        ]);
                        echo "<div id='modalContent'></div>";
                        Modal::end();
                    ?>
                    
                    <p><strong>1. Aktiviti / Projek Yang Ditambah</strong><br>
                    <i>(PYD hendaklah menyenaraikan aktiviti / projek yang ditambah beserta petunjuk prestasinya setelah berbincang dengan PPP)</i><p>
                    
                    <?php if (is_null($ulasan->skt_ulasan_tt_pyd) AND $lpp->PYD == Yii::$app->user->identity->ICNO AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat.' 23:59:59') OR ($lpp->PYD == \Yii::$app->user->identity->ICNO AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                    <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-skt1', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton'])?>
                    <?php } ?>
                        
                    <div class="table-responsive">
                            <?=
                                GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-sm table-bordered',
                                    ],
                                    'emptyText' => 'Tiada rekod penetapan SKT',
                                    'summary' => '',
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                            'headerOptions' => ['class'=>'text-center col-md-1'],
                                            'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'attribute' => 'skt_projek',
                                            'label' => 'Ringkasan Aktiviti / Projek',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'header' => 'Petunjuk Prestasi',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                return '<dl><dt>Kuantiti</dt><dd>'.(is_null($model->skt_kuantiti) ? '-' : $model->skt_kuantiti).'</dd>'.
                                                       '<dt>Kualiti</dt><dd>'.(is_null($model->skt_kualiti) ? '-' : $model->skt_kualiti).'</dd>'.
                                                       '<dt>Masa</dt><dd>'.(is_null($model->skt_masa) ? '-' : $model->skt_masa).'</dd>'.
                                                       '<dt>Kos</dt><dd>'.(is_null($model->skt_kos) ? '-' : $model->skt_kos).'</dd></dl>';
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'attribute' => 'skt_sasar',
                                            'header' => 'Sasaran Kerja',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'format' => 'html'
                                        ],
                                        [
                                            'attribute' => 'skt_capai',
                                            'header' => 'Pencapaian Sebenar',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'format' => 'html'
                                        ],
                                        [
                                            'attribute' => 'skt_ulasan',
                                            'header' => 'Ulasan',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'format' => 'html'
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Tindakan',
                                            'visible' => is_null($ulasan->skt_ulasan_tt_pyd) AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat.' 23:59:59') OR ($lpp->PYD == \Yii::$app->user->identity->ICNO AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)),
                                            'headerOptions' => ['class'=>'text-center col-md-1'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'template' => '{update}{delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    $url = Url::to(['lppums/update-skt', 'sktid' => $model->skt_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);

                                                },
                                                'delete' => function ($url, $model) {
                                                    $url = Url::to(['lppums/delete-skt', 'sktid' => $model->skt_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                        'class' => 'btn btn-default btn-sm',
                                                        'data' => [
                                                                'confirm' => 'Adakah anda ingin membuang rekod ini?',
                                                                'method' => 'post',
                                                            ],
                                                        ]);

                                                },        
                                            ],
                                        ],
                                    ],
                                ]);
                            ?>
                    </div>    
                </div>
                <div class="row">
                    
                    <?php
                        Modal::begin([
                            'header' => 'Tambah / Kemaskini Rekod',
                            'id' => 'modal',
                            'size' => 'modal-lg',
                        ]);
                        echo "<div id='modalContent'></div>";
                        Modal::end();
                    ?>
                    
                    <p><strong>2. Aktiviti / Projek Yang Digugurkan</strong><br>
                    <i>(PYD hendaklah menyenaraikan aktiviti / projek yang digugurkan setelah berbincang dengan PPP)</i><p>
                        
                    <?php if (is_null($ulasan->skt_ulasan_tt_pyd)) { ?>    
                    
                    <p align="center"><b>Senarai SKT yang Telah Ditetapkan</b></p>
                    
                    <div class="table-responsive">
                            <?=
                                GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-sm table-bordered',
                                    ],
                                    'emptyText' => 'Tiada rekod penetapan SKT',
                                    'summary' => '',
                                    'dataProvider' => $dataProvider2,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                            'headerOptions' => ['class'=>'text-center col-md-1'],
                                            'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'attribute' => 'skt_projek',
                                            'label' => 'Ringkasan Aktiviti / Projek',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'header' => 'Petunjuk Prestasi',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                return '<dl><dt>Kuantiti</dt><dd>'.(is_null($model->skt_kuantiti) ? '-' : $model->skt_kuantiti).'</dd>'.
                                                       '<dt>Kualiti</dt><dd>'.(is_null($model->skt_kualiti) ? '-' : $model->skt_kualiti).'</dd>'.
                                                       '<dt>Masa</dt><dd>'.(is_null($model->skt_masa) ? '-' : $model->skt_masa).'</dd>'.
                                                       '<dt>Kos</dt><dd>'.(is_null($model->skt_kos) ? '-' : $model->skt_kos).'</dd></dl>';
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'attribute' => 'skt_sasar',
                                            'header' => 'Sasaran Kerja',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'format' => 'html'
                                        ],
                                        [
                                            'attribute' => 'skt_capai',
                                            'header' => 'Pencapaian Sebenar',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'format' => 'html'
                                        ],
                                        [
                                            'attribute' => 'skt_ulasan',
                                            'header' => 'Ulasan',
                                            'headerOptions' => ['class'=>'text-center col-md-2'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                            'format' => 'html'
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Tindakan',
                                            'visible' => is_null($ulasan->skt_ulasan_tt_pyd) AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat.' 23:59:59') OR ($lpp->PYD == \Yii::$app->user->identity->ICNO AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)),
                                            'headerOptions' => ['class'=>'text-center col-md-1'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'template' => '{delete}',
                                            'buttons' => [
                                                'delete' => function ($url, $model) {
                                                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/lppums/gugur-skt', 'sktid' => $model->skt_id, 'lpp_id' => $model->lpp_id] , ['class' => 'btn btn-default btn-sm']);
                                                },        
                                            ],
                                        ],
                                    ],
                                ]);
                            ?>
                    </div> 
                    
                    <?php } ?>
                    
                    <?php if (is_null($ulasan->skt_ulasan_tt_pyd)) { ?>
                    <p align="center"><b>Senarai SKT yang Digugurkan</b></p>
                    <?php } ?>
                    
                    <div class="table-responsive">
                            <?=
                                GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-sm table-bordered',
                                    ],
                                    'emptyText' => 'Tiada rekod pengguguran SKT'  ,
                                    'summary' => '',
                                    'dataProvider' => $dataProvider1,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                            'headerOptions' => ['class'=>'text-center col-md-1'],
                                            'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'attribute' => 'skt_projek',
                                            'label' => 'Aktiviti / Projek',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                return $model->skt_projek.'<br>'.
                                                        '<strong>Petunjuk Prestasi</strong> (Kuantiti / Kualiti / Masa / Kos)<br>'.
                                                        $model->skt_kuantiti.' / '.$model->skt_kualiti.' / '.$model->skt_masa.' / '.$model->skt_kos.'<br>'.
                                                        '<strong>Sasaran Kerja</strong> (Berdasarkan petunjuk prestasi)<br>'.
                                                        $model->skt_sasar;
                                            },
                                            'format' => 'raw'
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Tindakan',
                                            'visible' => is_null($ulasan->skt_ulasan_tt_pyd) AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat.' 23:59:59') OR ($lpp->PYD == \Yii::$app->user->identity->ICNO AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)),
                                            'headerOptions' => ['class'=>'text-center col-md-1'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'template' => '{delete}',
                                            'buttons' => [
                                                'delete' => function ($url, $model) {
                                                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/lppums/kembali-skt', 'sktid' => $model->skt_id, 'lpp_id' => $model->lpp_id] , ['class' => 'btn btn-default btn-sm']);
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