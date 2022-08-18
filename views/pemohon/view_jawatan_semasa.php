<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<div class="x_panel">
    <div class="x_title">
        <h2>Permohonan Jawatan Semasa</h2> 
        <p align="right">
            <?= Html::a('Kembali', 'halaman-utama', ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">  
            <?=
            GridView::widget([
                'dataProvider' => $iklan,
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
                        'label' => 'Kampus',
                        'value' => function($model) {

                            $data = '';
                            foreach ($model->allPenempatan($model->iklan_id) as $penempatan) {

                                $data .= strtoupper($penempatan->campus->campus_name) . '<br/>';
                            }

                            return $data;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tarikh Mohon',
                        'value' => function($model) {
                            return $model->getTarikh($model->tarikh_mohon);
                        },
                    ],
                    [
                        'label' => 'Status',
                        'value' => function($model) {
                            if ($model->status_id == 5) {
                                $status = '<span class="label label-' . $model->statusDalaman->label . '">' . $model->statusDalaman->name . '</span>';
                            } else {
                                if ($model->findPP() == 1) {
                                    $status = '<span class="label label-' . $model->statusDalaman->label . '">' . $model->statusDalaman->name . '</span>';
                                } else { //tiada pp
                                    if ($model->status_id == 1) {
                                        $status = '<span class="label label-info">Menunggu perakuan dari Ketua Jabatan.</span>';
                                    } else {
                                        $status = '<span class="label label-' . $model->statusDalaman->label . '">' . $model->statusDalaman->name . '</span>';
                                    }
                                }
                            }

                            return $status;
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:40%'],
                    ],
                ],
            ]);
            ?>
        </div>
        <span class="required" style="color:red;"> 
            <strong>
                <?=
                strtoupper('PEMAKLUMAN: Proses tapisan dan temuduga akan dijalankan secara berperingkat. Sekiranya anda tidak menerima '
                        . 'sebarang maklum balas dalam tempoh enam (6) bulan, permohonan tersebut dianggap tidak berjaya. <br/> ');
                ?>
            </strong>
        </span>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2>Status Permohonan</h2> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <?php foreach ($status_dalaman as $status_dalaman) { ?>
            <ul>
                <li><?= '<span class="label label-' . $status_dalaman->label . '">'; ?><?= $status_dalaman->name; ?></span> : <?= $status_dalaman->status_desc; ?></li> 
            </ul>
        <?php } ?>
    </div> 
</div>





