<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
$options = [
        1 => 'Sendiri', 2 => 'Pasangan' , 3 => 'Anak',

];
error_reporting(0);


?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>
 <div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12 "> 
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link " href="#pegawai" data-toggle="tab">Pegawai</a>
    </li>   <?php if($pasangan2 != null){
        echo '<li><a data-toggle="tab" href="#pasangan">Pasangan</a></li>';
    } else{
        echo '<li><a data-toggle="tab" href="#pasangan2"></a></li>';
    }
    
     if($pasangan2 != null){
    if(($pasangankedua == true) && ($pasangan2 == $pasangankedua)){
        echo '';
    } else{
       echo '<li><a data-toggle="tab" href="#pasangankedua">Pasangan</a></li>';
    }
  }  
?>
</ul>
 </div>

<div class="tab-content">
    <div class="tab-pane fade in active " id="pegawai">
        <br>

    
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
              <div class="x_title">
            <h2><strong>BAHAGIAN 1 - KETERANGAN MENGENAI PEGAWAI</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
          
            <div class="x_content">
                          
<div style="margin-bottom: 30px;font-size: 15px;">
    <table width="800px" height="80px">
        <tr>
            <td>Nama Kakitangan</td>
            <td>: <?= ucwords(strtolower($maklumat->AssetOwnerNm))?></td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>: <?= $maklumat->icno?></td>
        </tr>
        <tr>
            <td>Jawatan dan Gred</td>
            <td>: <?=  $maklumat->jawatan ?></td>
        </tr>
         <tr>
            <td>Jabatan</td>
            <td>: <?=  $maklumat->jfpiu ?></td>
        </tr>
         <tr>
            <td>Status Lantikan</td>
            <td>: <?=  $maklumat->status_lantikan?></td>
        </tr>
         <tr>
            <td>Tarikh Lantikan</td>
            <td>: <?=  $maklumat->tarikh_lantikan?></td>
        </tr>
         <tr>
            <td>Tarikh Sandangan</td>
            <td>: <?=  $maklumat->tarikh_sandangan ?></td>
        </tr>
         
    </table>
