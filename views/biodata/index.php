<?php

use yii\helpers\Html;
use yii\grid\GridView;

error_reporting(0);


$this->title = 'Rekod Peribadi';
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
                        'contentOptions' => function($model){
                            if($model->Status != '06'){
                                return ['class' => 'text-center'];
                            }
                            return ['class' => 'text-center red'];
                        } ,
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
                                if(Yii::$app->MP->isKetuaProgram() && Yii::$app->MP->isPenggunaBiasa()){
                                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['ketua-program-view', 'id' => $model->ICNO]);
                                }
                                return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminview', 'id' => $model->ICNO]);
                            },
                        ],
                    ],
                ],
            ]);
        ?>
    </div>
</div><?php yii\widgets\Pjax::end() ?>