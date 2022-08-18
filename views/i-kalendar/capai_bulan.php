<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\widgets\StarRating;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$i = 0;
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
                <h2><strong> Laporan Pencapaian Keseluruhan Aktiviti Bulanan Setiap Bahagian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">BIL</th>
                            <th class="text-center">BAHAGIAN</th>
                            <th class="text-center">PURATA PENCAPAIAN AKTIVITI BULANAN</th>
                            <th class="text-center">JUMLAH BINTANG</th>
                        </tr>
                        <?php if (empty($laporan)) { ?>
                            <tr>
                                <td colspan="4">Tiada rekod dijumpai.</td>
                            </tr>
                            <?php } else {
                            while ($i < 5) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $i + 1; ?>
                                    </td>
                                    <td>
                                        <?php switch ($i + 1) {
                                            case 1:
                                                echo 'Bahagian Sumber Manusia';
                                                break;
                                            case 3:
                                                echo ' 	Bahagian Perkhidmatan Akademik';
                                                break;
                                            case 2:
                                                echo 'Bahagian Pentadbiran dan Governan';
                                                break;
                                            case 5:
                                                echo 'Bahagian Pengurusan Kualiti';
                                                break;
                                            case 4:
                                                echo 'Bahagian Keselamatan';
                                                break;
                                        }; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $laporan[$i][$model->bulan] ?? '0'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= starRating($laporan[$i][$model->bulan] ?? '0'); ?>
                                    </td>
                                </tr>
                        <?php $i++;
                            }
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>