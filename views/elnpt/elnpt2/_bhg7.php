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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center">BIL.</th>
            <th class="text-center">KATEGORI JAWATANKUASA</th>
            <th class="text-center">NAMA JAWATANKUASA</th>
            <th class="text-center">PERANAN</th>
            <th class="text-center">TAHAP LANTIKAN</th>
            <th class="text-center">DOKUMEN SOKONGAN</th>
        </tr>
        <?php if (empty($data)) { ?>
            <tr>
                <td colspan="5">Tiada rekod dijumpai.</td>
            </tr>
            <?php } else {
            foreach ($data as $ind => $dt) { ?>
                <tr>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
                                                                                                    // or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                                                                                                ) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-urus-tadbir', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-urus-tadbir', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                        <?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                    <td class="col-md-2 text-center" style="text-align:center"><?= $dt['Bilangan_jawatankuasa']; ?></td>
                    <td class="col-md-2 "><?= $dt['nama_jawatan']; ?></td>
                    <td class="col-md-1 text-center"><?= !isset($dt['Peranan_jawatankuasa']) ? '(not set)' : $dt['Peranan_jawatankuasa']; ?></td>
                    <td class="col-md-1 text-center"><?= !isset($dt['Tahap_jawatankuasa']) ? '(not set)' : $dt['Tahap_jawatankuasa']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ((strlen($dt['file_hash']) == 0 && !is_null($dt['file_hash']))) {
                            echo 'SYSTEM';
                        } else {
                            try {
                                echo  Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(['elnpt2/view-file', 'hashfile' => $dt['file_hash'], 'lppid' => $lppid]), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' .  $this->render('_verifyPPP', [
                                    'ind' => $ind,
                                    'lpp' => $lpp,
                                    'check' => $check,
                                    'lppid' => $lppid,
                                    'file_hash' => $dt['file_hash'],
                                    'ver_by' => $dt['ver_by'],
                                ]);
                            } catch (Exception $e) {
                                echo '<font color="orange">Error fetching file!</font>';
                            }
                        } ?>
                    </td>
                </tr>
        <?php }
        } ?>
    </table>
</div>


<div style="clear: both;" class="form-group pull-right">
    <?= ($lpp->PYD == Yii::$app->user->identity->ICNO ? !$check : false) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'id' => 'btn-alert']) : '' ?>
</div>

<div style="clear: both;"><br>
    <hr>
    <?php if (($lpp->PPP == Yii::$app->user->identity->ICNO) or ($lpp->PPK == Yii::$app->user->identity->ICNO)) { ?>
        <p><i>* Jawatankuasa yang ditambah secara manual oleh PYD.</i></p>
    <?php } ?>
</div>