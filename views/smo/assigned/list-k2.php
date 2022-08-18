<?php

use yii\helpers\Html;

?>

<?= Yii::$app->controller->renderPartial('/smo/_menu'); ?>

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
                            <th class="text-center">BIL</th>
                            <th class="text-center">ASPEK PENILAIAN</th>
                            <th class="text-center">KRITERIA</th>
                            <th class="text-center">PENILAI</th>
                            <th class="text-center">TARIKH / MASA</th>
                            <th class="text-center">TINDAKAN</th>
                        </tr>
                    </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><strong><?= $v->bhgnRel->bahagian ?></strong></td>
                                <td><strong><?= $v->kriteriaRel->kriteria_label ?></strong></td>
                                <td><strong><?= $v->ppBio->CONm; ?></strong></td>
                                <td class="text-center"><strong><?= $v->create_dt; ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong> <?= Html::a('<i class="fa fa-pencil"></i>', ['tindakan-k2', 'key' => hash('sha256', $v->id)]) ?></strong></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="align-center text-center"><i>Tiada tindakan buat masa ini</i></td>
                        </tr>
                    <?php } ?>
                </table>


            </div>
        </div>
    </div>
</div>