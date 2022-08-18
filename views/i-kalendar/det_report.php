<?php

use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\widgets\StarRating;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$i = 0;
$totalJumlah = 0;
$totalAsal = 0;
$totalTmbh = 0;
$totalSelesai = 0;
$totalTunda = 0;
$totalKemas = 0;
function starRating($total)
{
    if ($total == 100) {
        $total2 = 5.0;
    } else if (($total >= 90) && ($total < 100)) {
        $total2 = 4.5;
    } else if (($total >= 80) && ($total < 90)) {
        $total2 = 4.0;
    } else if (($total >= 70) && ($total < 80)) {
        $total2 = 3.0;
    } else if (($total >= 60) && ($total < 70)) {
        $total2 = 2.0;
    } else if (($total >= 50) && ($total < 60)) {
        $total2 = 1.0;
    } else {
        $total2 = 0.0;
    }

    echo StarRating::widget([
        'name' => 'rating_2',
        'value' => number_format($total2, 2),
        'disabled' => true,
        'pluginOptions' => ['size' => 'xs', 'displayOnly' => true, 'showCaption' => false,]
    ]);
}
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pilihan Tempoh Laporan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'post', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '2021' => '2021',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Sila pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'bulan')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '1' => 'Jan',
                                '2' => 'Feb',
                                '3' => 'Mar',
                                '4' => 'Apr',
                                '5' => 'Mei',
                                '6' => 'Jun',
                                '7' => 'Jul',
                                '8' => 'Ogos',
                                '9' => 'Sept',
                                '10' => 'Okt',
                                '11' => 'Nov',
                                '12' => 'Dis',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Sila pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Tarikh Mula <span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'start_date',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Tarikh Akhir <span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'end_date',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary'])
                        ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success'])
                        ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Statistik Terperinci Aktiviti Mengikut Bulan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center" rowspan="3">BAHAGIAN</th>
                            <th class="text-center" colspan="2">KPI</th>
                            <th class="text-center" colspan="3">BILANGAN AKTIVITI</th>
                            <th class="text-center" colspan="6">STATUS AKTIVITI</th>
                            <th class="text-center" rowspan="3">PENCAPAIAN (SELESAI)</th>
                        </tr>
                        <tr>
                            <th class="text-center" rowspan="2">Rancang</th>
                            <th class="text-center" rowspan="2">Capai</th>
                            <th class="text-center" rowspan="2">Jumlah</th>
                            <th class="text-center" rowspan="2">Asal</th>
                            <th class="text-center" rowspan="2">Tambahan</th>
                            <th class="text-center" colspan="2">Selesai</th>
                            <th class="text-center" colspan="2">Tunda</th>
                            <th class="text-center" colspan="2">Belum Kemaskini</th>
                        </tr>
                        <tr>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                        </tr>
                        <?php if (empty($laporan)) { ?>
                            <tr>
                                <td colspan="13">Tiada rekod dijumpai.</td>
                            </tr>
                            <?php } else {
                            while ($i < 5) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $i + 1; ?>
                                    </td>
                                    <td class="text-center">
                                        0
                                    </td>
                                    <td class="text-center">

                                    </td>
                                    <td class="text-center">
                                        <?= $jumlah = array_sum(ArrayHelper::getColumn($laporan[$i], function ($element) {
                                            return $element['sts'];
                                        })); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $asal = array_sum(ArrayHelper::getColumn($laporan[$i], function ($element) {
                                            if ($element['stats_id'] == 1 or $element['stats_id'] == 2 or $element['stats_id'] == 3 or $element['stats_id'] == 7 or $element['stats_id'] == 8)
                                                return $element['sts'];
                                        })); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $tmbh = array_sum(ArrayHelper::getColumn($laporan[$i], function ($element) {
                                            if ($element['stats_id'] == 5 or $element['stats_id'] == 6)
                                                return $element['sts'];
                                        })); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $selesai = array_sum(ArrayHelper::getColumn($laporan[$i], function ($element) {
                                            if ($element['stats_id'] == 2 or $element['stats_id'] == 6 or $element['stats_id'] == 8)
                                                return $element['sts'];
                                        })); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $jumlah ? (round(($selesai / $jumlah) * 100)) : 0; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $tunda = array_sum(ArrayHelper::getColumn($laporan[$i], function ($element) {
                                            if ($element['stats_id'] == 3 or $element['stats_id'] == 8)
                                                return $element['sts'];
                                        })); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $jumlah ? (round(($tunda / $jumlah) * 100)) : 0; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $kemaskini = array_sum(ArrayHelper::getColumn($laporan[$i], function ($element) {
                                            if ($element['stats_id'] == 1 or $element['stats_id'] == 7)
                                                return $element['sts'];
                                        })); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $jumlah ? (round(($kemaskini / $jumlah) * 100)) : 0; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= starRating($jumlah ? (round(($selesai / $jumlah) * 100)) : 0); ?>
                                    </td>
                                </tr>
                        <?php $i++;
                                $totalJumlah += $jumlah;
                                $totalAsal += $asal;
                                $totalTmbh += $tmbh;
                                $totalSelesai += $selesai;
                                $totalTunda += $tunda;
                                $totalKemas += $kemaskini;
                            }
                        } ?>
                        <tr>
                            <th class="text-center">JUMLAH KESELURUHAN</th>
                            <th class="text-center">0</th>
                            <th class="text-center"></th>
                            <th class="text-center"><?= $totalJumlah; ?></th>
                            <th class="text-center"><?= $totalAsal; ?></th>
                            <th class="text-center"><?= $totalTmbh; ?></th>
                            <th class="text-center"><?= $totalSelesai; ?></th>
                            <th class="text-center"><?= $totalJumlah ? (round(($totalSelesai / $totalJumlah) * 100)) : 0; ?></th>
                            <th class="text-center"><?= $totalTunda; ?></th>
                            <th class="text-center"><?= $totalTunda ? (round(($totalTunda / $totalJumlah) * 100))  : 0; ?></th>
                            <th class="text-center"><?= $totalKemas; ?></th>
                            <th class="text-center"><?= $totalKemas ? (round(($totalKemas / $totalJumlah) * 100))  : 0; ?></th>
                            <th class="text-center"><?= starRating($totalJumlah ? (round(($totalSelesai / $totalJumlah) * 100)) : 0); ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>