<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
?>   
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Batal Permohonan</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($batal, 'ulasan')->textArea(['maxlength' => true, 'rows' => 4])->label(false);
                    ?> 
                </div>
            </div>  
            <div class="hide">  
                <?= $form->field($batal, 'ICNO')->textInput(['value' => $permohonan->ICNO])->label(false);  ?>
                <?= $form->field($batal, 'gl_ICNO')->textInput(['value' => $permohonan->gl_ICNO])->label(false);  ?>
                <?= $form->field($batal, 'gl_hospital_id')->textInput(['value' => $permohonan->gl_hospital_id])->label(false);  ?>
                <?= $form->field($batal, 'datetime')->textInput(['value' => date('Y-m-d H:i:s')])->label(false);  ?>
                <?= $form->field($batal, 'created_by')->textInput(['value' => Yii::$app->user->getId()])->label(false);  ?> 
            </div>
            <div class="form-group text-center"> 
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div>  

