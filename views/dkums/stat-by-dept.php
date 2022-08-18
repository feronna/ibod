<?php

use app\models\dkums\TblMain;
use app\models\UtilitiesFunc;
use yii\helpers\ArrayHelper;
use app\models\dkums\YearSettings;
use yii\helpers\Html;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i> Search</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= Html::beginForm(['stat-by-dept'], 'GET', ['class' => 'form-horizontal form-label-left disable-submit-buttons']); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?= Html::dropDownList('GetTahun', $tahun, ArrayHelper::map(YearSettings::find()->all(), 'tahun', 'tahun'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Fasa</label>
                <div class="col-md-1 col-sm-1 col-xs-12">
                    <?= Html::dropDownList('GetFasa', $fasa,[1 => 1, 2 => 2], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                </div>
            </div>
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<i class="fa fa-search"></i> Carian', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?= Html::endForm(); ?>

        </div>

    </div>

</div>


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
                            <th class="text-center">JAFPIB</th>
                            <th class="text-center">Jumlah Staf</th>
                            <th class="text-center">Jumlah Isi</th>
                            <th class="text-center">Peratus Isi</th>
                            <th class="text-center">DKUMS</th>
                            <th class="text-center">Penilaian Hidup</th>
                            <th class="text-center">Emosi Positif</th>
                            <th class="text-center">Kepuasan Kerja</th>
                            <th class="text-center">Keterlibatan Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($department as $dept) { ?>
                            <?php

                            $data = TblMain::PurataByDept($dept['id'], $tahun, $fasa);

                            ?>
                            <tr>
                                <th class="text-center"><?= $bil++ ?></td>
                                <td><?= $dept['fullname'] ?></td>
                                <th class="text-center"><?= $totalStaff = UtilitiesFunc::totalStaffByDept($dept['id']); ?></td>
                                <th class="text-center"><?= $totalIsi = TblMain::totalCompleted($dept['id'], $tahun, $fasa); ?></td>
                                <th class="text-center"><?= UtilitiesFunc::kiraPeratus($totalIsi, $totalStaff); ?>%</td>
                                <th class="text-center"><?= $data['dkums'] ?>%</td>
                                <th class="text-center"><?= $data['penilaian_hidup'] ?>%</td>
                                <th class="text-center"><?= $data['emosi_positif'] ?>%</td>
                                <th class="text-center"><?= $data['kepuasan_kerja'] ?>%</td>
                                <th class="text-center"><?= $data['keterlibatan_kerja'] ?>%</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>