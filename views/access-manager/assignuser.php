<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Assign User';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        
        <div class="x_content">
<div class="tblpraddress-create">

    <div class="tblpraddress-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="form-group" id="poskod">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_name">Nama Role: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($role, 'role_name')->textInput(['maxlength' => true,'disabled'=>true])->label(false) ?>
                </div>
            </div>
            <div class="form-group" id="poskod">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_name">No K/P: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'user_id')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a('Kembali', ['role-details','id'=>$user->role_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
        </div>
    </div>
</div>
