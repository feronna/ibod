<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;

?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Carian Profil</li>
    </ol>
</nav>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian</strong></h2>

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
                    'CONm',
                    'jawatan.gred',
                    'jawatan.nama',
                    'umur',
                    
                    [
                        'label' => 'Status Warganegara',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => ''],
                        'contentOptions' => ['class' => 'text-center'],
                        'attribute' =>  'displayStatusWarganegara', //status lantikan
                    ],
                    [
                        'label' => 'Lantikan',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => ''],
                        'contentOptions' => ['class' => 'text-center'],
                        'attribute' =>  'statusLantikan.ApmtStatusNm', //status lantikan
                    ],
                    [
                        'label' => 'Status',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => ''],
                        'contentOptions' => ['class' => 'text-center'],
                        'attribute' =>  'serviceStatus.ServStatusNm', //status
                    ],
                    [
                        'label' => 'Kump. Khidmat',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => ''],
                        'contentOptions' => ['class' => 'text-center'],
                        'attribute' =>  'jawatan.skimPerkhidmatan.name', //KumpKhidmat
                    ],
                    [
                        'label' => 'JAFPIB',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => ''],
                        'contentOptions' => ['class' => 'text-center',],
                        'attribute' => 'department.shortname', //JFPIB
                    ],
                    [
                        'label' => 'Jenis Lantikan',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => '#f2ed6f'],
                        'contentOptions' => ['class' => 'text-center', 'bgcolor' => '#f2ed6f'],
                        'attribute' => 'allocation.jenis_lantikan',
                    ],
                    [
                        'label' => 'Sumber Peruntukan',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => '#f2ed6f'],
                        'contentOptions' => ['class' => 'text-center', 'bgcolor' => '#f2ed6f'],
                        'attribute' => 'allocation.labelSumberPeruntukan',
                    ],
                    [
                        'label' => 'Status Kontrak',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => '#f2ed6f'],
                        'contentOptions' => ['class' => 'text-center', 'bgcolor' => '#f2ed6f'],
                        'attribute' => 'allocation.labelStatusKontrak',
                    ],
                    [
                        'label' => 'Perincian',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => ''],
                        'contentOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                        'value' => function ($data) {
                             return Html::a('<i class="fa fa-eye"></i>', ['perincian-profil', 'icno' => $data->ICNO]);
                        },
                     ],
                ];


                ?>
                <!-- <hr> -->
                <div class="pull-right">
                    <strong>Export :</strong>
                    <?php
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
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <div class="pull-right">
                    <h4><strong><?= Html::encode('Jumlah Carian: ') . $dataProvider->getCount() . " / " . $dataProvider->getTotalCount() ?></strong></h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => false,
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