<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;

?>

<?php
echo $this->render('_menuBorang', ['lnpk_id' => $lnpk->lnpk_id]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p align="center"><?= yii\helpers\Html::img('@web/files/elnpt/logo_my.png', ['alt' => 'Logo Kerajaan Malaysia', 'height' => 100]) ?><br /><br /><strong><?= 'LAPORAN PENILAIAN PRESTASI KHAS <br/>BAGI ' . $lnpk->jenisBorang->lnpk_desc ?></strong></p>
                    <p align="center"><strong><?= 'TAHUN ' . $lnpk->tahun  ?></strong></p>
                    <hr style="border-top: 1px dashed" />
                    <p align="center"><strong>PERINGATAN</strong></p>
                    <ol type="a">
                        <li><b>Pegawai Penilai (PP)</b> adalah pegawai atasan atau penyelia yang terdekat kepada <b>Pegawai Dinilai (PYD)</b> dan mempunyai hubungan kerja secara langsung atau yang mengawasi kerjanya;</li>
                        <li>Tempoh penyeliaan bagi membolehkan PP membuat penilaian adalah tidak kurang dari 6 bulan; dan</li>
                        <li>PP dan PYD hendaklah memberi perhatian kepada perkara­-perkara berikut sebelum dan semasa membuat penilaian:</li>
                        <ol type="i">
                            <?php if ($lnpk->lnpk_jenis == 1) { ?>
                                <li>PYD hendaklah menyemak maklumat di <strong>Bahagian I</strong></li>
                            <?php } else { ?>
                                <li>PYD hendaklah melengkapkan maklumat di <strong>Bahagian I</strong> dan melengkapkan maklumat dalam borang Sasaran Kerja dan Pencapaian Sasaran Kerja untuk tempoh penilaian seperti di <strong>Lampiran ‘A’</strong>;</li>
                            <?php } ?>
                            <li>PP hendaklah membuat penilaian di <strong>Bahagian II</strong> serta membuat ulasan mengenai prestasi keseluruhan pegawai di <strong>Bahagian III;</strong> </li>
                            <li>PP hendaklah menggunakan Skala Penilaian seperti <strong>Bahagian II</strong> dan penjelasan terhadap skala seperti di <strong>Lampiran ‘A’;</strong> dan</li>
                            <li>PYD hendaklah menyertakan senarai tugas jawatan yang disandang.</li>
                        </ol>
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
                <h2><strong>MAKLUMAT PEGAWAI</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                    DetailView::widget([
                        'model' => $lnpk,
                        'attributes' => [
                            [
                                'label' => 'Nama',
                                'value' => function ($model) {
                                    return $model->pyd->CONm;
                                },
                                'captionOptions' => ['style' => 'width:20%'],
                            ],
                            [
                                'label' => 'No. Kad Pengenalan',
                                'value' => function ($model) {
                                    return $model->pyd->ICNO;
                                },
                            ],
                            [
                                'label' => 'Skim Perkhidmatan',
                                'value' => function ($model) {
                                    return $model->gredPyd->skimPerkhidmatan->name;
                                },
                            ],
                            [
                                'label' => 'Gred Hakiki',
                                'value' => function ($model) {
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Nama & Gred Jawatan Yang Disandang Sekarang',
                                'value' => function ($model) {
                                    return $model->gredPyd->nama . ' ' . $model->gredPyd->gred;
                                },
                            ],
                            [
                                'label' => 'Tempat Bertugas',
                                'value' => function ($model) {
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Tarikh Memangku Jawatan Sekarang',
                                'value' => function ($model) {
                                    return null;
                                },
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>