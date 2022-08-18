
<?php

use yii\helpers\Html;
use app\models\keselamatan\cuti;
use app\widgets\TopMenuWidget;
// as a widget
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Status Permohonan Penukaran Syif</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Tarikh</th>
                                <th class="text-center">Syif Dipohon</th>
                                <th class="text-center">Syif Sekarang</th>
                                <th class="text-center">Catatan Permohonan</th>
                                <th class="text-center">Penganti</th>
                                <th class="text-center">Status Perakuan Penganti</th>
                                <th class="text-center">Status Perakuan Pelulus</th>
                                <th class="text-center">Catatan Pelulus</th>
                            </tr>
                        </thead>
                        <?php foreach ($model as $models) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->formattarikh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->shifts->jenis_shifts ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->currshift->jenis_shifts ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->alasan_penukaran ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->penganti->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->status ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->statuslulus ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->catatan_pelulus ?></td>


                            </tr>
                        <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
