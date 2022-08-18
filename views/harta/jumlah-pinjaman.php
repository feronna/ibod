<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\cuti\AksesPengguna;
use app\models\vhrms\ViewPayroll;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use app\models\hronline\Tblprcobiodata;

$title = $this->title = 'Pinjaman';

?>

<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>
<div class="x_panel">
<?php if ($models == false){
   echo $this->render('_menu1', ['title' => $title]) ;      
}else{
    echo $this->render('_menu4', ['title' => $title]) ;   
}
?>

 <div class="col-md-12 col-sm-12 col-xs-12 "> 
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link " href="#pegawai" data-toggle="tab">Pegawai</a>
    </li>   <?php if($pasangan != null){
        echo '<li><a data-toggle="tab" href="#pasangan">Pasangan</a></li>';
    } else{
        echo '';
    }
    
     if($pasangan != null){
    if(($pasangankedua == true) && ($pasangan == $pasangankedua)){
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
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>BAHAGIAN 3 - TANGGUNGAN / ANSURAN BULANAN ATAS HUTANG / PINJAMAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            <div class="table-responsive">
                
                 <div style="margin-bottom: 10px;font-size: 12px;">
    <table width="500px" height="80px">
        <tr>
            <td>Nama Pegawai</td>
            <td>: <?= ucwords(strtolower($self->CONm))?></td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>: <?= $self->ICNO?></td>
         </tr>
    </table>
</div>          
            <table class="table table-sm table-bordered">
                <tr>
                     <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                     <th class="text-center">Jenis Bayaran</th>
                     <th <td width="200px" height="20px"><strong>Jumlah</strong></td></th>
                    
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
                             <td align="right">JUMLAH BAYARAN / POTONGAN</td>
                             <td><?= $item->MPH_TOTAL_DEDUCTION?></td>
                         
                        </tr>
                <?php endforeach; ?>
             
                    
            </table>
        </div>
              
             <?= Html::a('Tambah', ['tambah-bayaran'], ['class' => 'btn btn-primary']) ?> 
            
             <div class="table-responsive">
             <table class="table table-sm table-bordered">
                <tr>
                    <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                    <th class="text-center">Jenis Bayaran / Tanggungan / Potongan</th>
                    <th <td width="200px" height="20px"><strong>Jumlah</strong></td></th>
                    <th <td width="50px" height="20px"><strong>Tindakan</strong></td></th>
                </tr>
                
                <?php if($bayaran) {
                    
                   foreach ($bayaran as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->jenis->fullname?></td>
                    <td><?= $item->jumlah?></td>
                     <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-bayaran', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-bayaran', 'id' => $item->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
               
                </tr>

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
                        
                             <td align="right"><strong>JUMLAH BAYARAN / POTONGAN</strong></td>
                             <td><?= $item->jumBayaran?></td>
                             <td></td>
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
                        
                             <td align="right"><strong>JUMLAH (Jumlah Bayaran + Jumlah Bayaran lain-lain)</strong></td>
                             <td><?= $item->jumPemotongan?></td>
                            
                    </tr>
                    
                <?php endforeach; ?>
                  

            </table>
    </div>
    
</div>
            <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
            
                 <?php if($pasangan != null){
                if(($pasangankedua == true) && ($pasangan == $pasangankedua)){
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PENDAPATAN  (PEGAWAI + PASANGAN)';   
                echo '<td>';
                //echo $pendapatanPasangan2->jumPendapatanSemua;
                //echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemua; 
                 if(($pendapatanPasangan2->icno != null)&& ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null)) {
                    echo $pendapatanPasangan2->jumPendapatanSemua;
                }if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null)) {
                      echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemua; 
                }if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null))  {
                     echo $MPH_STAFF_ID->jumPendapatan;
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PINJAMAN (PEGAWAI + PASANGAN)'; 
                echo '<td>'; 
                if ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null) {
                     echo $potong2->jumPemotonganSemua;
                  }
                 if  ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null){
                     echo  $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPemotonganSemua;
                 }
                 if(($potong2->icno == null) && ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null))  {
                        echo $MPH_STAFF_ID->jumPemotongan;
                 }
                echo '</tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BERSIH PEGAWAI DAN PASANGAN (PENDAPATAN - PINJAMAN)';
                echo '<td>';
                 
