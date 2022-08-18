
<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;

// as a widget
?>


<!--<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li><?= Html::a('Senarai Staf Seliaan', ['kehadiran/senarai_kakitangan']) ?></li>
        <li>Waktu Bekerja Berperingkat (WBB)</li>
    </ol>
</div>-->


<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Waktu Bekerja Berperingkat</strong><small>(WBB)</small></h2>
            <ul class="nav navbar-right panel_toolbox collapse">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Bil </th>
                            <th class="column-title">Mohon pada</th>
                            <th class="column-title">WP </th>
                            <th class="column-title">CATATAN WAKTU BEKERJA </th>
                            <th class="column-title">Mula </th>
                            <th class="column-title">Tamat </th>
                            <th class="column-title">Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $models) { ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?= $models->tarikhMohon; ?></td>
                                <td><?= $models->wp->jenis_wp; ?></td>
                                <td><?= $models->remark; ?></td>
                                <td><?= $models->tarikhMula; ?></td>
                                <td><?= $models->tarikhTamat; ?></td>
                                <td><?= $models->statusLabel; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <ul>
                    <li><span class="label label-primary">VERIFIED</span> : Telah Diperakukan dan menunggu kelulusan</li>
                    <li><span class="label label-success">APPROVED</span> : Diluluskan</li>
                    <li><span class="label label-warning">ENTRY</span> : Menunggu Perakuan</li>
                </ul>


            </div>
        </div>
    </div>
</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Waktu bekerja</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p style="color: green">
                * Permohonan Pertukaran WBB hanya boleh sebelum atau pada <strong>20hb setiap bulan</strong>.<br>
                * Perubahan WBB akan berlaku pada bulan berikutnya.
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <?= $form->errorSummary($wp); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jenis WP <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($wp, 'wp_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefWp::find()->where(['mohon'=>1])->all(), 'id', 'detail'),
                        'options' => ['placeholder' => 'Pilih WP', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Perubahan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($wp, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Memperaku
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo ($peg->peraku_icno) ? $peg->peraku->CONm : 'Terus kepada Pegawai Melulus'; ?>" disabled />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Melulus
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $peg->pelulus->CONm; ?>" disabled />
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Permohonan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
