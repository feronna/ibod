<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
use dosamigos\datepicker\DatePicker;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\models\keselamatan\TblshiftKeselamatan;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblLmt;
use app\models\keselamatan\RefShifts;
?>
<?=
\app\widgets\TopMenuWidget::widget(['top_menu' => [61, 67], 'vars' => [
        ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId()),
//        'items' => [
//                                            [
//                                                'label' =>app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())
//                                            ],
//                                        ],]
]]);
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-calendar"></i>&nbsp; Jadual Penugasan Bulanan BKUMS (<?= TblRekod::viewBulan($bulan) . ' ' . $tahun ?>)</strong></h2>

                <div class="clearfix"></div>
            </div>
           
             <div class="x_content">

                <div class="table-responsive">
                    <table style="font-size: 11px" class="table table-striped table-sm jambo_table table-bordered table-condensed">
                        <thead>
                            <tr class="headings">
                                <th class="text-center" rowspan="2">UMSPER</th>
                                <th class="text-center">DAYS</th>
                                <th class="text-center"> KP/PKP</th>

                                <?php foreach ($var as $k => $v) { ?>
                                    <th class="text-center kv-align-middle"><?= $v ?></th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tr>
                            <td class="text-center kv-align-middle">#</td>
                            <td class="text-center">NAME</td>
                            <td class="text-center"> </td>
                            <?php foreach ($day as $k => $v) { ?>
                                <th class="text-center kv-align-middle"><?= $v ?></th>
                            <?php } ?>
                        </tr>
                        <?php foreach ($staffs as $staff) { ?>
                            <tr>
                                <td class="text-center kv-align-middle"><?= $staff->staff->COOldID ?></td>
                                <td class="text-left"><?= $staff->staff->CONm ?></td>
                                <td class="text-left"><?= $staff->kp ?></td>

                                <?php foreach ($var as $k => $v) { ?>
                                    <td class="text-center kv-align-middle"><?= TblshiftKeselamatan::viewShift($staff->staff_icno, "$tahun-$bulan-$v") ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>  
   