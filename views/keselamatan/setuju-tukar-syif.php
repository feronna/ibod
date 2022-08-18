
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\keselamatan\cuti;
use app\widgets\TopMenuWidget;
// as a widget
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Permohonan Tukar Syif</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Pemohon</th>
                                <th class="text-center">Tarikh Dipohon</th>
                                <th class="text-center">Syif Anda</th>
                                <th class="text-center">Syif Yang Dipohon</th>
                                <th class="text-center">Catatan Permohonan</th>
                                <th class="text-center">Status Perakuan Penganti</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <?php foreach ($model as $models) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->pemohon->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->formattarikh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->shifts->jenis_shifts ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->currshift->jenis_shifts ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->alasan_penukaran ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->status ?></td>
                                <td class="text-center"  style="text-align:center"><?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to(['keselamatan/setuju-penukaran-syif', 'id' => $models->id]), 'class' => 'mapBtn', 'id' => 'modalButton']) ?></td>



                            </tr>
                        <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
