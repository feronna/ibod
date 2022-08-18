<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$request = Yii::$app->request;

if (Yii::$app->controller->action->id == 'interview-record') {
    $title = 'INTERVIEW';
} else {
    $title = 'ARCHIVE INTERVIEW';
}
?> 

<?php echo $this->render('menu'); ?>


<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;"><?= $title; ?></p>
        <div class="clearfix"></div>
    </div>
    <div class="table-responsive">   
        <?php
        $Columns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Position',
                'value' => function($model) {
                    return $model->jawatan->fname;
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['style' => 'background-color:'
                        . ($model->tarikh_iv == date('Y-m-d') ? '#cccaf2' : '')];
                },
                    ],
//                            [
//                                'label' => 'Total',
//                                'value' => function($model) {
//                                    return $model->totalIV;
//                                },
//                                'format' => 'raw'
//                            ],
                    [
                        'label' => 'Date',
                        'value' => function($model) {
                            return $model->tarikh_iv;
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                        'contentOptions' => function ($model) {
                    return ['style' => 'background-color:'
                        . ($model->tarikh_iv == date('Y-m-d') ? '#cccaf2' : '')];
                },
                    ],
                    [
                        'label' => 'Time',
                        'value' => function($model) {
                            return $model->masa_iv;
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                    ],
                    [
                        'label' => 'Action',
                        'value' => function($model) {

                            return Html::a('<i class="fa fa-eye"></i>', ['candidate', 'id' => $model->id, 'url' => Yii::$app->controller->action->id], ['class' => 'btn btn-default btn-sm']);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                            ],
                            [
                                'label' => 'Qualified',
                                'value' => function($model) {

                                    return Html::a($model->findTotalQualified, ['candidate-qualified', 'id' => $model->id, 'url' => Yii::$app->controller->action->id], ['class' => 'btn btn-default btn-sm']);
                                },
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                                    ],
                                    [
                                        'label' => 'Notification',
                                        'value' => function($model) {
                                            if ($model->tarikh_iv < date('Y-m-d')) {
                                                if ($model->ads_id != NULL) {
                                                    if (is_null($model->notify_status_iv)) {
                                                        return Html::a('<i class="fa fa-envelope fa-lg"></i>', ['notify-candidate', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                                    } else {
                                                        return $model->notify_status_iv;
                                                    }
                                                }
                                            }
                                        },
                                                'format' => 'raw',
                                                'contentOptions' => ['class' => 'text-center'],
                                                'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                                            ],
                                        ];


                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'columns' => $Columns, 
                                        ]);
                                        ?> 
    </div>
</div>  