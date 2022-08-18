<?php

use yii\helpers\Html;
use yii\grid\GridView;

error_reporting(0);


$this->title = 'Hasil Carian';
?><?php yii\widgets\Pjax::begin(['id' => 'search-form']) ?>
<div class="tblprcobiodata-form">
    <div class="x_panel">
        <?= $this->render('_search', [
            'carian' => $carian,
        ]) ?>
    </div>
</div>

<div class="x_panel">
    <div class="x_title" style="color:#37393b;">
        <h2><?= Html::encode($this->title) ?></h2>
        <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $model->getCount() . " / " . $model->getTotalCount() ?></h5>
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
                'dataProvider' => $model,
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
                        'label' => 'JFPIU',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->department->fullname;
                        },
                    ],
                    [
                        'label' => 'Program Vaksinasi',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            if($model->vaksinasi){
                                return 'Sudah isi';
                            }
                            return 'Belum isi';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Tindakan',
                        'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                        'contentOptions' => ['class' => 'text-center',],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['admin-view', 'icno' => $model->ICNO]);
                            },
                        ],
                    ],
                ],
            ]);
        ?>
    </div>
</div><?php yii\widgets\Pjax::end() ?>