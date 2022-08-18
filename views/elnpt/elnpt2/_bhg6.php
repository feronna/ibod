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
            <th class="text-center">KATEGORI PERUNDINGAN</th>
            <th class="text-center">NAMA PROJEK/AKTIVITI</th>
            <th class="text-center">PERANAN</th>
            <th class="text-center">TAHAP PENYERTAAN</th>
            <th class="text-center">AMAUN GERAN</th>
            <th class="text-center">DOKUMEN SOKONGAN</th>
        </tr>
        <?php if (empty($data)) { ?>
            <tr>
                <td colspan="7">Tiada rekod dijumpai.</td>
            </tr>
            <?php } else {
            foreach ($data as $ind => $dt) { ?>
                <tr>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
                                                                                                    // or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  
                                                                                                    // // and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)
                                                                                                    // )
                                                                                                ) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                        <?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Bilangan_outreaching']; ?></td>
                    <td class="col-md-2 "><?= $dt['Title']; ?></td>
                    <td class="col-md-2 text-center"><?= $dt['Peranan_outreaching']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Tahap_outreaching']; ?></td>
                    <td class="col-md-1 text-center"><?= is_numeric($dt['Amaun_outreaching']) ? Yii::$app->formatter->asCurrency($dt['Amaun_outreaching'], 'RM ') : $dt['Amaun_outreaching']; ?></td>
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

<div style="clear: both;"><br>
    <hr>
    <?php if (($lpp->PPP == Yii::$app->user->identity->ICNO) or ($lpp->PPK == Yii::$app->user->identity->ICNO)) { ?>
        <p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
    <?php } ?>
</div>