<?php

use app\models\dkums\TblMain;
use app\models\UtilitiesFunc;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\dkums\YearSettings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i> Search</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= Html::beginForm(['stat-dept'], 'GET', ['class' => 'form-horizontal form-label-left disable-submit-buttons']); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?= Html::dropDownList('GetTahun', $tahun, ArrayHelper::map(YearSettings::find()->all(), 'tahun', 'tahun'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Fasa</label>
                <div class="col-md-1 col-sm-1 col-xs-12">
                    <?= Html::dropDownList('GetFasa', $fasa, [1 => 1, 2 => 2], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
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
                            <th class="text-center" width="25%" style="font-size: 15px;font-weight:bold">Keseluruhan Kakitangan</th>
                            <th class="text-center" width="25%" style="font-size: 15px;font-weight:bold">Telah isi</th>
                            <th class="text-center" width="25%" style="font-size: 15px;font-weight:bold">Belum isi</th>
                            <th class="text-center" width="25%" style="font-size: 15px;font-weight:bold">Peratus (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= $totalStaff = UtilitiesFunc::totalStaffByDept($department->id); ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= Html::button($totalIsi = TblMain::totalCompleted($department->id, $tahun, $fasa), ['value' => Url::to(['dkums/sudah-isi', 'deptId' => $department->id,'tahun'=>$tahun,'fasa'=>$fasa]), 'class' => 'mapBtn', 'id' => 'modalButton']); ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= Html::button($totalStaff - $totalIsi, ['value' => Url::to(['dkums/belum-isi', 'deptId' => $department->id,'tahun'=>$tahun,'fasa'=>$fasa]), 'class' => 'mapBtn', 'id' => 'modalButton']); ?></td>
                            <th class="text-center" style="font-size: 35px;font-weight:bold"><?= round(($totalIsi/$totalStaff)*100,2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="tile_count">
                    <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                        <span class="count_top"><i class="fa fa-users"></i>&nbsp;Purata DKUMS</span>
                        <div class="count blue"><?= $data['dkums']; ?>%</div>
                        <span class="count_bottom">Tahap <i class="blue"><?= $data['tahap_dkums']; ?></i></span>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                        <span class="count_top"><i class="fa fa-heart"></i>&nbsp;Purata Penilaian Hidup</span>
                        <div class="count green"><?= $data['penilaian_hidup']; ?>%</div>
                        <span class="count_bottom">Tahap <i class="blue"><?= $data['tahap_penilaian_hidup']; ?></i></span>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                        <span class="count_top"><i class="fa fa-briefcase"></i>&nbsp;Purata Keterlibatan Kerja</span>
                        <div class="count blue"><?= $data['keterlibatan_kerja']; ?>%</div>
                        <span class="count_bottom">Tahap <i class="blue"><?= $data['tahap_keterlibatan_kerja']; ?></i></span>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                        <span class="count_top"><i class="fa fa-thumbs-up"></i>&nbsp;Purata kepuasan kerja</span>
                        <div class="count green"><?= $data['kepuasan_kerja']; ?>%</div>
                        <span class="count_bottom">Tahap <i class="blue"><?= $data['tahap_kepuasan_kerja']; ?></i></span>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 tile_stats_count">
                        <span class="count_top"><i class="fa fa-smile-o"></i>&nbsp;Emosi Positif</span>
                        <div class="count blue"><?= $data['emosi_positif']; ?>%</div>
                        <span class="count_bottom">Tahap <i class="blue"><?= $data['tahap_emosi_positif']; ?></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>