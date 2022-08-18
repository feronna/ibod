<?php
/* @var $this yii\web\View */

use yii\grid\GridView;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">

                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'summary' => '',
                            'columns' => [
                                [
                                    // 'attribute' => 'SR_ROC_TYPE',
                                    'value' => function ($model) {
                                        return ($model->elaunnn) ? $model->elaunnn->it_account_name : null;
                                    },
                                    'label' => 'ELAUN/POTONGAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'SR_OLD_VALUE',
                                    'label' => 'JUMLAH SEBELUM',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'SR_NEW_VALUE',
                                    'label' => 'JUMLAH',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'SR_CALC_TYPE',
                                    'label' => 'JENIS KIRAAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'KOD PROJEK',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return null;
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'PUSAT KOS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return null;
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'DARI',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return \Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'yyyy-MM-dd');
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'SEHINGGA',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return \Yii::$app->formatter->asDate($model->SR_DATE_TO, 'yyyy-MM-dd');
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'JENIS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'JENIS PERUBAHAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->SR_CHANGE_TYPE;
                                    },
                                    'format' => 'html'
                                ],
                            ],
                        ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>