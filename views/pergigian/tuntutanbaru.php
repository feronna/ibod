<?php

use yii\helpers\Html;
?>

<div class="col-md-12">
<?php echo $this->render('/pergigian/_menu'); ?> 
</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Tuntutan Rawatan Pergigian</strong></h2>
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
                <thead>
                <tr>
                    <th class="text-center">BIL</th>
                    <th class="text-center">NAMA KLINIK</th>
                    <th class="text-center">TARIKH RAWATAN</th>
                    <th class="text-center">JUMLAH TUNTUTAN</th>
                    <th class="text-center">STATUS SEMAKAN</th>
                    <th class="text-center">STATUS KELULUSAN</th>
                    <th class="text-center">TARIKH TUNTUT</th>
                    <th class="text-center">Tindakan</th>
                </tr>
                </thead>
                <?php $bil=1;
                if ($ver) { ?>
                    <?php foreach ($ver as $v_list) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $v_list->kakitangan->CONm; ?></td>
                            <td class="text-center"><?php echo $v_list->kakitangan->jawatan->nama; ?></td>
                            <td class="text-center"><?php echo $v_list->kakitangan->department->shortname; ?></td>
                            <td class="text-center"><?php echo $v_list->kakitangan->startDateLantik; ?></td>
                            <td class="text-center"><?php echo $v_list->kakitangan->endDateLantik; ?></td>
                            <td class="text-center"><?php echo $v_list->tarikh_m; ?></td>
                            <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_pp", 'id' => $v_list->id]); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Menunggu Perakuan</strong></h2>
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
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">Jawatan</th>
                    <th class="text-center">JFPIU</th>
                    <th class="text-center">Tarikh Mula Kontrak</th>
                    <th class="text-center">Tarikh Tamat Kontrak</th>
                    <th class="text-center">Tarikh Mohon</th>
                    <th class="text-center">Tindakan</th>
                </tr>
                <?php $bils=1;
                if ($app) { ?>
                    <?php foreach ($app as $a_list) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $a_list->kakitangan->CONm; ?></td>
                            <td class="text-center"><?php echo $a_list->kakitangan->jawatan->nama; ?></td>
                            <td class="text-center"><?php echo $a_list->kakitangan->department->shortname; ?></td>
                            <td class="text-center"><?php echo $a_list->kakitangan->startDateLantik; ?></td>
                            <td class="text-center"><?php echo $a_list->kakitangan->endDateLantik; ?></td>
                            <td class="text-center"><?php echo $a_list->tarikh_m; ?></td>
                            <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_jfpiu", 'id' => $a_list->id]); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
        </div>
    </div>
</div>


