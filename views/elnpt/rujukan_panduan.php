<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$query = app\models\elnpt\testing\TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                                ->exists();

?>

<?= $query ? $this->render('_menuAdmin') : $this->render('_menuUtama'); ?>

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
                        <li>Manual Rujukan Rubrik Penilaian (<?=  \Yii::$app->formatter->asDate('2020-01-02', 'long') ?>) <strong><?= Html::a('Download', yii\helpers\Url::to('@web/files/MANUAL RUJUKAN RUBRIK PENILAIAN.pdf'), ['target'=>'_blank']); ?></strong></li>
                        <li>Manual Pengisian Borang e-LNPT Akademik (<?=  \Yii::$app->formatter->asDate('2019-12-09', 'long') ?>) <strong><?= Html::a('Download', yii\helpers\Url::to('@web/files/MANUAL PENGISIAN ELNPT AKADEMIK.pptx'), ['target'=>'_blank']); ?></strong></li>
                    </ol>
                    
                    </p>
                    <br>
                    <p>
                        <strong>Pertanyaan / Maklumat Lanjut</strong><br>
                        
                        Sebarang pertanyaan / maklumat lanjut berkenaan proses dan prosedur pengisian borang eLNPT Akademik boleh dibuat kepada pegawai-pegawai berikut:<br>
                        
                    <ul>
                        <li>Puan Carrie Grace Jaymess (Pegawai Psikologi Kanan) - Samb 4157</li>
                        <li>Puan Sabiah Binti Bansai (Pembantu Tadbir) - Samb 1173</li>
                        <li>Encik Cleeve Feeley Bachee (Pegawai Sistem LNPT) - Samb 1452</li>
                    </ul>
                    
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>