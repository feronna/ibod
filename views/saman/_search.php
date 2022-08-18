<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\saman\MainSamanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-saman-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NOSAMAN') ?>

    <?= $form->field($model, 'TRKHSAMAN') ?>

    <?= $form->field($model, 'KATEGORI') ?>

    <?= $form->field($model, 'IDNO') ?>

    <?= $form->field($model, 'NAMA') ?>

    <?php // echo $form->field($model, 'ICNO') ?>

    <?php // echo $form->field($model, 'NO_KENDERAAN') ?>

    <?php // echo $form->field($model, 'SIRI_PELEKAT') ?>

    <?php // echo $form->field($model, 'KODJENIS') ?>

    <?php // echo $form->field($model, 'KODMODEL') ?>

    <?php // echo $form->field($model, 'LOKASI') ?>

    <?php // echo $form->field($model, 'KODKAMPUS') ?>

    <?php // echo $form->field($model, 'KODKOLEJ') ?>

    <?php // echo $form->field($model, 'KODJFPIU') ?>

    <?php // echo $form->field($model, 'KODPROGRAM') ?>

    <?php // echo $form->field($model, 'TOTALAMN1') ?>

    <?php // echo $form->field($model, 'TOTALAMN2') ?>

    <?php // echo $form->field($model, 'TOTALAMN3') ?>

    <?php // echo $form->field($model, 'TOTALAMN4') ?>

    <?php // echo $form->field($model, 'KODSALAH1') ?>

    <?php // echo $form->field($model, 'NOTA1') ?>

    <?php // echo $form->field($model, 'KODSALAH1_AMN1') ?>

    <?php // echo $form->field($model, 'KODSALAH1_AMN2') ?>

    <?php // echo $form->field($model, 'KODSALAH1_AMN3') ?>

    <?php // echo $form->field($model, 'KODSALAH1_AMN4') ?>

    <?php // echo $form->field($model, 'KODSALAH2') ?>

    <?php // echo $form->field($model, 'NOTA2') ?>

    <?php // echo $form->field($model, 'KODSALAH2_AMN1') ?>

    <?php // echo $form->field($model, 'KODSALAH2_AMN2') ?>

    <?php // echo $form->field($model, 'KODSALAH2_AMN3') ?>

    <?php // echo $form->field($model, 'KODSALAH2_AMN4') ?>

    <?php // echo $form->field($model, 'KODSALAH3') ?>

    <?php // echo $form->field($model, 'NOTA3') ?>

    <?php // echo $form->field($model, 'KODSALAH3_AMN1') ?>

    <?php // echo $form->field($model, 'KODSALAH3_AMN2') ?>

    <?php // echo $form->field($model, 'KODSALAH3_AMN3') ?>

    <?php // echo $form->field($model, 'KODSALAH3_AMN4') ?>

    <?php // echo $form->field($model, 'KODSALAH4') ?>

    <?php // echo $form->field($model, 'NOTA4') ?>

    <?php // echo $form->field($model, 'KODSALAH4_AMN1') ?>

    <?php // echo $form->field($model, 'KODSALAH4_AMN2') ?>

    <?php // echo $form->field($model, 'KODSALAH4_AMN3') ?>

    <?php // echo $form->field($model, 'KODSALAH4_AMN4') ?>

    <?php // echo $form->field($model, 'NOKUNCI') ?>

    <?php // echo $form->field($model, 'KODBADAN') ?>

    <?php // echo $form->field($model, 'KODPGUATKUASA') ?>

    <?php // echo $form->field($model, 'DATELOG') ?>

    <?php // echo $form->field($model, 'LATITUD') ?>

    <?php // echo $form->field($model, 'LONGITUD') ?>

    <?php // echo $form->field($model, 'ACTION') ?>

    <?php // echo $form->field($model, 'ISTRANSFER') ?>

    <?php // echo $form->field($model, 'AMNKUNCI') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
