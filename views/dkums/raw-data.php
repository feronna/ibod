<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;

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
                    'action' => $action,
                ]) ?>

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],

                    'kakitangan.CONm',
                    'kakitangan.jawatan.fname',
                    'kakitangan.department.fullname',
                    [
                        'label' => 'Lantikan',
                        'attribute' =>  'kakitangan.statusLantikan.ApmtStatusNm', //status lantikan
                    ],
                    [
                        'label' => 'Status',
                        'attribute' =>  'kakitangan.serviceStatus.ServStatusNm', //status
                    ],
                    'kakitangan.tarikhLahir', //tarikh Lahir
                    'kakitangan.umur', //umur
                    'kakitangan.GenderCd', //Jantina
                    'tahun',
                    'fasa',
                    'results.penilaian_hidup',
                    'results.tahapPenilaianHidup',
                    'results.emosi_positif',
                    'results.tahapEmosiPositif',
                    'results.kepuasan_kerja',
                    'results.tahapKepuasanKerja',
                    'results.keterlibatan_kerja',
                    'results.tahapKeterlibatanKerja',
                    'results.dkums',
                    'results.tahapDkums',
                    'komen',
                    'cadangan',
                    // [
                    //     'label' => 'A1',
                    //     'attribute' =>   'relLifeEval.a1',
                    // ],
                    // 'relAffectMeasure.b1',
                    // 'relAffectMeasure.b2',
                    // 'relAffectMeasure.b3',
                    // 'relAffectMeasure.b4',
                    // 'relAffectMeasure.b5',
                    // 'relAffectMeasure.b6',
                    // 'relAffectMeasure.b7',
                    // 'relAffectMeasure.b8',
                    // 'relAffectMeasure.b9',
                    // 'relAffectMeasure.b10',
                    // 'relJobSatisfaction.c1',
                    // 'relJobSatisfaction.c2',
                    // 'relJobSatisfaction.c3',
                    // 'relJobSatisfaction.c4',
                    // 'relJobSatisfaction.c5',
                    // 'relJobSatisfaction.c6',
                    // 'relJobSatisfaction.c7',
                    // 'relJobSatisfaction.c8',
                    // 'relJobSatisfaction.c9',
                    // 'relJobSatisfaction.c10',
                    // 'relJobSatisfaction.c11',
                    // 'relJobSatisfaction.c12',
                    // 'relJobSatisfaction.c13',
                    // 'relJobSatisfaction.c14',
                    // 'relJobSatisfaction.c15',
                    // 'relJobSatisfaction.c16',
                    // 'relJobSatisfaction.c17',
                    // 'relJobSatisfaction.c18',
                    // 'relJobSatisfaction.c19',
                    // 'relJobSatisfaction.c20',
                    // 'relJobSatisfaction.c21',
                    // 'relJobSatisfaction.c22',
                    // 'relJobSatisfaction.c23',
                    // 'relJobSatisfaction.c24',
                    // 'relJobSatisfaction.c25',
                    // 'relJobSatisfaction.c26',
                    // 'relJobSatisfaction.c27',
                    // 'relJobEngagement.d1',
                    // 'relJobEngagement.d2',
                    // 'relJobEngagement.d3',
                    // 'relJobEngagement.d4',
                    // 'relJobEngagement.d5',
                    // 'relJobEngagement.d6',
                    // 'relJobEngagement.d7',
                    // 'relJobEngagement.d8',
                    // 'relJobEngagement.d9',
                    [
                        'label' => 'E1',
                        'attribute' =>   'relSyukur.e1',
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