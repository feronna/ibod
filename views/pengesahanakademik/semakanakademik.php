<?php
use yii\helpers\Html;
use yii\helpers\Url;
error_reporting(0);
?>
<?= $this->render('/pengesahan/_topmenu') ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
    <div class="x_content">  
        <strong>
            Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
            <table>
                <tr>
                    <td>
                        Pn Rozaidah Amir Hussein<br/>
                        Penolong Pendaftar Kanan <br/>
                        Tel: 088320000 (samb. 102005)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        Pn Patricia Binti Joseph<br/>
                        Pembantu Tadbir <br/>
                        Tel: 088320000 (samb. 102241)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </strong>  
    </div>
    </div>
    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Status Permohonan Pengesahan Dalam Perkhidmatan [Akademik]</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL.</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">TINDAKAN</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($status){
                    foreach ($status as $statuss) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:30%;"><?= $statuss->tarikhmohon; ?></td>
                            <td style="width:30%;"><?= $statuss->statuss; ?></td>
                            <td align= 'center'>
                                    <?php if($statuss->status == 'LULUS'){?>
                                  <?php if($statuss->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statuss->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> </a><br>
                                    <?php } ?>  
                                    <?php } ?>
                                    <?php if($statuss->status == 'TIDAK LULUS'){?>
                                  <?php if($statuss->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statuss->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> </a><br>
                                    <?php } ?>  
                                    <?php } ?>
                            </td> 
<!--                            <td align= 'center'>
                                    <?php if($statuss->status == 'LULUS'){?>
                                        <?= \yii\helpers\Html::a('', ['pengesahan/surat-pengesahan', 'id' => $statuss->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                    <?php } ?>
                                    <?php if($statuss->status == 'TIDAK LULUS'){?>
                                        <?= \yii\helpers\Html::a('', ['pengesahan/surat-pengesahan', 'id' => $statuss->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                    <?php } ?>
                                   
                           </td> -->
                         </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <ul>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>
</div>


