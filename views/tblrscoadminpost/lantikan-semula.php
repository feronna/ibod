<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
?>
<?php
Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>

<div style="display: <?php echo $displaytempoh;?>"> 
    <div class="x_panel"> 
        <div class="x_title">
                    <h2><strong></i>Lantikan Semula</strong></h2>
                    <div class="clearfix"></div>
        </div>
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No IC</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=  $form->field($biodata, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jawatan">Jawatan Pentadbiran</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=  $form->field($biodata->adminpos, 'position_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Program Pengajaran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?php if($biodata->program!= NULL){?>                   
                <?=  $form->field($biodata->program, 'NamaProgram')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <?php }else{
                    echo "Tiada Rekod";
                }?> 
            </div>
        </div>
                
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusjawatan">Status Jawatan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?=  $form->field($biodata->jobStatus0, 'jobstatus_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
        </div>   
     
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusbayaran">Status Bayaran</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=  $form->field($biodata->paymentStatus0, 'paymentstatus_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($biodata, 'description')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">JAFPIB</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=  $form->field($biodata->dept, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
        </div> 
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kampus">Kampus</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=  $form->field($biodata->campus, 'campus_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
        </div> 
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="appointmentdate">Tarikh Lantikan: <span class="required" style="color:red;">*</span>  
            </label>
                <div class="col-md-3 col-sm-3 col-xs-10"> 
                <?= $form->field($biodata, 'appoinment_date')->widget(DatePicker::className(),
                        ['clientOptions' => ['changeMonth' => true,
                            'yearRange' => '1996:2099',
                            'changeYear' => true, 
                            'format' => 'yyyy-mm-dd', 
                            'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                            'id' => 'appoinment_date' 
                        ]
                    ])->label(false);
                    ?>
                </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startdate">Tarikh Kuatkuasa: <span class="required" style="color:red;">*</span>  
            </label>
                <div class="col-md-3 col-sm-3 col-xs-10"> 
                <?= $form->field($biodata, 'start_date')->widget(DatePicker::className(),
                        ['clientOptions' => ['changeMonth' => true,
                            'yearRange' => '1996:2099',
                            'changeYear' => true, 
                            'format' => 'yyyy-mm-dd', 
                            'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                            'id' => 'start_date' 
                        ]
                    ])->label(false);
                    ?>
                </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enddate">Tarikh Tamat: <span class="required" style="color:red;">*</span>  
            </label>
                <div class="col-md-3 col-sm-3 col-xs-10"> 
                <?= $form->field($biodata, 'end_date')->widget(DatePicker::className(),
                        ['clientOptions' => ['changeMonth' => true,
                            'yearRange' => '1996:2099',
                            'changeYear' => true, 
                            'format' => 'yyyy-mm-dd', 
                            'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                            'id' => 'end_date' 
                        ]
                    ])->label(false);
                    ?>
                </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-10">
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                <?php 
                if( $biodata->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($biodata->files ? $msg =  Yii::$app->FileManager->NameFile($biodata->files) : $msg = 'Please provide related file.'));
                echo $form->field($biodata, 'file')->fileInput()->label($msg);?>
            </div>
        </div>


        <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar' ,['class' => 'btn btn-primary','name' => 'hantar']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
        </div>
</div>
<?php ActiveForm::end(); 
Pjax::end();?>



