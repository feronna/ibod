<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

error_reporting(0);
?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
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

                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        'columns' => [

                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil.',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'format' => 'raw',
                                'label' => 'Nama Pemohon',
                                'value' => function ($data) {
                                    return Html::a($data->kakitangan->CONm, ["lihat-rekod-lantikan", 'id' => $data->id], ['target' => '_blank']);
                                },
                                'filter' => Select2::widget([
                                    'name' => 'icno',
                                    'value' => $icno,
                                    'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'ICNO', 'kakitangan.CONm'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'contentOptions' => ['style' => 'text-decoration: underline;'],
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Jawatan Pentadbiran',
                                'value' => 'adminpos.position_name',
                                'filter' => Select2::widget([
                                    'name' => 'adminpos_id',
                                    'value' => $adminpos_id,
                                    'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->joinWith('adminpos')->where(['flag' => '1'])->orderBy(['position_type' => SORT_ASC, 'adminpos_id' => SORT_ASC])->all(), 'adminpos_id', 'adminpos.ref_position_name'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Program Pengajaran',
                                'value' => 'program.NamaProgram',
                                'filter' => Select2::widget([
                                    'name' => 'program_id',
                                    'value' => $program_id,
                                    'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->joinWith('program')->where(['flag' => '1'])->all(), 'program_id', 'program.NamaProgram'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Catatan',
                                'value' => 'description',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'JFPIB',
                                'value' => 'dept.fullname',
                                'filter' => Select2::widget([
                                    'name' => 'dept_id',
                                    'value' => $dept_id,
                                    'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'dept_id', 'dept.fullname'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Kampus',
                                'value' => 'campus.campus_name',
                                'filter' => Select2::widget([
                                    'name' => 'campus_id',
                                    'value' => $campus_id,
                                    'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->where(['flag' => '1'])->all(), 'campus_id', 'campus.campus_name'),
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Tarikh Tamat',
                                'attribute' => 'tarikhtamat',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'header' => 'Status',
                                'attribute' => 'displayflagstatuslantikansemula',
                                'format' => 'raw',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Kiraan Hari',
                                'attribute' => 'baki',
                                'contentOptions' => ['style' => 'color: red;'],
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],

                            [
                                'label' => 'Tindakan',
                                'value' => function ($model) {

                                    if ($model->aktivitiId) {
                                        return Html::a('<i class="fa fa-pencil"></i>&nbsp;Kemaskini Survey', ['perincian-aktiviti', 'id' => $model->aktivitiId], ['class' => 'btn btn-primary']);
                                    } else {
                                        return Html::a('<i class="fa fa-check-square-o"></i>&nbsp;Daftar Survey', ['create-aktiviti-tamat', 'id' => $model->id], ['class' => 'btn btn-success']);
                                    }
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],

                        ],

                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['position' => 'absolute'],
                        'resizableColumnsOptions' => ['resizeFromBody' => true]

                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>