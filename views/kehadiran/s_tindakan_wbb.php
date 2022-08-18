<?php

use yii\helpers\Html;
?>

<!--<div class="col-xs-12 col-md-12 col-lg-12"> 
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li>Senarai kakitangan WBB</li>
    </ol>
</div>-->

<div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Menunggu Perakuan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th class="text-center">Bil</th>
                        <th class="text-center">Nama Kakitangan</th>
                        <th class="text-center">Tindakan Perakuan</th>
                    </tr>
                    <?php if ($ver) { ?>
                        <?php foreach ($ver as $v_list) { ?>
                            <tr>
                                <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                <td class="text-center"><?php echo $v_list->kakitangan->CONm; ?></td>
                                <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["kehadiran/tindakan_wbb_peraku", 'id' => $v_list->id]); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Menunggu Kelulusan</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th class="text-center">Bil</th>
                        <th class="text-center">Nama Kakitangan</th>
                        <th class="text-center">Tindakan Perakuan</th>
                    </tr>
                    <?php if ($app) { ?>
                        <?php foreach ($app as $a_list) { ?>
                            <tr>
                                <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                <td class="text-center"><?php echo $a_list->kakitangan->CONm; ?></td>
                                <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["kehadiran/tindakan_wbb_lulus", 'id' => $a_list->id]); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div> 
    </div>
</div>


