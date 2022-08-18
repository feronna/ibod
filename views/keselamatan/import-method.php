<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="x_panel">
    <div class="x_title">
        <h2>Periksa Nama Anggota Dalam Jadual</h2> 
        <div class="clearfix"></div>
    </div>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($modelImport, 'fileImport')->fileInput() ?>
    <?= Html::submitButton('Import', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>
