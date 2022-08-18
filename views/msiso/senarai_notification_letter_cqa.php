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
            <h2><i class="fa fa-list"></i><strong> NOTIFICATION LETTER </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <?= GridView::widget([
                   'dataProvider' => $senarai,
                    'summary' => '',
                    'showFooter' => true,
                   
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],  
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                      
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
                            'value' => 'auditDt',
                        ], 
                        [
                            'label' => '',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['msiso/paparan-notification', 'id' => $list->id], ['class' => 'btn btn-success fa fa-eye '])
                            .Html::a(' ', ['msiso/makluman', 'id' => $list->id], ['class'=>'btn btn-primary fa fa-download', 'target' => '_blank']) ;  
                        }, 
                        ],
 
                    ], 
                ]); ?>  

    </div>  
</div> 
</div>  

            </div>   
        </div>
        </div>

</div>  