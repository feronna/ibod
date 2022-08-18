<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use dosamigos\datepicker\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\hronline\Department;
use kartik\number\NumberControl;
use wbraganca\dynamicform\DynamicFormWidget;


error_reporting(0);

?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
                <p align="right" >
                    <?php echo Html::a('Kembali', ['senarai-memorandum'], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
                <h2><i class="fa fa-book"></i>&nbsp;<strong>Tambah Rekod Memorandum</strong></h2>
                <hr>
            <div class="x_content">


                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data'],'id' => 'dynamic-form']); ?>
                
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
             
                             <?= $form->field($model, 'tarikh_rekod')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
                    </div>
             </div>
                
                
                
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Akhir Penghantaran Maklumbalas :<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
             
                             <?= $form->field($model, 'tarikh_tamat')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
                    </div>
             </div>
                
                
     
                
                
         <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bil.JPU :<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'bil_jpu')->textinput(['maxlength' => true, 'rows' => 4,  'placeholder' => 'Cth: 14/2022 (290)'])->label(false); ?>
                </div>
            </div>
                
                
                
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-2 col-xs-12">Kali Ke- :<span class="required" style="color:red;">*</span></label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                         <?=
                    $form->field($model, 'kali_ke')->widget(NumberControl::classname(), [
                         'name' => 'kali_ke',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => '',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => 'Cth: 246'
                                  ],
                                ])->label(false);
                            ?>
                </div>
            </div>
                
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Subjek Minit :<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'perkara')->widget(TinyMce::className(), [
                            'options' => ['rows' => 15],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ])->label(false); ?>
                </div>
            </div>
                
                
          
                
                
                
           <div class="customer-form">

        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelMakluman[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'dimensi',
                    'dimensi_utama',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelMakluman as $i => $modelMakluman): ?>
                
                
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                    
                       
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                     
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelMakluman->isNewRecord) {
                                echo Html::activeHiddenInput($modelMakluman, "[{$i}]id");
                            }
                        ?>
                        
     
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">JAFPIB :<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php // Usage with ActiveForm and model
                        echo $form->field($modelMakluman, "[{$i}]dept_id")->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($department, 'id', 'fullname'),
                            'options' => ['placeholder' => '-- Pilih JAFPIB --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                </div>
            </div>             

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Perkara :<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                           <?= $form->field($modelMakluman, "[{$i}]perkara")->widget(TinyMce::className(), [
                            'options' => ['rows' => 15],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ])->label(false); ?>
                </div>
            </div>
                   
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        
            <?php DynamicFormWidget::end(); ?>
        </div>
    


</div>
                
                
                
                     <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Minit Mesyuarat :<span class="required" style="color:red;">*</span></label>
           
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        echo $form->field($model, 'file', ['enableAjaxValidation' => false])->label(false)->widget(FileInput::class, [
                            'options' => [
                                'accept' => ['image/*', 'application/pdf'],
                            ],
                            'pluginOptions' => [
                                'showUpload' => false
                            ],

                        ]);
                        ?>
                    </div>
                    <?= Html::error($model, 'file3'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <p>Attachment *Only images (jpg, jpeg, png) or PDF is allowed (Max upload: 2MB)</p>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
                </div>

    
                  <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Simpan', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>