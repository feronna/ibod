
<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
?>
<!--<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li><?= Html::a('Senarai Staf Seliaan', ['kehadiran/senarai_kakitangan']) ?></li>
        <li>Senarai Waktu Bekerja Berperingkat (WBB)</li>
    </ol>
</div>-->
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Waktu Bekerja Berperingkat</strong><small>(WBB)</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <h4><i class="fa fa-user"></i> <strong><?= $biodata->CONm . ' (' . $biodata->COOldID . ')' ?></strong></h4>
                        <h4><i class="fa fa-briefcase"></i> <?= $biodata->jawatan->fname ?></h4>
                        <h4><i class="fa fa-address-card"></i> <?= $biodata->department->fullname ?></h4>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">BIL </th>
                                <th class="column-title">TARIKH PERMOHONAN</th>
                                <th class="column-title">WAKTU PILIHAN </th>
                                <th class="column-title">TARIKH MULA </th>
                                <th class="column-title">TARIKH TAMAT </th>
                                <th class="column-title">STATUS </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($model) { ?>
                                <?php foreach ($model as $models) { ?>
                                    <tr>
                                        <td><?= $bil++; ?></td>
                                        <td><?= $models->tarikhMohon; ?></td>
                                        <td><?= $models->wp->jenis_wp; ?></td>
                                        <td><?= $models->tarikhMula; ?></td>
                                        <td><?= $models->tarikhTamat; ?></td>
                                        <td><?= $models->statusLabel; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="6"><i>Tidak ada sebarang WBB setakat ini.</i></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div>
                    <span class="label label-warning">ENTRY</span> : Menunggu Perakuan &nbsp;&nbsp;
                    <span class="label label-primary">VERIFIED</span> : Telah Diperakukan dan menunggu kelulusan &nbsp;&nbsp;
                    <span class="label label-success">APPROVED</span> : Diluluskan 
                </div>
                <hr>
                <?= Html::a('<i class="fa fa-plus"></i> TAMBAH WAKTU BERKERJA BARU', ['kehadiran/add_wbb', 'id' => $id], ['class' => 'btn btn-primary btn-block']) ?>


            </div>
        </div>
    </div>
</div>