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
use app\models\elnpt\TblLppTahun;

$tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();

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

<?php
// ($lpp->PYD == Yii::$app->user->identity->ICNO) ? $this->render('//elnpt/elnpt2/_menu', ['mrkh_all' => $menu, 'lppid' => $lppid]) 
//     : $this->render('_semakMenu', ['mrkh_all' => $menu, 'lppid' => $lppid]); 
// echo $this->render('//elnpt/elnpt2/_menu', ['menu' => $menu, 'lppid' => $lppid, 'sah' => isset($lpp) ? $lpp->PYD_sah : false]);
echo $this->render('//elnpt/elnpt2/_semakMenu', ['mrkh_all' => $menu, 'lppid' => $lppid]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengesahan Pegawai Yang Dinilai (PYD)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PYD <?= ($lpp->PYD_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PYD_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PYD_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                    <?php if ($lpp->PYD == \Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 1) { ?>
                        <p align="center">Sila klik pada pautan <b><a href="https://docs.google.com/forms/d/17WocQVoYhak7iIL6YYwBxwDI0cgmKXefRhdkpHJK9mY/edit?ts=5fe2a901&gxids=7628" target="_blank">Google Form</a></b> ini untuk aduan/komen/cadangan lain.
                            Kami mohon <b>Maklumbalas</b>, <b>Pertanyaan</b> Dan <b>Cadangan</b> anda bagi meningkatkan mutu sistem e-LNPT ini. </p>
                    <?php } ?>

                    <?php if ((($lpp->PYD_sah != 1 and $lpp->PYD == \Yii::$app->user->identity->ICNO) and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat))
                        or ($lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                    ) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['elnpt2/pengesahan-pyd', 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
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
                <h2><strong>Pengesahan Pegawai Penilai Pertama (PPP)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PPP <?= ($lpp->PPP_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PPP_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                    <?php if ((($lpp->PPP_sah != 1 and $lpp->PPP == \Yii::$app->user->identity->ICNO) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat))
                        or ($lpp->PPP == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                    ) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['elnpt2/pengesahan-ppp', 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
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
                <h2><strong>Pengesahan Pegawai Penilai Kedua (PPK)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PPK <?= ($lpp->PPK_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PPK_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                    <?php if ((($lpp->PPK_sah != 1 and $lpp->PPK == \Yii::$app->user->identity->ICNO) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat))
                        or ($lpp->PPK == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                    ) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['elnpt2/pengesahan-ppk', 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
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
                <h2><strong>Pengesahan PEER</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PEER <?= ($lpp->PEER_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PEER_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PEER_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                    <?php if ((($lpp->PEER_sah != 1 and $lpp->PEER == \Yii::$app->user->identity->ICNO) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat))
                        or ($lpp->PEER == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                    ) { ?>
                        <div style="text-align: center">
                            <?= Html::button('Sahkan', ['value' =>  Url::to(['elnpt2/pengesahan-peer', 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>