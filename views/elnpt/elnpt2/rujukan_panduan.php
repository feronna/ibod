<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\imagine\Image;

Image::thumbnail('@webroot/files/elnpt/tatacara-mohon-semakan-markah.png', 120, 120)
    ->save(Yii::getAlias('files/elnpt/thumbnails/tatacara-mohon-semakan-markah.jpg'), ['quality' => 50]);
Image::thumbnail('@webroot/files/elnpt/index.jpg', 120, 120)
    ->save(Yii::getAlias('files/elnpt/thumbnails/index.jpg'), ['quality' => 50]);

$query = app\models\elnpt\testing\TblTestingAccess::find()
    ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
    ->exists();

?>

<?= $query ? $this->render('//elnpt/_menuAdmin') : $this->render('//elnpt/_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Rujukan / Pertanyaan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        <strong>Rujukan</strong><br>

                    <ol>
                        <li>MANUAL RUJUKAN LNPT GURU (<?= \Yii::$app->formatter->asDate('2021-12-03', 'long') ?>) <strong><?= Html::a('Download', yii\helpers\Url::to('@web/files/elnpt/MANUAL LNPT GURU 2021.pdf'), ['target' => '_blank']); ?></strong></li>
                        <li><?=
                            Html::a(Html::img(Yii::getAlias('@web/files/elnpt/thumbnails/tatacara-mohon-semakan-markah.jpg')), Yii::getAlias('@web/files/elnpt/tatacara-mohon-semakan-markah.png'),  ['target' => '_blank']);
                            ?><br> Tatacara Permohonan Rayuan Semakan Markah LNPT</li>
                        <li><?=
                            Html::a(Html::img(Yii::getAlias('@web/files/elnpt/thumbnails/index.jpg')), Yii::getAlias('@web/files/elnpt/index.jpg'),  ['target' => '_blank']);
                            ?><br> Pengesahan Maklumat</li>
                    </ol>
                    </p>
                    <br>
                    <p>
                        <strong>Pertanyaan / Maklumat Lanjut</strong><br>

                        Sebarang pertanyaan / maklumat lanjut berkenaan proses dan prosedur pengisian borang eLNPT Akademik boleh dibuat kepada pegawai-pegawai berikut:<br>

                    <ul>
                        <li>Puan Carrie Grace Jaymess (Pegawai Psikologi Kanan) - Samb 4157</li>
                        <li>Puan Sabiah Binti Bansai (Pembantu Tadbir) - Samb 1173</li>
                    </ul>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>