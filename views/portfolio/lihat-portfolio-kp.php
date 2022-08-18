<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use kongoon\orgchart\OrgChart;
use yii\helpers\Url;

error_reporting(0);
?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>
<p align="right"><?= Html::a('Kembali', ['halaman-kp'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">  
    <div> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
             myPortfolio</5> 
        <div class="clearfix"></div> 
    </div> 
</div>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
         <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
             Maklumat Khusus</5> 
        <div class="clearfix"></div> 
    </div> 
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-building"></i> MAKLUMAT BAHAGIAN</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                <table class="table table-sm table-bordered">
                 
                     <tr>
                     <td><strong>BAHAGIAN</strong></td>
                     <td><?= strtoupper($deskripsi->department->fullname)?></td>

                     </tr>
                       <tr>
                     <td><strong>ALAMAT</strong></td>
                     <td><?= strtoupper($deskripsi->department->address)?></td>
                     </tr>
                       <tr>
                     <td><strong>POSKOD</strong></td>
                     <td></td>
                     </tr>
                       <tr>
                     <td><strong>NO. TELEFON</strong></td>
                     <td><?= strtoupper($deskripsi->department->tel_no)?></td>
                     </tr>
                     <tr>
                     <td><strong>NO. FAKS</strong></td>
                     <td><?= strtoupper($deskripsi->department->fax_no)?></td>
                     </tr>
                   
                </table>
            </div>
            </div>
        </div>
    </div>    
<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
        
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-user"></i> MAKLUMAT PEGAWAI</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
               <p style="color:black">
                    ** Pengemaskinian Data Adalah Di Modul Rekod Pegawai.</p>
           
                <table class="table table-sm table-bordered">
                 
                     <tr>
                     <td><strong>NAMA</strong></td>
                     <td><?= strtoupper($deskripsi->biodata->CONm)?></td>

                     </tr>
                       <tr>
                     <td><strong>GELARAN JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatan)?></td>
                     </tr>
                       <tr>
                     <td><strong>JAWATAN HAKIKI</strong></td>
                     <td><?= strtoupper($deskripsi->biodata->jawatan->gred)?></td>
                     </tr>
                       <tr>
                     <td><strong>TARIKH PENEMPATAN</strong></td>
                     <td><?= strtoupper($deskripsi->biodata->startDateLantik)?></td>
                     </tr>
                     
                   
                </table>
            </div>
            </div>
        </div>
    </div> 
<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
        
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-check-square"></i> MAKLUMAT PENGESAH/PELULUS</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                <p style="color:black">
                    ** Pengemaskinian Data Adalah Di Modul Pentadbir.</p>
           
                <table class="table table-sm table-bordered">
                 
                     <tr>
                     <td><strong>PEGAWAI PENGESAH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaPerkhidmatan->CONm)?></td>

                     </tr>
                       <tr>
                     <td><strong>PEGAWAI PELULUS</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaJabatan->CONm)?></td>
                     </tr>
                    
                       <tr>
                     <td><strong>TARIKH HANTAR</strong></td>
                     <td><?= strtoupper($deskripsi->tarikh_hantar)?></td>
                     </tr>
                   
                   
                </table>
            </div>
            </div>
        </div>
    </div>    

