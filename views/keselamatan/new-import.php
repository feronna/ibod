<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="x_panel">
    <div class="x_title">
        <h2>Halaman Muat Naik Jadual Anggota</h2> 
        <div class="clearfix"></div>
    </div>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($modelImportHakiki, 'fileImport')->fileInput() ?>
    <?= Html::submitButton('Import', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>
</div>
