<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\imagine\Image;

Image::thumbnail('@webroot/files/elnpt/tatacara-mohon-semakan-markah.png', 120, 120)
    ->save(Yii::getAlias('files/elnpt/thumbnails/tatacara-mohon-semakan-markah.jpg'), ['quality' => 50]); ?>
<?= $this->render('_menuUtama'); ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Panduan pengisian borang Laporan Penilaian Prestasi Tahunan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        <strong>Senarai Panduan / Pekeliling</strong><br>
                    <ol>
                        <li>Panduan Pengisian Borang Laporan Penilaian Prestasi (LPP) bagi Pegawai Yang Dinilai (PYD) <strong><?= Html::a('Download', 'https://hronline.ums.edu.my/lppums2013/file/PANDUAN%20PENGISIAN%20BORANG%20LAPORAN%20PENILAIAN%20PRESTASI%20(PYD).doc', ['target' => '_blank']); ?></strong></li>
                        <li>Panduan Pengisian Borang Laporan Penilaian Prestasi (LPP) bagi Pegawai Penilai Pertama (PPP)</li>
                        <li>Panduan Pengisian Borang Laporan Penilaian Prestasi (LPP) bagi Pegawai Penilai Kedua (PPK)</li>
                        <li>Panduan Pengisian Borang Laporan Penilaian Prestasi (LPP) bagi Ketua Jabatan</li>
                        <li>Panduan Penyediaan Sasaran Kerja Tahunan (SKT) <strong><?= Html::a('Download', 'https://hronline.ums.edu.my/lppums2013/file/PANDUAN%20PENYEDIAAN%20SKT.doc', ['target' => '_blank']); ?></strong></li>
                        <li>Surat Pekeliling Perkhidmatan Bilangan 2 Tahun 2009 <strong><?= Html::a('Download', 'https://hronline.ums.edu.my/lppums2013/file/SURAT%20PEKELILING%20PERKHIDMATAN%20BILANGAN%202%20TAHUN%202009.pdf', ['target' => '_blank']); ?></strong></li>
                        <li><?=
                            Html::a(Html::img(Yii::getAlias('@web/files/elnpt/thumbnails/tatacara-mohon-semakan-markah.jpg')), Yii::getAlias('@web/files/elnpt/tatacara-mohon-semakan-markah.png'),  ['target' => '_blank']);
                            ?><br> Tatacara Permohonan Rayuan Semakan Markah LNPT 2020</li>
                    </ol>
                    </p>
                    <p>
                        <strong>Pertanyaan / Maklumat Lanjut</strong><br> Sebarang pertanyaan / maklumat lanjut berkenaan proses dan prosedur pengisian borang Laporan Penilaian Prestasi boleh dibuat kepada pegawai-pegawai berikut:<br>
                    <ul>
                        <li>Puan Carrie Grace Jaymess (Pegawai Psikologi Kanan) - Samb 4157</li>
                        <li>Puan Sabiah Binti Bansai (Pembantu Tadbir) - Samb 1173</li>
                        <li>Cleeve Feeley Bachee (Pegawai Sistem LNPT) - Samb 1452</li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>