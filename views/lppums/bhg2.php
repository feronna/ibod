<?php
/* @var $this yii\web\View */

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
        
    $('.modalButton2').on('click', function () {
        $('#modal2').modal('show')
                .find('#modalContent2')
                .load($(this).attr('value'));
    });    
        
    $('.modalButton3').on('click', function () {
        $('#modal3').modal('show')
                .find('#modalContent3')
                .load($(this).attr('value'));
    });      
js;
$this->registerJs($js);

//$this->registerJs ( "$('#nav .nav-tabs a[href=\"#".$tab."\"]').tab('show');" , yii\web\View::POS_READY );

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$layak = 'layak' . $lpp->tahun;
$jumlah = 'jum' . $lpp->tahun;

?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian II - Kegiatan dan Sumbangan Di Luar Tugas Rasmi</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm. ' - ' . $lpp->tahun. ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li class="<?= $tab == '1' ? 'active' : '' ?>" role="presentation"><a data-toggle="tab" href="#1">Kegiatan dan Sumbangan Di Luar Tugas Rasmi</a></li>
                        <li class="<?= $tab == '2' ? 'active' : '' ?>" role="presentation"><a data-toggle="tab" href="#2">Aktiviti Rasmi dan Latihan</a></li>
                    </ul>

                    <?php
                    Modal::begin([
                        'header' => 'Tambah / Kemaskini Rekod',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();

                    Modal::begin([
                        'header' => 'Tambah / Kemaskini Rekod',
                        'id' => 'modal2',
                        'size' => 'modal-md',
                    ]);
                    echo "<div id='modalContent2'></div>";
                    Modal::end();

                    Modal::begin([
                        'header' => 'Tambah / Kemaskini Rekod',
                        'id' => 'modal3',
                        'size' => 'modal-md',
                    ]);
                    echo "<div id='modalContent3'></div>";
                    Modal::end();
                    ?>

                    <div class="tab-content">
                        <div id="1" class="tab-pane fade in <?= $tab == '1' ? 'active' : '' ?>">
                            <p>
                            <ul>
                                <li>
                                    Senaraikan kegiatan dan sumbangan di luar tugas rasmi seperti sukan / pertubuhan / sumbangan kreatif di peringkat komuniti / Jabatan / daerah / Negeri / Negara / Antarabangsa yang berfaedah kepada organisasi / komuniti / negara pada tahun yang dinilai.
                                </li>
                            </ul>
                            </p>

                            <?php if (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                                <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-sumbangan', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                            <?php } ?>

                            <div class="table-responsive">
                                <?=
                                GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-sm table-bordered',
                                    ],
                                    'emptyText' => 'Tiada rekod kegiatan / aktiviti / sumbangan',
                                    'summary' => '',
                                    'dataProvider' => $dataProvider1,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'attribute' => 'sumb',
                                            'label' => 'Senarai Kegiatan / Aktiviti / Sumbangan',
                                            'headerOptions' => ['class' => 'text-center col-md-4'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'attribute' => 'sumb_peringkat',
                                            'label' => 'Peringkat Kegiatan / Aktiviti / Sumbangan',
                                            'headerOptions' => ['class' => 'text-center col-md-4'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Tindakan',
                                            'visible' => (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))),
                                            'headerOptions' => ['class' => 'text-center col-md-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'template' => '{update}{delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    $url = Url::to(['lppums/update-sumbangan', 'sumbid' => $model->sumb_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                                },
                                                'delete' => function ($url, $model) {
                                                    $url = Url::to(['lppums/padam-sumbangan', 'sumbid' => $model->sumb_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                        'class' => 'btn btn-default btn-sm', 'data' => [
                                                            'confirm' => 'Are you sure you want to delete this item?',
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
                        <div id="2" class="tab-pane fade in <?= $tab == '2' ? 'active' : '' ?>">
                            <p>
                            <ul>
                                <li>
                                    Senaraikan program latihan (seminar, kursus, bengkel dan lain-lain) yang dihadiri dalam tahun yang dinilai.
                                </li>
                            </ul>
                            </p>


                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <th class="text-center col-md-1" rowspan="2">Bil</th>
                                        <th class="text-center col-md-4" rowspan="2">Nama Latihan</th>
                                        <th class="text-center col-md-2" rowspan="2">Tarikh / Tambah</th>
                                        <th class="text-center col-md-1" rowspan="2">Tempat</th>
                                        <th class="text-center" colspan="2">Pencapaian Mata CPD</th>

                                    </tr>
                                    <tr>
                                        <th class="text-center">Mata Minima CPD</th>
                                        <th class="text-center">Jumlah Mata CPD Terkumpul</th>
                                    </tr>

                                    <?php if (!$latih_tmbh) { ?>
                                        <tr>
                                            <td colspan="7">Tiada rekod program latihan</td>
                                        </tr>
                                        <?php } else {
                                        foreach ($latih_tmbh as $ind => $lth) { ?>
                                            <tr>
                                                <td class="text-center"><?= $ind + 1; ?></td>
                                                <td><?= ($lpp->tahun >= 2020) ? $lth->sasaran3->tajukLatihan : $lth->namaLatihan->vcsl_nama_latihan; ?></td>
                                                <td class="text-center"><?php
                                                                        $mula = ($lpp->tahun >= 2020) ? strtotime($lth->tarikhMula) : strtotime($lth->vcl_tkh_mula);
                                                                        $tamat = ($lpp->tahun >= 2020) ? strtotime($lth->tarikhAkhir) : strtotime($lth->vcl_tkh_tamat);
                                                                        $interval = $tamat - $mula;
                                                                        //$interval = add(1);
                                                                        echo Yii::$app->formatter->asDate(($lpp->tahun >= 2020) ? $lth->tarikhMula : $lth->vcl_tkh_mula, 'dd') . ' - ' . Yii::$app->formatter->asDate(($lpp->tahun >= 2020) ? $lth->tarikhAkhir : $lth->vcl_tkh_tamat, 'dd MMM yyyy') . ' (';
                                                                        //echo $interval->format('%a hari').')'; 
                                                                        echo (round($interval / (60 * 60 * 24)) + 1) . ' hari)';
                                                                        ?></td>
                                                <td class="text-center"><?= ($lpp->tahun >= 2020) ? $lth->lokasi : $lth->namaLatihan->vcsl_tempat; ?></td>
                                                <?php if ($ind == 0) { ?>
                                                    <td class="text-center" rowspan="<?= count($latih_tmbh) ?>"><strong>
                                                            <?php if ($lpp->tahun >= 2020) { ?>
                                                                <?= !is_null($mataCpd) ? (($mataCpd->idp_mata_min == 0) ? 'Dikecualikan' : $mataCpd->idp_mata_min) : ''; ?>
                                                            <?php } else { ?>
                                                                <?= !is_null($mataCpd) ? (!isset($mataCpd2->{$layak}) ? '' : $mataCpd2->{$layak}) : (!isset($mataCpd->idp_mata_min) ? 0 : $mataCpd->idp_mata_min); ?>
                                                            <?php  } ?></strong>
                                                    </td>
                                                    <td class="text-center" rowspan="<?= count($latih_tmbh) ?>"><strong>
                                                            <?php if ($lpp->tahun >= 2020) { ?>
                                                                <?= !is_null($mataCpd) ?  (($mataCpd->idp_mata_min == 0) ? 'Dikecualikan' : $summ) : ''; ?>
                                                            <?php } else { ?>
                                                                <?= !is_null($mataCpd) ? (!isset($mataCpd2->{$jumlah}) ? '' : $mataCpd2->{$jumlah}) : (!isset($mataCpd->jum_mata_dikira) ? 0 : $mataCpd->jum_mata_dikira); ?>
                                                            <?php  } ?>
                                                        </strong>
                                                    </td>
                                                <?php } ?>

                                            </tr>
                                    <?php }
                                    } ?>

                                </table>
                            </div>

                            <p>
                            <ul>
                                <li>
                                    Senarai latihan yang ditambah.
                                </li>
                            </ul>
                            </p>

                            <?php if (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                                <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-latihan', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton2']) ?>
                            <?php } ?>

                            <div class="table-responsive">
                                <?=
                                GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-sm table-bordered',
                                    ],
                                    'emptyText' => 'Tiada rekod tambahan program latihan',
                                    'summary' => '',
                                    'dataProvider' => $dataProvider3,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'attribute' => 'lat_tamb',
                                            'label' => 'Nama Latihan',
                                            'headerOptions' => ['class' => 'text-center'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'label' => 'Tarikh / Tambah',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) {
                                                $mula = strtotime($model->lat_tamb_mula);
                                                $tamat = strtotime($model->lat_tamb_tamat);
                                                $interval = $tamat - $mula;
                                                //$interval = add(1);
                                                return Yii::$app->formatter->asDate($model->lat_tamb_mula, 'dd') . ' - ' . Yii::$app->formatter->asDate($model->lat_tamb_tamat, 'dd MMM yyyy') . ' (' . (round($interval / (60 * 60 * 24)) + 1) . ' hari)';
                                                //echo $interval->format('%a hari').')'; 
                                                //echo (round($interval / (60 * 60 * 24)) + 1).' hari)';        
                                            },
                                        ],
                                        [
                                            'attribute' => 'lat_tamb_tempat',
                                            'label' => 'Tempat',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Tindakan',
                                            'headerOptions' => ['class' => 'text-center col-md-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'template' => '{update}{delete}',
                                            'visible' => (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))),
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    $url = Url::to(['lppums/update-latihan', 'latid' => $model->lat_tamb_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton2']);
                                                },
                                                'delete' => function ($url, $model) {
                                                    $url = Url::to(['lppums/padam-latihan', 'latid' => $model->lat_tamb_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-default']);
                                                },
                                            ],
                                        ],
                                    ],
                                ]);
                                ?>
                            </div>

                            <p>
                            <ul>
                                <li>
                                    Senarai latihan yang diperlukan.
                                </li>
                            </ul>
                            </p>

                            <?php if (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                                <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-latihan-perlu', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton3']) ?>
                            <?php } ?>

                            <div class="table-responsive">
                                <?=
                                GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-sm table-bordered',
                                    ],
                                    'emptyText' => 'Tiada rekod latihan yang diperlukan',
                                    'summary' => '',
                                    'dataProvider' => $dataProvider2,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'attribute' => 'lat_perlu',
                                            'label' => 'Nama Bidang / Latihan',
                                            'headerOptions' => ['class' => 'text-center'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'attribute' => 'lat_sebab_perlu',
                                            'label' => 'Sebab Diperlukan',
                                            'headerOptions' => ['class' => 'text-center'],
                                            //'contentOptions' => ['class'=>'text-center'],
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Tindakan',
                                            'visible' => (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))),
                                            'headerOptions' => ['class' => 'text-center col-md-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'template' => '{update} {delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    $url = Url::to(['lppums/update-latihan-perlu', 'latid' => $model->lat_perlu_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                                },
                                                'delete' => function ($url, $model) {
                                                    $url = Url::to(['lppums/padam-latihan-perlu', 'latid' => $model->lat_perlu_id, 'lpp_id' => $model->lpp_id]);
                                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-default']);
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

                <div class="row">
                    <hr>
                    <?php if ($tt->isNewRecord) { ?>
                        <strong>Saya mengesahkan bahawa semua kenyataan di atas adalah benar.</strong>
                    <?php } ?>
                </div><br>

                <div class="row">
                    <?php if (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                        <div class="col-md-3 col-xs-6" style="text-align:center">
                            <?= Html::a(
                                'Klik untuk tandatangan PYD',
                                ['lppums/bahagian2', 'lpp_id' => $_GET['lpp_id']],
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
                    <div class="col-md-3 col-xs-6">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <?= Html::input('text', 'password1', ((is_null($tt)) ? '' : ((is_null($tt->pyd)) ? '' : $tt->pyd->CONm)), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                    </div>
                    <div class="col-md-6 col-xs-0">
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <?= Html::input('text', 'password1', ((is_null($tt)) ? '' : ((is_null($tt->sumbangan_tt_date)) ? '' : Yii::$app->formatter->asDateTime($tt->sumbangan_tt_date . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A"))), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-3 col-xs-6" style="text-align: center">
                        Tandatangan PYD
                    </div>
                    <div class="col-md-6 col-xs-0">
                    </div>
                    <div class="col-md-3 col-xs-6" style="text-align: center">
                        Tarikh
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>