</div>

            </div>
        
    
        <div class="x_title">
           <h2><strong>BAHAGIAN 2 - JUMLAH PENDAPATAN DAN TANGGUNGAN BULANAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            
        <table class="table table-sm table-bordered">
                <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                     <th class="text-center">Jenis Pendapatan</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
            
                   <?php foreach ($b as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
                  
                <?php foreach ($model2 as $key=>$item): ?>
                      
                           
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN (RM)</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td></tr>
                    
                <?php endforeach; ?>
                
            </table>
     
           
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                 <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                      <th class="text-center">Jenis Pendapatan / Elaun Lain</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
                
                
                
                        
                         <?php if($elaun) {
                    
                   foreach ($elaun as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->pendapatan?></td>
                    <td><?= $item->jumlah?></td>
                     
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                      <?php foreach ($jumElaun as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH ELAUN (RM)</strong></td>
                             <td><?= $item->jumElaun?></td>
                    
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
          
</div>
         
            <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered">

                      <?php foreach ($jumElaun as $key=>$item): ?>
                      
                           
                <tr>
                        
                             <td align="right"><strong>JUMLAH (RM) (Jumlah Pendapatan + Jlllumlah Elaun)</strong></td>
                             <td><?= $item->jumPendapatan?></td>
                            
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
    
</div>
            
             <div class="x_title">
            <h2><strong>BAHAGIAN 3 - TANGGUNGAN / ANSURAN BULANAN ATAS HUTANG / PINJAMAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                      <th class="text-center">Jenis Bayaran</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
                   <?php foreach ($pinjaman as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
                         <?php foreach ($jumlahPinjaman as $key=>$item): ?>
                        <tr>
                            <td></td>
                            <td align="right"><strong>JUMLAH BAYARAN / POTONGAN (RM)</strong></td>
                             <td><?= $item->MPH_TOTAL_DEDUCTION?></td>
                         
                        </tr>
                <?php endforeach; ?>
               
                    
            </table>
        </div>
  
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                       <th class="text-center">Jenis Bayaran / Tanggungan / Potongan</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
                
                
                
                <?php if($bayaran) {
                    
                   foreach ($bayaran as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->jenis->fullname?></td>
                    <td><?= $item->jumlah?></td>
                   
                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                
                     <?php foreach ($jumBayaran as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH BAYARAN / POTONGAN (RM)</strong></td>
                             <td><?= $item->jumBayaran?></td>
                             
                    </tr>
                    
                <?php endforeach; ?>
                
                        
            </table>
    </div>
        
        </div>
           
             <div class="x_content">
  
            <div class="table-responsive">
            <table class="table table-sm table-bordered">

                
                    
                  <?php foreach ($jumBayaran as $key=>$item): ?>
                    <tr>
                             <td align="right"><strong>JUMLAH (RM)(Jumlah Bayaran + Jumlah Bayaran lain-lain)</strong></td>
                             <td><?= $item->jumPemotongan?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
    </div>
             </div>
            
            
             <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
            
                 <?php if($pasangan2 != null){
                if(($pasangankedua == true) && ($pasangan2 == $pasangankedua)){
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PENDAPATAN  (PEGAWAI + PASANGAN) (RM)';   
                echo '<td>'; 
                //echo $pendapatanPasangan2->jumPendapatanSemua;
               // echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemua; 
                if(($pendapatanPasangan2->icno != null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null)) {
                    echo $pendapatanPasangan2->jumPendapatanSemua;
                }  
                if  ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null){
                     echo  $MPH_STAFF_ID->jumPendapatanSemua;
                 }
                  if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID == null))  {
                     echo $MPH_STAFF_ID->jumPendapatan;
                }
                     
//                if(($pendapatanPasangan2->icno != null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID == null)) {
//                    echo $pendapatanPasangan2->jumPendapatanSemua;
//                }if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID != null)) {
//                      echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemua; 
//                }if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID == null))  {
//                     echo $MPH_STAFF_ID->jumPendapatan;
//                }
                
                echo '</tr>';
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PINJAMAN (PEGAWAI + PASANGAN) (RM)'; 
                echo '<td>'; 
                if (($potong2->icno != null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null)) {
                     echo $potong2->jumPemotonganSemua;
                  }
                 if  ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null){
                     echo  $MPH_STAFF_ID->jumPemotonganSemua;
                 }
                 if(($potong2->icno == null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null))  {
                        echo $MPH_STAFF_ID->jumPemotongan;
                 }
                 
//                 if ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null) {
//                     echo $potong2->jumPemotonganSemua;
//                  }
//                 if  ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null){
//                     echo  $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPemotonganSemua;
//                 }
//                 if(($potong2->icno == null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null))  {
//                        echo $MPH_STAFF_ID->jumPemotongan;
//                 }
                echo '</tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BERSIH PEGAWAI DAN PASANGAN (PENDAPATAN - PINJAMAN) (RM)';
                echo '<td>';
                 
//                   if ($a->CONm != null){
//                   echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanBersih;
//                  }else{
//                      echo  $potong2->jumPendapatanBersih;
//                 }
                 if ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null) {
                     echo $potong2->jumPendapatanBersih;
                  }
                 else if  ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null){
                     echo  $MPH_STAFF_ID->jumPendapatanBersih;
                 }
           
                  if(($potong2->icno == null) && ($pendapatanPasangan2->icno == null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null))  {
                    echo ($MPH_STAFF_ID->jumPendapatan - $MPH_STAFF_ID->jumPemotongan) ;
                }
                 if(($potong2->icno == null) && ($pendapatanPasangan2->icno != null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null))  {
                       echo ($pendapatanPasangan2->jumPendapatanSemua - $MPH_STAFF_ID->jumPemotongan) ;
                 }
                echo '</td>';
       }else{
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PENDAPATAN (PEGAWAI + PASANGAN) (RM)';   
                echo '<td>'; echo $pendapatanPasangan2->jumPendapatanSemuaKedua;
                echo '</tr>';
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PINJAMAN (PEGAWAI + PASANGAN) (RM)'; 
                echo '<td>'; if (($potong2Kedua->icno != null) && ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID != null)){
                     echo '';
                  }else{
                    echo $potong2Kedua->jumPemotonganSemuaKedua;
                 }
                 if ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID != null){
                     echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPemotonganSemua;
                  }else{
                      echo '';
                 }
                echo '</tr>';
                echo '<td align="right"><strong> (RM)';
                echo 'JUMLAH BERSIH PEGAWAI DAN PASANGAN (PENDAPATAN - PINJAMAN)';
                echo '<td>';
                 
                   if ($a->CONm != null){
                   echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanBersihKedua;
                  }else{
                      echo  $potong2Kedua->jumPendapatanBersihKedua;
                 }
       }
                 }
           ?>
                
                <?php if($pasangan2 == null){
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH PENDAPATAN PEGAWAI (RM)';   
                echo '<td>'; 
                echo $MPH_STAFF_ID->jumPendapatan; 
                echo '</tr>';
                
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH PINJAMAN PEGAWAI (RM)';   
                echo '<td>'; 
                echo $MPH_STAFF_ID->jumPemotongan; 
                echo '</tr>';
                
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BERSIH PEGAWAI(PENDAPATAN - PINJAMAN) (RM)';   
                echo '<td>'; 
                echo $MPH_STAFF_ID->jumPendapatanBersihIndividu; 
                echo '</tr>';
               }
           ?>
            </table>
    </div>
    
