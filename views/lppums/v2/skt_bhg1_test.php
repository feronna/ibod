<?php

$js = <<<JS
     $('.modalButtonn').on('click', function () {
        $('#modalLnpkSkt').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').text('Tambah SKT');
    });

    $('.modalButtonn1').on('click', function () {
        $('#modalLnpkSkt').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').text('Kemaskini SKT');
    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;

$akses = \app\models\lppums\TblStafAkses::find()
    ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
    ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
    ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
    ->exists();

$tabs = [];
foreach ($bhgs as $ind => $bhg) {
    $tabs[$ind]['label'] = strtoupper($bhg['bahagian']);
    $tabs[$ind]['active'] = isset($chosen_tab) ? (($ind == $chosen_tab) ? true : false) : (($ind == 0) ? true : false);
    $tabs[$ind]['content'] = $this->render('_skt', ['query' => $query, 'bhg' => $bhg['bahagian_id'], 'lppid' => $lppid, 'lpp' => $lpp, 'akses' => $akses, 'tt' => $tt, 'currTab' => $ind]);
}

Modal::begin([
    'header' => '<strong id="modalHeader"></strong>',
    'id' => 'modalLnpkSkt',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

// $items = [];
// foreach ($aspeks as $ind => $aspek) {
//     $items[$ind]['title'] = strtoupper($aspek['aspek_label']);
//     $items[$ind]['active'] = ($ind == 0) ? true : false;
//     $items[$ind]['content'] = $this->render('_skt');
// }
?>

<?= $this->render('//lppums/_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

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
                    <?=
                    TabsX::widget(['items' => $tabs, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
                    ?>
                </div>
                <hr>
                <div class="row">

                    <div class="row">
                        <?php if (is_null($tt->skt_tt_pyd) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    'Klik untuk tandatangan PYD',
                                    ['lppums/skt-bahagian1-test', 'lpp_id' => $_GET['lpp_id']],
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
                                    ['lppums/skt-bahagian1-test', 'lpp_id' => $_GET['lpp_id']],
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