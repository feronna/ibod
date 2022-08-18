<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kemudahan\BorangehsanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borangehsan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'icno') ?>

    <?= $form->field($model, 'jeniskemudahan') ?>

    <?= $form->field($model, 'pohon') ?>

    <?= $form->field($model, 'tujuan') ?>

    <?php // echo $form->field($model, 'tarikh_mohon') ?>

    <?php // echo $form->field($model, 'status_pt') ?>

    <?php // echo $form->field($model, 'catatan_pt') ?>

    <?php // echo $form->field($model, 'semakan_pt') ?>

    <?php // echo $form->field($model, 'status_pp') ?>

    <?php // echo $form->field($model, 'catatan_pp') ?>

    <?php // echo $form->field($model, 'ver_date') ?>

    <?php // echo $form->field($model, 'status_kj') ?>

    <?php // echo $form->field($model, 'catatan_kj') ?>

    <?php // echo $form->field($model, 'app_date') ?>

    <?php // echo $form->field($model, 'tarikh_terima') ?>

    <?php // echo $form->field($model, 'pengakuan') ?>

    <?php // echo $form->field($model, 'isActive') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
