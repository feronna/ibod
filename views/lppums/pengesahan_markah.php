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
    'header' => 'Permohonan Rayuan Semakan Semula Markah Laporan Penilaian Prestasi Tahun ' . $lpp->tahun . '',
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
                <h2><strong>Pengesahan Markah Pegawai Yang Dinilai (PYD)<?= ($lpp->markah_sah == 1) ? ' <sub>(' . $lpp->markah_sah_datetime . ')</sub>' : '' ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <p align="center">
                        <?php if (($lpp->markah_sah == 1) && !is_null($lpp->markah_sah_datetime)) { ?>
                            Saya <?= '<u>' . $lpp->pyd->CONm . '</u>' ?> dengan ini mengesahkan bahawa saya telah menyemak markah LNPT Tahun <?= $lpp->tahun ?> dan berpuas hati dengan penilaian yang telah diberikan.
                        <?php } else if (($lpp->markah_sah == 0) && !is_null($lpp->markah_sah_datetime)) { ?>
                            Saya <?= '<u>' . $lpp->pyd->CONm . '</u>' ?> dengan ini mengesahkan bahawa saya telah menyemak markah LNPT Tahun <?= $lpp->tahun ?> dan TIDAK BERSETUJU dengan penilaian yang telah diberikan. Oleh itu saya memohon rayuan semakan semula markah.
                        <?php } else { ?>
                            Klik pada <b>[Setuju]</b> atau <b>[Tidak Setuju]</b> untuk menerima atau menolak markah LNPT Tahun <?= $lpp->tahun ?>.
                        <?php } ?>
                    </p>

                    <?php if (($lpp->PYD == \Yii::$app->user->identity->ICNO) && ($lpp->markah_sah == 0)) { ?>
                        <div style="text-align: center">
                            <?= Html::a('Setuju', Url::to(['lppums/markah-setuju', 'lpp_id' => $lpp->lpp_id]), ['class' => 'btn btn-success btn-sm', 'id' => 'setuju']) ?>
                            <?= Html::button('Tidak Setuju', ['value' =>  Url::to(['lppums/mohon-semak', 'lpp_id' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-sm modalButton', 'id' => 'nda-setuju']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>