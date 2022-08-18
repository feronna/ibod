<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengakuan Pegawai</strong></h2>
                <div class="clearfix"></div>
            </div>
          
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                      <p style="color:red">Saya mengaku bahawa segala maklumat dan rekod yang diberikan dalam borang ini
                      adalah lengkap dan betul.</p>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?=
                            $form->field($mohon, 'status')->label(false)->widget(Select2::classname(), [
                            'data' => [1=>'YA'],
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
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
                          
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Adakah anda pasti dengan tindakan ini?']]) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <!--form-->
            
            </div>
        </div>
    </div>
</div>

