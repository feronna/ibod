<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
 

$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';
//error_reporting(0);
?>
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>

            <p align="right"><?= Html::a('Kembali', ['index'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="iklan-form"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5><strong><i class="fa fa-plus"></i> TAMBAH PENYELIA</strong></h5> 
              
           
            
            <div class="clearfix"></div>

          
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> NAMA KAKITANGAN: <span class="required" style="color:red;">*</span>
                    </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
              <?=
                $form->field($pengajian, 'staff_icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Kakitangan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
            
            </div>
                </div> 
                 <div class="clearfix"></div>
                 <div class="x_title">
                     <h5><strong><i class="fa fa-user"></i> MAKLUMAT PENYELIA</strong></h5> 
                <div class="clearfix"></div>
            </div>
                
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">NAMA PENYELIA: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($pengajian, 'nama')->textInput()->label(false); ?> 
                    </div>
                </div> 
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">EMEL: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($pengajian, 'emel')->textInput()->label(false); ?> 

                    </div>
                </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">JAWATAN: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($pengajian, 'jawatan')->textInput()->label(false); ?> 

                    </div>
                  </div>
                 <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">JABATAN: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          
            
                                     <?= $form->field($pengajian, 'jabatan')->textInput()->label(false); ?> 

                                
        </div>
                 </div>
                
                
                
               
                
                                
           
                
                

                 
                 
                
                    
                     
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

             

            </div>
        </div>
    </div>
     
       <?php ActiveForm::end(); ?>
</div>
