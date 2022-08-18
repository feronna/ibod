<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\myhealth\TblmaxtuntutanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="tblmaxtuntutan-search">
    <div class="x_panel">
        <div class="x_content">
            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
        <div class="x_title">
            <h2><i class="fa fa-list-alt"></i><strong> Rekod Lawatan Kakitangan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- </div> -->
        <div class="x_panel">
            <?php
            $form = ActiveForm::begin([
                'action' => ['rekod-lawatan'],
                'method' => 'get',
            ]);
            ?>


            <div class="col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($searchModel, 'visit_icno')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['IN', 'statLantikan', [1, 3]])->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Carian Nama Kakitangan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($searchModel, 'pesakit_name')->widget(Select2::classname(), [
                    'data' => $searchName,
                    'options' => ['placeholder' => 'Carian Nama Pesakit/Tanggungan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?= $form->field($searchModel, 'pesakit_icno')->textInput(['placeholder' => 'Carian No.KP Pesakit/Tanggungan'])->label(false); ?>
            </div>
            <div class="form-group">

                <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>



            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                    ],
                    [
                        'attribute' => 'rawatan_date',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'No.KP Kakitangan',
                        'attribute' => 'visit_icno',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'Nama Kakitangan',
                        'value' => 'kakitangan.kakitangan.CONm',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'No.KP Pesakit',
                        'attribute' => 'pesakit_icno',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'Nama Pesakit',
                        'attribute' => 'pesakit_name',
                        'format' => 'text',
                    ],
                    [
                        'attribute' => 'jum_tuntutan',
                        'format' => 'text',
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '',
                        'template' => '{view-admin}',
                        'buttons' => [
                            'view-admin' => function ($url, $dataProvider) {
                                $url = Url::to(['klinikpanel/view-adminr', 'id' => $dataProvider->rawatan_id]);
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                            }
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>