<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?= $this->render('menu') ?> 
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
    <div class="x_title">
        <h2>Muat Naik Jadual</h2> 
        <div class="clearfix"></div>
    </div>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'fileImport')->fileInput() ?>
    <?= Html::submitButton('Import', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>
</div>
</div>
