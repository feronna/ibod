<?php
 
use yii\helpers\Html;
use kartik\grid\GridView; 
?> 
<div class="tblpraddress-form">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
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
                        'label' => 'Subject',
                        'value' => function($model) {
                            return $model->subjek->subj;
                        },
                        'format' => 'raw'
                    ], 
                    [
                        'label' => 'Date/Time',
                        'value' => function($model) {
                            return $model->assign_at;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Action',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-edit"></i>', ['question', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
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
//                                            '{export}', 
//                                            '{toggleData}'
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
                        'heading' => '<h2>Assigned Competency</h2>',
                    ],
                ]);
                ?> 
            </div>
        </div>

    </div>

</div>
</div>