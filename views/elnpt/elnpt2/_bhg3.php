<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$js = <<< JS
$("#btn-alert").on("click", function() {
    krajeeDialog.alert("Data berjaya disimpan!")
});
JS;

// register your javascript
$this->registerJs($js);

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\dialog\Dialog;

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);

$tahun = app\models\elnpt\TblLppTahun::findOne(['lpp_tahun' => $lpp->tahun]);

$grant = app\models\elnpt\TblGrantApplication::find()
    ->where(['UserIC' => $lpp->PYD, 'tahun' => $lpp->tahun])
    ->count();
$sum = 0;
echo Dialog::widget();
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center">BIL.</th>
            <th class="text-center">PROJEK ID</th>
            <th class="text-center col-md-4">TAJUK PROJEK</th>
            <th class="text-center">PERANAN</th>
            <th class="text-center col-md-2">PEMBIAYA</th>
            <th class="text-center col-md-2">KATEGORI PEMBIAYA</th>
            <th class="text-center col-md-2">JUMLAH BIAYA (RM)</th>
            <th class="text-center">MULA</th>
            <th class="text-center">TAMAT</th>
            <th class="text-center">STATUS</th>
            <th class="text-center">DOKUMEN SOKONGAN</th>
        </tr>
        <?php if (empty($data)) { ?>
            <tr>
                <td colspan="10">Tiada rekod dijumpai.</td>
            </tr>
            <?php } else {
            foreach ($data as $ind => $dt) { ?>
                <tr>
                    <td class="col-md-2 text-center" style="text-align:center">
                        <?= $ind + 1; ?>
                        <?= ($dt['Display'] == 1 && $lpp->PYD == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                            or ($dt['Display'] == 1 and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                    </td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['ProjectID']; ?></td>
                    <td class="col-md-2"><?= $dt['Title']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Peranan']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['AgencyName']; ?></td>
                    <td class="col-md-3 text-center"><?php
                                                        switch ($dt['Tahap_geran']):
                                                            case '1':
                                                                echo 'GERAN UNIVERSITI';
                                                                break;
                                                            case '2':
                                                                echo 'GERAN LUAR (TEMPATAN)';
                                                                break;
                                                            case '3':
                                                                echo 'GERAN LUAR (ANTARABANGSA)';
                                                                break;
                                                            default:
                                                                echo $dt['Tahap_geran'];
                                                                break;
                                                        endswitch;
                                                        ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= is_null($dt['Amount']) ? 'RM 0' : Yii::$app->formatter->asCurrency($dt['Amount'], 'RM '); ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDate($dt['StartDate'], 'yyyy'); ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDate($dt['EndDate'], 'yyyy'); ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_geran']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?= (strlen($dt['file_hash']) == 0 && !is_null($dt['file_hash'])) ? 'SYSTEM' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(['elnpt2/view-file', 'hashfile' => $dt['file_hash'], 'lppid' => $lppid]), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' . Html::checkbox('agree', !empty($dt['ver_by']) ? true : false, [
                            'label' => 'Verify',
                            'onclick' => "
                                            $.ajax({
                                                type: 'POST',
                                                url: '" . Url::to(['elnpt2/verify-document', 'lppid' => $lppid, 'filehash' => $dt['file_hash']]) . "',

                                                success: function(result) {
                                                    if(result == 1) {
                                                            setTimeout(function(){
                                                            location.reload(); // then reload the page.(3)
                                                        }, 1); 
                                                    } else {
                                                    }
                                                }, 
                                                error: function(result) {
                                                    console.log(\"Ada Error\");
                                                }
                                            });
                                        ",

                        ]); ?>
                    </td>
                </tr>
        <?php

                $sum += $dt['Amount'];
            }
        } ?>
        <tr>
            <th colspan="7" style="text-align:right">Jumlah Geran</th>
            <td style="text-align:center"><?= Yii::$app->formatter->asDecimal($sum); ?></td>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </table>
</div>

<p><b>* Bilangan Permohonan : </b><?= $grant; ?>

    <br>
<div style="clear: both;" class="form-group pull-right">
    <?= ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'id' => 'btn-alert']) : '' ?>
</div>
</p>
<br><br>
<hr>
<p><i>* Nota : Hanya permohonan berstatus <strong>VERIFIED</strong> sahaja diambil kira dalam penilaian. Sila berhubung dengan pihak PPPI berkenaan dengan status permohonan anda.</i></p>