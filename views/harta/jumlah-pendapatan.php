<?php

use yii\helpers\Html;
$title = $this->title = 'Pendapatan';

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
            <h2><strong>BAHAGIAN 2 - Jumlah Pendapatan Dan Tanggungan Bulanan</strong></h2>
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
                     <th class="text-center">Jenis Pendapatan</th>
                   <th <td width="200px" height="20px"><strong>Jumlah</strong></td></th>
                    
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
                             <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td></tr>
                    
                <?php endforeach; ?>
                    
            </table>
        </div>
              
             <?= Html::a('Tambah', ['tambah-elaun'], ['class' => 'btn btn-primary']) ?> 
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                   <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                    <th class="text-center">Jenis Pendapatan / Elaun Lain</th>
                    <th <td width="200px" height="20px"><strong>Jumlah</strong></td></th>
                    <th <td width="50px" height="20px"><strong>Tindakan</strong></td></th>
                </tr>
           
                
                        
                         <?php if($elaun) {
                    
                   foreach ($elaun as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->pendapatan?></td>
                    <td><?= $item->jumlah?></td>
                     <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-elaun', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-elaun', 'id' => $item->id], [
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
                    
                      <?php foreach ($jumElaun as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH ELAUN</strong></td>
                             <td><?= $item->jumElaun?></td>
                             <td></td>
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
                 <td align="right"><strong>JUMLAH (Jumlah Pendapatan + Jumlah Elaun)</strong></td>
                 <td><?= $item->jumPendapatan?></td>
                            
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
               // echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemua; 
                 if(($pendapatanPasangan2->icno != null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID == null)) {
                    echo $pendapatanPasangan2->jumPendapatanSemua;
                }if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID != null)) {
                      echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemua; 
                }if(($pendapatanPasangan2->icno == null)&& ($MPH_STAFF_ID_PASANGAN_JUMLAH->MPH_STAFF_ID == null))  {
                     echo $MPH_STAFF_ID->jumPendapatan;
                }
                echo '</tr>';
               }else{
                echo '<tr>';
                echo '<td align="right"><strong> ';
                echo 'JUMLAH BESAR PENDAPATAN (PEGAWAI + PASANGAN)';   
                echo '<td>'; echo $pendapatanPasangan2->jumPendapatanSemuaKedua;
                echo $MPH_STAFF_ID_PASANGAN_JUMLAH->jumPendapatanSemuaKedua; 
                echo '</tr>';
               }
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
            <h2><strong>BAHAGIAN 2 - Jumlah Pendapatan Dan Tanggungan Bulanan Pasangan</strong></h2>
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
</div>
             <div class="table-responsive" style="display: <?php echo $displaymohon;?>">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                     <th class="text-center">Jenis Pendapatan</th>
                    <th class="text-center">Jumlah</th>
            
                   <?php foreach ($bPasangan as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
                  
                <?php foreach ($model2Pasangan as $key=>$item): ?>
                      
                           
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td></tr>
                    
                <?php endforeach; ?>
                
            </table></div>

            
            <div class="table-responsive" style="display: <?php echo $displaymohon2;?>">
                <?php if (($pend == null) && ($tambahPasangan == null)){
             echo Html::a('Tambah Pendapatan', ['tambah-pendapatan-pasangan'], ['class' => 'btn btn-primary']);
                }
                if (($pend != null) && ($tambahPasangan == null)){
             echo Html::a('Kemaskini Pendapatan', ['tambah-pendapatan-pasangan'], ['class' => 'btn btn-success']);
                }
                
                
             ?> 
               
      
            <table class="table table-sm table-bordered">
                
                       <?php if (($pend != null) && ($tambahPasangan == null)){
               echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan</th><th <td width="200px" height="20px">Jumlah</td></th></strong>' ;
                }
                 if (($pend == null) && ($tambahPasangan == null)){
             echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan</th><th <td width="200px" height="20px">Jumlah</td></th></strong>' ;
            
                }
                 ?> 
               
                
                    <?php foreach ($pendapatanPasangan as $key=>$item): ?>
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
                            <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                            <td><?= $item->jumlah?></td>
                        </tr>
                       
                <?php endforeach; ?>
          
            </table>
    </div>
                   
         
             <?= Html::a('Tambah Elaun', ['tambah-elaun-pasangan'], ['class' => 'btn btn-primary']) ?> 
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                    <th class="text-center">Jenis Pendapatan d/ Elaun Lain</th>
                   <th <td width="200px" height="20px"><strong>Jumlah</strong></td></th>
                   <th <td width="50px" height="20px"><strong>Tindakan</strong></td></th>
                </tr>
                
                        
                         <?php if($elaunPasangan) {
                    
                   foreach ($elaunPasangan as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->pendapatan?></td>
                    <td><?= $item->jumlah?></td>
                     <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-elaun-pasangan', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-elaun-pasangan', 'id' => $item->id], [
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
                    
                      <?php foreach ($jumElaunPasangan as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH ELAUN</strong></td>
                             <td><?= $item->jumElaunPasangan?></td>
                             <td></td>
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
                        
                             <td align="right"><strong>JUMLAH (Jumlah Pendapatan + Jumlah Elaun)</strong></td>
                         
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
     
</div>
    </div>
</div>
    
     <div class="tab-pane fade " id="pasangankedua">
        <br>
    <div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>BAHAGIAN 2 - Jumlah Pendapatan Dan Tanggungan Bulanan Pasangan</strong></h2>
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
             <div class="table-responsive" style="display: <?php echo $displaymohon;?>">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                     <th class="text-center">Jenis Pendapatan</th>
                    <th class="text-center">Jumlah</th>
            
                   <?php foreach ($bPasangan as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
                  
                <?php foreach ($model2Pasangan as $key=>$item): ?>
                      
                           
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td></tr>
                    
                <?php endforeach; ?>
                
            </table></div>

            
            <div class="table-responsive" style="display: <?php echo $displaymohon2;?>">
                <?php if (($pendKedua == null) && ($tambahPasangan == null)){
             echo Html::a('Tambah Pendapatan', ['tambah-pendapatan-pasangan-kedua'], ['class' => 'btn btn-primary']);
                }
                if (($pendKedua != null) && ($tambahPasangan == null)){
             echo Html::a('Kemaskini Pendapatan', ['tambah-pendapatan-pasangan-kedua'], ['class' => 'btn btn-success']);
                }
                
                
             ?> 
               
      
            <table class="table table-sm table-bordered">
                
                       <?php if (($pendKedua != null) && ($tambahPasangan == null)){
               echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan</th><th <td width="200px" height="20px">Jumlah</td></th></strong>' ;
                }
                 if (($pendKedua == null) && ($tambahPasangan == null)){
             echo '<strong><th <td width="50px" height="20px">Bil</td></th><th>Jumlah Pendapatan</th><th <td width="200px" height="20px">Jumlah</td></th></strong>' ;
            
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
                            <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                            <td><?= $item->jumlah?></td>
                        </tr>
                       
                <?php endforeach; ?>
          
            </table>
    </div>
                   
         
             <?= Html::a('Tambah Elaun', ['tambah-elaun-pasangan-kedua'], ['class' => 'btn btn-primary']) ?> 
            
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th <td width="50px" height="20px"><strong>Bil</strong></td></th>
                    <th class="text-center">Jenis Pendapatan d/ Elaun Lain</th>
                   <th <td width="200px" height="20px"><strong>Jumlah</strong></td></th>
                   <th <td width="50px" height="20px"><strong>Tindakan</strong></td></th>
                </tr>
                
                        
                         <?php if($elaunPasanganKedua) {
                    
                   foreach ($elaunPasanganKedua as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $item->pendapatan?></td>
                    <td><?= $item->jumlah?></td>
                     <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-elaun-pasangan', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-elaun-pasangan', 'id' => $item->id], [
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
                    
                      <?php foreach ($jumElaunPasanganKedua as $key=>$item): ?>
                      
                           
                    <tr><td></td>
                        
                             <td align="right"><strong>JUMLAH ELAUN</strong></td>
                             <td><?= $item->jumElaunPasanganKedua?></td>
                             <td></td>
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
                        
                             <td align="right"><strong>JUMLAH (Jumlah Pendapatan + Jumlah Elaun)</strong></td>
                         
                            <td>  <?php  if ($item->pend->icno == null){
                     echo $item->jumPendapatanPasanganKedua;
                  }else{
                      echo $item->jumPendapatanPasangan2Kedua;
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
    </div>
     

    


