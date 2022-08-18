<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\ejobs\TblpPermohonan;
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
                            'value' => function ($model) {
                                return $model->biodataStaff->CONm;
                            },
                            'format' => 'raw',
                        ],
//                        'ICNO',
                        [
                            'label' => 'Jawatan di Mohon',
                            'value' => function ($model) {
                                return $model->iklan->jawatan->fname;
                            },
                        ],
                        [
                            'label' => 'JFPIU',
                            'value' => function ($model) {
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
                                if ($model->biodataStaff->jawatan->job_category == 1) {
                                    return "(" . $model->biodataStaff->markahlnptCV(1, 'Tahun') . ' - ' . $model->biodataStaff->markahlnptCV(1, 'Markah') . ")";
                                } else {
                                    return "(" . $model->biodataStaff->markahlnptCVpen(1, 'Tahun') . ' - ' . $model->biodataStaff->markahlnptCV(1, 'Markah') . ")";
                                }
                            },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => function ($model) {
                                return $model->getTarikh($model->tarikh_mohon);
                            },
                        ],
                        [
                            'label' => 'Status',
                            'value' => function ($model) {
                                if ($model->isPp(Yii::$app->user->getId())) {
                                    return $model->statusPp;
                                } else {
                                    if ($model->checkPP(Yii::$app->user->getId()) == 1) {
                                        return $model->statusKj;
                                    } else {
                                        return $model->statusPpNull;
                                    }
                                }
                            },
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Tindakan',
                            'value' => function ($model) {
                                if ($model->isPp(Yii::$app->user->getId())) {
                                    $status = 2;
                                } else {
                                    if ($model->checkPP(Yii::$app->user->getId()) == 1) {
                                        $status = 4;
                                    } else {
                                        $status = 2;
                                    }
                                }

                                if ($model->status_saringan_id == $status) {
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

    <?php if ((TblpPermohonan::isKj(Yii::$app->user->getId())) && (TblpPermohonan::checkPP(Yii::$app->user->getId()) == 1)) { ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai permohonan <span class="label label-danger">ditolak</span> Ketua Pentadbiran </h2> 
                <div class="clearfix"></div>
            </div> 
            <div class="x_content"> 
                <div class="table-responsive">  
                    <?=
                    GridView::widget([
                        'dataProvider' => $permohonanDitolak,
                        'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'], 
                            'id',
                            [
                                'label' => 'Nama',
                                'value' => function ($model) {
                                    return $model->biodataStaff->CONm;
                                },
                                'format' => 'raw',
                            ],
//                        'ICNO',
                            [
                                'label' => 'Jawatan di Mohon',
                                'value' => function ($model) {
                                    return $model->iklan->jawatan->fname;
                                },
                            ],
                            [
                                'label' => 'JFPIU',
                                'value' => function ($model) {
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
                                    if ($model->biodataStaff->jawatan->job_category == 1) {
                                        return "(" . $model->biodataStaff->markahlnptCV(1, 'Tahun') . ' - ' . $model->biodataStaff->markahlnptCV(1, 'Markah') . ")";
                                    } else {
                                        return "(" . $model->biodataStaff->markahlnptCVpen(1, 'Tahun') . ' - ' . $model->biodataStaff->markahlnptCV(1, 'Markah') . ")";
                                    }
                                },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Tarikh Mohon',
                                'value' => function ($model) {
                                    return $model->getTarikh($model->tarikh_mohon);
                                },
                            ],
                            [
                                'label' => 'Status',
                                'value' => function ($model) {
                                    if ($model->isPp(Yii::$app->user->getId())) {
                                        return $model->statusPp;
                                    } else {
                                        if ($model->checkPP(Yii::$app->user->getId()) == 1) {
                                            return $model->statusKj;
                                        } else {
                                            return $model->statusPpNull;
                                        }
                                    }
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Ulasan KP',
                                'value' => function ($model) {

                                    return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['ulasan-pp', 'id' => $model->id]), 'style' => 'background-color: transparent; border: none;', 'class' => 'fa fa-eye mapBtn']);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                                        [
                            'label' => 'Tindakan',
                            'value' => function ($model) { 

                                if ($model->status_saringan_id == 5) {
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
    <?php } ?>
</div> 
