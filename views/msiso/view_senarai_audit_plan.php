<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata; 
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\msiso\RefAuditor;
 

error_reporting(0);
?> 
<?= $this->render('menu') ?> 
 
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> AUDIT PLAN </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'summary' => '',
                    'showFooter' => true,
                    // 'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],  
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn',
                        //                 'header' => '#',
                        //     'headerOptions' => ['class'=>'text-center'],
                        //                     'contentOptions' => ['class'=>'text-center'], 
                        //  ],  
                        [
                            'label' => 'Tahun',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value'=> 'year',
                        ], 

                        [
                            'label' => 'Audit Plan',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value'=>function ($list){   
                               return Html::a(' '.$list->title, Yii::$app->FileManager->DisplayFile($list->audit_plan), ['class'=>'fa fa-download', 'target' => '_blank']);  
                            },
                        ], 
                            
                        // [
                        //     'label' => 'Catatan',
                        //     'format' => 'raw',
                        //     'headerOptions' => ['class'=>'text-center'],
                        //     'contentOptions' => ['class'=>'text-center'],
                        //     'value'=> 'catatan',
                        // ],
                    ],
                            
                ]); ?>

    </div>  
</div> 
</div>  

            </div>   
        </div>
        </div>

</div>  