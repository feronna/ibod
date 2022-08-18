<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use yii\helpers\Url;
use app\models\saman\SamanStatus;
use kartik\widgets\DatePicker;
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian Saman</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['saman-status-user'], 'GET'); ?>

                <strong>No Saman :</strong>
                <br>

                <?= Html::textInput('nosaman', $nosaman, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <strong>No Kenderaan :</strong>
                <br>
                <?= Html::textInput('nokenderaan', $nokenderaan, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <strong>Tarikh :</strong>

                <?=
                DatePicker::widget([
                    'name' => 'tsaman',
                    'value' => $tsaman,
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
                <br>
                <br>

                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Saman Individu</strong></h2>
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
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'NOSAMAN',
                            [
                                'label' => 'Tarikh Saman',
                                'format' => 'raw',
                                'value' => 'formattarikh'
                            ],
                            [
                                'label' => 'Jumlah Saman (RM)',
                                'format' => 'raw',
                                'value' => 'TOTALAMN4'
                            ],
                            [
                                'label' => 'Jumlah Saman KUNCI(RM)',
                                'format' => 'raw',
                                'value' => 'AMNKUNCI'
                            ],
                            [
                                'label' => 'Status Bayaran',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $status = SamanStatus::find()->where(['NOSAMAN' => $data->NOSAMAN])->one();
                                    return $status->STATUS;
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>