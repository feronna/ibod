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

$this->title = 'Rekod Lawatan Sistem MedCare - HUMS';
error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="x_panel" >
<div class="x_content">
                <p>
                    <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
                </p>
        </div>
        <div class="x_title">
            <h2><i class="fa fa-list-alt"></i><strong> Rekod Lawatan Sistem MedCare - HUMS</strong></h2>
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
            'action' => ['rekod-medcare'],
            'method' => 'get',
        ]);
        ?>

        <div class="col-md-5 col-sm-3 col-xs-6">
            <?=
            $form->field($searchModel, 'name')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['<>', 'Status', '6'])->all(), 'CONm', 'CONm'),
                'options' => ['placeholder' => 'Nama Kakitangan'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
            ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
            <?= $form->field($searchModel, 'staff_icno')->textInput(['placeholder' => 'Carian No.KP Kakitangan'])->label(false); ?>
        </div>
        <div class="form-group">

            <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Cari', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $query,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            [
                'attribute' => 'receipt_no',
                'format' => 'text',
            ],

            [
                'label' => 'Tarikh Rawatan',
                'attribute' => 'visit_dt',
                'format' => 'text',
            ],

            [
                'label' => 'No.KP Kakitangan',
                'attribute' => 'staff_icno',
                'format' => 'text',
            ],
            [
                'label' => 'Nama Kakitangan',
                'value' => 'kakitangan.kakitangan.CONm',
                'format' => 'text',
            ],
            [
                'attribute' => 'patient_icno',
                'format' => 'text',
            ],
            [
                'label' => 'Nama Pesakit',
                'value' => function ($model) {
                    if ($model->staff_icno == $model->patient_icno) {
                        return $model->kakitangan->kakitangan->CONm;
                    } else {
                        return $model->pesakit->FmyNm;
                    }
                },
                'format' => 'text',

            ],
            [
                'label' => 'Jumlah Tuntutan (RM)',
                'attribute' => 'deduct_amt',
                'format' => 'text',
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => '<i class="glyphicon glyphicon-info-sign"></i>',
                'template' => '{view-medcare}',
                'buttons' => [
                    'view-medcare' => function ($url, $querys) {
                        $url = Url::to(['klinikpanel/view-medcarepapar', 'id' => $querys->id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
                ]
            ]
        ]
    ]); ?>
</div>
</div>