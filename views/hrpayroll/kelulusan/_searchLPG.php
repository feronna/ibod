<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="x_title">
    <h2>Carian</h2>
    <div class="clearfix"></div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['kelulusan-l-p-g'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
]); ?>
<div class="form-group ">
        <div class="form-group col-md-12 col-sm-12 col-xs-12 align-center">
            <div class=" col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($search, 'carian_data')->textInput(['placeholder' => 'Batch Code / Staff ID'])->label(false) ?>
            </div>
            <div class=" col-md-1 col-sm-1 col-xs-6">
                <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true">Cari</i> ', ['class' => 'btn btn-primary']) ?>
            </div>
            <div class=" col-md-1 col-sm-1 col-xs-6">
                <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"> Set Semula</i> ',['kelulusan-l-p-g'], ['class' => 'btn btn-warning']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>