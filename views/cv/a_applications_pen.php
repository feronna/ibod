<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel">  
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">RECORD APPLICATION</p> 
        <div class="clearfix"></div>
    </div>  
    <div class="x_content">
        <p align="right">
        <?php
        $btn = app\models\cv\StatusTapisan::find()->where(['status' => 1])->andWhere(['category' => 2])->One();
        $btntapisan = 'btn btn-default';
        if ($btn) {
            $btntapisan = 'btn btn-success';
        }

        echo Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['aktif-jawatankuasa']), 'class' => 'fa fa-lightbulb-o mapBtn ' . $btntapisan . ' btn-lg']);
        ?>
        </p>
        <div class="table-responsive">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Position',
                    'value' => function($model) {
                        return $model->findJawatan($model->gred_id);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Total',
                    'value' => function($model) {
                        return '<p style="color:red;"><b>' . $model->Total($model->id) . '</p></b>';
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Waiting',
                    'value' => function($model) {
                        return '<p style="color:red;"><b><u><a href=' . Url::to(['list-candidate-wait', 'id' => $model->id]) . '> ' . $model->TotalWaiting($model->id) . '</a></u></p></b>';
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Approve',
                            'value' => function($model) {
                                return '<b><u><a href=' . Url::to(['list-candidate-pen', 'id' => $model->id, 'status' => 1]) . '> ' . $model->TotalKjVerify(1, $model->id) . '</a></u></b>';
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'Reject',
                                    'value' => function($model) {
                                        return '<b><u><a href=' . Url::to(['list-candidate-pen', 'id' => $model->id, 'status' => 2]) . '> ' . $model->TotalKjVerify(2, $model->id) . '</a></u></b>';
                                    },
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'label' => 'Interview',
                                            'value' => function($model) {
                                                return '<b><u><a href=' . Url::to(['list-candidate-pass', 'id' => $model->id]) . '> ' . $model->TotalAdminPass($model->id) . '</a></u></b>';
                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                [
                                                    'label' => 'Action',
                                                    'value' => function($model) {
                                                        $button = '';

                                                        if ($model->TotalWaiting($model->id) == 0 && $model->Total($model->id) != 0) {
                                                            if ($model->temuduga) {
                                                                $btn = 'success';
                                                            } else {
                                                                $btn = 'default';
                                                            }
                                                            $button = Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-interview', 'id' => $model->id]), 'class' => 'fa fa-edit mapBtn btn btn-' . $btn . ' btn-lg']);
                                                        }
                                                        return $button . ' ' . Html::a('<i class="fa fa-power-off"></i>', ['off-iklan', 'id' => $model->id], ['class' => 'btn btn-danger']);
                                                    },
                                                            'format' => 'raw',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                        ],
                                                    ];



                                                    echo GridView::widget([
                                                        'dataProvider' => $model,
                                                        'columns' => $gridColumns,
                                                    ]);
                                                    ?>
        </div>




    </div>
</div>  

