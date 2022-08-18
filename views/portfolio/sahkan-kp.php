<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;

error_reporting(0);
?>


<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Tindakan Ketua Perkhidmatan</strong></h2>
             
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <div class="table-responsive">
                      
                      
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                        $form->field($model, 'kp_agree')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'DIPERAKUKAN', 2 => 'DITOLAK'],
                            'options' => ['placeholder' => 'Pilih Perakuan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
               
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Perakuan Ketua Perkhidmatan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'perakuan_kp')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                        </div>
                    </div>
                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Adakah anda pasti dengan tindakan ini?']]) ?>
                        </div>
                    </div>
 
                <!--form-->
            </div>
            </div>
        </div>
    </div>
</div>
  <?php ActiveForm::end(); 
            Pjax::end();?>
