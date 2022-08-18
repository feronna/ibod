<?php

// use kartik\dialog\Dialog;

// $js = <<< JS
// $("#btn-alert").on("click", function() {
//     krajeeDialog.alert("Data berjaya disimpan!")
// });
// JS;

// // register your javascript
// $this->registerJs($js);
// echo Dialog::widget();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);
$ind = 0;
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="col-md-1 text-center">BIL.</th>
            <th class="text-center">PARAMETER</th>
            <th class="col-md-2 text-center">BILANGAN JAM</th>
        </tr>
        <?php $form = ActiveForm::begin(); ?>
        <tr>
            <td class="text-center"><?= $ind = $ind + 1; ?></td>
            <td>Clinical Consultation (Clinic / Ward Round / Procedure)</td>
            <td class="text-center"><?= ($lpp->PYD == Yii::$app->user->identity->ICNO ? true : ($check)) ? $form->field($input, "clinic_consult")->textInput(['style' => 'text-align:center;  width: 40%', 'placeholder' => '0', 'class' => 'text-center', 'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? ($check) : true)])->label(false) : ($input->clinic_consult ?? 0); ?></td>
        </tr>

        <tr>
            <td class="text-center"><?= $ind = $ind + 1; ?></td>
            <td>Annual Practicing Certificate Renewal (APC - MMC)</td>
            <td class="text-center">
                <!-- <?php if ($lpp->PPP == Yii::$app->user->identity->ICNO) { ?>
                    <?= $form->field($input, 'apc')->checkbox(['label' => '', 'disabled' => $check]); ?>
                <?php } else {
                            if ($input->apc == 0 or is_null($input->apc)) {
                                echo 'Unverified';
                            } else {
                                echo 'Verified';
                            }
                        } ?> -->

                <?= $data['apc'] ? 'Ya' : 'Tidak'; ?>
            </td>
        </tr>
    </table>
    <?php if ($lpp->PYD == Yii::$app->user->identity->ICNO and $lpp->PYD_sah == 0) { ?>

        <div style="clear: both;" class="form-group pull-right">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'value' => 'create_add', 'name' => 'submit']) ?>
        </div>
    <?php } ?>
    <!-- <?php if ($lpp->PPP == Yii::$app->user->identity->ICNO and $lpp->PPP_sah == 0) { ?>

        <div style="clear: both;" class="form-group pull-right">
            <?= (!$check) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'value' => 'create_add', 'name' => 'submit']) : '' ?>
        </div>
        <?php } ?>` -->

    <?php ActiveForm::end(); ?>

    </table>
</div>
<!-- 
<hr>
<p><i>*Aspek Annual Practicing Certificate Renewal (APC - MMC) hanya boleh diisi oleh PPP sahaja.</i></p> -->