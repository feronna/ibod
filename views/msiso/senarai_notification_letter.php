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
        
    <div class="x_content"> 
    <div class="table-responsive">

    <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
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
                        ['class' => 'yii\grid\SerialColumn',
                                        'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'], 
                                            ],  
                        [
                            'label' => 'JAFPIB',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'dept',
                        ], 
                        [
                            'label' => 'Tarikh Audit',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'plan_audit_dt',
                        ], 

                            
                    ],
                            
                ]); ?>
                        
            </table>  
</div> 
</div>      
        </div>
        </div>

</div>  


 


