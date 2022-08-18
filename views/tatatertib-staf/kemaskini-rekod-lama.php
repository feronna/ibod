<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
 

$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';
error_reporting(0);
?>
 
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5><strong><i class="fa fa-plus"></i>Kemaskini Rekod Lama</strong></h5> 
              
           
            
            <div class="clearfix"></div>

          
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
                
                
                 <div class="clearfix"></div>
               
         
                 
                 
             <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-user"></i>&nbsp;Nama Kakitangan: <span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <?=
                    $form->field($rekod, 'icno')->label(false)->widget(Select2::class, [
                       'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '-- Select Staff --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true,
                         //   'multiple' => true,
                        ],
                        
                    ]);
                ?>
            </div>
        </div>
        
         <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-pencil"></i>&nbsp;Jenis Kesalahan (i): <span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                  <?=
                            $form->field($rekod, 'jenis_kesalahan')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\tatatertib_staf\RefJenisKesalahan::find()->all(), 'id', 'kesalahan_nm'),
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                  ?>
            </div>
        </div>
        
    
        <div class="form-group">
               <label class="col-sm-3 control-label"><i class="fa fa-book"></i>&nbsp;Pelanggaran Tatakelakuan Yang Disabitkan (ii: <span class="required" style="color:red;">*</span></label>        
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($rekod, 'kes')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
             
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank">Tarikh Mula Kesalahan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=
                    DatePicker::widget([
                        'model' => $rekod,
                        'attribute' => 'tarikh_mula_kesalahan',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>              
                </div>
            </div>
        
           <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank">Tarikh Akhir Kesalahan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=
                    DatePicker::widget([
                        'model' => $rekod,
                        'attribute' => 'tarikh_akhir_kesalahan',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>              
                </div>
            </div>
                 
                 
                 
           <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-pencil"></i>&nbsp;Rayuan: <span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                  <?=
                            $form->field($rekod, 'rayuan')->label(false)->widget(Select2::classname(), [
                            'data' => [1=>'Merayu', 2 =>'Tidak Merayu', 3 => 'Tiada Tindakan'],
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                  ?>
            </div>
        </div>
                 
                 
       <div class="form-group">
               <label class="col-sm-3 control-label"><i class="fa fa-book"></i>&nbsp;Catatan Rayuan: <span class="required" style="color:red;">*</span></label>        
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($rekod, 'catatan_rayuan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
                 
                 
                            <div class="form-group">
               <label class="col-sm-3 control-label"><i class="fa fa-book"></i>&nbsp;Hukuman: <span class="required" style="color:red;">*</span></label>        
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                            $form->field($rekod, 'hukuman')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\tatatertib_staf\RefJenisHukuman::find()->all(), 'id', 'hukuman_nm'),
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                  ?>
                </div>
        </div>
                 
                 
                 
                   <div class="form-group">
               <label class="col-sm-3 control-label"><i class="fa fa-book"></i>&nbsp;Catatan Hukuman <span class="required" style="color:red;">*</span></label>        
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($rekod, 'catatan_hukuman')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
           
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::submitButton('TAMBAH', ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton('RESET', ['class' => 'btn btn-primary']); ?>

                    </div>
                </div>

             

            </div>
        </div>
    </div>
     
       <?php ActiveForm::end(); ?>

</div>