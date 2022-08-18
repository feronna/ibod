<?php

$js = <<<js
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

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PERINGATAN</strong></p>
                    <p>Pegawai Yang Dinilai (PYD) dan Pegawai Penilai Pertama (PPP) hendaklah memberi perhatian kepada perkara-perkara berikut sebelum dan semasa melengkapkan borang ini:</p>
                    <ol type="i">
                        <li>PYD dan PPP hendaklah berbincang bersama dalam membuat penetapan Sasaran Kerja Tahunan (SKT) dan menurunkan tandatangan yang ditetapkan di Bahagian I;</li><br>
                        <li>SKT yang ditetapkan hendaklah mengandungi sekurang-kurangnya satu petunjuk prestasi iaitu samada kuantiti, kualiti, masa atau kos bergantung kepada kesesuaian sesuatu aktiviti / projek;</li><br>
                        <li>SKT yang telah ditetapkan pada awal tahun hendaklah dikaji semula di pertengahan tahun. SKT yang digugurkan atau ditambah hendaklah dicatatkan di ruangan Bahagian II;</li><br>
                        <li>PYD dan PPP hendaklah membuat laporan dan ulasan keseluruhan pencapaian SKT pada akhir tahun serta menurunkan tandatangan di ruangan yang ditetapkan di Bahagian III; dan</li><br>
                        <li>Sila rujuk Panduan Penyediaan Sasaran Kerja Tahunan (SKT) untuk keterangan lanjut.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian I - Penetapan Sasaran Kerja Tahunan</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm . ' - ' . $lpp->tahun . ')' : '' ?></h2>
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

                    <p><i>(PYD dan PPP hendaklah berbincang bersama sebelum menetapkan SKT dan petunjuk prestasinya)</i></p>

                    <?php if (is_null($tt->skt_tt_pyd) and $lpp->PYD == Yii::$app->user->identity->ICNO  and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                        <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-skt', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
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
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'skt_projek',
                                    'label' => 'Ringkasan Aktiviti / Projek',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'header' => 'Petunjuk Prestasi',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($model) {
                                        return '<dl><dt>Kuantiti</dt><dd>' . (is_null($model->skt_kuantiti) ? '-' : $model->skt_kuantiti) . '</dd>' .
                                            '<dt>Kualiti</dt><dd>' . (is_null($model->skt_kualiti) ? '-' : $model->skt_kualiti) . '</dd>' .
                                            '<dt>Masa</dt><dd>' . (is_null($model->skt_masa) ? '-' : $model->skt_masa) . '</dd>' .
                                            '<dt>Kos</dt><dd>' . (is_null($model->skt_kos) ? '-' : $model->skt_kos) . '</dd></dl>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'skt_sasar',
                                    'header' => 'Sasaran Kerja',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'skt_capai',
                                    'header' => 'Pencapaian Sebenar',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'skt_ulasan',
                                    'header' => 'Ulasan',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    //'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($model) {
                                        if (is_null($model->skt_ulasan)) {
                                            return '';
                                        } else {
                                            return $model->skt_ulasan;
                                        }
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Tindakan',
                                    //                                            'visible' => is_null($tt->skt_tt_pyd) AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat.' 23:59:59'),
                                    'visible' => (is_null($tt->skt_tt_pyd) and $lpp->PYD == Yii::$app->user->identity->ICNO  and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))),
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
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
                <hr>
                <div class="row">

                    <div class="row">
                        <?php if (is_null($tt->skt_tt_pyd) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    'Klik untuk tandatangan PYD',
                                    ['lppums/skt-bahagian1', 'lpp_id' => $_GET['lpp_id']],
                                    [
                                        'class' => 'btn btn-default btn-primary',
                                        'data' => [
                                            'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                            'method' => 'post',
                                        ],
                                    ]
                                ) ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-xs-6">
                            </div>
                        <?php } ?>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <?php if (is_null($tt->skt_tt_ppp) and $lpp->PPP == Yii::$app->user->identity->ICNO) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    'Klik untuk tandatangan PPP',
                                    ['lppums/skt-bahagian1', 'lpp_id' => $_GET['lpp_id']],
                                    [
                                        'class' => 'btn btn-default btn-primary',
                                        'data' => [
                                            'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                            'method' => 'post',
                                        ],
                                    ]
                                ) ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-xs-6">
                            </div>
                        <?php } ?>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <?= Html::input('text', 'password1', (is_null($tt->skt_tt_pyd) ? '' : $tt->pyd->CONm), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <?= Html::input('text', 'password1', (is_null($tt->skt_tt_ppp) ? '' : $tt->pppDetails), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                        </div>
                    </div><br>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-md-3 col-xs-6" style="text-align: center">
                            Tandatangan PYD
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6" style="text-align: center">
                            Tandatangan PPP
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            Tarikh: <?= is_null($tt->skt_tt_pyd) ? '' : $tt->skt_tt_pyd_datetime; ?>
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                            Tarikh: <?= is_null($tt->skt_tt_ppp) ? '' : $tt->skt_tt_ppp_datetime; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>