<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblkeluargaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblkeluarga-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'FamilyId') ?>

    <?= $form->field($model, 'TitleCd') ?>

    <?= $form->field($model, 'ReligionCd') ?>

    <?= $form->field($model, 'MrtlStatusCd') ?>

    <?php // echo $form->field($model, 'RaceCd') ?>

    <?php // echo $form->field($model, 'FmyStatusCd') ?>

    <?php // echo $form->field($model, 'CorpBodyTypeCd') ?>

    <?php // echo $form->field($model, 'OccSectorCd') ?>

    <?php // echo $form->field($model, 'HighestEduLevelCd') ?>

    <?php // echo $form->field($model, 'GenderCd') ?>

    <?php // echo $form->field($model, 'CountryCd') ?>

    <?php // echo $form->field($model, 'NatCd') ?>

    <?php // echo $form->field($model, 'StateCd') ?>

    <?php // echo $form->field($model, 'FmyBirthPlaceCd') ?>

    <?php // echo $form->field($model, 'CityCd') ?>

    <?php // echo $form->field($model, 'RelCd') ?>

    <?php // echo $form->field($model, 'NatStatusCd') ?>

    <?php // echo $form->field($model, 'FmyNm') ?>

    <?php // echo $form->field($model, 'FmyMomNm') ?>

    <?php // echo $form->field($model, 'FmyTelNo') ?>

    <?php // echo $form->field($model, 'FmyBirthDt') ?>

    <?php // echo $form->field($model, 'FmyTwinStatus') ?>

    <?php // echo $form->field($model, 'FmyMarriageDt') ?>

    <?php // echo $form->field($model, 'FmyMarriageCertNo') ?>

    <?php // echo $form->field($model, 'FmyDeceaseDt') ?>

    <?php // echo $form->field($model, 'FmyBumiStatus') ?>

    <?php // echo $form->field($model, 'FmyDivorceDt') ?>

    <?php // echo $form->field($model, 'FmyEmployerNm') ?>

    <?php // echo $form->field($model, 'FmyDisabilityStatus') ?>

    <?php // echo $form->field($model, 'FmyDependencyStatus') ?>

    <?php // echo $form->field($model, 'FmyAddr1') ?>

    <?php // echo $form->field($model, 'FmyAddr2') ?>

    <?php // echo $form->field($model, 'FmyAddr3') ?>

    <?php // echo $form->field($model, 'FmyPostcode') ?>

    <?php // echo $form->field($model, 'FmyNextOfKinStatus') ?>

    <?php // echo $form->field($model, 'FmyEmerContactStatus') ?>

    <?php // echo $form->field($model, 'FmyPensionRecipient') ?>

    <?php // echo $form->field($model, 'ChildReliefInd') ?>

    <?php // echo $form->field($model, 'FmyEmailAddr') ?>

    <?php // echo $form->field($model, 'FmyDependencyCd') ?>

    <?php // echo $form->field($model, 'FmyDependencyICTypeCd') ?>

    <?php // echo $form->field($model, 'FmyBirthCertNo') ?>

    <?php // echo $form->field($model, 'FmyPassportNo') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
