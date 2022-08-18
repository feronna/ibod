<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\SwitchInput;


error_reporting(0);
?>
 <?= $this->render('menu') ?> 

 <?php  $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left','enctype' => 'multipart/form-data']]); ?>
 
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Sistem Akses MSISO</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
            ?>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Akses :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
            <?= $form->field($model, 'access_level')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\msiso\RefAccess::find()->where(['!=','id', '99'])->all(), 'id', 'access_type'),
                            'options' => [
                            'placeholder' => 'Akses Sistem'],
                            ])->label(false); 
            ?>
            </div>
        </div>  

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'isActive')->widget(SwitchInput::classname(), [
                                        'items' => [
                                            ['label' => 'Complete', 'value' => 1,

                                            ],
                                            ['label' => 'Incomplete', 'value' => 0 ],
                                        ],
                                        'pluginOptions' => [
                                            'onText' => 'Aktif',
                                            'offText' => 'Tidak Aktif',
                                            'size' => 'small',
                                            'onColor' => 'success',
                                            'offColor' => 'danger',
                                        ]
                                    ])->label(false) ?>
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
                <h2><strong><i class="fa fa-list"></i> Senarai Akses Sistem</strong></h2>
                  
                <div class="clearfix"></div>
                <!-- status 0 = close, 1 = open -->
            </div>
        <div class="x_content">
           <div class="table-responsive">
               <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'summary' => '',
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
                        [
                            'label' => 'NAMA',
                            'value' => 'kakitangan.CONm', 
                        ],

                        [
                            'label' => 'No. I/C',
                            'value' => 'icno', 
                        ],
                             
                        [
                            'label' => 'Role',
                            'value' => 'accessRole', 
                        ],
                        
                        [
                            'label' => 'Status',
                            'format' => 'raw',
                            'value' => 'active', 
                        ],
                      
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['msiso/update-akses', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit',
                             
                            ])       
                            .Html::a('', ['del-akses', 'id' => $list->id], [
                            'class' => 'btn btn-danger fa fa-trash',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                          
                        
                      },
                            
                        ],
                                   
                    ],
                           
                           
                ]); ?>
                        
            </table>
           </div>
           </div>
  
 </div> 
</div>

 


