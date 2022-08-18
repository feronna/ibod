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
                            <th class="text-center">JFPIB</th>
                            <th class="text-center">Jawatan</th>
                            <th class="text-center">Tarikh/Masa</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Perincian</th>
                            <th class="text-center">Keputusan</th>
                            <th class="text-center">Status Pengundi</th>
                        </tr>
                    </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><strong><?= $v->nama ?></strong></td>
                                <td><strong><?= $v->jfpib->fullname ?></strong></td>
                                <td><strong><?= $v->adminPosition->position_name ?></strong></td>
                                <td><strong><?= $v->full_date ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $v->statusText ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong> <?= Html::a('<i class="fa fa-eye"></i>', ['perincian-aktiviti', 'id' => $v->id]) ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong> <?= Html::a('<i class="fa fa-bar-chart"></i>', ['result', 'id' => $v->id]) ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong> <?= Html::a('<i class="fa fa-list"></i>', ['status-pengundi', 'id' => $v->id]) ?></strong></td>
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