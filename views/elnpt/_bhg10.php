<?php

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
            <td class="text-center"><?= $form->field($input, "clinic_consult")->textInput(['style' => 'text-align:center;  width: 40%', 'placeholder' => '0', 'class' => 'text-center', 'disabled' => !($lpp->PYD == Yii::$app->user->identity->ICNO)])->label(false); ?></td>
        </tr>
        <tr>
            <td class="text-center"><?= $ind = $ind + 1; ?></td>
            <td>Clinical Bedside Teaching</td>
            <td class="text-center"><?= $form->field($input, "cbt")->textInput(['style' => 'text-align:center;  width: 40%', 'placeholder' => '0', 'class' => 'text-center', 'disabled' => !($lpp->PYD == Yii::$app->user->identity->ICNO)])->label(false); ?></td>
        </tr>
        <tr>
            <td class="text-center"><?= $ind = $ind + 1; ?></td>
            <td>Annual Practicing Certificate Renewal (APC - MMC)</td>
            <td class="text-center">
                <?php if($lpp->PPP == Yii::$app->user->identity->ICNO) { ?>
                    <?= $form->field($input, 'apc')->checkbox(['label'=>'', ]); ?>
                <?php }else {
                    if($input->apc == 0 or is_null($input->apc)){
                        echo 'Unverified';
                    }else {
                        echo 'Verified';
                    }
                } ?>
            </td>
        </tr>
        </table>
        <?php if(($lpp->PYD == Yii::$app->user->identity->ICNO AND $lpp->PYD_sah == 0) OR ($lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
        
            <div style="clear: both;" class="form-group pull-right">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'value'=>'create_add', 'name'=>'submit']) ?>
            </div>    
        <?php } ?>
        <?php if(($lpp->PPP == Yii::$app->user->identity->ICNO AND $lpp->PPP_sah == 0) OR ($lpp->PPP == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
        
            <div style="clear: both;" class="form-group pull-right">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'value'=>'create_add', 'name'=>'submit']) ?>
            </div>    
        <?php } ?>`

        <?php ActiveForm::end(); ?>
        
    </table>
</div>

<hr>
<p><i>*Aspek Annual Practicing Certificate Renewal (APC - MMC) hanya boleh diisi oleh PPP sahaja.</i></p>