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
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
?>

<?php
Modal::begin([
    'header' => 'Pengesahan Laporan Penilaian Prestasi Tahun ' . $lpp->tahun . '',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengesahan Pegawai Yang Dinilai (PYD)</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm. ' - ' . $lpp->tahun. ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PYD <?= ($lpp->PYD_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lpp->tahun; ?> <?= ($lpp->PYD_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PYD_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                    <ol>
                        <li>Pastikan Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>
                        <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                        <?php if (is_null($lpp->PP_ALL)) { ?>
                            <ol type="i">
                                <li>PPP akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD</li>
                                <li>PPK akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD (setelah PPP membuat pengesahan)</li>
                            </ol>
                        <?php } else { ?>
                            <ol type="i">
                                <li>PP akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD</li>
                            </ol>
                        <?php } ?>
                    </ol>
                    <?php if (($lpp->PYD_sah != 1 and $lpp->PYD == \Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59'))
                        or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                    ) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['lppums/pengesahan-pyd', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengesahan <?= is_null($lpp->PP_ALL) ? 'Pegawai Penilai Pertama (PPP)' : 'Pegawai Penilai Keseluruhan (PP)' ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong><?= is_null($lpp->PP_ALL) ? 'PPP' : 'PP' ?> <?= ($lpp->PPP_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lpp->tahun; ?> <?= ($lpp->PPP_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                    <ol>
                        <li>Pastikan semua laporan/ulasan/komen pada Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>

                        <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                        <?php if (is_null($lpp->PP_ALL)) { ?>
                            <ol type="i">
                                <li>PPK akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> PYD</li>
                            </ol>
                        <?php } else { ?>
                            <ol type="i">
                                <li>LPP akan disahkan oleh Ketua Jabatan</li>
                            </ol>
                        <?php } ?>
                    </ol>
                    <?php if ($lpp->PPP_sah != 1 and $lpp->PPP == \Yii::$app->user->identity->ICNO) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['lppums/pengesahan-ppp', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (is_null($lpp->PP_ALL)) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Pengesahan Pegawai Penilai Kedua (PPK)</strong></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <p align="center"><strong>PPK <?= ($lpp->PPK_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lpp->tahun; ?> <?= ($lpp->PPK_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                        <ol>
                            <li>Pastikan semua laporan/ulasan/komen pada Laporan Penilaian Prestasi Tahun <?= $lpp->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>
                            <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                            <ol type="i">
                                <li>LPP akan disahkan oleh Ketua Jabatan</li>
                            </ol>
                        </ol>
                        <?php if ($lpp->PPK_sah != 1 and $lpp->PPK == \Yii::$app->user->identity->ICNO) { ?>
                            <div style="text-align: center">
                                <?= Html::button('Sahkan', ['value' =>  Url::to(['lppums/pengesahan-ppk', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>