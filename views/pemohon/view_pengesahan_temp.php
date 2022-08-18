<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">
        <div class="x_title">
            <h2>Senarai Menunggu <?= $title; ?></h2> 
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
            <div class="table-responsive">  
                <?=
                GridView::widget([
                    'dataProvider' => $permohonan,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Nama',
                            'value' => function($model) {
                                return $model->biodataStaff->CONm;
                            },
                            'format' => 'raw',
                        ],
//                        'ICNO',
                        [
                            'label' => 'Jawatan di Mohon',
                            'value' => function($model) {
                                return $model->iklan->jawatan->fname;
                            },
                        ],
                        [
                            'label' => 'JFPIU',
                            'value' => function($model) {
                                if ($model->biodataStaff->department) {
                                    return $model->biodataStaff->department->shortname;
                                } else {
                                    return;
                                }
                            },
                        ],
                        [
                            'label' => 'LNPT Terakhir',
                            'value' => function ($model) {
                                if ($model->biodataStaff->lnpt == '') {
                                    return "<div class='text-center'>-" . "<br>(" . (date('Y') - 1) . ")</div>";
                                } else {
                                    return $model->biodataStaff->lnpt->markah_PP . "<br>(" . (date('Y') - 1) . ")";
                                }
                            },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
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
                                if ($model->status_saringan_id == 2) {
                                    return '<span class="label label-warning">Menunggu</span>';
                                } elseif ($model->status_saringan_id == 6) {
                                    return '<span class="label label-success">Dipersetujui</span>';
                                } elseif ($model->status_saringan_id == 7) {
                                    return '<span class="label label-success">Ditolak</span>';
                                }
                            },
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tindakan',
                            'value' => function($model) { 

                                if ($model->status_saringan_id == 2) {
                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update-status-saringan', 'id' => $model->id]), 'style' => 'background-color: transparent; border: none;', 'class' => 'fa fa-edit mapBtn']);
                                } else {
                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['lihat-tindakan', 'id' => $model->id]), 'style' => 'background-color: transparent; border: none;', 'class' => 'fa fa-eye mapBtn']);
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
