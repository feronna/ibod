<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
  
error_reporting(0);
?>



<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1183,1314], 'vars' => []]); ?>
<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Permohonan Lebih Tempoh</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false);
                            
                        
            ?>
            </div>
        </div> 
         
<!--         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kemudahan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'facility')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                '7' => 'WILAYAH ASAL', 
                              
                               
                             ],
                                'options' => [
                                        'placeholder' => 'Kemudahan'],

                            ]); ?> 
            </div>
        </div>-->
 <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
             
               
                <?= $form->field($model, 'isActive')->radioList( [1=> 'Akses Ibu Bapa', 2 => 'Lanjutan Tempoh'] )->label(false); ?>
                <!-- $form->field($model, 'myattribute')->radioList( [0=>'zero', 1 => 'one', 2 => 'two'] ); -->

              
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
                <h2><strong><i class="fa fa-list"></i> Akses Sementara lebih tempoh</strong></h2>
                  
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
//                        [
//                            'label' => 'NAMA',
//                            'value' => 'name',
//                                                       
//                        ],
//                        [
//                            'label' => 'ICNO',
//                            'value' => 'staffName.ICNO',
//                                                       
//                        ],
                         
                        
                          [
                            'label' => 'NAMA',
                            'value' => 'kakitangan.CONm',
                                                       
                        ],
                                                       
                        
                        [
                            'label' => 'Status',
                            'value' => 'isActive',
                                                       
                        ], 
                      
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['kemudahan/update-akses', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit',
                             
                        ])       
                            .Html::a('', ['pdm-akses', 'id' => $list->id], [
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


