<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
?>

<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>

<?php echo $this->render('/pengesahan/_menu');?> 

<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>
        1. Untuk maklumat lanjut berkaitan pengesahan dalam perkhidmatan, sila berhubung dengan Puan BIBIANA BINTI ROBERT di talian 088-320000 Samb. 1154. <br> 
    </p>
</marquee>
        
<div class="row">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Status Permohonan Pengajian Lanjutan</strong></h2>
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
                    if($status){
                    foreach ($status as $statuss) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:30%;"><?= $statuss->tarikhmohon; ?></td>
                            <td style="width:30%;"><?= $statuss->statuss; ?></td>
                            <td style="width:30%;">
                                <?php if($statuss->status == 'LULUS'){?>
                                <div class="container" align="center">
                                <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">                                                           
                                <a href="<?php echo Url::to('@web/'.'uploads/pengesahandalamperkhidmatan/Surat Disahkan Dalam Perkhidmatan.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i>Surat Disahkan Dalam Perkhidmatan</a><br>
                                </div>
                                </div>
                            </td>
                            <?php }?>
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




