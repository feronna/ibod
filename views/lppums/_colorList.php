<?php

use app\models\kehadiran\TblWarnaKad;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-bar-chart"></i>&nbsp;Card Color Summary <?= $lpp->tahun ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="text-align:right;width:30%">CARD COLOR</th>
                            <th class="text-center">YELLOW</th>
                            <th class="text-center">GREEN</th>
                            <th class="text-center">RED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" style="text-align:right;font-weight:bold">TOTAL</td>
                            <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($lpp->tahun, $lpp->PYD, 'YELLOW') ?></td>
                            <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($lpp->tahun, $lpp->PYD, 'GREEN') ?></td>
                            <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($lpp->tahun, $lpp->PYD, 'RED') ?></td>
                        </tr>
                        <tr>
                            <td class="text-center" style="text-align:right;font-weight:bold;background-color:bisque">PERFORMANCE INDICATOR</td>
                            <td colspan="3" class="text-center" style="text-align:left;font-weight:bold;background-color:bisque"><?= TblWarnaKad::prestasiWarnaKad($lpp->tahun, $lpp->PYD) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>