//                   if ($a->CONm != null){
//                   echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanBersih;
//                  }else{
//                      echo  $potong2->jumPendapatanBersih;
//                 }
//                if (($potong2->icno != null) && ($a->CONm == null)){
//                    echo  $potong2->jumPendapatanBersih;
//                 }else{
//                      echo $MPH_STAFF_ID->jumPemotongan;
//                 }
                  if ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID == null) {
                     echo $potong2->jumPendapatanBersih;
                  }
                 if  ($MPH_STAFF_ID_PASANGAN->MPH_STAFF_ID != null){
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
                echo 'JUMLAH BESAR PENDAPATAN  (PEGAWAI + PASANGAN)';   
                echo '<td>'; echo $pendapatanPasangan2->jumPendapatanSemuaKedua;
                echo '</tr>';
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PINJAMAN (PEGAWAI + PASANGAN)'; 
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
                echo '<td align="right"><strong> ';
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
                
                <?php if($pasangan == null){
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH PENDAPATAN PEGAWAI';   
                echo '<td>'; 
                echo $MPH_STAFF_ID->jumPendapatan; 
                echo '</tr>';
                
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH PINJAMAN PEGAWAI';   
                echo '<td>'; 
                echo $MPH_STAFF_ID->jumPemotongan; 
                echo '</tr>';
                
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BERSIH PEGAWAI(PENDAPATAN - PINJAMAN)';   
                echo '<td>'; 
                echo $MPH_STAFF_ID->jumPendapatanBersihIndividu; 
                echo '</tr>';
               }
           ?>
            </table>
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
              <h2><strong>BAHAGIAN 3 - TANGGUNGAN / ANSURAN BULANAN ATAS HUTANG / PINJAMAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            <div class="table-responsive">
                          
<div style="margin-bottom: 10px;font-size: 12px;">
    <table width="500px" height="80px">
        <tr>
            <td>Nama Pasangan</td>
            <td>:<?php  if ($a->CONm != null){
                     echo "\n"; echo  ucwords(strtolower($a->CONm)); 
                  }else{
                     echo " \n";  echo ucwords(strtolower($pasangan->FmyNm));
                 }
                ?> </td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>:<?php  if ($a->ICNO != null){
                     echo "\n"; echo  $a->ICNO; 
                  }else{
                     echo " \n";  echo $pasangan->FamilyId;
                 }
                ?> </td>
         </tr>
    </table>
    
</div>          <?php if($display == '') {
                foreach ($pinjamanPasangan2 as $key=>$item): ?>
                <table class="table table-sm table-bordered" style="$display-none">
               
                <tr>
                    <th class="text-center">Bil</th>
                     <th class="text-center">Jenis Bayaran</th>
                    <th class="text-center">Jumlah</th>
                    
                </tr>
              <?php if($display == '') {
                      foreach ($pinjamanPasangan as $key=>$items): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $items->it_income_desc?></td>
                             <td><?= $items->MPDH_PAID_AMT?></td>
                         
                        </tr>

                        
               
                      <?php endforeach;} ?>  
                         <?php foreach ($jumlahPinjamanPasangan as $key=>$item): ?>
                        <tr>
                            <td></td>
                             <td align="right">JUMLAH BAYARAN / POTONGAN</td>
                             <td><?= $item->MPH_TOTAL_DEDUCTION?></td>
                         
                        </tr>
                <?php endforeach; ?>
                            <?php endforeach;} ?>   
            </table>
        
        </div>
        </div>
                <?php
             echo Html::a('Tambah Pemotongan', ['tambah-pemotongan-pasangan'], ['class' => 'btn btn-success']);
               
             ?> 
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                    <th class="text-center">Jenis Bayaran / Pemotongan</th>
                    <th <td width="200px" height="20px"><strong>Tindakan</strong></td></th>
                    <th <td width="50px" height="20px"><strong>Tindakan</strong></td></th>
                </tr>
                
                <?php if($potong) {
                   foreach ($potong as $key=>$item) {   
                ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->jenisBayaran->fullname?></td>
                    <td><?= $item->jumlah?></td>
                     <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-bayaran-pasangan', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-bayaran-pasangan', 'id' => $item->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>

                </tr>
                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                 
                      
                           
                    <tr>
                        
                             <td colspan="3" align="right"><strong>JUMLAH PEMOTONGAN</strong></td>
                             <td><?= $potong2->totalPemotonganPasangan?></td>
                           
                    </tr>
               
          
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
              <h2><strong>BAHAGIAN 3 - TANGGUNGAN / ANSURAN BULANAN ATAS HUTANG / PINJAMAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            <div class="table-responsive">
                          
<div style="margin-bottom: 10px;font-size: 12px;">
    <table width="500px" height="80px">
        <tr>
            <td>Nama Pasangan</td>
            <td>:<?php  if ($a->CONm != null){
                     echo "\n"; echo  ucwords(strtolower($a->CONm)); 
                  }else{
                     echo " \n";  echo ucwords(strtolower($pasangankedua->FmyNm));
                 }
                ?> </td>
        </tr>
         <tr>
            <td>No. Kad Pengenalan / Paspot</td>
            <td>:<?php  if ($a->ICNO != null){
                     echo "\n"; echo  $a->ICNO; 
                  }else{
                     echo " \n";  echo $pasangankedua->FamilyId;
                 }
                ?> </td>
         </tr>
    </table>
    
</div>          
        </div>
        </div>
                <?php
             echo Html::a('Tambah Pemotongan', ['tambah-pemotongan-pasangan-kedua'], ['class' => 'btn btn-success']);
               
             ?> 
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                    <th class="text-center">Jenis Bayaran / Pemotongan</th>
                    <th <td width="200px" height="20px"><strong>Tindakan</strong></td></th>
                    <th <td width="50px" height="20px"><strong>Tindakan</strong></td></th>
                </tr>
                
                <?php if($potongKedua) {
                   foreach ($potongKedua as $key=>$item) {   
                ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->jenisBayaran->fullname?></td>
                    <td><?= $item->jumlah?></td>
                     <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-bayaran-pasangan', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-bayaran-pasangan', 'id' => $item->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>

                </tr>
                   <?php } 
                   
                } else{
                    ?>
                 <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                 
                      
                           
                    <tr>
                        
                             <td colspan="3" align="right"><strong>JUMLAH PEMOTONGAN</strong></td>
                             <td><?= $potong2Kedua->totalPemotonganPasanganKedua?></td>
                           
                    </tr>
               
          
            </table>
    </div>
             <div class="x_content">
  
            <div class="table-responsive">
            <table class="table table-sm table-bordered">

                
                    
                      <?php foreach ($jumElaunPasanganKedua as $key=>$item): ?>
                      
                           
                <tr>
                        
                             <td align="right"><strong>JUMLAH BAYARAN KESELURUHAN</strong></td>
                       
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

     