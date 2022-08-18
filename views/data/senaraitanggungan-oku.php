<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);
?>
<div>
    <?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1349], 'vars' => []]); ?>
</div>
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Kakitangan Mempunyai Tanggungan Berstatus OKU</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['tanggungan-oku']) ?>
                <?=
                GridView::widget([
                    'dataProvider' => $query,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'label' => 'Nama Kakitangan',
                            'attribute' => 'keluarga.biodata.CONm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'UMSPER',
                            'attribute' => 'keluarga.biodata.COOldID',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Nama Tanggungan',
                            'attribute' => 'keluarga.FmyNm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'No. KP / MyKid',
                            'attribute' => 'keluarga.FamilyId',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'No. Kad Kebajikan',
                            'attribute' => 'SocialWelfareNo',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Jenis Kecacatan',
                            'attribute' => 'JenKecacatan',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Hubungan',
                            'attribute' => 'keluarga.Hubkeluarga',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Gred Jawatan',
                            'value' => 'keluarga.biodata.displayJawatan',
                            'format' => 'text',
                        ],
                        // [
                        //     'label' => 'Kategori',
                        //     'value' => function ($model) {
                        //         if ($model->keluarga->biodata->gredJawatan->job_category == 1) {
                        //             return 'Akademik';
                        //         } else {
                        //             return 'Pentadbiran';
                        //         }
                        //     },
                        //     'format' => 'text',
                        // ],
                        // [
                        //     'label' => 'Status Lantikan',
                        //     'value' => 'keluarga.biodata.statusLantikan.ApmtStatusNm',
                        //     'format' => 'text',
                        // ],
                        // [
                        //     'label' => 'Status Khidmat',
                        //     'value' => 'keluarga.biodata.serviceStatus.ServStatusNm',
                        //     'format' => 'text',
                        // ],
                        [
                            'label' => 'JAFPIB',
                            'value' => 'keluarga.biodata.displayDepartment',
                            'format' => 'text',
                        ],


                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '',
                            'template' => '{view-tanggunganoku}',
                            'buttons' => [
                                'view-tanggunganoku' => function ($url, $query) {
                                    $url = Url::to(['data/view-tanggunganoku', 'id' => $query->tblfmy_id]);
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                }
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>