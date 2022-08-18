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
    'header' => 'Pengesahan Laporan Penilaian Prestasi Tahun ' . $lnpk->tahun . '',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
echo $this->render('_menuBorang', ['lnpk_id' => $lnpk->lnpk_id]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengesahan <?= (is_null($lnpk->isPP) || ($lnpk->isAdmin() && !$lnpk->isPP)) ? 'Pegawai Penilai Pertama (PPP)' : 'Pegawai Penilai Keseluruhan (PP)' ?></strong><?= $lnpk->isAdmin() ? '<sup> View as Admin</sup>' : '' ?><?= ' - ' . $lnpk->pyd->CONm ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong><?= (is_null($lnpk->isPP) || ($lnpk->isAdmin() && !$lnpk->isPP)) ? 'PPP' : 'PP' ?> <?= ($lnpk->PPP_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lnpk->tahun; ?> <?= ($lnpk->PPP_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lnpk->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                    <ol>
                        <li>Pastikan semua laporan/ulasan/komen pada Laporan Penilaian Prestasi Tahun <?= $lnpk->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>

                        <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                        <?php if ((is_null($lnpk->isPP)) || ($lnpk->isAdmin() && !$lnpk->isPP)) { ?>
                            <ol type="i">
                                <li>PPK akan mula menilai Laporan Penilaian Prestasi Tahun <?= $lnpk->tahun; ?> PYD</li>
                            </ol>
                        <?php } else { ?>
                            <ol type="i">
                                <li>LPP akan disahkan oleh Ketua Jabatan</li>
                            </ol>
                        <?php } ?>
                    </ol>
                    <?php if ($lnpk->PPP_sah != 1 and ($lnpk->PPP == \Yii::$app->user->identity->ICNO || $lnpk->isAdmin())) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['lnpk/pengesahan-ppp', 'lnpk_id' => $lnpk->lnpk_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (is_null($lnpk->isPP) || ($lnpk->isAdmin() && !$lnpk->isPP)) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Pengesahan Pegawai Penilai Kedua (PPK)</strong></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <p align="center"><strong>PPK <?= ($lnpk->PPK_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN LAPORAN PENILAIAN PRESTASI TAHUN <?= $lnpk->tahun; ?> <?= ($lnpk->PPK_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lnpk->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                        <ol>
                            <li>Pastikan semua laporan/ulasan/komen pada Laporan Penilaian Prestasi Tahun <?= $lnpk->tahun; ?> telah dilengkapkan sebelum membuat pengesahan</li>
                            <li>Laporan Penilaian Prestasi yang telah dibuat pengesahan tidak boleh dikemaskini kerana:</li>
                            <ol type="i">
                                <li>LPP akan disahkan oleh Ketua Jabatan</li>
                            </ol>
                        </ol>
                        <?php if ($lnpk->PPK_sah != 1 and ($lnpk->PPK == \Yii::$app->user->identity->ICNO  || $lnpk->isAdmin())) { ?>
                            <div style="text-align: center">
                                <?= Html::button('Sahkan', ['value' =>  Url::to(['lnpk/pengesahan-ppk', 'lnpk_id' => $lnpk->lnpk_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>