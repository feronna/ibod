<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\models\msiso\RefAuditor;

error_reporting(0);
?>
 <?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Lokasi Audit Auditor</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\msiso\msiso::find()->all(), 'icno', 'name'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
            ?>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'dept')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive' => '1'])->all(), 'shortname', 'shortname'),
                            'options' => [
                            'placeholder' => ''],
                            ])->label(false); 
                        ?> 
            </div>
        </div>  

        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
                    <br>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div> 
        <div class="ln_solid"></div>
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>

<div class="row"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Agihan Lokasi Audit</strong></h2>
                  
                <div class="clearfix"></div>
                <!-- status 0 = close, 1 = open -->
            </div>
        <div class="x_content">
           <div class="table-responsive">
               <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'summary' => '',
                    'filterModel' => true,  
                    'showFooter' => true,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
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
                        // [
                        //     'label' => 'NAMA',
                        //     'value' => 'kakitangan.CONm', 
                        // ],
                        [
                            'label' => 'Nama ',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\msiso\RefAuditorDept::find()->where(['isActive' => 1])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            'value'=>function ($list) {
                            return '<small>'. strtoupper($list->kakitangan->CONm). '</small>';
                            },
            
                            'value' => 'kakitangan.CONm',
            
                        ],

                        [
                            'label' => 'Role',
                            'value' => 'auditor.auditorRole', 
                        ],
                            
                        [
                            'label' => 'Lokasi Audit',
                            'value' => 'dept', 
                        ], 
                        // [
                        //     'label' => 'Lokasi Audit ',
                        //     'format' => 'raw',
                        //     'filter' => Select2::widget([
                        //     'name' => 'deptId',
                        //     'value' => isset(Yii::$app->request->queryParams['deptId'])? Yii::$app->request->queryParams['deptId']:'',
                        //     'data' => ArrayHelper::map(\app\models\msiso\RefAuditorDept::find()->where(['isActive' => 1])->all(), 'deptId', 'dept'),
                        //     'options' => ['placeholder' => ''],
                        //     'pluginOptions' => [
                        //      'allowClear' => true
                        //     ],
                        // ]),
                        //     'value'=>function ($list) {
                        //     return '<small>'. strtoupper($list->dept). '</small>';
                        //     },
            
                        //     'value' => 'dept',
            
                        // ],
                      
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['msiso/kemaskini-lokasi', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit',
                             
                            ]) 
                            .Html::a(' ', ['del-lokasi', 'id' => $list->id], [
                            'class' => 'btn btn-danger fa fa-trash',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                            ]);
                            ;       
                       
                        
                      },
                            
                        ],
                                   
                    ],
                           
                           
                ]); ?>
                        
            </table>
           </div>
           </div>
        </div>
    
</div>

 


