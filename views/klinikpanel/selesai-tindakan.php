<?php

use app\models\hronline\Department;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Tblprcobiodata;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="tblmaxtuntutan-search">
    <div class="x_panel">
        <h2><i class="fa fa-search"></i><strong> Carian</strong></h2>
        <ul class="nav navbar-right panel_toolbox">
        </ul>
        <div class="clearfix"></div>
        <div class="x_content">
            <?php
            $form = ActiveForm::begin([
                'action' => ['selesai-tindakan'],
                'method' => 'get',
            ]);
            ?>
            <div class="col-md-4 col-sm-3 col-xs-6">
                <?=
                $form->field($searchModel, 'CONm')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['<>', 'Status', '6'])->all(), 'CONm', 'CONm'),
                    'options' => ['placeholder' => 'Carian Kakitangan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <?= $form->field($searchModel, 'icno')->textInput(['placeholder' => 'Carian No.KP Kakitangan'])->label(false); ?>
            </div>
            <div class="col-md- col-sm-3 col-xs-6">
                <?=
                $form->field($searchModel, 'dept')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                    'options' => ['placeholder' => 'JAFPIB'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Cari', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            
        </div>
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Permohonan Selesai Tindakan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table-responsive">
                
                <?=
                GridView::widget([
                    'dataProvider' => $query,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'attribute' => 'entry_dt',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Nama Kakitangan',
                            'attribute' => 'kakitangan.kakitangan.CONm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'No.KP Kakitangan',
                            'attribute' => 'icno',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'JAFPIB',
                            'attribute' => 'kakitangan.kakitangan.department.fullname',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Tanggungan',
                            'value' => 'dependent',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Status',
                            'value' => 'kakitangan.kakitangan.tarafPerkahwinan.MrtlStatus',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Peruntukan Tahun Semasa (RM)',
                            'value' => 'kakitangan.max_tuntutan',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Baki Semasa (RM)',
                            'attribute' => 'kakitangan.current_balance',
                            'format' => 'text',
                        ],

                        [
                            'label' => 'Permohonan Kali',
                            'attribute' => 'permohonan',
                            'format' => 'raw',
                        ],
                        // [
                        //     'label' => 'Justifikasi Permohonan',
                        //     'attribute' => 'entry_remarks',
                        //     'format' => 'text',
                        // ],
                        [
                            'label' => 'Status',
                            'value' => 'statusS',
                            'format' => 'raw',
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '',
                            'template' => '{view-admin}',
                            'buttons' => [
                                'view-admin' => function ($url, $query) {
                                    $url = Url::to(['klinikpanel/memo-lulus', 'id' => $query->id]);
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                }
                            ],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '',
                            'template' => '{update-permohonan}',
                            'buttons' => [
                                'update-permohonan' => function ($url, $query) {
                                    $url = Url::to(['klinikpanel/update-permohonan', 'id' => $query->id]);
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                                }
                            ],

                        ]
                    ]
                ]);
                ?>
                <ul>
                    <li><span class="label label-warning">BARU</span> : Permohonan Baru</li>
                    <li><span class="label label-info">DIPERAKU</span> : Permohohan Telah Diperaku Ketua Jabatan</li>
                    <li><span class="label label-primary">DISEMAK</span> : Permohonan Telah Disemak</li>
                    <li><span class="label label-success">DILULUSKAN</span> : Permohonan Telah Diluluskan</li>
                    <li><span class="label label-danger">DITOLAK</span> : Permohonan Tidak Diluluskan</li>

                </ul>
            </div>
        </div>
    </div>
</div>