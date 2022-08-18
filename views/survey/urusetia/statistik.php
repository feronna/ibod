<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center">Bil</th>
                            <th class="text-center">Nama Aktiviti</th>
                            <th class="text-center">Tarikh Survey</th>
                            <th class="text-center">Survey Tamat</th>
                            <th class="text-center">Jumlah Pengundi</th>
                            <th class="text-center">Telah undi</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><strong><?= $v->nama ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $v->tarikhMula ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $v->tarikhTamat ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $v->totalVoters ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $v->totalVoted ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $v->peratusUndi ?></strong></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="align-center text-center"><i>No Record Found!</i></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>