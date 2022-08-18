<?php

use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
use app\models\keselamatan\TblRekod;
use app\models\kehadiran\TblWp;
?>
<div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Ketidakpatuhan yang belum diberi Catatan/Alasan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">Bil</th>
                            <th class="text-center">Tarikh</th>
                            <th class="text-center">Masa Masuk</th>
                            <th class="text-center">Masa Keluar</th>
                            <th class="text-center">Status Ketidakpatuhan</th>
                            <th class="text-center">Alasan/Catatan</th>
                        </tr>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->formatTarikh ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->formatTimeIn ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->formatTimeOut ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->statusAll ?></td>
                                    <td class="text-center"  style="text-align:center"><?= Html::a('<i class="fa fa-pencil"></i> REMARK', ['keselamatan/remark', 'id' => $senarai->id], ['class' => 'btn btn-primary btn-sm']) ?></td>

                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                        <?php if ($model1) { ?>
                            <?php foreach ($model1 as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->formatTarikh ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->formatTimeIn ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->formatTimeOut ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $senarai->statusAllOt ?></td>
                                    <td class="text-center"  style="text-align:center"><?= Html::a('<i class="fa fa-pencil"></i> REMARK', ['keselamatan/remark-ot', 'id' => $senarai->id], ['class' => 'btn btn-primary btn-sm']) ?></td>

                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
