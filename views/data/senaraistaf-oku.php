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
            <h2><i class="fa fa-list"></i><strong> Senarai Kakitangan Berstatus OKU</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['senarai-oku']) ?>
                <?=
                GridView::widget([
                    'dataProvider' => $query,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'label' => 'Nama Kakitangan',
                            'attribute' => 'biodata.CONm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'UMSPER',
                            'attribute' => 'biodata.COOldID',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'No. Kad Kebajikan',
                            'attribute' => 'SocialWelfareNo',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Gred Jawatan',
                            'value' => 'biodata.displayJawatan',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Kategori',
                            'value' => function ($model) {
                                if ($model->biodata->gredJawatan->job_category == 1) {
                                    return 'Akademik';
                                } else {
                                    return 'Pentadbiran';
                                }
                            },
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Status Lantikan',
                            'value' => 'biodata.statusLantikan.ApmtStatusNm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Status Khidmat',
                            'value' => 'biodata.serviceStatus.ServStatusNm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'JAFPIB',
                            'value' => 'biodata.displayDepartment',
                            'format' => 'text',
                        ],


                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '',
                            'template' => '{view-stafoku}',
                            'buttons' => [
                                'view-stafoku' => function ($url, $query) {
                                    $url = Url::to(['data/view-stafoku', 'id' => $query->ICNO]);
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