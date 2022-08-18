<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= $this->render('_search', [
                    'carian' => $searchModel,
                    'action' => $action
                ]) ?>

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    
                    'kakitangan.CONm',
                    'kakitangan.jawatan.fname',
                    'kakitangan.department.fullname',
                    'results.penilaian_hidup',
                    'results.emosi_positif',
                    'results.kepuasan_kerja',
                    'results.keterlibatan_kerja',
                    'results.dkums',
                    [
                        'label' => 'Prestasi Warna Kad',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('<i class="fa fa-bar-chart"></i>', ['dkums/indeks-individu', 'id' => $data->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']);
                        },
                    ],
                    
                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                    'exportConfig' => [
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_EXCEL => false,
                    ]
                ]);
                ?>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'hover' => true,
                        'pjax' => true,
                        'columns' => $gridColumns,
                        'perfectScrollbar' => true,
                        'responsive' => true,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>