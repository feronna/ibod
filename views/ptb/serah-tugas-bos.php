<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


?>

        <?php echo $this->render('/ptb/_menu'); ?>

<div class="col-md-12 col-xs-12">  
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Nota Serah Tugas</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
             
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <div class="table-responsive">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($tugas, 'pengganti_ICNO')->label(false)->  widget(Select2::classname(), [
                    'data' => $allBiodata,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($tugas, 'catatan_pengganti')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
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
</div>