</div>
             
             
              <div class="x_title">
            <h2><strong>BAHAGIAN 4 (A) - KETERANGAN MENGENAI HARTA SEDIA ADA/PERTAMBAHAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
       <div class="tbl-serah-tugas-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">HTA / HA</th>
                    <th class="text-center">Jenis Harta</th>
                    <th class="text-center">Spesifikasi Harta</th>
                    <th class="text-center">Pemilikan</th>
                    <th class="text-center">Cara dan dari Siapa Harta Diperolehi(dipusakai,
                 dibeli, dihadiahkan, dll)</th>
                    <th class="text-center">Tarikh Pemilikan</th>
                   <th class="text-center">Nilai Pembelian Aset(RM)</th>
                 
                     <th> Tindakan </th>
                </tr>
                         <?php if($model) {
                    
                   foreach ($model as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= strtoupper($item->hta->jenis_harta)?></td>
                    <td><?= strtoupper($item->jenisHarta->keterangan)?></td>
                     <td><?= strtoupper($item->spesifikasiHarta->keterangan)?></td>
                      <td><?= strtoupper($options[$item->pemilikan])?></td>
                      <td>
                        <?php  if ($item->AcqSrcCd == 'XX'){
                    echo strtoupper($item->cara);
                  }else{
                    echo strtoupper($item->caraDiperolehi->AcqSrcNm);
                 }
                ?>
                   </td>
                      
                      <td><?= $item->tarikhPemilikan?></td>
                     <td>RM  <?=$item->AlPurchasedValue?></td>
                   
                     <td class="text-center"> <?= Html::a('<i class="fa fa-info" aria-hidden="true"></i>', ['detail-harta', 'id' => $item->id])?></td>  
               
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="11" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
               
            </table>
    </div>
          
</div>

    </div>
            
                         <div class="x_title">
            <h2><strong>BAHAGIAN 4 (B) - KETERANGAN MENGENAI PELUPUSAN HARTA</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
       <div class="tbl-serah-tugas-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">HTA / HA</th>
                    <th class="text-center">Jenis Harta</th>
                    <th class="text-center">Spesifikasi Harta</th>
                    <th class="text-center">Pemilikan</th>
                    <th class="text-center">Cara dan dari Siapa Harta Diperolehi(dipusakai,
                 dibeli, dihadiahkan, dll)</th>
                    <th class="text-center">Tarikh Pemilikan</th>
                   <th class="text-center">Nilai Pembelian Aset(RM)</th>
                 
                     <th> Tindakan </th>
                </tr>
                         <?php if($modelz) {
                    
                   foreach ($modelz as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= strtoupper($item->hta->jenis_harta)?></td>
                    <td><?= strtoupper($item->jenisHarta->keterangan)?></td>
                     <td><?= strtoupper($item->spesifikasiHarta->keterangan)?></td>
                      <td><?= strtoupper($options[$item->pemilikan])?></td>
                      <td>
                        <?php  if ($item->AcqSrcCd == 'XX'){
                    echo strtoupper($item->cara);
                  }else{
                    echo strtoupper($item->caraDiperolehi->AcqSrcNm);
                 }
                ?>
                   </td>
                      
                      <td><?= $item->tarikhPemilikan?></td>
                     <td>RM  <?=$item->AlPurchasedValue?></td>
                    <td class="text-center"> <?= Html::a('<i class="fa fa-info" aria-hidden="true"></i>', ['detail-harta', 'id' => $item->id])?></td>  
               
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="11" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
         
            </table>
    </div>
          
</div>

    </div>
    </div>
    </div>
    </div>

         <div class="tab-pane fade " id="pasangan">
    
        <br>
    <div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
              <h2><strong>BAHAGIAN 1 - KETERANGAN MENGENAI PASANGAN PEGAWAI </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            <div class="table-responsive">
         
                          
<div style="margin-bottom: 30px;font-size: 15px;">
    <table width="800px" height="80px">
        <tr>
            <td>Nama Pasangan</td>
            <td>:<?php  if ($a->CONm != null){
                     echo "\n"; echo  ucwords(strtolower($a->CONm)); 
                  }else{
                     echo " \n";  echo ucwords(strtolower($pasangan2->FmyNm));
                 }
                ?></td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>: <?php  if ($a->ICNO != null){
                     echo "\n"; echo  $a->ICNO; 
                  }else{
                     echo " \n";  echo $pasangan2->FamilyId;
                 }
                ?></td>
        </tr>
        <tr>
            <td>Jawatan dan Gred</td>
            <td>:<?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->jawatan->nama; echo "\n"; echo '('; echo($a->jawatan->gred); echo ')';
                  }else{
                     echo " \n";  echo 'Tidak Berkenaan';
                 }
                ?></td>
        </tr>
         <tr>
            <td>Jabatan</td>
            <td>: <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->department->fullname; 
                  }else{
                      echo " \n";  echo 'Tidak Berkenaan';
                 }
                ?></td>
        </tr>
         <tr>
            <td>Status Lantikan</td>
            <td>:  <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->statusLantikan->ApmtStatusNm;
                  }else{
                 echo " \n";  echo 'Tidak Berkenaan';
                 }?></td>
        </tr>
         <tr>
            <td>Tarikh Lantikan</td>
            <td>:  <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->displayStartDateSandangan;
                  }else{
                   echo " \n";  echo 'Tidak Berkenaan';
                 }?></td>
        </tr>
         <tr>
            <td>Tarikh Sandangan</td>
            <td>:  <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->mulaLantikan->tarikhMulalantikan;
                  }else{
                    echo " \n";  echo 'Tidak Berkenaan';
                 }?></td>
        </tr>
         
    </table>
