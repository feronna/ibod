<?php

$statusLabel = [
        0 => 'Tidak Berpencen',
        1 => 'Berpencen'
   
];
error_reporting(0);

?>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     
     
     
     <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="400px" height="auto" alt="signature"/> <br><br>
                        </div>
                    </div>
      </div>

      <div style="margin-bottom:800px; text-align:center">
      <br><b><h2>BUKU PERKHIDMATAN UMS</h2></b>
      &nbsp; &nbsp;&nbsp;&nbsp; 
     </div>
     
      <div class="break"></div>


    <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; margin-top: 800px; font-size:15px;">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                            <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($nama->ICNO)); ?>.jpeg" width="100" height="120">
                        </div>
                    </div>
     </div> 
     
     
   
            <table> 
                
                    <thead> 
                     <tr class="headings">
                        <td class="column-title"  style="background-color:#2290F0" color="white" colspan="2" class="text-center"><font size="2">Maklumat Peribadi</td>  
                   </tr>
                   
     
                     
                    <tr class="headings">
                       <td id="customer"><font size="2">Nama Kakitangan</font></td>    
                       <td><font size="2"><?=  ucwords(strtolower($nama->CONm))?></font></td>
                   </tr>
                    <tr class="headings">
                        <td><font size="2">Rujukan No Fail</font></td>
                       <td><font size="2"><?=  $nama->COOldID ?></font></td>
                    </tr>
                    <tr class="headings">
                        <td><font size="2">No. Kad Pengenalan</font></td>
                       <td><font size="2"><?=   $nama->ICNO  ?></font></td>
                    </tr>
                     <tr class="headings">
                         <td><font size="2">Jantina</font></td>
                       <td><font size="2"><?=   $nama->jantina->Gender  ?></font></td>
                    </tr>
                     <tr class="headings">
                         <td><font size="2">Taraf Perkahwinan</font></td>  
                       <td><font size="2"><?=   $nama->tarafPerkahwinan->MrtlStatus   ?></font></td>
                    </tr>
                     <tr class="headings">
                         <td><font size="2">Tarikh Lahir</font></td>
                       <td><font size="2"><?= $nama->tarikhLahir ?></font></td>
                    </tr>
                      <tr class="headings">
                          <td><font size="2">Tempat Lahir</font></td>
                       <td><font size="2"><?= $nama->tempatLahir->State ?></font></td>
                    </tr>
                       <tr class="headings">
                           <td><font size="2">Negara Lahir</font></td>
                       <td><font size="2"><?=  $nama->negaraLahir->Country ?></font></td>
                    </tr>
                     <tr class="headings">
                         <td><font size="2">Agama</font></td>
                       <td><font size="2"><?=  $nama->agama->Religion ?></font></td>
                    </tr>
                    
                    <tr class="headings">
                         <td><font size="2">Bangsa</font></td>
                       <td><font size="2"><?=  $nama->bangsa->Race ?></font></td>
                    </tr>
                   
                    <tr class="headings">
                         <td><font size="2">No. Sijil Kerakyatan Persekutuan dan Tarikh</font></td>
                       <td><font size="2"></font></td>
                    </tr>
                    
                    <tr class="headings">
                         <td><font size="2">No. Akaun Bank</font></td>
                       <td><font size="2"><?= $akaun->SA_ACCT_NO?></font></td>
                    </tr>
                      <tr class="headings">
                         <td><font size="2">Nama Akaun Bank</font></td>
                       <td><font size="2"><?= $akaun->SA_BANK_CODE ?></font></td>
                    </tr>
                    <tr class="headings">
                         <td><font size="2">No. Pendaftaran Kumpulan Wang Simpanan Pekerja</font></td>
                       <td><font size="2"><?= $kwsp->SA_ACCT_NO ?></font></td>
                    </tr>
                    <tr class="headings">
                         <td><font size="2">No. Pendaftaran Kumpulan Wang Persaraan (Diperbadankan)</font></td>
                       <td><font size="2"><?= $kwap->SA_ACCT_NO ?></font></td>
                    </tr>
                      <tr class="headings">
                         <td><font size="2">No. Kira-kira Cukai Pendapatan (Hasil Dalam Negeri)</font></td>
                       <td><font size="2"><?= $cukai->SA_ACCT_NO ;?></font></td>
                    </tr>
   
                     <tr class="headings">
                        <td class="column-title"  style="background-color:#2290F0" color="white" colspan="2" class="text-center"><font size="2">Maklumat Jawatan Sekarang</td>  
                   </tr>
                    <tr class="headings">
                         <td><font size="2">Jawatan Sekarang</font></td>
                       <td><font size="2"><?= $nama->jawatan->nama . " (" . $nama->jawatan->gred . ")";?></font></td>
                    </tr>
                    <tr class="headings">
                         <td><font size="2">Tarikh Dilantik</font></td>
                         <td><font size="2">  <?php  if ($nama->tarikhDilantikPerkhidmatan->tarikhMulaLantikan != null){
                                                echo  $nama->tarikhDilantikPerkhidmatan->tarikhMulaLantikan;  
                                               }else{
                                               echo 'Tiada Rekod';
                                                    }?></font>
                         </td>
                    </tr>
                     <tr class="headings">
                         <td><font size="2">Tarikh Disahkan Dalam Jawatan</font></td>
                       <td><font size="2"><?php  if ($nama->sahJawatan->tarikhMula != null){
                                           echo $nama->sahJawatan->tarikhMula;  
                                           }else{
                                           echo 'Tiada Rekod'; }
                                           ?></font>
                       </td>
                    </tr>
                    <tr class="headings">
                         <td><font size="2">Jabatan Sekarang</font></td>
                       <td><font size="2"><?= $nama->department->fullname?></font></td>
                    </tr>
                    
                   <tr class="headings">
                        <td class="column-title"  style="background-color:#2290F0" color="white" colspan="2" class="text-center"><font size="2">Kenyataan Perkhidmatan</td>  
                   </tr>
                   
                    <tr class="headings">
                         <td><font size="2">Tarikh Layak Dimasukkan Ke Dalam Perjawatan Berpencen</font></td>
                       <td><font size="2"><?= $pencen->tarikhMula ?></font></td>
                    </tr>
                     <tr class="headings">
                         <td><font size="2">Tarikh Dimasukkan Ke Dalam Perjawatan Berpencen</font></td>
                       <td><font size="2"><?= $pencen->tarikhMula ?></font></td>
                    </tr>
                   <tr class="headings">
                         <td><font size="2">Tarikh Sampai Umur Dihadkan</font></td>
                       <td><font size="2"><?=$bersara-> tarikhKuatkuasa?></font></td>
                    </tr>
                   

                </thead>
            </table>
     
        <div class="break"></div>
        
        
         <div class="x_title">
                <h6><strong><i class="fa fa-book"></i>Butir-butir Jawatan Sebelum Lantikan Ke UMS</strong></h6>
                <div class="clearfix"></div>
            </div>
                  <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Bil</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Jawatan</font> </th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Tarikh Dilantik</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Nama Majikan</font></th>
      
                    </tr>

                </thead>
                <tbody>

                      <?php if($pengalaman) {
                          foreach ($pengalaman as $i=>$pengalamans) { ?>
                          <tr>
                          <td style="width:6%;"><font size="2"><?= $i+1; ?></font></td>
                          <td><font size="2"><?php if ($pengalamans->PrevEmpRemarks != null){
                              echo $pengalamans->PrevEmpRemarks;
                          }else{
                                  echo $pengalamans->Position;
                              }
                             ?>
                          </td>
                          <td><font size="2"><?php if ($pengalamans->PrevEmpStartDt != null){
                                                echo $pengalamans->prevEmpStartDt; 
                                               }else{
                                               echo '-';
                                               }?>
                          </td>
                           <td><font size="2"><?= ucwords(strtolower($pengalamans->OrgNm))?></td>
                          </tr>
                          
                               <?php } }
      else{
                    ?>
                    <tr>
                        <td colspan="4" class="text-center"><font size="2">Tiada Rekod</font></td>                        
                    </tr>
                  <?php  
                } ?>
                </tbody>

                     </table>
     
            <div class="x_title">
                <h6><strong><i class="fa fa-book"></i> Kelayakan Akademik</strong></h6>
                <div class="clearfix"></div>
            </div>
                  <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Bil</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Tahap Pendidikan</font> </th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Bidang</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Universiti / Institusi</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Nama Sijil</font></th>
                   
             
                    </tr>

                </thead>
                <tbody>
                    
                      <?php if($sijil) {
                          foreach ($sijil as $i=>$akademik) { ?>

       

                        <tr>

                            <td style="width:6%;"><font size="2"><?= $i+1; ?></font></td>
                            <td><font size="2"><?= ucwords($akademik->tahapPendidikan); ?></font></td>
                            <td><font size="2"><?= ucwords($akademik->namaMajor);?></font></td>
                            <td><font size="2"><?= ucwords($akademik->namainstitut);?></font></td>
          
                   
                      <td><font size="2"><?php $edu = str_replace("(","( ", $akademik->EduCertTitle); $edu = str_replace(")"," )", $edu); echo ucwords(strtolower($edu))?></font></td>
          
                        </tr>
                              <?php } }
      else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center"><font size="2">Tiada Rekod</font></td>                        
                    </tr>
                  <?php  
                } ?>
                </tbody>

                     </table>
        
        
        
              <div class="x_title">
                <h6><strong><i class="fa fa-book"></i>Waris Dekat</strong></h6>
                <div class="clearfix"></div>
            </div>
                  <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Bil</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Nama</font> </th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Persaudaraan</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Alamat</font></th>
      
                    </tr>

                </thead>
                <tbody>

                      <?php if($waris) {
                          foreach  ($waris as $i=>$wariss) { ?>
                          <tr>
                          <td style="width:6%;"><font size="2"><?= $i+1; ?></font></td>
                          <td><font size="2"><?= ucwords(strtolower($wariss->FmyNm))?></td>
                          <td><font size="2"><?= ucwords(strtolower($wariss->hubunganKeluarga->RelNm))?></td>
                           <td><font size="2"><?= ucwords(strtolower($wariss->FmyAddr1))."\n".ucwords(strtolower($wariss->FmyAddr2))?></td>
                          </tr>
                          
                               <?php } }
      else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center"><font size="2">Tiada Rekod</font></td>                      
                    </tr>
                  <?php  
                } ?>
                </tbody>

                     </table>
        
        
                <div class="break"></div>
             

     <div class="x_title">
                <h6><strong><i class="fa fa-book"></i>Butir-butir Perkhidmatan</strong></h6>
                <div class="clearfix"></div>
     </div>


               <table>
                    <tr>
                        <td  style="text-align:center; font-size:35px; background-color:#2290F0" color="white"><strong>Kebenaran</strong></td>
                        <td  style="text-align:center; font-size:35px; background-color:#2290F0" color="white"><strong>Butir-butir perubahan atau lain-lain hal mengenai Kakitangan (Lihat Panduan 5)</strong></td> 
                        <td  style="text-align:center; font-size:35px; background-color:#2290F0" color="white"><strong>Nama Jawatan, Peringkat dan/atau Kelas (Lihat Panduan 5)</strong></td> 
                        <td  style="text-align:center; font-size:35px; background-color:#2290F0" color="white"><strong>Tarikh Mulai Daripada</strong></td> 
                        <td  style="text-align:center; font-size:35px; background-color:#2290F0" color="white"><strong>Berpencen Tak Berpencen, Peruntukan Terbuka</strong></td> 
                        <td  style="text-align:center; font-size:35px; background-color:#2290F0" color="white"><strong>Gaji Sebulan (Lihat Panduan 6)</strong></td> 
                       
                    </tr>
                    
                    
                  <?php foreach($maklumat as $maklumats){ ?>
                     <tr>
                       
                          <?php
                            echo '<td style="width:10%; height:40%; font-size:250%">' .'UMS(PER)'.$maklumats->kakitangan->COOldID."\n".'bth:'.date("d.m.Y",strtotime($maklumats->tarikh_surat)).$maklumats->t_lpg_id;
                            ?>
                            <?php 
                            if($maklumats->t_lpg_id == null){
                         //    echo '<td colspan=5 style="width:50%; height:20%; font-size:250%; padding-right: 20px; padding-top:20px;  padding-bottom: 20px; padding-left: 20px;">'; echo "<u>". strtoupper($maklumats->jenisBrp->brpTitle)."</u>"."<br>"."<br>".$maklumats->remark;
                      echo '<td style="width:35%; height:35%; font-size:250% ">' ."<u>". "<b>". strtoupper($maklumats->jenisBrp->brpTitle)."</u>"."<br>".$maklumats->remark;
         
                      echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' .$maklumats->gredJawatan->nama. "<br>". $maklumats->gredJawatan->gred;
                      echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' .$maklumats->tarikhMulai;
                      echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' .$statusLabel[$maklumats->isPencen]; 
                      echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' ."<strong>".'RM'. $maklumats->gaji_sebulan."</strong>";
                        
                            }else{
                        
                            echo '<td style="width:35%; height:35%; font-size:250% ">' ."<u>". "<b>". strtoupper($maklumats->jenisBrp->brpTitle)."</u>"."<br>".$maklumats->remark;
                            echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' .$maklumats->gredJawatan->nama. "<br>". $maklumats->gredJawatan->gred;
                            echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' .$maklumats->tarikhMulai;
                            echo '<td style="width:10%; height:35%; text-align:center; font-size:250%">' .$statusLabel[$maklumats->isPencen];
                            echo '<td>'. $maklumats->gajiSebulan;
                           
                            }
                          ?>
         
                    </tr>
                    <?php  } ?>
               
               
                </table>
                
                
          <div class="break"></div>
   
          
            <div class="x_title">
                <h6><strong><i class="fa fa-book"></i>Halaman Kelakuan</strong></h6>
                <div class="clearfix"></div>
            </div>
                  <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Bil</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Tarikh</font> </th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Kebenaran</font></th>
                        <th class="column-title"  style="background-color:#2290F0" color="white"><font size="2">Butir-butir Pujian, Teguran atau Tindakan Tatatertib</font></th>
                       
                    </tr>

                </thead>
                <tbody>

                      <?php if($anugerah) {
                          foreach ($anugerah as $i=>$anugerahs) { ?>
                          <tr>
                          <td style="width:6%;"><font size="2"><?= $i+1; ?></font></td>
                          <td><font size="2"><?= $anugerahs->tarikhMulai?> </td>
                          <td><font size="2"><?php if($anugerahs->rujukan_surat != null){
                               echo  $anugerahs->rujukan_surat."\n".'bth:'.date("d.m.Y",  strtotime($anugerahs->tarikh_surat));
                               }else{
                               echo 'UMS(PER)'.$anugerahs->kakitangan->COOldID."\n".'bth:'.date("d.m.Y",  strtotime($anugerahs->tarikh_surat))."\n".$anugerahs->t_lpg_id;   
                               }?>
                          </td>
                           <td><font size="2"><?= $anugerahs->remark?></td>
                          </tr>
                          
                               <?php } }
      else{
                    ?>
                    <tr>
                             <td style="text-align:center; font-size:10px;" colspan="4" class="text-center">Tiada Rekod</td>                   
                    </tr>
                  <?php  
                } ?>
                </tbody>

                     </table>
    

