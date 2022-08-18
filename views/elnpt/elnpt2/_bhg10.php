<?php

use yii\bootstrap\Alert;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\kehadiran\TblRekod;
use app\models\elnpt\TblMain;

$lpp = TblMain::findOne(['lpp_id' => $lppid]);

$late = TblRekod::find()
    ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'late_in' => 1])
    ->andWhere(['!=', 'remark_status', 'APPROVED'])
    ->count();

$absent = TblRekod::find()
    ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'absent' => 1])
    ->andWhere(['!=', 'remark_status', 'APPROVED'])
    ->count();
?>

<?= Alert::widget([
    'options' => ['class' => 'alert-warning'],
    'body' => '<font color="black">
                    <strong>INFO</strong><br>
                    <p>
                        Bahagian ini tidak perlu diisi oleh PYD / Guru. Markah akan diperolehi selepas PPP, PPK dan PEER membuat penilaian.
                    </p>
                </font>',
]); ?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center" rowspan="2">BIL.</th>
            <th class="text-center" rowspan="2">KATEGORI KUALITI</th>
            <th class="text-center" colspan="3">SUMBER INPUT</th>
        </tr>
        <tr>
            <th class="text-center">PPP <sub>/ 100%</sub></th>
            <th class="text-center">PPK <sub>/ 100%</sub></th>
            <th class="text-center">PEER <sub>/ 100%</sub></th>
        </tr>
        <?php
        $abc = 1;
        $form = ActiveForm::begin();
        foreach ($input as $ind => $inp) { ?>
            <tr>
                <td class="col-md-1 text-center" style="text-align:center"><?= $abc ?></td>
                <td><?= $data[$inp->ref_kualiti_id]['desc']; ?></td>
                <td class="col-md-1 text-center"><?= (($lpp->PPP != Yii::$app->user->identity->ICNO)) ? 'PPP' : $form->field($inp, "[$ind]markah_ppp")->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'step' => '0.01', 'style' => 'text-align:center', 'placeholder' => '0.0', 'disabled' => $check])->label(false) ?></td>
                <td class="col-md-1 text-center"><?= (($lpp->PPK != Yii::$app->user->identity->ICNO)) ? 'PPK' : $form->field($inp, "[$ind]markah_ppk")->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'step' => '0.01', 'style' => 'text-align:center', 'placeholder' => '0.0', 'disabled' => (($lpp->PPP == Yii::$app->user->identity->ICNO) && ($lpp->PPK_sah == 0)) ? false : $check])->label(false) ?></td>
                <td class="col-md-1 text-center"><?= (($lpp->PEER != Yii::$app->user->identity->ICNO)) ? 'PEER' : $form->field($inp, "[$ind]markah_peer")->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'step' => '0.01', 'style' => 'text-align:center', 'placeholder' => '0.0', 'disabled' => $check])->label(false) ?></td>
            </tr>
        <?php
            $abc++;
        } ?>

    </table>

    <dl class="dl-horizontal">
        <dt>Late In</dt>
        <dd><?= $late; ?> day(s)</dd>
        <dt>Absent</dt>
        <dd><?= $absent; ?> day(s)</dd>
        <dt></dt>
        <dd><i>*Taken from STARS Attendance Report</i></dd>
    </dl>

    <?php
    // if(
    //         ($lpp->PPP == Yii::$app->user->identity->ICNO AND (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat) AND ($lpp->PPP_sah == 0)) 
    //         OR ($lpp->PPK == Yii::$app->user->identity->ICNO AND (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat) AND ($lpp->PPK_sah == 0)) 
    //         OR ($lpp->PEER == Yii::$app->user->identity->ICNO AND (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat) AND ($lpp->PEER_sah == 0))
    //         ) { 
    ?>
    <div style="clear: both;" class="form-group pull-right">
        <?= ((($lpp->PPP == Yii::$app->user->identity->ICNO) || ($lpp->PPK == Yii::$app->user->identity->ICNO) || ($lpp->PEER == Yii::$app->user->identity->ICNO)) ? ((($lpp->PPP == Yii::$app->user->identity->ICNO) && ($lpp->PPK_sah == 0)) ? true : !$check) : false) ? Html::submitButton('Submit', ['class' => 'btn btn-primary', 'value' => 'create_add', 'name' => 'submit']) : '' ?>
    </div>
    <?php //} 
    ?>

    <?php ActiveForm::end(); ?>

</div>
<hr>