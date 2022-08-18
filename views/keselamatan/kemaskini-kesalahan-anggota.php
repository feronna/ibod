
<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use yii\helpers\Url;
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
            <h2><strong>Senarai Kesalahan Anggota</strong></h2>
            <ul class="nav navbar-right panel_toolbox collapse">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <?php $id = Yii::$app->getRequest()->getQueryParam('id'); ?>
            <a href="<?= Url::to(['tambah-kesalahan', 'id' => Yii::$app->getRequest()->getQueryParam('id')]); ?>" class="btn btn-primary btn-md rounded">
                <strong> Kemaskini Kesalahan</strong></a>
            <a href="#" data-toggle="tooltip" title="Untuk Mengemaskini/Menambah Kesalahan Anggota, Sekiranya Anggota Melakukan Kesalahan!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style = "background-color: navy; color: white;">
                        <tr class="headings">
                            <th class="column-title">Bil </th>
                            <th class="column-title">Tarikh Kesalahan</th>
                            <th class="column-title">Syif</th>
                            <th class="column-title">THTC</th>
                            <th class="column-title">THLM</th>
                            <th class="column-title">THTM</th>
                            <th class="column-title">LHB</th>
                            <th class="column-title">MPKTK</th>
                            <th class="column-title">THB</th>
                            <th class="column-title">THP</th>
                            <th class="column-title">GMK</th>
                            <th class="column-title">Lain-Lain</th>
                            <!--<th class="column-title">Remark</th>-->
                            <th class="column-title">Remark Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $models) { ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?= $models->tarikh; ?></td>
                              
                                    <td class="text-center"><?= $models->syif; ?></td>

                                <td class="text-center"><?= $models->thtc; ?></td>
                                <td class="text-center"><?= $models->thlm; ?></td>
                                <td class="text-center"><?= $models->thtm; ?></td>
                                <td class="text-center"><?= $models->lhb; ?></td>
                                <td class="text-center"><?= $models->mpktk; ?></td>
                                <td class="text-center"><?= $models->thb; ?></td>
                                <td class="text-center"><?= $models->thp; ?></td>
                                <td class="text-center"><?= $models->gmk; ?></td>
                                <td class="text-center"><?= $models->lain_lain; ?></td>
<!--                                <td class="text-center"><?= $models->remark; ?></td>-->
                                <td class="text-center"><?= $models->rmk; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div><h4><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rujukan </h4></strong></div>
                <ul>
                    <li><span class="label label-success">THTC</span> : Tidak Hadir Bertugas (Tugas Hakiki) (THTC)</li>
                    <li><span class="label label-success">THLM</span> : Tidak Hadir Bertugas Lebih Masa </li>
                    <li><span class="label label-success">THTM</span> : Tidak Hadir Tanpa Maklumat</li>
                    <li><span class="label label-success">THTM</span> : Lewat Hadir Bertugas</li>
                    <li><span class="label label-success">THTM</span> : Meninggalkan Pos Kawalan Tanpa Kebenaran</li>
                    <li><span class="label label-success">THTM</span> : Membuat Laporan Awal Sebelum Masanya</li>
                    <li><span class="label label-success">THTM</span> : Tidak Hadir Baris : (THB)</li>
                    <li><span class="label label-success">THTM</span> : Tidak Hadir Penugasan</li>
                    <li><span class="label label-success">THTM</span> : Gagal Melapor Kejadian</li>
                </ul>
                
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
       
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>

