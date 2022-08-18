<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Halaman Utama';
?> 


<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Halaman Utama</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Senarai Iklan</h2><p align="right"><?= Html::a('Tambah Iklan', ['/bsm/tambah-iklan'], ['class' => 'btn btn-primary']) ?></p> 
                    <div class="clearfix"></div>
                </div>
                <div class="x_content"> 

                    <div class="table-responsive">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_iklan,
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'Jawatan',
                                    'value' => function($model) {
                                        if ($model->jawatan->fname == '(N41) Penolong Pendaftar') {
                                            $model->jawatan->fname = '(N41) Pegawai Tadbir';
                                        }
                                        return "<b><u><a href=" . Url::to(['bsm/iklan', 'id' => $model->id]) . "> " . $model->jawatan->fname . "</u></b></a> ";
                                    },
                                            'format' => 'raw',
                                        ],
                                        [
                                            'label' => 'Kategori',
                                            'value' => function($model) {
                                                if ($model->jawatan->job_category == 1) {
                                                    return 'AKADEMIK';
                                                } else {
                                                    return 'PENTADBIR';
                                                }
                                            },
                                        ],
                                        [
                                            'label' => 'Kampus',
                                            'value' => function($model) {
                                                return $model->penempatan->campus_name;
                                            },
                                        ],
                                        [
                                            'label' => 'Tarikh Buka',
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_buka);
                                            },
                                        ],
                                        [
                                            'label' => 'Tarikh Tutup',
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_tutup);
                                            },
                                        ],
                                        [
                                            'label' => 'Tindakan',
                                            'value' => function($model) {

                                                $url = Url::to(['/bsm/aktif-iklan', 'id' => $model->id]);
                                                return Html::button('ON', ['value' => $url, 'class' => 'btn btn-primary btn-sm modalButton']);
                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div> 

                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Iklan Semasa</h2><br/>
                                    <div class="clearfix"></div> 
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered jambo_table table-striped text-center">
                                            <tr> 
                                                <th class="text-center">JUMLAH LAYAK</th>
                                                <th class="text-center">JUMLAH TIDAk LAYAK</th> 
                                                <th class="text-center">JUMLAH PERMOHONAN SEMASA</th>
                                            </tr>
                                            <tr>  
                                                <td><span class="required" style="color:red;"> <b><?= $jumlahLayak; ?></b></span></td> 
                                                <td><span class="required" style="color:red;"> <b><?= $jumlahTidakLayak; ?></b></span></td>
                                                <td><span class="required" style="color:red;"> <b><?= $jumlah_permohonan; ?></b></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="x_content">    
                                    <div class="table-responsive">
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $iklan_semasa,
                                            'layout' => "{items}\n{pager}",
                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'label' => 'Jawatan',
                                                    'value' => function($model) {
                                                        if ($model->jawatan->fname == '(N41) Penolong Pendaftar') {
                                                            $model->jawatan->fname = '(N41) Pegawai Tadbir';
                                                        }
                                                        return "<b><u><a href=" . Url::to(['bsm/iklan-semasa', 'id' => $model->id]) . "> " . $model->jawatan->fname . "</u></b></a> ";
                                                    },
                                                            'format' => 'raw',
                                                        ],
                                                        [
                                                            'label' => 'Kategori',
                                                            'value' => function($model) {
                                                                if ($model->jawatan->job_category == 1) {
                                                                    return 'AKADEMIK';
                                                                } else {
                                                                    return 'PENTADBIR';
                                                                }
                                                            },
                                                        ],
                                                        [
                                                            'label' => 'Kampus',
                                                            'value' => function($model) {
                                                                return $model->penempatan->campus_name;
                                                            },
                                                        ],
                                                        [
                                                            'label' => 'Tarikh Buka',
                                                            'value' => function($model) {
                                                                return $model->getTarikh($model->tarikh_buka);
                                                            },
                                                        ],
                                                        [
                                                            'label' => 'Tarikh Tutup',
                                                            'value' => function($model) {
                                                                return $model->getTarikh($model->tarikh_tutup);
                                                            },
                                                        ],
                                                        [
                                                            'label' => 'Permohonan tidak Layak',
                                                            'value' => function($model) {
                                                                if ($model->jumlah_tidak_layak) {
                                                                    return '<b><u><a href=' . Url::to(['saringan-tidak-layak', 'id' => $model->id]) . '> ' . $model->jumlah_tidak_layak . '</a></u></b>';
                                                                }
                                                            },
                                                                    'format' => 'raw',
                                                                    'contentOptions' => ['class' => 'text-center'],
                                                                ],
                                                                [
                                                                    'label' => 'Permohonan Layak',
                                                                    'value' => function($model) {
                                                                        if ($model->jumlah_layak) {
                                                                            return '<b><u><a href=' . Url::to(['saringan-layak', 'id' => $model->id]) . '> ' . $model->jumlah_layak . '</a></u></b>';
                                                                        }
                                                                    },
                                                                            'format' => 'raw',
                                                                            'contentOptions' => ['class' => 'text-center'],
                                                                        ],
                                                                    ],
                                                                ]);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="x_panel">
                                                        <div class="x_title">
                                                            <h2>Post Iklan</h2><br/>
                                                            <div class="clearfix"></div>  
                                                        </div>

                                                        <div class="x_content">    
                                                            <div class="table-responsive">
                                                                <?=
                                                                GridView::widget([
                                                                    'dataProvider' => $post_iklan,
                                                                    'layout' => "{items}\n{pager}",
                                                                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                                                    'columns' => [
                                                                        ['class' => 'yii\grid\SerialColumn'],
                                                                        [
                                                                            'label' => 'Jawatan',
                                                                            'value' => function($model) {
                                                                                if ($model->jawatan->fname == '(N41) Penolong Pendaftar') {
                                                                                    $model->jawatan->fname = '(N41) Pegawai Tadbir';
                                                                                }
                                                                                return "<b><u><a href=" . Url::to(['bsm/iklan-semasa', 'id' => $model->id]) . "> " . $model->jawatan->fname . "</u></b></a> ";
                                                                            },
                                                                                    'format' => 'raw',
                                                                                ],
                                                                                [
                                                                                    'label' => 'Kategori',
                                                                                    'value' => function($model) {
                                                                                        if ($model->jawatan->job_category == 1) {
                                                                                            return 'AKADEMIK';
                                                                                        } else {
                                                                                            return 'PENTADBIR';
                                                                                        }
                                                                                    },
                                                                                ],
                                                                                [
                                                                                    'label' => 'Kampus',
                                                                                    'value' => function($model) {
                                                                                        return $model->penempatan->campus_name;
                                                                                    },
                                                                                ],
                                                                                [
                                                                                    'label' => 'Tarikh Buka',
                                                                                    'value' => function($model) {
                                                                                        return $model->getTarikh($model->tarikh_buka);
                                                                                    },
                                                                                ],
                                                                                [
                                                                                    'label' => 'Tarikh Tutup',
                                                                                    'value' => function($model) {
                                                                                        return $model->getTarikh($model->tarikh_tutup);
                                                                                    },
                                                                                ],
                                                                                [
                                                                                    'label' => 'Permohonan tidak Layak',
                                                                                    'value' => function($model) {
                                                                                        if ($model->jumlah_tidak_layak) {
                                                                                            return '<b><u><a href=' . Url::to(['saringan-tidak-layak', 'id' => $model->id]) . '> ' . $model->jumlah_tidak_layak . '</a></u></b>';
                                                                                        }
                                                                                    },
                                                                                            'format' => 'raw',
                                                                                            'contentOptions' => ['class' => 'text-center'],
                                                                                        ],
                                                                                        [
                                                                                            'label' => 'Permohonan Layak',
                                                                                            'value' => function($model) {
                                                                                                if ($model->jumlah_layak) {
                                                                                                    return '<b><u><a href=' . Url::to(['saringan-layak', 'id' => $model->id]) . '> ' . $model->jumlah_layak . '</a></u></b>';
                                                                                                }
                                                                                            },
                                                                                                    'format' => 'raw',
                                                                                                    'contentOptions' => ['class' => 'text-center'],
                                                                                                ],
                                                                                            ],
                                                                                        ]);
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                    </div>
                                                                </div>  
                                                                <?php
                                                                Modal::begin([
                                                                    'header' => '<strong>Kemaskini Status</strong>',
                                                                    'id' => 'modal',
                                                                    'size' => 'modal-lg',
                                                                ]);
                                                                echo "<div id='modalContent'></div>";
                                                                Modal::end();
                                                                ?>
