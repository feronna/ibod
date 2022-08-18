<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$this->title = 'Assign Permission to role';

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
                <div class="col-md-6 col-sm-6 col-xs-12 disabled">
                    <?=
                    $form->field($roleperm, 'role_id')->label(false)->widget(Select2::classname(), [
                        'data' => $role,
                        'options' => ['placeholder' => 'Pilih Role', 'class' => 'form-control col-md-7 col-xs-12','disabled'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="controller_id">Nama Permission: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($roleperm, 'perm_id')->label(false)->widget(Select2::classname(), [
                        'data' => $perm,
                        'options' => ['placeholder' => 'Pilih Permission', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a('Kembali', ['role-details','id'=>$roleperm->role_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
        </div>
    </div>
</div>
