
<?php

use yii\helpers\Html;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">

    <div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Kesalahan Anggota (Rollcall)</strong></h2>
                <ul class="nav navbar-right panel_toolbox collapse">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style = "background-color: navy; color: white;">
                            <tr class="headings">
                                <th class="column-title">Bil </th>
                                <th class="column-title">Tarikh Kesalahan</th>
                                <th class="column-title">Jadual</th>
                                <th class="column-title">Syif</th>
                                <th class="column-title">THTC</th>
                                <th class="column-title">THBH</th>
                                <th class="column-title">THH</th>
                                <th class="column-title">THBLMJ</th>
                                <th class="column-title">THBLMT</th>
                                <th class="column-title">THBKWLN</th>
                                <th class="column-title">THLMJ</th>
                                <th class="column-title">THLMT</th>
                                <th class="column-title">THKWLN</th>
                                <!--<th class="column-title">GMK</th>-->
                                <!--<th class="column-title">Lain-Lain</th>-->
                                <!--<th class="column-title">Remark</th>-->
                                <th class="column-title">Status Catatan</th>
                                <th class="column-title">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model as $models) { ?>
                                <tr>
                                    <td><?= $bil++; ?></td>
                                    <td><?= $models->formatdate; ?></td>

                                    <td class="text-center"><?= $models->jadual; ?></td>
                                    <td class="text-center"><?= $models->syif; ?></td>
                                    <td class="text-center"><?= $models->THTC; ?></td>
                                    <td class="text-center"><?= $models->THBH; ?></td>
                                    <td class="text-center"><?= $models->THH; ?></td>
                                    <td class="text-center"><?= $models->THBLMJ; ?></td>
                                    <td class="text-center"><?= $models->THBLMT; ?></td>
                                    <td class="text-center"><?= $models->THBKWLN; ?></td>
                                    <td class="text-center"><?= $models->THLMJ; ?></td>
                                    <td class="text-center"><?= $models->THLMT; ?></td>
                                    <td class="text-center"><?= $models->THKWLN; ?></td>
                                    <td class="text-center"><?= $models->stat; ?></td>

                                    <?php if ($models->status == 'APPROVED' || $models->status == 'REJECTED' || $models->status == 'REMARKED') { ?> 
                                        <td class="text-center"></td>

                                    <?php } else { ?>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-pencil"></i>', ['keselamatan/remark-kesalahan', 'id' => $models->id], ['class' => '']) ?></td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div><h4><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rujukan </h4></strong></div>
                    <ul>
                        <li><span class="label label-success">THTC</span> : Tidak Hadir Tanpa Cuti</li>
                        <li><span class="label label-success">THBH</span> : Tidak Hadir Baris Hakiki</li>
                        <li><span class="label label-success">THH</span> : Tidak Hadir Hakiki </li>
                        <li><span class="label label-success">THBLMJ</span> : Tidak Hadir Baris Lebihan Masa Jadual</li>
                        <li><span class="label label-success">THBLMT</span> : Tidak Hadir Baris Lebihan Masa Tambahan</li>
                        <li><span class="label label-success">THBKWLN</span> : Tidak Hadir Baris Kawalan</li>
                        <li><span class="label label-success">THLMJ</span> : Tidak Hadir Lebihan Masa Jadual</li>
                        <li><span class="label label-success">THLMT</span> : Tidak Hadir Lebihan Masa Tambahan</li>
                        <li><span class="label label-success">THKWLN</span> : Tidak Hadir Kawalan</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
       
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>

