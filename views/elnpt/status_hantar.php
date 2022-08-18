<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_searchStatus', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Status Penhantaran Borang Mengikut J/S/P/I/U</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
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
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'label' => 'J/S/P/I/U',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return $model->getTotalBahagian();
//                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'BIL. GURU',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return $model->getTotalBahagian();
//                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'BIL. GURU BARU',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return $model->getTotalBahagian();
//                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'AKAUN AKTIF',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return $model->getTotalBahagian();
//                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'SELESAI',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return $model->getTotalBahagian();
//                                    },
                                    'format' => 'html',
                                ]
                            ],
                        ]);
                    ?>
                </div>
        </div>
    </div>
    </div>
</div>       