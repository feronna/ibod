<?php

use yii\helpers\Html;
use yii\helpers\Url;
error_reporting(0);?>

<?= $this->render('/kontrak/_topmenu') ?>
<?= $this->render('_inquiry') ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">STATUS</th>
                       
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($model){
                    foreach ($model as $statuss) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:30%;"><?= $statuss->tarikhmohon; ?></td>
                            <td style="width:30%;"><?= $statuss->statuspentadbiran; ?></td>
                            
                            <td style="width:30%;">
                                <?php if($statuss->status == '4'){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-chevron-down"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <a href="<?php echo Url::to('@web/'.'uploads/pelantikansemulakontrak/BORANGPEMERIKSAANPERUBATANBARU.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Borang Pemeriksaan Perubatan</a><br>
                                <a href="<?php echo Url::to('@web/'.'kontrak/borangakuankerahsiaan', true); ?>" target="_blank" ><i class="fa fa-download"></i> Borang Akuan Kerahsiaan</a><br>
                                <a href="<?php echo Url::to('@web/'.'kontrak/borangakuan', true); ?>" target="_blank" ><i class="fa fa-download"></i> Borang Akuan</a><br>
                                <a href="<?php echo Url::to('@web/'.'uploads/pelantikansemulakontrak/Surat Penerimaan Tawaran.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Surat Penerimaan Tawaran</a><br>

                                </div>
                              </div>
                                  </td>
                            <?php }?>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <ul>
                <li><span class="label label-warning">Dalam Tindakan KP</span> : Menunggu persetujuan dari Ketua Pentadbiran</li>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>
