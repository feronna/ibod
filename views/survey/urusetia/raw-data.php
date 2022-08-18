<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;

?>

<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>
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
                ]) ?>

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    'COOldID',
                    'gelaran.Title',
                    'CONm',
                    'jawatan.gred',
                    'jawatan.nama',

                    [
                        'label' => 'Lantikan',
                        'attribute' =>  'statusLantikan.ApmtStatusNm', //status lantikan
                    ],
                    [
                        'label' => 'Status',
                        'attribute' =>  'serviceStatus.ServStatusNm', //status
                    ],
                    [
                        'label' => 'Status Warganegara',
                        'attribute' =>  'statusWarganegara.NatStatus', //Status Warga
                    ],
                    [
                        'label' => 'Kumpulan Khidmat',
                        'attribute' =>  'jawatan.skimPerkhidmatan.name', //KumpKhidmat
                    ],
                    'tarikhLahir', //tarikh Lahir
                    'umur', //umur
                    'GenderCd', //Jantina
                    'programPengajaran.KodProgram', //kod Program
                    'programPengajaran.NamaProgram', //Nama Program
                    [
                        'label' => 'Pendidikan Tertinggi',
                        'attribute' =>  'pendidikan.EduLevelNm', //Pendidikan Tertinggi
                    ],
                    [
                        'label' => 'JFPIB Semasa',
                        'attribute' => 'department.fullname', //JFPIB
                    ],
                    [
                        'label' => 'Kampus Hakiki',
                        'attribute' =>   'kampus.campus_name', //campus
                    ],

                    [
                        'label' => 'JFPIB HAKIKI',
                        'attribute' => 'departmentHakiki.fullname', //JFPIB
                    ],
                    [
                        'label' => 'Status Pengesahan',
                        'attribute' => 'confirmpengesahan.statusPengesahan.ConfirmStatusNm', //Status Pengesahan
                    ],
                    [ //tarikh bersara
                        'label' => 'Tarikh Bersara',
                        'attribute' => 'tarikhbersara',
                    ],
                    [ //Tempoh Perkhidmatan
                        'label' => 'Baki Tempoh Perkhidmatan',
                        'attribute' => 'tempohperkhidmatan',
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
                        'responsive'=>true,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>