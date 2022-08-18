
<?php

use yii\helpers\Html;
use app\models\keselamatan\cuti;

// as a widget
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Rekod Permohonan Cuti Anggota </strong></h2>

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
                                <th class="text-center">Tempoh</th>
                                <th class="text-center">Catatan</th>
                                <th class="text-center">Status Perakuan</th>
                            </tr>
                        </thead>
<?php foreach ($model as $models) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->tarikh?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->cuti_tempoh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->cuti_catatan ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->statusperaku ?></td>

                            </tr>
<?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
