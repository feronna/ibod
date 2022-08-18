<?php

use yii\helpers\Html;
?>

<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li>Senarai Permohonan Keluar Pejabat</li>
    </ol>
</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Keluar Pejabat</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">UMSPER</th>
                    <th class="text-center">Nama Kakitangan</th>
                    <th class="text-center">Mohon Pada</th>
                    <th class="text-center">Hantar Pada</th>
                    <th class="text-center">Lulus Pada</th>
                    <th class="text-center">Tujuan</th>
                    <th class="text-center">Keluar Mula</th>
                    <th class="text-center">Keluar Hingga</th>
                    <th class="text-center">Status </th>
                    <th class="text-center">Status Dtl</th>
                </tr>
                <?php foreach ($model as $rows) { ?>
                    <tr>
                        <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                        <td class="text-center"><?php echo $rows->NoPer; ?></td>
                        <td class="text-center"><?php echo $rows->StaffName; ?></td>
                        <td class="text-center"><?php echo $rows->AppliedDate; ?></td>
                        <td class="text-center"><?php echo $rows->DateSubmitted; ?></td>
                        <td class="text-center"><?php echo $rows->ApprovedDate; ?></td>
                        <td class="text-center"><?php echo $rows->Name; ?></td>
                        <td class="text-center"><?php echo $rows->OutstationDateTimeStart; ?></td>
                        <td class="text-center"><?php echo $rows->OutstationDateTimeEnd; ?></td>
                        <td class="text-center"><?php echo $rows->StatusShtName; ?></td>
                        <td class="text-center"><?php echo $rows->StatusLgName; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>