<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Refjeniskemudahan;
use app\models\kemudahan\Refakaun;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;
use kartik\date\DatePicker;
error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1183,1314], 'vars' => []]); ?>
<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Jenis Kemudahan</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
          
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kemudahan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model, 'jeniskemudahan')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Refjeniskemudahan::find()->all(), 'kemudahancd', 'kemudahan'),
                    'options' => [
                            'placeholder' => 'Sila Pilih'],

                ]); ?>
            </div>
        </div>
 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Akaun<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?=
                    $form->field($model, 'kodAkaun')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Refakaun::find()->all(), 'akauncd', 'kodAkaun'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => 'Sila Pilih',
                            'depends' => [Html::getInputId($model, 'jeniskemudahan')],
                            'initialize' => true,
                            'url' => Url::to(['/kemudahan/jenis'])
                        ]
                    ])->label(false)
                    ?>
            </div>
        </div>
          
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
                <?php $model->status = 1; ?>
                <?php // $form->field($model, 'status')->checkbox()->label(false); ?>
                <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
                                        'pluginOptions' => [
                                            'onText' => 'Open',
                                            'offText' => 'Close',
                                            'size' => 'small',
                                            'onColor' => 'success',
                                            'offColor' => 'danger',
                                        ]
                                    ])->label(false) ?>


              
            </div>
        </div> 
        
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
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
                <h2><strong><i class="fa fa-list"></i> E-Kemudahan</strong></h2>
                  <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
                <div class="clearfix"></div>
                status 0 = close, 1 = open
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
                                        'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'], 
                                            ],
                        [
                            'label' => 'Jenis Kemudahan',
                            'value' => 'displayjenis.kemudahan',
                                                       
                        ],
//                        [
//                            'label' => 'Kod Akaun',
//                            'value' => 'displayakaun.kodAkaun',
//                                                       
//                        ],
                        [
                            'label' => 'Catatan',
                           'value'=>function ($data) {
                        if($data->status  == 1){
                            return $data->reason;
                        }
                           }
                            
                    ],
                              [
                            'label' => 'Tarikh Buka',
                            'value' => function($dataProvider) { 
                            if($dataProvider->status  == 1){
                                  return $dataProvider->start;
                        
                            }
                            }
                            
                        ], 
                       [
                            'label' => 'Tarikh Tutup',
                            'value' => function($dataProvider) { 
                            if($dataProvider->status  == 1){
                                  return $dataProvider->end ;
                        
                            }
                            }
                        ],      
                       
//                        [
//                            'label' => 'Kemaskini Oleh', 
//                            'value' => 'officer.CONm',
//                            
//                        ], 
                        [
                            'label' => 'Tarikh Kemaskini',
                            'value' => 'updateddate',
                        ],
                        [
                            'label' => 'Status',
                            'format' => 'raw',
                            'value' => 'OpenClose',
                            
                        ], 
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['kemudahan/kemaskini-permohonan', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit',
                             
                        ])       
                            .Html::a('', ['del2', 'id' => $list->id], [
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


