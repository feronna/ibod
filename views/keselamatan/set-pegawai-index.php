
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
                <h2><strong><i class="fa fa-list"></i>Senarai Set Pegawai</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Anggota Icno</th>
                                <th class="text-center">Peraku Icno</th>
                                <th class="text-center">Pelulus Icno</th>
                                <th class="text-center">Kampus</th>
                             
                            </tr>
                        </thead>
                        <?php foreach ($model as $models) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->anggota->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->peraku->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->pelulus->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->camp->campus_name ?></td>
 

                            </tr>
                        <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
