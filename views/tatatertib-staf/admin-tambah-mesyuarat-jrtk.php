<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select2;
?>


    <div class="x_panel" >
              <p align="right"> 
    
            <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="x_title">
            <h2><strong>Mesyuarat Jawatankuasan Tatatertib Kakitangan</strong></h2>
        
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <div class="table-responsive">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
            
        <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Mesyuarat<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'nama_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
        </div>
       
            
            
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <?= $form->field($urus, 'tarikh_mesyuarat')->widget(DatePicker::classname(), [
  
                            'value' => date('Y-m-d'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                      'format' => 'yyyy-m-d'
                            ]
                        ])->label(false);?>
                    </div>
                </div>
            
       
      
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Mesyuarat<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'tempat_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
            
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bidang Kuasa<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?=
                            $form->field($urus, 'bidang_kuasa')->label(false)->widget(Select2::classname(), [
                            'data' => [1=>'Tindakan tatatertib dengan tujuan buang kerja atau turun pangkat', 2 =>'Tindakan tatatertib bukan dengan tujuan buang kerja atau turun pangkat'],
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                  ?>
               </div>
              </div>
            
             <div class="form-group">
            <label class="col-sm-3 control-label">Pengerusi<span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
         
               <?=
                   $form->field($urus, 'pengerusi_icno')->label(false)->  widget(Select2::classname(), [
                    'data' => $dropdown_list_name,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
            
   
            
 
        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>




