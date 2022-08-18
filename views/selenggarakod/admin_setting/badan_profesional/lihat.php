<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

$this->title = 'Maklumat Badan Profesional';

?>

<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblpraddress-view">
                <p>
                    <?= Html::a('Kembali', ['index-badanprofesional-skim'], ['class' => 'btn btn-primary']) ?>
                </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'ID',
                            'attribute' => 'ProfBodyCd',
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                        ],

                        [
                            'label' => 'Nama Badan',
                            'attribute' => 'ProfBody'
                        ],
                    ],
                ]) ?>
            </div>
            <div class="x_title">
                <h2><?= 'Senarai Skim (Scheme)' ?></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <?php //Html::a('Assign Scheme', ['set-badanprofesional-skim','bp_id'=>$model->ProfBodyCd], ['class' => 'btn btn-primary']) 
                ?>
                <?= Html::button('Masukkan Skim', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['set-badanprofesional-skim', 'bp_id' => $model->ProfBodyCd]), 'class' => 'btn btn-primary mapBtn ']) ?>
                <?php Pjax::begin() ?>
                <?php 
                
                 echo GridView::widget([
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $model->relSkim,
                        'pagination' => [
                            'pageSize' => 10,
                        ],
                    ]),
                    'tableOptions' => ['class' => 'table table-bordered table-sm'],
                    'columns' => [
                        [
                            'label' => 'Nama Skim',
                            'value' => 'skim.nama',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:auto', 'bgcolor' => '#e8e9ea'],
                        ],
                        [
                            'label' => 'Gred Skim',
                            'value' => 'skim.gred_skim',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            'template' => '{padam}',
                            'buttons' => [
                                'padam' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-trash"></span>', ['buang-skim', 'badanskim_id' => $model->id], [
                                        'data' => [
                                            'confirm' => 'Anda ingin membuang rekod ini?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                            ],
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => '#e8e9ea'],
                        ],
                    ]
                ]); ?>
                <?php Pjax::end() ?>
            </div>

        </div>
    </div>
</div>