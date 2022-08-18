<?php

use yii\helpers\Html; 
use kartik\form\ActiveForm;

?>
<?php $form = ActiveForm::begin([
                            'action' => ['view-penceramah?siriID='.$model->siriLatihanID.'&penceramahID='.$model->penceramahID],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-4 col-xs-4">Bayaran Penceramah (RM) : </label>
                <div class="col-md-9 col-sm-8 col-xs-8">
                    <?= $form->field($model, 'upah')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '0'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-4 col-xs-4">Jamuan (RM) : </label>
                <div class="col-md-9 col-sm-8 col-xs-8">
                    <?= $form->field($model, 'jamuan')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '0'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>    
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-4 col-xs-4">Penginapan (RM) : </label>
                <div class="col-md-9 col-sm-8 col-xs-8">
                    <?= $form->field($model, 'penginapan')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '0'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-4 col-xs-4">Tiket Penerbangan (RM) : </label>
                <div class="col-md-9 col-sm-8 col-xs-8">
                    <?= $form->field($model, 'tiket')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '0'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
            </div>
<?php ActiveForm::end(); ?>
