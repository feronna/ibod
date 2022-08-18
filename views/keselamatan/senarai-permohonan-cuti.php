
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
                <h2><strong><i class="fa fa-list"></i> Senarai Cuti Yang Belum Diambil Tindakan</strong></h2>

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
                                <!--<th class="text-center">Status Perakuan Peraku</th>-->
                                <th class="text-center">Status Perakuan Pelulus</th>
                            </tr>
                        </thead>
                        <?php foreach ($model2 as $models2) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models2->tarikh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models2->cuti_tempoh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models2->cuti_catatan ?></td>
<!--                                <td class="text-center"  style="text-align:center"><?= $models2->statusperaku ?></td>-->
                                <td class="text-center"  style="text-align:center"><?= $models2->statusLulus ?></td>

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
                <h2><strong><i class="fa fa-list"></i> Senarai Cuti </strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
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
                                <td class="text-center"  style="text-align:center"><?= $models->tarikh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->cuti_tempoh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->cuti_catatan ?></td>
                                <td class="text-center"  style="text-align:center"><?php if($models->statusLulus == "-"){echo "Tidak Diluluskan";}else{echo $models->statusLulus;}?></td>

                            </tr>
                        <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
