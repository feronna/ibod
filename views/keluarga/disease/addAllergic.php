<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<script src="jquery-1.11.2.js"></script>

<div class="tblkeluarga-form">
    <?php $form = ActiveForm::begin(['options' => [
        'class' => 'form-horizontal form-label-left disable-submit-buttons']]);
    ?>

        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Alahan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($new_disease, 'description')->textarea(['placeholder' => 'Isikan Nama Penyakit','name'=>'addname'], ['maxlength' => true])->label(false); ?>
                </div>
            </div>

        </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Simpan',['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>