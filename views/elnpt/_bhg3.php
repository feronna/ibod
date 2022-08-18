<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;
$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);

$grant = app\models\elnpt\TblGrantApplication::find()
                ->where(['UserIC' => $lpp->PYD, 'tahun' => $lpp->tahun])
                ->count();
$sum = 0;
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
        </tr>
        <?php if(empty($data)) { ?>
        <tr>
            <td colspan="10">Tiada rekod dijumpai.</td>
        </tr>
        <?php }else{ 
            foreach ($data as $ind => $dt) { ?>
        <tr>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $ind+1; ?> <?= ($dt['Display'] == 1 && $lpp->PYD == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 0 AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                    or ($dt['Display'] == 1 AND $lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']).Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
            <?= ($dt['Display'] == 1 && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
        <td class="col-md-1 text-center"  style="text-align:center"><?= $dt['ProjectID']; ?></td>
            <td class="col-md-2"  ><?= $dt['Title']; ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $dt['Peranan']; ?></td>
            <td class="col-md-1 text-center"><?= $dt['AgencyName']; ?></td>
            <td class="col-md-3 text-center"><?php 
            switch($dt['Tahap_geran']):
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
            <td class="col-md-1 text-center"  style="text-align:center"><?= is_null($dt['Amount']) ? 'RM 0' : Yii::$app->formatter->asCurrency($dt['Amount'], 'RM '); ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= Yii::$app->formatter->asDate($dt['StartDate'], 'yyyy'); ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= Yii::$app->formatter->asDate($dt['EndDate'], 'yyyy'); ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $dt['Status_geran']; ?></td>
        </tr>
        <?php 
        
        $sum += $dt['Amount'];
            }} ?>
        <tr>
            <th colspan="6" style="text-align:right">Jumlah Geran</th>
            <th style="text-align:center"><?=  Yii::$app->formatter->asDecimal($sum); ?></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </table>
</div>

<p><b>Bilangan Permohonan : </b><?= $grant; ?></p>

<div style="clear: both;"><br><hr>
            <?php if(($lpp->PPP == Yii::$app->user->identity->ICNO) OR ($lpp->PPK == Yii::$app->user->identity->ICNO)) { ?>
            <p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
            <?php } ?></div>