</div>

                     <div class="x_title">
           <h2><strong>BAHAGIAN 2 - JUMLAH PENDAPATAN DAN TANGGUNGAN BULANAN PASANGAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>

     
            <table class="table table-sm table-bordered"  style="display: <?php echo $displaymohon;?>">
                <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                 <th class="text-center">Jenis Pendapatan / Elaun Lain</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
            
                   <?php foreach ($bPasangan as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
                 
                   <?php foreach ($jumlahPinjamanPasangan as $key=>$item): ?>
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN (RM)</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td></tr>
                         <?php endforeach; ?>
          
                
            </table>
     
       
               <div class="table-responsive" style="display: <?php echo $displaymohon2;?>">
              
      
                      <table class="table table-sm table-bordered">
                
                  <?php if (($pend != null) && ($tambahPasangan == null)){
               echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan (RM)</th><th <td width="200px" height="20px">Jumlah (RM)</td></th></strong>' ;
                }
                 if (($pend == null) && ($tambahPasangan == null)){
             echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan (RM)</th><th <td width="200px" height="20px">Jumlah (RM)</td></th></strong>' ;
            
                }
                 ?> 
                       <?php if($pendapatanPasangan) {
                    
                      foreach ($pendapatanPasangan as $key=>$item) { ?>
                
                  
                        <tr>
                            <td>1</td>
                            <td>GAJI POKOK</td>
                            <td><?= $item->gaji_pokok?></td>
                         
                        </tr>
                         <tr>
                            <td>2</td>
                            <td>IMBUHAN TETAP KHIDMAT AWAM (ITKA)</td>
                            <td><?= $item->itka?></td>
                        </tr>
                           <tr>
                            <td>3</td>
                            <td>IMBUHAN TETAP KERAIAN (ITK)</td>
                            <td><?= $item->itk?></td>
                        </tr>
                          <tr>
                            <td>4</td>
                            <td>BAYARAN INSENTIF WILAYAH (BIW)</td>
                            <td><?= $item->biw?></td>
                        </tr>
                         <tr>
                            <td>5</td>
                            <td>IMBUHAN TETAP PERUMAHAN (ITP)</td>
                            <td><?= $item->itp?></td>
                        </tr>
                         <tr>
                            <td>6</td>
                            <td>ELAUN PERUMAHAN WILAYAH (EPW)</td>
                            <td><?= $item->epw?></td>
                        </tr>
                         <tr>
                            <td></td>
                            <td align="right"><strong>JUMLAH PENDAPATAN (RM)</strong></td>
                            <td><?= $item->jumlah?></td>
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
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
             <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                 <th class="text-center">Jenis Pendapatan / Elaun Lain</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
                
                        
                         <?php if($elaunPasangan) {
                    
                   foreach ($elaunPasangan as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->pendapatan?></td>
                    <td><?= $item->jumlah?></td>
         
               
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                      <?php foreach ($jumElaunPasangan as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH ELAUN (RM)</strong></td>
                             <td><?= $item->jumElaunPasangan?></td>
                      
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
          
</div>
         <div class="x_content">
  
            <div class="table-responsive">
            <table class="table table-sm table-bordered">

                
                    
                      <?php foreach ($jumElaunPasangan as $key=>$item): ?>
                      
                           
                <tr>
                        
                             <td align="right"><strong>JUMLAH (RM)(Jumlah Pendapatan + Jumlah Elaun)</strong></td>
                         
                            <td>  <?php  if ($item->pend->icno == null){
                     echo $item->jumPendapatanPasangan;
                  }else{
                      echo $item->jumPendapatanPasangan2;
                 }
                 ?></td>
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
    
</div>
    </div>
    

        <div class="x_title">
              <h2><strong>BAHAGIAN 3 - TANGGUNGAN / ANSURAN BULANAN ATAS HUTANG / PINJAMAN PASANGAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
    
           
               <table class="table table-sm table-bordered"  style="display: <?php echo $displaymohon;?>">
               
                <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                 <th class="text-center">Jenis Bayaran</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
    
              <?php foreach ($pinjamanPasangan as $key=>$items): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $items->it_income_desc?></td>
                             <td><?= $items->MPDH_PAID_AMT?></td>
                         
                        </tr>
                    <?php endforeach; ?>
                    
                        
                        
               
                         <?php foreach ($jumlahPinjamanPasangan as $key=>$item): ?>
                        <tr>
                            <td></td>
                            <td align="right"><strong>JUMLAH BAYARAN / POTONGAN (RM)</strong></td>
                             <td><?= $item->MPH_TOTAL_DEDUCTION?></td>
                         
                        </tr>
                <?php endforeach; ?>
                          
            </table>
           
        
                <?php

             ?> 
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
            <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                 <th class="text-center">Jenis Bayaran / Pemotongan</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
              
                </tr>
                
                <?php if($potong) {
                   foreach ($potong as $key=>$item) {   
                ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->jenisBayaran->fullname?></td>
                    <td><?= $item->jumlah?></td>
                   

                </tr>
                   <?php } 
                   
                } else{
                    ?>
                       <tr>
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                         
          
            </table>
    </div>
        
    </div>
     
</div>
    </div>
    
       <div class="tab-pane fade " id="pasangankedua">
    
        <br>
    <div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
              <h2><strong>BAHAGIAN 1 - KETERANGAN MENGENAI PASANGAN PEGAWAI </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            <div class="table-responsive">
         
                          
<div style="margin-bottom: 30px;font-size: 15px;">
    <table width="600px" height="80px">
        <tr>
            <td>Nama Pasangan</td>
            <td>:<?php  if ($a->CONm != null){
                     echo "\n"; echo  ucwords(strtolower($a->CONm)); 
                  }else{
                     echo " \n";  echo ucwords(strtolower($pasangankedua->FmyNm));
                 }
                ?></td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>: <?php  if ($a->ICNO != null){
                     echo "\n"; echo  $a->ICNO; 
                  }else{
                     echo " \n";  echo $pasangankedua->FamilyId;
                 }
                ?></td>
        </tr>
        <tr>
            <td>Jawatan dan Gred</td>
            <td>:<?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->jawatan->nama; echo "\n"; echo '('; echo($a->jawatan->gred); echo ')';
                  }else{
                     echo " \n";  echo 'Tidak Berkenaan';
                 }
                ?></td>
        </tr>
         <tr>
            <td>Jabatan</td>
            <td>: <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->department->fullname; 
                  }else{
                      echo " \n";  echo 'Tidak Berkenaan';
                 }
                ?></td>
        </tr>
         <tr>
            <td>Status Lantikan</td>
            <td>:  <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->statusLantikan->ApmtStatusNm;
                  }else{
                 echo " \n";  echo 'Tidak Berkenaan';
                 }?></td>
        </tr>
         <tr>
            <td>Tarikh Lantikan</td>
            <td>:  <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->displayStartDateSandangan;
                  }else{
                   echo " \n";  echo 'Tidak Berkenaan';
                 }?></td>
        </tr>
         <tr>
            <td>Tarikh Sandangan</td>
            <td>:  <?php  if ($a->ICNO != null){
                     echo "\n"; echo $a->mulaLantikan->tarikhMulalantikan;
                  }else{
                    echo " \n";  echo 'Tidak Berkenaan';
                 }?></td>
        </tr>
         
    </table>
</div>

                     <div class="x_title">
           <h2><strong>BAHAGIAN 2 - JUMLAH PENDAPATAN DAN TANGGUNGAN BULANAN PASANGAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>

       
               <div class="table-responsive" style="display: <?php echo $displaymohon;?>">
              
      
                      <table class="table table-sm table-bordered">
                
                  <?php if (($pendKedua != null) && ($tambahPasangan == null)){
               echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan (RM)</th><th <td width="200px" height="20px">Jumlah (RM)</td></th></strong>' ;
                }
                 if (($pendKedua == null) && ($tambahPasangan == null)){
             echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan (RM)</th><th <td width="200px" height="20px">Jumlah (RM)</td></th></strong>' ;
            
                }
                 ?> 
               
                
                    <?php foreach ($pendapatanPasanganKedua as $key=>$item): ?>
                        <tr>
                            <td>1</td>
                            <td>GAJI POKOK</td>
                            <td><?= $item->gaji_pokok?></td>
                         
                        </tr>
                         <tr>
                            <td>2</td>
                            <td>IMBUHAN TETAP KHIDMAT AWAM (ITKA)</td>
                            <td><?= $item->itka?></td>
                        </tr>
                           <tr>
                            <td>3</td>
                            <td>IMBUHAN TETAP KERAIAN (ITK)</td>
                            <td><?= $item->itk?></td>
                        </tr>
                          <tr>
                            <td>4</td>
                            <td>BAYARAN INSENTIF WILAYAH (BIW)</td>
                            <td><?= $item->biw?></td>
                        </tr>
                         <tr>
                            <td>5</td>
                            <td>IMBUHAN TETAP PERUMAHAN (ITP)</td>
                            <td><?= $item->itp?></td>
                        </tr>
                         <tr>
                            <td>6</td>
                            <td>ELAUN PERUMAHAN WILAYAH (EPW)</td>
                            <td><?= $item->epw?></td>
                        </tr>
                         <tr>
                            <td></td>
                            <td align="right"><strong>JUMLAH PENDAPATAN (RM)</strong></td>
                            <td><?= $item->jumlah?></td>
                        </tr>
                       
                <?php endforeach; ?>
          
            </table>
    </div>
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
             <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                 <th class="text-center">Jenis Pendapatan / Elaun Lain</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
                </tr>
                
                        
                         <?php if($elaunPasanganKedua) {
                    
                   foreach ($elaunPasanganKedua as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->pendapatan?></td>
                    <td><?= $item->jumlah?></td>
         
               
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                      <?php foreach ($jumElaunPasanganKedua as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH ELAUN (RM)</strong></td>
                             <td><?= $item->jumElaunPasanganKedua?></td>
                      
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
          
</div>
         <div class="x_content">
  
            <div class="table-responsive">
            <table class="table table-sm table-bordered">

                
                    
                      <?php foreach ($jumElaunPasanganKedua as $key=>$item): ?>
                      
                           
                <tr>
                        
                             <td align="right"><strong>JUMLAH (RM)(Jumlah Pendapatan + Jumlah Elaun)</strong></td>
                         
                            <td>  <?php  if ($item->pend->icno == null){
                     echo $item->jumPendapatanPasanganKedua;
                  }else{
                      echo $item->jumPendapatanPasangan2kedua;
                 }
                 ?></td>
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
    
</div>
    </div>
    

        <div class="x_title">
              <h2><strong>BAHAGIAN 3 - TANGGUNGAN / ANSURAN BULANAN ATAS HUTANG / PINJAMAN PASANGAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
    
        
                <?php

             ?> 
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
            <tr>
                 <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                 <th class="text-center">Jenis Bayaran / Pemotongan</th>
                 <th <td width="200px" height="20px"><strong>Jumlah (RM)</strong></td></th>
              
                </tr>
                
                <?php if($potongKedua) {
                   foreach ($potongKedua as $key=>$item) {   
                ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->jenisBayaran->fullname?></td>
                    <td><?= $item->jumlah?></td>
                   

                </tr>
                   <?php } 
                   
                } else{
                    ?>
                       <tr>
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                 
                      
                           
                    <tr>
                         <td></td>
                             <td align="right"><strong>JUMLAH PEMOTONGAN (RM)</strong></td>
                             <td><?= $potong2Kedua->totalPemotonganPasanganKedua?></td>
                         
                    </tr>
               
          
            </table>
    </div>
             <div class="x_content">
  
            <div class="table-responsive">
            <table class="table table-sm table-bordered">

                
                    
                      <?php foreach ($jumElaunPasanganKedua2 as $key=>$item): ?>
                      
                           
                <tr>
                        
                             <td align="right"><strong>JUMLAH BAYARAN KESELURUHAN (RM)</strong></td>
                       
                            <td>  <?php  if ($item->icno != null){
                   echo $item->jumPemotonganPasangan2;
                  }else{
                      echo '';
                 }
                 ?></td>

                    </tr>
                    
                <?php endforeach; ?>
                  
            </table>
    </div>
    
</div>
        
    </div>
     
</div>
    </div>
    </div>
 </div>





