<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\FileInput;

$title = $this->title = 'Muatnaik Dokumen';
?> 

<?php echo $this->render('/cutibelajar/_topmenu'); ?>
    <p align="right">  <?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-primary btn-sm'])
?></p>
    <div class="row">

    <div class="x_panel">

        <div class="x_content"> 
            <?php if ($model->kakitangan->jawatan->job_category == 1) { ?> 
                <h3> <span class="label label-info">AKADEMIK</span></h3>

                <?php
                $dataProvider = new ActiveDataProvider([
                    'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 1]),
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
                ?>                   <div class="table-responsive ">
                <?php if ((!$pengajian) || ($pengajian->status == NULL) || ($pengajian->status == 9) || ($pengajian->status == 2) || ($pengajian->status == 4)|| ($pengajian->status == 6)) {
                    
                    ?>

                        <h5><strong><i class="fa fa-list"></i> PERMOHONAN BAHARU PENGAJIAN LANJUTAN</strong></h5>

                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [

                                ['class' => 'yii\grid\SerialColumn',
//                                         'headerOptions' => ['class'=>'text-center'],
                                    'headerOptions' => ['style' => 'width:5%'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'header' => 'Bil.'],
                                [
                                    'label' => 'Nama Borang',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function($model) {
                                return strtoupper($model->jenisBorang);
                            },
                                ],
                                [
                                    'header' => 'Tindakan',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{mohon}',
                                    'buttons' => [
                                        'mohon' => function($url, $model, $key) use ($iklan, $model2, $model3,$model4,$mohon,$pengajian) {
//                                                    $id = $model3->id;
                                            if (($model->id == 1) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['sepenuh-masa/lihat-permohonan', 'id' => $model3->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model->id]);
                                            } elseif (($model->id == 2) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['sabatikal/lihat-permohonan', 'id' => $model2->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model->id]);
                                            } elseif (($model->id == 38) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['separuh-masa/lihat-permohonan', 'id' => $model3->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model3->id]);
                                            } elseif (($model->id == 43) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['sub-kepakaran/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model3->id]);
                                            }
                                            elseif (($model->id == 39) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['latihan-industri/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model3->id]);
                                            }
                                             elseif (($model->id == 40) && ($model->checkPermohonan8($iklan->id, $model->id))) {
                                                $url = Url::to(['sangkutan/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model4->id]);
                                            }
                                             elseif (($model->id == 44) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['cuti-penyelidikan/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model3->id]);
                                            }
                                             elseif (($model->id == 51) && ($model->checkPermohonan10($iklan->id, $model->id))) {
                                                $url = Url::to(['pensijilan/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model3->id]);
                                            }
                                              elseif (($model->id == 41) && ($model->checkPermohonan($iklan->id, $model->id))) {
                                                $url = Url::to(['pra-warta/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Selesai Permohonan', 'id' => $model3->id]);
                                            }
                                            elseif (($model->id == 1) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['sepenuh-masa/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                            } elseif (($model->id == 38) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/separuh-masa/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                            }elseif (($model->id == 39) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/latihan-industri/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                            }
                                            elseif (($model->id == 41) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/pra-warta/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                            }
                                              elseif (($model->id == 42) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/pos-doktoral/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                                
                                            }
                                             elseif (($model->id == 43) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/sub-kepakaran/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                             }
                                               elseif (($model->id == 40) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/sangkutan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                             }
                                              elseif (($model->id == 38) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/separuh-masa/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                             }
                                             elseif (($model->id == 44) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['/cuti-penyelidikan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                             }elseif (($model->id == 2) && ($model->checkSimpan($iklan->id, $model->id))) {
                                                $url = Url::to(['sabatikal/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                            } elseif (($model->id == 1) && ($model->checkBuka($iklan->id, $model->id))) {
                                                $url = Url::to(['cbelajar/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-pencil fa-lg" style="color: blue"></i>', $url, [
                                                            'title' => 'Kemaskini Borang']);
                                            }
                                            elseif (($model->id == 40) && ($model->checkBuka($iklan->id, $model->id))) {
                                                $url = Url::to(['sangkutan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                return Html::a('<i class="fa fa-pencil fa-lg" style="color: blue"></i>', $url, [
                                                            'title' => 'Kemaskini Borang']);
                                            }elseif(!$mohon) {
                                                if ($model->id == 1) {
                                                    return Html::a('MOHON', ['/sepenuh-masa/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                } elseif ($model->id == 2) {
                                                    $url = Url::to(['cutisabatikal/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['sabatikal/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                elseif ($model->id == 39) {
                                                    $url = Url::to(['latihan-industri/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['latihan-industri/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                elseif ($model->id == 41) {
                                                    $url = Url::to(['pra-warta/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['pra-warta/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                 elseif ($model->id == 42) {
                                                    return Html::a('MOHON', ['pos-doktoral/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                 elseif ($model->id == 43) {
                                                    return Html::a('MOHON', ['sub-kepakaran/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                 elseif ($model->id == 44) {
                                                    return Html::a('MOHON', ['cuti-penyelidikan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                 elseif ($model->id == 38) {
                                                    return Html::a('MOHON', ['separuh-masa/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                 elseif ($model->id == 40) {
                                                    return Html::a('MOHON', ['sangkutan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                  elseif ($model->id == 51) {
                                                    return Html::a('MOHON', ['pensijilan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                
                                            }
                                            else
                                            {
                                                if ($model->id == 1) {
                                                    $url = Url::to(['cbelajar/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['cbelajar/gambar', 'id' => $iklan->id, 'borang' => 1], ['class' => 'btn btn-primary btn-xs disabled']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                } elseif ($model->id == 2) {
                                                    $url = Url::to(['cutisabatikal/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['sabatikal/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                  elseif ($model->id == 38) {
                                                    $url = Url::to(['separuh-masa/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['separuh-masa/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                elseif ($model->id == 39) {
                                                    $url = Url::to(['latihan-industri/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['latihan-industri/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                 elseif ($model->id == 41) {
                                                    $url = Url::to(['pra-warta/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['pra-warta/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                  elseif ($model->id == 42) {
                                                    $url = Url::to(['pos-doktoral/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['pos-doktoral/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                elseif ($model->id == 43) {
                                                    $url = Url::to(['sub-kepakaran/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['sub-kepakaran/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                elseif ($model->id == 44) {
                                                    $url = Url::to(['cuti-penyelidikan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['cuti-penyelidikan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                  elseif ($model->id == 40) {
                                                    $url = Url::to(['cuti-penyelidikan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['sangkutan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
                                                  elseif ($model->id == 51) {
                                                    $url = Url::to(['cuti-penyelidikan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                    return Html::a('MOHON', ['sangkutan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                }
//                                                else {
//                                                    $url = Url::to(['cbelajar/gambar', 'id' => $iklan->id, 'borang' => 38]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                    return Html::a('MOHON', ['gambar-separuh-masa', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
////                                                            'title' => 'Mohon Cuti Belajar']);
//                                                }
                                                
                                            }
                                            }
                                            ],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ]
                                    ],
                                ]);
                            }
                        } elseif ($model->kakitangan->jawatan->job_category == 2) {
                            ?>
                            <h3> <span class="label label-info">PENTADBIRAN</span></h3>
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => \app\models\cbelajar\RefBorang::find()->where(['status'=>3]),
                                'pagination' => [
                                    'pageSize' => 10,
                                ],
                            ]);
                            ?> 
                            <?php if ((!$pengajian) || ($pengajian->status == NULL) || ($pengajian->status == 9) 
                                    ||  ($pengajian->status == 6) || ($pengajian->status == 8)) {
                                ?>

                                <div class="table-responsive ">

                                    <h5><strong><i class="fa fa-list"></i> PERMOHONAN BAHARU PENGAJIAN LANJUTAN PENTADBIRAN</strong></h5>

                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $senarai_dokumen3,
                                        'options' => ['style' => 'width:100%'],
                                        'layout' => "{items}\n{pager}",
                                        'columns' => [

                                            ['class' => 'yii\grid\SerialColumn',
//                                         'headerOptions' => ['class'=>'text-center'],
                                                'headerOptions' => ['style' => 'width:5%'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'header' => 'Bil.'],
                                            [
                                                'label' => 'Nama Borang',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'value' => function($model) {
                                            return strtoupper($model->jenisBorang);
                                        },
                                            ],
                                            [
                                                'header' => 'Tindakan',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{mohon}',
                                                'buttons' => [
                                                    'mohon' => function($url, $model, $key) use ($iklan, $model2, $model3, $model4, $model5,$mohon) {
                                                        if (($model->id == 32) && ($model->checkPermohonan9($iklan->id, $model->id))) {
                                                            $url = Url::to(['pentadbiran/lihat-permohonan', 'id' => $model3->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                        'title' => 'Lihat Permohonan', 'id' => $model2->id]);
                                                        } elseif (($model->id == 33) && ($model->checkPermohonan1($iklan->id, $model->id))) {
                                                            $url = Url::to(['sabatikal/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                        'title' => 'Selesai Permohonan', 'id' => $model2->id]);
                                                        }
                                                        elseif (($model->id == 40) && ($model->checkPermohonan1($iklan->id, $model->id))) {
                                                            $url = Url::to(['sangkutan/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                        'title' => 'Selesai Permohonan', 'id' => $model2->id]);
                                                        }
                                                         elseif (($model->id == 51) && ($model->checkPermohonan1($iklan->id, $model->id))) {
                                                            $url = Url::to(['latihan-pensijilan/lihat-permohonan', 'id' => $model4->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                        'title' => 'Selesai Permohonan', 'id' => $model2->id]);
                                                        }
                                                         
                                                        
                                                        elseif (($model->id == 32) && ($model->checkSimpan1($iklan->id, $model->id))) {
                                                            $url = Url::to(['pentadbiran/pengakuan-pemohon?id=' . $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                                        'title' => 'Hantar Permohonan']);
                                                        } elseif (($model->id == 33) && ($model->checkSimpan2($iklan->id, $model->id))) {
                                                            $url = Url::to(['sabatikal/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                                        'title' => 'Hantar Permohonan']);
                                                        } 
                                                         elseif (($model->id == 40) && ($model->checkSimpan3($iklan->id, $model->id))) {
                                                            $url = Url::to(['sangkutan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                                        'title' => 'Hantar Permohonan']);
                                                        }
                                                         elseif (($model->id == 48) && ($model->checkSimpan4($iklan->id, $model->id))) {
                                                            $url = Url::to(['pra-warta/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                                        'title' => 'Hantar Permohonan']);
                                                        } 
                                                          elseif (($model->id == 51) && ($model->checkSimpan4($iklan->id, $model->id))) {
                                                            $url = Url::to(['latihan-pensijilan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                            return Html::a('<i class="fa fa-save fa-lg" style="color: orange"></i>', $url, [
                                                                        'title' => 'Hantar Permohonan']);
                                                        } 
                                                        elseif(!$mohon) {
                                                if ($model->id == 32) {
                                                                return Html::a('MOHON', ['pentadbiran/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                            } elseif ($model->id == 48) {
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['pra-warta/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                            }
                                                            elseif ($model->id == 40) {
                                                                $url = Url::to(['sangkutan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['sangkutan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                            }
                                                             elseif ($model->id == 51) {
                                                                $url = Url::to(['sangkutan/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['latihan-pensijilan/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                            }
                                            }
                                            else
                                            {
                                                if ($model->id == 32) {
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['pentadbiran/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                }
                                                elseif ($model->id == 2) {
                                                                return Html::a('MOHON', ['sabatikal/lihatpermohonan', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                            }
                                                            elseif ($model->id == 40) {
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['sangkutan/lihatpermohonan', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                            }elseif ($model->id == 33) {
                                                                $url = Url::to(['cutisabatikal/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['cutisabatikal/gambar', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                            }
                                                            elseif ($model->id == 51) {
                                                                $url = Url::to(['cutisabatikal/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['laithan-pensijilan/lihatpermohonan', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs disabled']);
                                                            }
                                                
                                            }
                                                        
//                                                        else {
//                                                            if ($model->id == 32) {
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                                return Html::a('MOHON', ['pentadbiran/pengakuan-pemohon', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
////                                                            'title' => 'Mohon Cuti Belajar']);
//                                                            } elseif ($model->id == 33) {
//                                                                $url = Url::to(['cutisabatikal/gambar', 'id' => $iklan->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                                return Html::a('MOHON', ['cutisabatikal/gambar', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                            }
//                                                        }
                                                    }
                                                        ],
                                                        'contentOptions' => ['class' => 'text-center'],
                                                    ]
                                                ],
                                            ]);
                                            ?>
                                        </div>

                                    </div>


                                </div><?php
                            }
                        }
                        ?>

                        <div class="x_panel">

                            <div class="x_content"> 
                                <?php
                                $dataProvider = new ActiveDataProvider([
                                    'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 1])->one(),
                                    'pagination' => [
                                        'pageSize' => 10,
                                    ],
                                ]);
                                ?> 
                                <?php if ($pengajians) { ?>

                                    <div class="table-responsive ">

                                        <h5><strong><i class="fa fa-clock-o"></i> PERMOHONAN PELANJUTAN TEMPOH CUTI BELAJAR</strong></h5>

                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $senarai_dokumen1,
                                            'options' => ['style' => 'width:100%'],
                                            'layout' => "{items}\n{pager}",
                                            'columns' => [


                                                ['class' => 'yii\grid\SerialColumn',
                                                    'headerOptions' => ['style' => 'width:5%'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'header' => 'Bil.'],
                                                [
                                                    'label' => 'Nama Borang',
                                                    'headerOptions' => ['style' => 'width:80%'],
                                                    'value' => function($model) {
                                                return strtoupper($model->jenisBorang);
                                            },
                                                ],
                                                [
                                                    'header' => 'Tindakan',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'template' => '{mohon}',
                                                    'buttons' => [
                                                        'mohon' => function($url, $model, $key) use ($iklan) {
                                                            if ($model->checkPermohonanLanjutan($iklan->id)) {
                                                                $url = Url::to(['lanjutancb/lihat-permohonan', 'id' => $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                            'title' => 'Selesai Permohonan']);
                                                            } elseif ($model->checkSimpanBorang($iklan->id)) {
                                                                $url = Url::to(['lanjutancb/borang-permohonan', 'id' => $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('<i class="fa fa-save" style="color: orange"></i>', $url, [
                                                                            'title' => 'Hantar Permohonan']);
                                                            } else {
                                                                $url = Url::to(['lanjutancb/borang-permohonan', 'id' => $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                return Html::a('MOHON', ['lanjutancb/borang-permohonan', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                            }
                                                        }
                                                            ],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                        ]
                                                    ],
                                                ]);
                                                ?>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="x_panel">

                                        <div class="x_content"> 
                                            <?php
                                            $dataProvider = new ActiveDataProvider([
                                                'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 1]),
                                                'pagination' => [
                                                    'pageSize' => 10,
                                                ],
                                            ]);
                                            ?> 


                                            <div class="table-responsive ">
                                                <h5><strong><i class="fa fa-file-o"></i>  LAIN-LAIN PERMOHONAN</strong></h5>

                                                <?=
                                                GridView::widget([
                                                    'dataProvider' => $senarai_dokumen2,
                                                    'options' => ['style' => 'width:100%'],
                                                    'layout' => "{items}\n{pager}",
                                                    'columns' => [

                                                        ['class' => 'yii\grid\SerialColumn',
                                                            'headerOptions' => ['style' => 'width:5%'],
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'header' => 'Bil.'],
                                                        [
                                                            'label' => 'Nama Borang',
                                                            'headerOptions' => ['style' => 'width:80%'],
                                                            'value' => function($model) {
                                                        return strtoupper($model->jenisBorang);
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'Tindakan',
                                                            'headerOptions' => ['class' => 'text-center'],
                                                            'class' => 'yii\grid\ActionColumn',
                                                            'template' => '{mohon}',
                                                            'buttons' => [
                                                                'mohon' => function($url, $model, $key) use ($iklan) {
                                                                    if (($model->id == 22) && ($model->checkPermohonanLain($iklan->id, $model->id))) {
                                                                        $url = Url::to(['cblainlain/lihat-permohonan', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                        return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                                    'title' => 'Selesai Permohonan']);
                                                                    } elseif (($model->id == 23) && ($model->checkPermohonanLain($iklan->id, $model->id))) {
                                                                        $url = Url::to(['cblainlain/lihat-permohonan-tarikh', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                        return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                                    'title' => 'Selesai Permohonan']);
                                                                    } elseif (($model->id == 24) && ($model->checkPermohonanLain($iklan->id, $model->id))) {
                                                                        $url = Url::to(['cblainlain/lihat-permohonan-tukar-tempat', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                        return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                                    'title' => 'Selesai Permohonan']);
                                                                    } elseif (($model->id == 31) && ($model->checkPermohonanLain($iklan->id, $model->id))) {
                                                                        $url = Url::to(['cblainlain/lihat-permohonan-tangguh-pengajian', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                        return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                                    'title' => 'Selesai Permohonan']);
                                                                    }
                                                                    elseif (($model->id == 49) && ($model->checkPermohonanLain($iklan->id, $model->id))) {
                                                                        $url = Url::to(['cblainlain/lihat-permohonan-tukar-mod-pengajian', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                        return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                                                    'title' => 'Selesai Permohonan']);
                                                                    }
//                                                     elseif (($model->id == 31) &&($model->checkPermohonanLain($iklan->id, $model->id)))  {
//                                                        $url = Url::to(['cblainlain/lihat-permohonan-tangguh-pengajian', 'id' => $iklan->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
//                                                            'title' => 'Selesai Permohonan']);
//                                                    } 
//                                                 
                                                                    else {
                                                                        if ($model->id == 22) {
                                                                            $url = Url::to(['cblainlain/borang-permohonan', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                            return Html::a('MOHON', ['cblainlain/borang-permohonan', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                                        } elseif ($model->id == 23) {
                                                                            $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                            return Html::a('MOHON', ['cblainlain/borang-permohonan-tukar-tarikh', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                                        } elseif ($model->id == 24) {
                                                                            $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                            return Html::a('MOHON', ['cblainlain/borang-permohonan-tukar-tempat', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                                        } elseif ($model->id == 31) {
                                                                            $url = Url::to(['cblainlain/mohon-penangguhan-pengajian', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                            return Html::a('MOHON', ['cblainlain/mohon-penangguhan-pengajian', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                                        }
                                                                        elseif ($model->id == 49) {
                                                                            $url = Url::to(['cblainlain/mohon-tukar-mod-pengajian', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                                            return Html::a('MOHON', ['cblainlain/mohon-tukar-mod-pengajian', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                                        }
                                                                    }
                                                                }
                                                                    ],
                                                                    'contentOptions' => ['class' => 'text-center'],
                                                                ]
                                                            ],
                                                        ]);
                                                        ?>
                                                    </div>

                                                </div>



                                            </div>
         <div class="x_panel">

            <ul>
                <li><i class="fa fa-save fa-lg" style="color: orange"></i>: <span class="label label-primary">Permohonan Disimpan</span></li>
                <li><i class="fa fa-check-square-o fa-lg" style="color: green"></i> : <span class="label label-success">Permohonan Telah Dihantar</span> </li> 
            </ul>
                                        </div>

 </div></div>
                                        <?php } else{
                                            
                                            ?>
<div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

        <div class="x_content">  
            <div class="x_title">
            <h5><strong><i class="fa fa-info-circle"></i>  Untuk maklumat lanjut, sila hubungi:</strong></h5> 
            <div class="clearfix"></div>
        </div>
<!--            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="6"><i class="fa fa-info-circle"></i><h5> MAKLUMAT LANJUT, SILA HUBUNGI:</h5></th> 
                    </tr>
                </thead>
            </table>-->
            <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                  
                                        <tr>
                                            <th class="text-center" style="width:40%">PERKARA</th>
                                            <th class="text-center" style="width:50%">KAKITANGAN</th>
<!--                                            <th class="text-center">TARIKH PENGAJIAN</th>-->
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                           

                                        </tr>
                                       
<!--                                        <tr>
                                                <td ><ul>
                                                        <li>Urusan Sistem Pengajian Lanjutan</li>
                                                       
                                                     </ul></td>
                                                     <td class="text-justify"><b> Cik Nor Fazleenawana Binti Awang Latiff</b>	 <br/>
                                                    Penolong Pegawai Teknologi Maklumat <br/>
                                                    <i class="fa fa-envelope"></i> norfazleenawana@ums.edu.my</td>
                                               
                                                
                                            </tr>-->

                                            <tr>
                                                <td ><ul>
                                                        <li>Urusan Cuti Belajar/Cuti Sabatikal/Pasca Kedoktoran/Sub-Kepakaran/Program Sangkutan Pentadbiran
                                                        /Latihan Industri (Jurutera Profesional)</li>
                                                      
                                                     </ul></td>
                                                     <td class="text-justify"><b> En Goraid J John</b>	 <br/>
                                                    Pembantu Tadbir (P/O) <br/>
                                                     <i class="fa fa-envelope"></i> goraidj.john@ums.edu.my</td>
                                               
                                                
                                            </tr>
                                            
                                              <tr>
                                                  <td><ul>
                                                      <li>Urusan Saraan Kakitangan Cuti Belajar dan Tajaan Hadiah Latihan KPT & Biasiswa UMS</li>
                                                      <li>Urusan Laporan Kemajuan Pengajian (LKP)</li></ul></td>
                                                      <td class="text-justify"><b> Puan Dayang Nooranizah Mohd Amin <br/>
                                               </b> Pembantu Tadbir (P/O) Kanan <br/>
                                                 <i class="fa fa-envelope"></i> anizah@ums.edu.my

                                                
                                            </tr>
                                            
                                            <tr>
                                                <td><ul><li>Urusan Hal Ehwal Untuk Tindakan Pihak Perundangan <br>
                                                        (Bon Perkhidmatan, Nominal Damages & Pecah Kontrak)</li>
                                                    </ul></td>
                                                    <td class="text-justify"><b>  En Goraid J John</b> <br/> 
                                            Pembantu Tadbir (P/O) <br/>
                                            <i class="fa fa-envelope"></i> goraidj.john@ums.edu.my
                                               
                                                
                                            </tr>

                                            
                       
                                            
                                </table>
         <div class="x_panel">
        <div class="x_content">  
            <strong>
                <table>
                    <tr>
                                                
<!--                        <td>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

                           
                        </td>-->
                        <td>
                            
                            Ketua Bahagian Sumber Manusia<br/>
                            <strong>Cik Kamisah Husin</strong><br/>
                             <i class="fa fa-envelope"></i> anjangkh@ums.edu.my	<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                        </td>
                        
                        <td>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

                           
                        </td>
                        
                         <td>
                            Seksyen Pengembangan Profesionalisme<br/>
                            <strong>Pn. Yanti Binti Yusup</strong><br/>
                            Penolong Pendaftar Kanan<br/>
                            <i class="fa fa-envelope"></i> yantiy@ums.edu.my
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </td>
                       
                    </tr>
                </table>
            </strong>  
        </div>
    </div>
    </div>
                           
                            </div>
                        </div>
                    </div>
            
             
        </div>
                                     </div> </div>
<?php }
       
   

