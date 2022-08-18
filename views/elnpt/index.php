<?php
/* @var $this yii\web\View */

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\imagine\Image;


Image::thumbnail('@webroot/files/elnpt/uji-lari.png', 120, 120)
    ->save(Yii::getAlias('files/elnpt/thumbnails/uji-lari.jpg'), ['quality' => 50]);

?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Laman Utama</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Selamat datang ke Sistem Laporan Penilaian Prestasi Tahunan (Akademik).<br><br>

                        Sistem ini digunakan untuk tujuan pengisian borang Laporan Penilaian Prestasi (LPP) bagi kakitangan:<br>

                    <ul>
                        <li>Kakitangan Akademik</li>
                        <li>Kumpulan Pengurusan Tertinggi (Profesor)</li>
                    </ul>

                    Sila rujuk panduan pengisian borang yang disediakan dan mula mengisi borang Laporan Penilaian Prestasi.
                    </p>
                    <br />
                    <p>
                        <strong>Cara Akses Uji Lari Sistem e-LNPT 2022</strong><br>

                    <ol>
                        <li>
                            <?=
                            Html::a(Html::img(Yii::getAlias('@web/files/elnpt/thumbnails/uji-lari.jpg')), Yii::getAlias('@web/files/elnpt/uji-lari.png'),  ['target' => '_blank']);
                            ?>
                        </li>
                    </ol>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>