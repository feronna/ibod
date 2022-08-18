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
            <h2><i class="fa fa-list"></i><strong> Penetapan Kadar Kelayakan</strong></h2>
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
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tanggungan')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                'KADAR KELUARGA' => 'KADAR KELUARGA', 
                                'KADAR BUJANG' => 'KADAR BUJANG',
                               
                             ],
                                'options' => [
                                        'placeholder' => 'Kadar Kelayakan'],

                            ]); ?> 
            </div>
        </div>
         
 <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
             
               <?php $model->isActive = 0; ?>
                <?= $form->field($model, 'isActive')->checkbox()->label(false); ?>


              
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
                <h2><strong><i class="fa fa-list"></i> Tanggungan</strong></h2>
                  <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
                <div class="clearfix"></div>
                status 0 = close, 1 = open
            </div>
        <div class="x_content">
           <div class="table-responsive">
               <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => true,
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
                            'label' => 'Name',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                            'name' => 'name',
                            'value' => isset(Yii::$app->request->queryParams['name'])? Yii::$app->request->queryParams['name']:'',
                            'data' => ArrayHelper::map(\app\models\kemudahan\Borangwilayah::find()->all(), 'nama', 'nama'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            'value'=>function ($data) {
                            return '<small>'. strtoupper($data->kakitangan->CONm). '</small>';
                            },

                            'value' => 'kakitangan.CONm',
                                                       
                        ],
                        
                        [
                            'label' => 'ICNO',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['name'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\kemudahan\Borangwilayah::find()->all(), 'icno', 'icno'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            'value'=>function ($data) {
                            return '<small>'. strtoupper($data->icno). '</small>';
                            },

                            'value' => 'icno',
                                                       
                        ],
                                                       
                        
                        [
                            'label' => 'KADAR TANGGUNGAN',
                            'value' => 'tanggungan',
                                                       
                        ],
                            
//                        [
//                            'label' => 'Status',
//                            'value' => 'isActive',
//                            
//                        ], 
                      
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['kemudahan/update-tanggungan', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit',
                             
                        ])       
                            .Html::a('', ['pdm', 'id' => $list->id], [
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


