<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\grid\GridView;
use app\models\portfolio\SenaraiPa;
?> <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">SETIAUSAHA</p> 
            <div class="clearfix"></div>
        </div>        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

        <div class="x_content">    
            
                        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                  <?= $form->field($test->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 8])->textInput(['disabled' => 'disabled'])->label(false); ?>

                </div>
            </div>  
            
      
  
         
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KETUA : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                 <?= $form->field($test->department->chiefBiodata, 'CONm')->textArea(['maxlength' => true, 'rows' => 8])->textInput(['disabled' => 'disabled'])->label(false); ?>

              
                </div>
            </div>
   
  
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH STRUKTUR : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
            
                                <?=
                $form->field($model, 'section_ketua')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefSection::find()->where(['jabatan_id' => $test->DeptId])->all(), 'id', 'section_details'),
                    'options' => ['placeholder' => 'Pilih Struktur', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                    
                </div>
            </div>

<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH SETIAUSAHA : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
              
                    
                                <?=
                $form->field($model, 'icno')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(SenaraiPa::find()
                               ->joinWith('kakitangan')->all(), 'icno', 'kakitangan.CONm'),
                    'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                </div>
            </div>  

              
            <div class="form-group text-center">
                <?= Html::submitButton($model->isNewRecord ? 'SIMPAN' : 'KEMASKINI', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?> 
        </div>
    </div>




            
</div>
</div>