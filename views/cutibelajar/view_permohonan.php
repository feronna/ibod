<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

// use dosamigos\datepicker\DatePicker;
// use yii\web\UploadedFile;
// use yii\helpers\ArrayHelper;
error_reporting(0);
?>

<div class="row">

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
    SEMAKAN PERMOHONAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div></div>
<div class="x_panel">
<div class="x_content"> 
<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>Permohonan Baharu</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Pelanjutan</b></a>
                </li>
            
               <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><b>Lain-Lain Permohonan</b></a>
                </li>
                 <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false"><b>Lapor Diri</b></a>
                </li>
                 <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false"><b>Tiket Penerbangan</b></a>
                </li>
                 <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false"><b>Tuntutan</b></a>
                </li>
            </ul>
        </div>
</div></div>
<div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
<div class="row"> 
        
<div class="col-md-12 col-sm-12 col-xs-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-th-list"></i><strong> PERMOHONAN BAHARU</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead  style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH SEMAKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                       <th class="column-title text-center">TINDAKAN</th>
                        <th class="column-title text-center">SALINAN SURAT</th>
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
                            <td style="width:10%;"><b><?= $statuss->borang->alt; ?></b></td>
                            <td style="width:30%;"><?= $statuss->tarikh_m; ?></td>
                            <td style="width:30%;"><?= $statuss->statusjfpiu?><br><?= $statuss->app_date; ?></td>
                            <td style="width:30%;"><?= $statuss->ver_date;?></td>
                            <td style="width:30%;"><?= $statuss->statuss; ?></td>
                            <td class="text-center">
                           <?php if($statuss->study->HighestEduLevelCd == 99)
                           {?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['cutisabatikal/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                      <?php     }elseif($statuss->borang->id == 32){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['pentadbiran/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }elseif($statuss->borang->id == 38){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['separuh-masa/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      
                      elseif($statuss->borang->id == 39){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['latihan-industri/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      elseif($statuss->borang->id == 41){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['pra-warta/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      elseif($statuss->borang->id == 51){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['latihan-pensijilan/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      elseif($statuss->borang->id == 42){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['pos-doktoral/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      elseif($statuss->borang->id == 43){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['sub-kepakaran/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      
                      elseif($statuss->borang->id == 40){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['sangkutan/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                      elseif($statuss->borang->id == 1){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['sepenuh-masa/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }
                        elseif($statuss->borang->id == 44){?>
                                <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['cuti-penyelidikan/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                     
                      <?php }else{?>
                          
                          <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
                                ['cutibelajar/lihat-permohonan', 'id' => $statuss->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                  <?php    }?>

                            
                            
                            <td style="width:40%;">
                                <?php if($statuss->status == 'LULUS' || $statuss->status == 'Lulus Tanpa Pantauan' || $statuss->status == 'TERIMA TAWARAN' || $statuss->status == "TIDAK LULUS"){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statuss->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statuss->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($statuss->dokumen->tajuk))?></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                              </div>
                                  </td>
                            <?php }
 else {
     echo '-';
 }?>

                           
                          
                        </tr>
                    <?php }} else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
</div>
</div>
    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-plus-square"></i> PELANJUTAN TEMPOH CUTI BELAJAR</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">TINDAKAN</th>
                        <th class="column-title text-center">SALINAN SURAT</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($statuslanjutan){
                    foreach ($statuslanjutan as $statusslanjutan) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:10%;"><?= $statusslanjutan->borang->alt; ?></td>
                            <td style="width:30%;"><?= $statusslanjutan->tarikh_mohon; ?></td>
                            <td style="width:30%;"><?= $statusslanjutan->app_date; ?></td>
                            <td style="width:30%;"><?= $statusslanjutan->ver_date;?></td>
                            <td style="width:30%;"><?= $statusslanjutan->statuss; ?></td>

                              <td style="width:40%;">
                                  <?php $surat = app\models\cbelajar\TblSurat::find()->where(['icno'=>$statusslanjutan->id])->one();
                                 if($statusslanjutan->status == 'LULUS' || $statusslanjutan->status == 'KIV'){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#d<?php echo $statusslanjutan->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='d<?php echo $statusslanjutan->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($surat->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($surat->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($surat->tajuk))?></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                              </div>
                                  </td>
                            <?php }?>
                          

                         <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lanjutancb/lihat-permohonan', "id"=> $statusslanjutan->iklan_id], ['class' => 'btn btn-default btn-xs']) ?></td>  

                          
                        </tr>
                    <?php }}else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
        </div></div>
    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">

<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list-alt"></i> LAIN - LAIN PERMOHONAN</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                                                 <th class="column-title text-center">SURAT KELULUSAN</th>
<th class="column-title text-center">TINDAKAN</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($statuslain){
                    foreach ($statuslain as $statusslain) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:10%;"><?= $statusslain->borang->alt; ?></td>
                            <td style="width:30%;"><?= $statusslain->tarikh_mohon; ?></td>
                            <td style="width:30%;"><?= $statusslain->app_date; ?></td>
                            <td style="width:30%;"><?= $statusslain->ver_date;?></td>
                            <td style="width:30%;"><?= $statusslain->statusbsm; ?></td>
                            <td style="width:40%;">
                                <?php if($statusslain->status == 'LULUS'){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statusslain->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='demo<?php echo $statusslain->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statusslain->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statusslain->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($statuss->dokumen->tajuk))?></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                              </div>
                                  </td>
                            <?php }?> 
                           
                           

                      <td class="text-center">
                                  <?php 
                                   if ($statusslain->idBorang == 22)  {?>
                               
                               <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['cblainlain/lihat-permohonan', 'id' => $statusslain->iklan_id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                               
                    <?php }elseif ($statusslain->idBorang == 23){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['cblainlain/lihat-permohonan-tarikh', 'id' => $statusslain->iklan_id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php }  elseif($statusslain->idBorang == 24) {?>
                               
                  <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['cblainlain/lihat-permohonan-tukar-tempat', 'id' => $statusslain->iklan_id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>              
                    <?php }
                               elseif($statusslain->idBorang == 31) {?>
                               
                  <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['cblainlain/lihat-permohonan-tangguh-pengajian', 'id' => $statusslain->iklan_id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>              
                    <?php }
                       elseif($statusslain->idBorang == 49) {?>
                               
                  <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['cblainlain/lihat-permohonan-mod', 'id' => $statusslain->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>              
                    <?php }?>
                          
                           </td>

                           
                          
                        </tr>
                    <?php }}else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
</div>
</div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">

<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-suitcase"> </i> LAPOR DIRI</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
<!--                        <th class="column-title text-center">SURAT KELULUSAN</th>-->
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
                            <td style="width:30%;"><?= $lapordiri->statusbsm; ?></td>

                             
                           <td class="text-center">
                                  <?php 
                                   if ($lapordiri->status_pengajian == 1)  {?>
                               
                               <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lapordiri/pengesahan', 'i' => $lapordiri->laporID],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                               
                    <?php } 
                              else {?>
                               <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lapordiri/belum-selesai', "i"=> $lapordiri->laporID, 'i'=> $lapordiri->laporID], ['class' => 'btn btn-default btn-xs']) ?>
                    <?php }?>
                           </td>


                           
                          
                        </tr>
                    <?php }}else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
</div>
</div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">


<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-plane"></i> PERMOHONAN TIKET PENERBANGAN</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                                                 <th class="column-title text-center">SURAT KELULUSAN</th>
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
                            <td style="width:10%;">
                          <?php if(($statusstiket->idBorang == 'CBDN') || ($statusstiket->idBorang == 'CBLN')){
                              
                             echo '<span class="label label-primary">TEMPAHAN</span>';
                          }
                          else
                          {
                              echo '<span class="label label-primary">TUNTUTAN</span>';
                          }
?>
                            </td>
                            <td style="width:30%;"><?= $statusstiket->tarikh_mohon; ?></td>
                            <td style="width:30%;"><?= $statusstiket->ver_date;?></td>
                            <td style="width:30%;"><?= $statusstiket->statusbsm; ?></td>
                            <td style="width:40%;">
                                <?php if($statusstiket->status == 'LULUS'){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statusslain->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='demo<?php echo $statusstiket->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statusstiket->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statusslain->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($statuss->dokumen->tajuk))?></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                              </div>
                                  </td>
                            <?php }?> 
                           
                           

                      <td class="text-center">
                                  <?php 
                                   if (($statusstiket->idBorang == "CBDN") || ($statusstiket->idBorang == "CBLN")) {?>
                               
                               <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['tiketpenerbangan/lihat-permohonan', 'id' => $statusstiket->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?> 
                             
                               
                    <?php }elseif ($statusstiket->idBorang == "TUNT"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['tiketpenerbangan/lihat-permohonan-tuntut', 'id' => $statusstiket->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php }  
                               ?>
                           </td>

                           
                          
                        </tr>
                    <?php }}else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
        </div></div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">

    
    <div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h4><strong><i class="fa fa-plane"></i> PERMOHONAN HPG/ELAUN TESIS/AKHIR PENGAJIAN/ YURAN/IELTS</strong></h4>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead style="background-color:lightseagreen;color:white">
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH SEMAKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
<th class="column-title text-center">TINDAKAN</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($statustuntut){
                    foreach ($statustuntut as $statusst) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:10%;">
                          <?php if($statusst->idBorang == '35')
                          {
                             echo '<span class="label label-primary">ELAUN TESIS</span>';
                          }
                          elseif ($statusst->idBorang == '37'){?>
                            
                          
                             <span class="label label-primary">ELAUN AKHIR PENGAJIAN</span>
                          <?php } elseif ($statusst->idBorang == '30'){?>
                            
                          
                             <span class="label label-primary">HADIAH PERGERAKAN GAJI</span>
                          <?php }
                           elseif ($statusst->idBorang == '46'){?>
                            
                          
                             <span class="label label-primary">YURAN</span>
                          <?php }
                          elseif ($statusst->idBorang == '50'){?>
                                                          <span class="label label-primary">IELTS</span>

                          <?php }
                          elseif ($statusst->idBorang == '52'){?>
                                                          <span class="label label-primary">VISA</span>

                          <?php }
                          elseif ($statusst->idBorang == '53'){?>
                                                          <span class="label label-primary">INSURANS</span>

                          <?php }?>
                                                          
                            </td>
                            <td style="width:30%;"><?= $statusst->tarikh_m; ?></td>
                            <td style="width:30%;"><?= $statusst->ver_date;?></td>
                            <td style="width:30%;"><?= $statusst->statusbsm; ?> <br><b><small><?= $statusst->ulasan_bsm; ?></small></b></td>
                           
                          
                           
                           

                      <td class="text-center">
                                  <?php 
                                   if ($statusst->idBorang == "30")  {?>
                               
                               <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                                       ['lapordiri/lihat-permohonan-hpg', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>
                               
                    <?php } if ($statusst->idBorang == "35"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['lapordiri/lihat-permohonan-tesis', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php } if ($statusst->idBorang == "37"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['lapordiri/lihat-permohonan-akhir', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php }  if ($statusst->idBorang == "46"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['tuntutan-yuran/lihat-permohonan-yuran', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php }   
                    if ($statusst->idBorang == "50"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['tuntutan-ielts/lihat-permohonan-ielts', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php }   
                     if ($statusst->idBorang == "52"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['tuntutan-visa/lihat-permohonan-visa', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php } 
                       if ($statusst->idBorang == "53"){?>
                        
                    <?= \yii\helpers\Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',
                     ['tuntutan-insurans/lihat-permohonan-insurans', 'id' => $statusst->id],['class' => 'btn btn-default btn-xs','target' => '_blank']) ?>

                    <?php } 
                               ?>
                          
                           </td>

                           
                          
                        </tr>
                    <?php }}else{?> <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                                    </tr></table>
                            <?php }?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
    </div></div>
    </div></div></div>
<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
<ul>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
    </div>
        </div></div>