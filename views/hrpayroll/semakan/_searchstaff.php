<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="x_title">
    <h2>Carian Kakitangan</h2>
    <div class="clearfix"></div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['semakan'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
]); ?>
<div class="form-group ">
    <div class="form-group align-center">
        <div class="col-md-4 col-sm-4 col-xs-12">
        <div class=" col-md-5 col-sm-5 col-xs-12">
            <?= $form->field($carian, 'carian_data')->textInput(['placeholder' => 'Nama / Nombor IC / ID'])->label(false) ?>
        </div>
        <div class=" col-md-1 col-sm-1 col-xs-12">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
</div>
<?php ActiveForm::end(); ?>