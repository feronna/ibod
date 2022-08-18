<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php

                $columnData = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Tarikh WFH',
                        'value' => 'full_date',
                    ],
                    [
                        'attribute' => 'icno',
                        'value' => 'kakitangan.CONm',
                    ],
                    [
                        'label' => 'JAFPIB',
                        'value' => 'kakitangan.department.shortname',
                    ],
                    'remark:html',
                    [
                        'attribute' => 'status',
                        'filter' => ['ENTRY' => 'ENTRY - DALAM TINDAKAN KJ', 'APPROVED' => 'APPROVED - DILULUSKAN', 'REJECTED' => 'REJECTED - DITOLAK'],
                        'format' => 'html',
                    ],
                    'entry_dt:datetime',
                    'app_dt:datetime',
                    [
                        'header' => 'Buang',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',  // the default buttons + your custom button
                        'buttons' => [
                            'view' => function ($url, $model) {
                                // if ($model->status == 'ENTRY' || $model->status == 'REJECTED') {
                                    return html::a('<span class="fa fa-trash"></span>', ['kehadiran/delete-wfh', 'id' => $model->id], [
                                        'class' => 'btn btn-xs btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete ?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                // }
                            },
                        ],
                    ],
                ];

                ?>


                <?php
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columnData,
                    'clearBuffers' => true,
                    'exportConfig' => [
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_EXCEL => false,
                        ExportMenu::FORMAT_HTML => false,
                    ],
                ]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax' => true, // pjax is set to always true for this demo
                    'columns' => $columnData,
                    'floatHeader' => true,
                    'responsive' => true,
                    'resizableColumns' => true,
                    'responsiveWrap' => true
                ]); ?>
            </div>
        </div>
    </div>
</div>