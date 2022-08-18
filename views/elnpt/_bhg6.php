<?php

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
        </tr>
        <?php if(empty($data)) { ?>
        <tr>
            <td colspan="6">Tiada rekod dijumpai.</td>
        </tr>
        <?php }else{
          foreach ($data as $ind => $dt) {?>
                <tr>
                    <td class="col-md-1 text-center"  style="text-align:center"><?= $ind+1 ?> <?= ($dt['id'] != '0' && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0 AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                  or ($dt['id'] != '0' AND $lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']).Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                    <?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                    <td class="col-md-1 text-center"  style="text-align:center"><?= $dt['Bilangan_outreaching']; ?></td>
                    <td class="col-md-2 " ><?= $dt['Title']; ?></td>
                    <td class="col-md-2 text-center"><?= $dt['Peranan_outreaching']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Tahap_outreaching']; ?></td>
                    <td class="col-md-1 text-center"><?= is_numeric($dt['Amaun_outreaching']) ? Yii::$app->formatter->asCurrency($dt['Amaun_outreaching'], 'RM ') : $dt['Amaun_outreaching']; ?></td>
                </tr>
          <?php }} ?>           
    </table>
</div>

<div style="clear: both;"><br><hr>
            <?php if(($lpp->PPP == Yii::$app->user->identity->ICNO) OR ($lpp->PPK == Yii::$app->user->identity->ICNO)) { ?>
            <p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
            <?php } ?></div>