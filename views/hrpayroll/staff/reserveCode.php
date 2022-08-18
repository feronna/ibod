<?php

use yii\helpers\Html;
use yii\grid\GridView;

error_reporting(0);


$this->title = 'Senarai Elaun'; 
?>
<div class="row">
    <div class="col-xs-12 col-md-3">
        <?php
        $permohonan = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'address-card',
                'header' => 'Kemasukan',
                'text' =>  'LPG Dipohon/Dipulangkan',
                'number' => '1',
            ]
        );
        echo Html::a($permohonan, ['kemasukan']);
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php
        $semakan = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'list-alt',
                'header' => 'Semakan',
                'text' =>  'Semakan LPG/KEW8',
                'number' => '2',
            ]
        );
        echo Html::a($semakan, ['semakan']);
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php
        $kelulusan = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'users',
                'header' => 'Kelulusan',
                'text' =>  'Meluluskan/Memulangkan LPG/KEW8',
                'number' => '3',
            ]
        );
        echo Html::a($kelulusan, ['kelulusan']);
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php
        $kemasukan = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'users',
                'header' => 'Slip',
                'text' =>  'Slip Gaji Terkini',
                'number' => '4',
            ]
        );
        echo Html::a($kemasukan, ['#', 'staff_id' => '']);
        ?>
    </div>
</div>

<div class="tblprcobiodata-form">
    <div class="x_panel">
        <?= $this->render('_searchstaff', [
            'carian' => $carian,
        ]) ?>
    </div>
</div>

<div class="x_panel">
    <div class="x_title" style="color:#37393b;">
        <h2><?= Html::encode($this->title) ?></h2>
        <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $dataProvider->getCount() . " / " . $dataProvider->getTotalCount() ?></h5>
        <div class="clearfix"></div>
    </div>
    
    <div class="table-responsive">
        <?=
            GridView::widget([
                //'tableOptions' => [
                //  'class' => 'table table-striped jambo_table',
                //],
                'emptyText' => 'Tiada Rekod',
                'summary' => '',
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'label' => 'IC/KP',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                        'value' => 'ICNO',
                    ],
                    [
                        'label' => 'UMSPER',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => 'COOldID',
                    ],
                    [
                        'label' => 'Nama',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => 'CONm',
                    ],
                    [
                        'label' => 'Gred',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->jawatan->gred;
                        },
                    ],
                    [
                        'label' => 'Email',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => 'COEmail',
                    ],
                    [
                        'label' => 'JFPIU',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->department->fullname;
                        },
                    ],
                    [
                        'label' => 'Pendidikan Tertinggi',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->pendidikan->HighestEduLevel;
                        },
                    ],
                    [
                        'label' => 'Kampus',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->kampus->campus_name;
                        },
                    ],
                    [
                        'label' => 'Status',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->serviceStatus->ServStatusNm;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Tindakan',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center',],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['viewpayroll', 'id' => $model->ICNO]);
                            },
                        ],
                    ],
                ],
            ]);
        ?>
    </div>
</div>