<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
        
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-calendar-check-o"></i> JADUAL PENGEMASKINIAN</strong></h5> 
                </div>
                <br>
                <div class="table-responsive">
               <p style="color:black">
                    ** Jadual Pengemaskinian Menyatakan Maklumat Terkini Perubahan Pada Sebarang TAB MyPortfolio.</p>
           
                <table class="table table-sm table-bordered">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">TARIKH TERKINI KEMASKINI</th>
                            <th class="column-title">CARTA</th>
                            <th class="column-title">STATUS KEMASKINI </th>
                       
                            
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:center">1.</td>
                                <td style="text-align:center"><?= $carta->created_at?></td>
                                <td style="text-align:left">Carta Organisasi</td>
                                <td style="text-align:center"><?php if ($carta->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">2.</td>
                                <td style="text-align:center"><?= $fungsi->created_at?></td>
                                <td style="text-align:left">Carta Fungsi</td>
                                <td style="text-align:center"><?php if ($fungsi->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">3.</td>
                                <td style="text-align:center"><?= $aktiviti->created_at?></td>
                                <td style="text-align:left">Aktiviti-Aktiviti Bagi Fungsi</td>
                                <td style="text-align:center"><?php if ($aktiviti->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">4.</td>
                                <td style="text-align:center"><?= $deskripsi->created_at?></td>
                                <td style="text-align:left">Deskripsi Tugas</td>
                                <td style="text-align:center"><?php if ($deskripsi->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">5.</td>
                                <td style="text-align:center"></td>
                                <td style="text-align:left">Proses Kerja</td>
                                <td></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">6.</td>
                                <td style="text-align:center"></td>
                                <td style="text-align:left">Carta Alir</td>
                                <td></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">7.</td>
                                <td style="text-align:center"></td>
                                <td style="text-align:left">Senarai Semak</td>
                                <td></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">8.</td>
                                <td style="text-align:center"><?= $undang->created_at?></td>
                                <td style="text-align:left">Senarai Undang - Undang, Peraturan Dan Punca Kuasa</td>
                                <td style="text-align:center"><?php if ($undang->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">9.</td>
                                <td style="text-align:center"><?= $borang->created_at?></td>
                                <td style="text-align:left">Senarai Borang</td>
                                <td style="text-align:center"><?php if ($borang->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">10.</td>
                                <td style="text-align:center"><?= $jawatanKuasa->created_at?></td>
                                <td style="text-align:left">Senarai Jawatankuasa Yang Dianggotai</td>
                                <td style="text-align:center"><?php if ($jawatanKuasa->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                            
           

                    </table>
            </div>
            </div>
        </div>
    </div> 


        <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
         <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
             Maklumat Umum</5> 
        <div class="clearfix"></div> 
    </div> 
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-bar-chart"></i> CARTA ORGANISASI</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                <table class="table table-sm table-bordered">
                 
                      <?php  
  
  

echo OrgChart::widget([
    
    
    'data' => $model,


    
    ]) ?>
                   
                </table>
            </div>
            </div>
        </div>
    </div>   

<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
         
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-th-list"></i> CARTA FUNGSI</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
    
     <tr>
                        <th  <td style="width:50px; height: 20px">Bil.</strong></td></th>
                        <th colspan="2" <td style="width:200px; height: 20px">SEKSYEN</strong></td></th>
                         <th colspan="2" <td style="width:200px; height: 20px">UNIT</strong></td></th>
                         <th colspan="3"<td style="width:500px; height: 20px">FUNGSI UNIT</strong></td></th>
                   
                    </tr>
                               <?php if($fungsiUnit) {
                    
                   foreach ($fungsiUnit as $key=>$item){?>
                    <tr>
                            <td align="left"><?= $key+1?></td>
                              <td><?= ucwords(strtolower($item->sectionID->section_details))?> </td>
                            <td colspan="2">
                            <?= ucwords(strtolower($item->unit_details))?> </td>
                             <td colspan="2">
                            <?php echo ($item->TugasUtama2($item->id))?> </td>
                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                </table>
            </div>
            </div>
        </div>
            
            
</div>

<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
         
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-bookmark"></i> PROSES KERJA</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                    
                            <th class="column-title">TANGGUNGJAWAB </th>
                            <th class="column-title">PROSES KERJA </th>
                            <th class="column-title">PEGAWAI LAIN/DIRUJUK </th>
                            <th class="column-title">SENARAI UNDANG-UNDANG, PERATURAN DAN PUNCA KUASA</th>
                            <th class="column-title">TEMPOH MASA</th>
                            <th class="column-title">DOKUMEN</th>
                       
                            
                        </tr>
                        </thead>
                        <tbody>

                 <?php if($viewAktiviti) {
                    
                   foreach ($viewAktiviti as $key=>$item){
                    
                ?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                          
                            <td width="50px" align="center"> <?php echo $item->kakitangan->CONm. '<br>'. $item->kakitangan->jawatan->fname?></td>
                            <td width="50px" align="center"> <?= $item->proses_kerja?></td>
                            <td width="50px" align="center"> <?php echo $item->pegawai->CONm. '<br>'. $item->pegawai->jawatan->fname?></td>
                            <td width="50px" align="center"> <?= $item->undang ?></td>
                            <td width="50px" align="center"> <?= $item->tempoh ?></td>
                               <td width="50px" align="center">
                          
                           
                                <div id='demo<?php echo $item->id?>'style="text-align: left; padding-left: 10%;">
                                <?php if($item->file){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($item->file), true); ?>" target="_blank" ><center><i class="fa fa-download"></i></center></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                             
                                  </td>
                              

                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    </table>
            </div>
            </div>
        </div>
            
            
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
         
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-legal"></i> SENARAI UNDANG</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
    
    <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">SENARAI UNDANG-UNDANG, PERATURAN DAN PUNCA KUASA</th>
                            <th class="column-title">DOKUMEN</th>

                       
                            
                        </tr>
                        </thead>
                        <tbody>

                 <?php if($viewAktiviti) {
                    
                   foreach ($viewAktiviti as $key=>$item){
                    
                ?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td width="50px" align="center"> <?php if($item->aktiviti)?></td>
                            <td width="50px" align="center">
                          
                           
                                <div id='demo<?php echo $item->id?>'style="text-align: left; padding-left: 10%;">
                                <?php if($item->file){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($item->file), true); ?>" target="_blank" ><center><i class="fa fa-download"></i></center></a><br>
                                <?php }
                                else
                                {
                                    echo '-';
                                }
                                
                                ?><br>
                                </div>
                             
                                  </td>
                                     
                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                </table>
            </div>
            </div>
        </div>
 
</div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
         
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-book"></i> SENARAI BORANG</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
    
     <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">BORANG</th>
                            <th class="column-title">KOD BORANG</th>
                                                  <th class="column-title">DOKUMEN</th>

                       
                            
                        </tr>
                        </thead>
                        <tbody>

                 <?php if($viewBorang) {
                    
                   foreach ($viewBorang as $key=>$item){
                    
                ?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td width="50px" align="center"> <?= $item->borang?></td>
                            <td width="50px" align="center"> <?= $item->kod_borang?></td>
                            <td width="50px" align="center">
                          
                           
                                <div id='demo<?php echo $item->id?>'style="text-align: left; padding-left: 10%;">
                                <?php if($item->file){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($item->file), true); ?>" target="_blank" ><center><i class="fa fa-download"></i></center></a><br>
                                <?php }
                                else
                                {
                                    echo '-';
                                }
                                
                                ?><br>
                                </div>
                             
                                  </td>
                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                </table>
            </div>
            </div>
        </div>
 
</div>
   
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
         
            <div class="panel panel-info">

                <div class="panel-heading">
        <h5><strong><i class="fa fa-users"></i> SENARAI JAWATANKUASA</strong></h5> 
                </div>
                </br>
                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
    
     
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">SENARAI JAWATANKUASA YANG DIANGGOTAI</th>
                                                  <th class="column-title">DOKUMEN</th>

                      
                       
                            
                        </tr>
                        </thead>
                        <tbody>

                 <?php if($viewJawatan) {
                    
                   foreach ($viewJawatan as $key=>$item){
                    
                ?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td width="50px" align="left"> <?= $item->catatan?></td>
                           <td width="50px" align="center">
                          
                           
                                <div id='demo<?php echo $item->id?>'style="text-align: left; padding-left: 10%;">
                                <?php if($item->file){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($item->file), true); ?>" target="_blank" ><center><i class="fa fa-download"></i></center></a><br>
                                <?php }
                                else
                                {
                                    echo '-';
                                }
                                
                                ?><br>
                                </div>
                             
                                  </td>
                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                </table>
            </div>
            </div>
        </div>
 
</div>