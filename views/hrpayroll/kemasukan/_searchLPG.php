<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="x_title">
    <h2>Carian LPG/Kew8</h2>
    <div class="clearfix"></div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['kemasukan-l-p-g'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
]); ?>
<div class="form-group ">
        <div class="form-group col-md-12 col-sm-12 col-xs-12 align-center">
            <div class=" col-md-5 col-sm-5 col-xs-12">
                <?= $form->field($search, 'carian_data')->textInput(['placeholder' => 'Batch Code / Staff ID'])->label(false) ?>
            </div>
            <div class=" col-md-1 col-sm-1 col-xs-12">
                <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
            </div>
            <div class=" col-md-1 col-sm-1 col-xs-12">
                <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i> Set Semula',['kemasukan-l-p-g'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>