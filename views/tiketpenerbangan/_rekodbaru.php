<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

// use dosamigos\datepicker\DatePicker;
// use yii\web\UploadedFile;
// use yii\helpers\ArrayHelper;

?>
<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tempahan Tiket Penerbangan</strong></h2>
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
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">TINDAKAN</th>
                     
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($statustiket){
                    foreach ($statustiket as $statusstiket) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:30%;"><?= $statusstiket->tarikh_mohon; ?></td>
                            <td style="width:30%;"><?= $statusstiket->app_date; ?></td>
                            <td style="width:30%;"><?= $statusstiket->ver_date;?></td>
                            <td style="width:30%;"><?= $statusstiket->statusbsm; ?></td>
                            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['tiketpenerbangan/lihat-permohonan', "id"=> $statusstiket->id]) ?></td>  

                           
                          
                        </tr>
                    <?php }} else{?>
                     
                   
                    <tr>
                        <td colspan="8" class="text-center"><i>Tiada Rekod Ditemui</i></td>                     
                    </tr>
                  <?php  
                } ?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
</div>