<?php

$js = <<<js
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
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Borang Laporan Penilaian Prestasi bagi PYD <?= $bio->CONm; ?> (<?= Yii::$app->user->getId(); ?>)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">

                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">TAHUN PENILAIAN</th>
                                <th class="text-center" colspan="2">REKOD</th>
                                <th class="text-center" colspan="3">STATUS PENGESAHAN BORANG LPP</th>
                                <th class="text-center">MARKAH</th>
                            </tr>

                            <?php if (!$lpp) { ?>
                                <tr>
                                    <td colspan="7">Tiada rekod borang laporan penilaian prestasi</td>
                                </tr>
                                <?php } else {
                                foreach ($lpp as $ind => $l) { ?>
                                    <tr>
                                        <td class="text-center" rowspan="7"><?= Html::a('<i class="fa fa-pencil"></i> <strong>' . $l->tahun . '</strong>', Url::to(['lppums/bahagian1', 'lpp_id' => $l->lpp_id]), ['class' => 'btn btn-sm btn-primary']); ?></td>
                                        <td class="text-center" colspan="2"><strong><?= strtoupper($l->gredJawatan->lppJenis->lpp_jenis) ?></strong></td>
                                        <td>PYD</td>
                                        <td class="text-center"><?= ($l->PYD_sah == 1) ? Yii::$app->formatter->asDateTime($l->PYD_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") : '' ?></td>
                                        <td class="text-center"><?= ($l->PYD_sah == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '' ?></td>
                                        <td class="text-center"><?= ($l->PYD_sah == 1) ? '-' : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jawatan dan Gred</strong></td>
                                        <td><?= $l->gredJawatan->nama . ' ' . $l->gredJawatan->gred ?></td>
                                        <td>PPP</td>
                                        <td class="text-center"><?= ($l->PPP_sah == 1) ? Yii::$app->formatter->asDateTime($l->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") : '' ?></td>
                                        <td class="text-center"><?= ($l->PPP_sah == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '' ?></td>
                                        <td class="text-center"><?= ($l->PPP_sah == 1) ? 'PPP' : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>JFPIB</strong></td>
                                        <td><?= $l->department->fullname ?></td>
                                        <td>PPK</td>
                                        <td class="text-center"><?= ($l->PPK_sah == 1) ? Yii::$app->formatter->asDateTime($l->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") : '' ?></td>
                                        <td class="text-center"><?= ($l->PPK_sah == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '' ?></td>
                                        <td class="text-center"><?= ($l->PPK_sah == 1) ? 'PPK' : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PPP</strong></td>
                                        <td><?= (is_null($l->ppp) ? '-' : $l->ppp->CONm) ?></td>
                                        <td>Ketua Jabatan</td>
                                        <td class="text-center"><?= ($l->KJ_sah == 1) ? $l->KJ_sah_datetime : '' ?></td>
                                        <td class="text-center"><?= !is_null($l->KJ_sah) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '' ?></td>
                                        <td class="text-center"><?= is_null($l->KJ_sah) ? '-' : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PPK</strong></td>
                                        <td><?= (is_null($l->ppk) ? '-' : $l->ppk->CONm) ?></td>
                                        <td colspan="3" align="right"><strong>MARKAH PURATA</strong></td>
                                        <td class="text-center"><strong>
                                                <?php if (empty($l->markahSeluruh)) {
                                                    echo 'N/A';
                                                } else {
                                                    if ($l->PPP_sah == 1 and !is_null($l->PP_ALL)) {
                                                        echo $l->markahSeluruh->markah_PP;
                                                    } else if ($l->PPP_sah == 1 and $l->PPK_sah == 1) {
                                                        echo $l->markahSeluruh->markah_PP;
                                                    } else {
                                                        echo 'Menunggu Penilaian Selesai';
                                                    }
                                                } ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Catatan</strong></td>
                                        <td colspan="5">
                                            <?= $l->catatan ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <?= (($l->PYD_sah == 1) && (is_null($l->PP_ALL) ? ($l->PPP_sah == 1 && $l->PPK_sah == 1) : $l->PPP_sah == 1)) ? Html::a('<i class="fa fa-download"></i> <strong>MUAT TURUN BORANG</strong>', Url::to(['lppums/generate-borang', 'lpp_id' => $l->lpp_id]), ['target' => '_blank', 'class' => 'btn btn-sm btn-success']) : '<strong>Menunggu Penilaian Selesai</strong>'; ?>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>

                        </table>

                    </div>

                    <?php //Html::button('Klik untuk mohon borang LPP', ['value'=>\yii\helpers\Url::to(['lppums/mohon-lpp', ]), 'class' => 'btn btn-primary modalButton']) 
                    ?>

                    <?php
                    Modal::begin([
                        'header' => 'Mohon borang Laporan Penilaian Prestasi bagi PYD ' . $bio->CONm,
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    ?>

                    <dl class="dl-horizontal">
                        <dt>PPP</dt>
                        <dd>Pegawai Penilai Pertama</dd>
                        <dt>PPK</dt>
                        <dd>Pegawai Penilai Kedua</dd>
                    </dl>

                </div>
            </div>
        </div>
    </div>
</div>