
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />

              <div style="margin-bottom: 18px;" >
                      <table class="table table-sm table-bordered" style=" font-size: 10px;">
                     <tr>
                       <td colspan="6" style="text-align:center; background-color:#2290F0" color="white" height="25px"><strong>  MAKLUMAT UMUM </strong></td>
                     </tr>
                    <tr>
                     <td></td>
                     <td style="width:70px"><strong>GELARAN JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatan)?></td>
                     <td><strong>KETUA PERKHIDMATAN</strong></td>
                     <td colspan="2">KETUA PENGARAH PENDIDIKAN TINGGI</td>
                     </tr>
                     <tr>
                           <td></td>
                     <td><strong>RINGKASAN GELARAN JAWATAN</strong></td>
                     <td><?=strtoupper( $deskripsi->ringkasan_gelaran )?></td>
                     <td><strong>KEDUDUKAN DI WARAN PERJAWATAN</strong></td>
                     <td colspan="2">TIDAK BERKENAAN</td>
                     </tr>
                     <tr>
                           <td></td>
                     <td><strong>GRED JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatanss->gred) ?></td>
                     <td><strong>BIDANG UTAMA</strong></td>
                     <td colspan="2"><?= strtoupper($deskripsi->bidang_utama) ?></td>
                     </tr>
                     <tr>
                           <td></td>
                     <td><strong>GRED JD</strong></td>
                     <td><?= strtoupper($deskripsi->greds->gred)?></td>
                     <td><strong>SUB BIDANG</strong></td>
                     <td colspan="2"><?= strtoupper($deskripsi->sub_bidang) ?></td>
                     </tr>
                     <tr>
                           <td></td>
                     <td><strong>STATUS JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->status_jawatan)?></td>
                     <td><strong>DISEDIAKAN OLEH</strong></td>
                     <td colspan="2"><?= strtoupper($deskripsi->name) ?></td>
                     </tr>
                    <tr>
                          <td></td>
                     <td><strong>HIRARKI 1 (BAHAGIAN)</strong></td>
                     <td><?=strtoupper( $deskripsi->department->fullname)?></td>
                     <td><strong>DISEMAK OLEH</strong></td>
                     <td colspan="2"><?= strtoupper($deskripsi->ketuaPerkhidmatan->CONm)?></td>
                     </tr>
                     <tr>
                           <td></td>
                     <td><strong>HIRARKI 2 (CAWANGAN /SEKTOR/ UNIT)</strong></td>
                     <td><?= strtoupper($deskripsi->hirarki_2)?></td>
                     <td><strong>DILULUSKAN OLEH</strong></td>
                     <td colspan="2"><?= strtoupper($deskripsi->ketuaJabatan->CONm) ?></td>
                     </tr>
                     <tr>
                           <td></td>
                     <td><strong>SKIM PERKHIDMATAN</strong></td>
                     <td><?= strtoupper($deskripsi->skim_perkhidmatan)?></td>
                     <td><strong>TARIKH DOKUMEN</strong></td>
                     <td colspan="2"><?= strtoupper($deskripsi->tarikhDokumen)?></td>
                     </tr>
                     <tr>
                         <td colspan="6"  style="text-align:center; background-color:#2290F0" color="white"   height="25px"  ><strong> TUJUAN PEWUJUDAN JAWATAN </strong></td>
                     </tr>
                     
                    <tr> <td colspan="6" style="text-align:justify"><?php echo ucwords(strtolower($deskripsi->kata_kerja)) ?>  <?php echo $deskripsi->object?>  <?php echo $deskripsi->tujuan?></td></tr>
                 
           
                 
                    <tr>
                         <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>Bil.</strong></td>
                         <td colspan="2"  style="text-align:center; background-color:#2290F0" color="white" height="25px" ><strong>AKAUNTABILITI</strong></td>
                         <td colspan="3"  style="text-align:center; background-color:#2290F0" color="white" height="25px"  ><strong>TUGAS UTAMA</strong></td>
                  
                    </tr>
                  <?php   foreach ($akauntabiliti as $key=>$item){ ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td colspan="2">   <?php echo ucwords(strtolower($item->kata_kerja)) ?> <?= $item->object?> <?= $item->description?></td>
                            <td colspan="3"> <?= $item->TugasUtama3($item->id)?></td>
                        </tr> 
                                              
                   <?php } ?>
              
                    <tr>
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>Bil.</strong></td>
                        <td  colspan="2" style="text-align:center; background-color:#2290F0" color="white" height="25px"><strong>DIMENSI</strong></td>
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"  colspan="3"><strong>SKOP</strong></td>
                   
                    </tr>
                               <?php if($lihatDimensi) {
                    
                   foreach ($lihatDimensi as $key=>$item){?>
                    <tr>
                            <td><?= $key+1?></td>
                            <td colspan="2"  height="25px"  ><?=  ucwords(strtolower($item->dimensi)) ?></td>
                            <td colspan="3"  height="25px" ><?= ucwords(strtolower($item->dimensi_utama))?></td>
            
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
                         <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>Bil.</strong></td>
                        <td  colspan="2" style="text-align:center; background-color:#2290F0" color="white" height="25px"><strong>KELAYAKAN AKADEMIK / IKHTISAS</strong></td>
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"  colspan="3"><strong>BIDANG</strong></td>
                    </tr>
                          <?php if($ikhtisas) {
                    
                   foreach ($ikhtisas as $key=>$item){?>
                        <tr>
                         <td><?= $key+1?></td>
                         <td colspan="2"  height="25px" > <?= ucwords(strtolower($item->refPendidikan->HighestEduLevel))?></td>
                         <td colspan="3"  height="25px" > <?= ucwords(strtolower($item->bidang))?></td>
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
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>Bil.</strong></td>
                        <td  style="text-align:center; background-color:#2290F0" color="white" height="25px" colspan="6"><strong> SYARAT TAMBAHAN</strong></td>
                        
                    </tr>
                    
                    <?php if($lihatSyarat) {
                    
                   foreach ($lihatSyarat as $key=>$item){?>
                    <tr>
                            <td><?= $key+1?></td>
                            <td colspan="6" height="25px" ><?= ucwords(strtolower($item->syarat_tambahan))?></td>
                    </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
          
                    <tr>
                        <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px"><strong>Bil.</strong></td>
                        <td  style="text-align:center; background-color:#2290F0" color="white" height="25px" colspan="6"><strong> KOMPETENSI</strong></td>
                        
                    </tr>
                    
                    <?php if($lihatKompetensi) {
                    
                   foreach ($lihatKompetensi as $key=>$item){?>
                    <tr>
                            <td><?= $key+1?></td>
                            <td colspan="6" height="25px" ><?= ucwords(strtolower($item->kompetensi))?></td>
                    </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
      
                     <tr>
                         <td  style="text-align:center; background-color:#2290F0" color="white"   height="25px" ><strong>Bil.</strong></td>
                         <td  style="text-align:center; background-color:#2290F0" color="white"  height="25px" colspan="6"><strong>PENGALAMAN</strong></td>
                  
                    </tr>
                  <?php if($pengalaman) {
                    
                   foreach ($pengalaman as $key=>$item){
                    
                ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td colspan="6" height="25px" ><?= ucwords(strtolower($item->tempoh)) ?> <?= ucwords(strtolower($item->pengalaman)) ?></td>
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
