<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\helpers\Html;
?>

<?= $this->render('//elnpt/elnpt3/_menu', ['menu' => $menu, 'lppid' => $lppid, 'sah' => isset($lpp) ? $lpp->PYD_sah : false]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Maklumat Guru</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                    DetailView::widget([
                        'model' => $query,
                        'attributes' => [
                            [
                                'label' => 'Tahun Penilaian',
                                'value' => function ($model) {
                                    return $model->tahun;
                                },
                                'captionOptions' => ['style' => 'width:20%'],
                            ],
                            [
                                'label' => 'Tempoh Pengisian',
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->tahunLpp->lpp_trkh_hantar, 'dd/MM/yyyy') . ' hingga ' . Yii::$app->formatter->asDate($model->tahunLpp->pengisian_PYD_tamat, 'dd/MM/yyyy');
                                },
                                //'captionOptions' => ['style' => 'width:20%'],
                            ],
                            [
                                'label' => 'Nama',
                                'value' => function ($model) {
                                    return $model->guru->CONm;
                                },
                            ],
                            [
                                'label' => 'Gred / Jawatan',
                                'value' => function ($model) {
                                    return $model->gredGuru->fname;
                                }
                            ],
                            [
                                'label' => 'No. UMSPER',
                                'value' => function ($model) {
                                    return $model->guru->COOldID;
                                },
                            ],
                            [
                                'label' => 'No. Kad Pengenalan / No. Passport',
                                'value' => function ($model) {
                                    return $model->guru->ICNO;
                                },
                            ],
                            [
                                'label' => 'J/S/P/I/U',
                                'value' => function ($model) {
                                    return $model->deptGuru->fullname;
                                },
                            ],
                            [
                                'label' => 'PPP',
                                'value' => function ($model) {
                                    return is_null($model->ppp) ? '<b>Pegawai Penilai Pertama Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $model->ppp->CONm;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PPK',
                                'value' => function ($model) {
                                    return is_null($model->ppk) ? '<b>Pegawai Penilai Kedua Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $model->ppk->CONm;
                                    return $model->ppk->CONm;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PEER',
                                'value' => function ($model) {
                                    return is_null($model->peer) ? '<b>Peer Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : '<b>Peer Sudah Ditetapkan.</b>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'CATATAN',
                                'value' => function ($model) {
                                    return $model->catatan;
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