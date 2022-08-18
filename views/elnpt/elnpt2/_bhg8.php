<?php

use kartik\dialog\Dialog;

$js = <<< JS
$("#btn-alert").on("click", function() {
    krajeeDialog.alert("Data berjaya disimpan!")
});
JS;

// register your javascript
$this->registerJs($js);
echo Dialog::widget();

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);
?>

<?php
//echo Alert::widget([
//    'options' => ['class' => 'alert-warning'],
//    'body' => '<font color="black">
//                    <strong>INFO</strong><br>
//                    <p>
//                        Bagi Persidangan & Inovasi, PPP & PPK tidak perlu membuat pemarkahan. Markah yang di bahagian ini mengambil kira markah yang telah auto-generated.
//                    </p>
//                </font>',
//]);
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center">BIL.</th>
            <th class="text-center">KATEGORI HARTA INTELEK</th>
            <th class="text-center">NAMA PROJEK</th>
            <th class="text-center">PERANAN</th>
            <th class="text-center">TAHAP PENYERTAAN</th>
            <th class="text-center">BIL. PENERIMA IMPAK</th>
            <th class="text-center">AMAUN PROJEK</th>
            <th class="text-center">DOKUMEN SOKONGAN</th>
        </tr>
        <?php if (empty($data)) { ?>
            <tr>
                <td colspan="8">Tiada rekod dijumpai.</td>
            </tr>
            <?php } else {
            foreach ($data as $ind => $dt) { ?>
                <tr>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
                                                                                                    // or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                                                                                                ) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-inovasi', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-inovasi', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                        <?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                    <td class="col-md-3 text-center" style="text-align:center"><?= $dt['Bilangan_Persidangan_dan_Inovasi']; ?></td>
                    <td class="col-md-5"><?= $dt['ConferenceTitle']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Peranan_dalam_projek_Inovasi']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Tahap_penyertaan']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Bilangan_individu']; ?></td>
                    <td class="col-md-1 text-center"><?= 'RM ' . $dt['Julat_amaun']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?= (strlen($dt['file_hash']) == 0 && !is_null($dt['file_hash'])) ? 'SYSTEM' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(['elnpt2/view-file', 'hashfile' => $dt['file_hash'], 'lppid' => $lppid]), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' ?>
                        <?php
                        echo $this->render('_verifyPPP', [
                            'ind' => $ind,
                            'lpp' => $lpp,
                            'check' => $check,
                            'lppid' => $lppid,
                            'file_hash' => $dt['file_hash'],
                            'ver_by' => $dt['ver_by'],
                        ]);
                        ?>
                    </td>
                </tr>
        <?php }
        } ?>
    </table>
</div>


<div style="clear: both;" class="form-group pull-right">
    <?= ($lpp->PYD == Yii::$app->user->identity->ICNO ? !$check : false) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'id' => 'btn-alert']) : '' ?>
</div>
<br>
<br>
<hr>