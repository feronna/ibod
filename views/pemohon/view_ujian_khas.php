<?php

use yii\helpers\Html;
use yii\grid\GridView;
?> 
<div class="x_panel">
    <div class="x_title">
        <h2>Ujian Khas</h2>  
        <p align="right">
            <?= Html::a('Kembali', 'halaman-utama', ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">  
            <?=
            GridView::widget([
                'dataProvider' => $kompetensiDalaman,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Jawatan',
                        'value' => function($model) {
                            if ($model->iklan->jawatan->fname == '(N41) Penolong Pendaftar') {
                                $model->iklan->jawatan->fname = '(N41) Pegawai Tadbir';
                            }

                            if ($model->iklan->jawatan->fname == '(J41) Jurutera') {
                                $model->iklan->jawatan->fname = '(J41) Jurutera/Juruukur Bahan/Arkitek';
                            }

                            if ($model->iklan->jawatan->fname == '(N29) Setiausaha Pejabat') {
                                $model->iklan->jawatan->fname = '(N29) Pembantu Khas/Pembantu Setiausaha Pejabat/Setiausaha Pejabat';
                            }

                            if ($model->iklan->jawatan->fname == '(W19) Pembantu Tadbir Kewangan') {
                                $model->iklan->jawatan->fname = '(W19) Pembantu Tadbir Kewangan/Pembantu Akauntan';
                            }

                            if ($model->iklan->jawatan->fname == '(UD43) Pegawai Perubatan') {
                                $model->iklan->jawatan->fname = '(UD43/UD47/UD51/UD53) Pegawai Perubatan';
                            }
                            return $model->iklan->jawatan->fname;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Jemputan',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-download"></i>', ['jemputan', 'iklan_id' => $model->iklan_id, 'title' => 'komp'], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Status Kehadiran',
                                'value' => function($model) {
                                    if ($model->status_kehadiran_id != 0) {
                                        return '<span class="label label-' . $model->kehadiranKomp->label . '">' . $model->kehadiranKomp->name . '</span>';
                                    } else {
                                        return Html::button('<i class="fa fa-edit"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kehadiran', 'id' => $model->id, 'title' => 'komp']), 'class' => 'btn btn-default btn-sm mapBtn']);
                                    }
                                },
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['class' => 'text-center'],
                                    ],
                                    [
                                        'label' => 'Status Ujian',
                                        'value' => function($model) {
                                            return '<span class="label label-' . $model->statusKomp->label . '">' . $model->statusKomp->name . '</span>';
                                        },
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['class' => 'text-center'],
                                    ],
                                ],
                            ]);
                            ?>
                        </div> 
                    </div>
                </div> 
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Status Ujian Khas</h2> 
                                        <div class="clearfix"></div>
                                    </div> 
                                    <div class="x_content">
                                        <?php foreach ($statusKompetensi as $status) { ?>
                                            <ul>
                                                <li><?= '<span class="label label-' . $status->label . '">'; ?><?= $status->name; ?></span> : <?= $status->status_desc; ?></li> 
                                            </ul>
                                        <?php } ?>
    </div> 
</div>



