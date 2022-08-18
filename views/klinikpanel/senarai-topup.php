<?php

use app\models\hronline\Tblprcobiodata;
use app\models\klinikpanel\TblTopupHis;
use yii\helpers\Html;
use yii\grid\GridView;
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

            <div class="x_title">
                <h2><i class="fa fa-list-alt"></i><strong> Rekod Penambahan Peruntukan MyHealth</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="tblmaxtuntutan-search">
            <?php
            $form = ActiveForm::begin([
                'action' => ['senarai-topup'],
                'method' => 'get',
            ]);
            ?>

            <div class="col-md-4 col-sm-3 col-xs-6">
                <?=
                $form->field($searchModel, 'name')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['<>','Status','6'])->all(), 'CONm', 'CONm'),
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

            <div class="form-group">

                <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Cari', ['class' => 'btn btn-success']) ?>
            </div>



            <?php ActiveForm::end(); ?>

        </div>
            <div class="table-responsive">
                <?=
                GridView::widget([
                    'dataProvider' => $query,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'label' => 'Nama Kakitangan',
                            'attribute' => 'kakitangan.CONm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'No.KP Kakitangan',
                            'attribute' => 'icno',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Jumlah Penambahan Peruntukan (RM)',
                            'value' => 'topup_amount',
                            'format' => 'text',
                            'contentOptions' => ['class' => 'text-center']

                        ],
                        [
                            'label' => 'Ditambah Oleh',
                            'value' => 'penambah.CONm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Ditambah Pada',
                            'attribute' => 'topup_dt',
                            'format' => 'text',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => ' ',
                            'template' => '{papar}',
                            'buttons' => [
                                'papar' => function ($url, $query) {
                                    $url = Url::to(['klinikpanel/papar', 'id' => $query->icno]);
                                    return Html::a('<span class="fa fa-eye"></span>', $url);
                                }
                            ]
                            ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '',
                            'template' => '{delete-topup}',
                            'buttons' => [
                                'delete-topup' => function ($url, $query) {
                                    $url = Url::to(['klinikpanel/delete-topup', 'id' => $query->id]);
                                    return Html::a('<span class="fa fa-trash"></span>', $url);
                                }
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>