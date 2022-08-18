<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\form\ActiveForm;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 

<div class="x_panel">
    <div class="x_title">
        <h2>Carian</h2> 
        <p align="right"><?= \yii\helpers\Html::a('Kembali', ['msiso/index-audit-report'], ['class' => 'btn btn-default btn-sm']) ?></p>  
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
    <?php
        $form = ActiveForm::begin([
                    'action' => ['senarai-best-practice'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                    'fieldConfig' => ['autoPlaceholder' => true,
                    ],
        ]);
        ?>

        <div class="col-md-3 col-sm-3 col-xs-5">
            <?=
            $form->field($searchModel, 'dept')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\msiso\TblBestPractice::find()->all(), 'dept', 'dept'),
                'options' => ['placeholder' => 'JAFPIB', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>    
             
        <div class="col-md-5 col-sm-5 col-xs-5">
            <?=
            $form->field($searchModel, 'created_by')->label(false)->widget(Select2::classname(), [ 
                'data' => ArrayHelper::map(app\models\msiso\TblBestPractice::find()->all(), 'created_by', 'kakitangan.CONm'), 
                'options' => ['placeholder' => 'Auditor', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div> 
    
        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="form-group">
            <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
            <?= Html::a('Reset','senarai-best-practice', ['class' => 'btn btn-danger']) ?> 
            </div>
        </div>

<?php ActiveForm::end(); ?> 
    </div>
</div>
  
<div class="row"> 
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
        <h2><i class="fa fa-list"></i><strong> BEST PRACTICE</strong></h2> 
        <div class="clearfix"></div>
        </div> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        <!-- senarai nota audit -->
             <?= GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => true,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>BEST PRACTICE</h2>',
                    ],
                    'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                                        'header' => '#',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ],  

                    [
                        'label' => 'JAFPIB',
                        'value' => 'dept',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 

                    // [
                    //     'label' => 'Tarikh Audit',
                    //     'value' => 'AuditDt',
                    //     'headerOptions' => ['class'=>'text-center'],
                    //                     'contentOptions' => ['class'=>'text-center'],
                    // ], 
                    [
                        'label' => 'Auditor',
                        'value' => 'kakitangan.CONm',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    // [
                    //     'label' => 'Best Practice',
                    //     'value' => 'best_practice',
                    //     'headerOptions' => ['class'=>'text-justify'],
                    //                     'contentOptions' => ['class'=>'text-justify'],
                    // ], 
                    [
                        'label' => 'Tindakan', 
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-justify'],
                                        'contentOptions' => ['class'=>'text-justify'],
                        'value'=>function ($list){ 
                            if($list->status == '1' ){
                                return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-best-practice", 'id' => $list->id], ['class' => 'btn btn-primary']); 
                                
                            } 
                        }
                    ], 
                    
                      
                ],
            ]); ?>
       
    </div>
    

</div>
</div>
</div>
