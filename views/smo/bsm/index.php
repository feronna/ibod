<?php

use yii\helpers\Html;

?>

<?= Yii::$app->controller->renderPartial('/adu/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
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
                            <th class="text-center">Tajuk Aduan</th>
                            <th class="text-center">Nama Pengadu</th>
                            <th class="text-center">Tarikh/Masa Aduan</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><strong><?= $v->title ?></strong></td>
                                <td><strong><?= $v->staffBio->CONm; ?></strong></td>
                                <td><strong><?= $v->complaint_dt; ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong> <?= Html::a('<i class="fa fa-pencil"></i>', ['tindakan-bsm', 'key' => hash('sha256', $v->id)]) ?></strong></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="align-center text-center"><i>Tidak ada aktiviti buat masa ini!</i></td>
                        </tr>
                    <?php } ?>
                </table>


            </div>
        </div>
    </div>
</div>