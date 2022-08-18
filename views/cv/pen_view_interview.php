<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\grid\GridView;
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php echo $this->render('menu'); ?>
        <div class="x_panel"> 

            <div class="table-responsive">   
                <?php
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Position',
                        'value' => function($model) {
                            return $model->jawatan->fname;
                        },
                        'format' => 'raw'
                    ], 
                    [
                        'label' => 'Total',
                        'value' => function($model) {
                            return $model->getTotalIV($model->getActiveIV($model->jawatan_id));
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Action',
                        'value' => function($model) {
                            if($model->getActiveIV($model->jawatan_id)){
                            return Html::a('<i class="fa fa-edit"></i>', ['list-iv', 'id' => $model->getActiveIV($model->jawatan_id)], ['class' => 'btn btn-default btn-sm']);
                            }
                        },
                        'format' => 'raw'
                    ],
                ];


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $Columns,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
                    ],
                    'pjax' => false,
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'showPageSummary' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Interview</h2>',
                    ],
                ]);
                ?> 
            </div>
        </div> 
    </div>
</div>