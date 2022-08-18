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
<h5> <strong><center>MAKLUMAT PENYELIA</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
           
 
        

        
       
        
        <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> NAMA KAKITANGAN: <span class="required" style="color:red;">*</span>
                    </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
              <?=
                $form->field($model, 'staff_icno')->widget(Select2::classname(), [
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
                        <?= $form->field($model, 'nama')->textInput()->label(false); ?> 
                    </div>
                </div> 
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">EMEL: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($model, 'emel')->textInput()->label(false); ?> 

                    </div>
                </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">JAWATAN: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($model, 'jawatan')->textInput()->label(false); ?> 

                    </div>
                  </div>
                 <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">JABATAN: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          
            
                                     <?= $form->field($model, 'jabatan')->textInput()->label(false); ?> 

                                
        </div>
                 </div>
       
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         <!-- <div class="ln_solid"></div> -->
            
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
