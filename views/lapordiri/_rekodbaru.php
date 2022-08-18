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
            <h2><strong>Lapor Diri</strong></h2>
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
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">SALINAN SURAT</th>
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($lapordiri){
                    foreach ($lapordiri as $lapordiri) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                        
                            <td style="width:30%;"><?= $lapordiri->tarikh_mohon; ?></td>
                            <td style="width:30%;"><?= $lapordiri->app_date; ?></td>
                          
                            <td style="width:30%;"><?= $lapordiri->statusjfpiu; ?></td>
                             <td align= 'center'>
                                    <?php if($lapordiri->status == 'LULUS'){?>
                                        <?= \yii\helpers\Html::a('', ['cutibelajar/surat-tawaran', 'id' => $lapordiri->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                    <?php } ?>
                                    <?php if($lapordiri->status == 'TIDAK LULUS'){?>
                                        <?= \yii\helpers\Html::a('', ['cutibelajar/surat-tawaran', 'id' => $lapordiri->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                    <?php } ?>
                                   
                           </td>
                           <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lapordiri/lihat-permohonan', "id"=> $lapordiri->iklan_id, 'i'=> $lapordiri->laporID]) ?></td>  

                           
                          
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