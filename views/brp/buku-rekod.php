<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$statusLabel = [
        0 => 'Tidak Berpencen',
        1 => 'Berpencen'
   
];
error_reporting(0);
?>
<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-search"></i> Carian', ['brp/index']) ?></li>
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['brp/view', 'ICNO' =>  $model2->ICNO ]) ?></li>
        <li>Buku Rekod Perkhidmatan</li>
    </ol>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

 
<div class="row">
        <div class="x_panel">
         <div class="x_content">
    
         <div class="x_title">
            <h2><strong>BUKU REKOD PERKHIDMATAN</strong></h2>
            <div class="clearfix"></div>
         </div>
                          
         <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px;">
                    <div class="profile_img text-center">
                        <div id="crop-avatar" > 
                            <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($nama->ICNO)); ?>.jpeg" border-style="solid" width="100" height="120">
                        </div>
                    </div>
         </div>  
             
       
        <div class="x_content">    
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                   <tr>
                       <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="4">MAKLUMAT PERIBADI</td></th>
                       
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Kakitangan</th>
                        <td colspan="4"><?= ucwords(strtolower($nama->CONm))?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan / Paspott</th>
                        <td colspan="4"><?php
                            if ($nama->NatCd == "MYS") {
                                echo strtoupper($nama->ICNO);
                            } else {
                                echo $nama->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Rujukan No Fail</th>
                        <td colspan="4"><?= $nama->COOldID ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jantina</th>
                        <td colspan="4"><?=  $nama->jantina->Gender ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Taraf Perkahwinan</th>
                        <td colspan="4"><?=$nama->tarafPerkahwinan->MrtlStatus ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Lahir</th>
                        <td colspan="4"><?=$nama->tempatLahir->State ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tempat Lahir</th>
                        <td colspan="4"><?=$nama->tempatLahir->State ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Negara Lahir</th>
                        <td colspan="4"><?=$nama->negaraLahir->Country  ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Agama</th>
                        <td colspan="4"><?=$nama->agama->Religion?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Bangsa</th>
                        <td colspan="4"><?=$nama->bangsa->Race?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Sijil Kerakyatan Persekutuan dan Tarikh</th>
                        <td colspan="4"></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Akaun Bank</th>
                        <td colspan="4"></td> 
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Akaun Bank</th>
                        <td colspan="4"><?= $akaun->SA_BANK_CODE?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pendaftaran Kumpulan Wang Simpanan Pekerja</th>
                        <td colspan="4"></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pendaftaran Kumpulan Wang Persaraan (Diperbadankan)</th>
                        <td colspan="4"></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kira-kira Cukai Pendapatan (Hasil Dalam Negeri)</th>
                        <td colspan="4"></td> 
                    </tr>
                     <tr>
                       <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="4">MAKLUMAT JAWATAN SEKARANG</td></th>
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan Sekarang</th>
                        <td colspan="4"> <?= $nama->jawatan->nama . " (" . $nama->jawatan->gred . ")";?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Dilantik</th>
                        <td colspan="4"> <?php  if ($nama->tarikhDilantikPerkhidmatan->tarikhMulaLantikan != null){
                          echo  $nama->tarikhDilantikPerkhidmatan->tarikhMulaLantikan;  
                         }else{
                      echo 'Tiada Rekod';
                 }
                ?></td> 
                  </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Disahkan Dalam Jawatan</th>
                        <td colspan="4">  <?php  if ($nama->sahJawatan->tarikhMula != null){
                              echo  $nama->sahJawatan->tarikhMula;  
                              }else{
                              echo 'Tiada Rekod';
                              }
                        ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan Sekarang</th>
                        <td colspan="4"> <?= $nama->department->fullname?></td> 
                    </tr>
                 
                     <tr>
                       <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="4">BUTIR-BUTIR JAWATAN SEBELUM LANTIKAN KE UMS</td></th>
                    </tr>
                     <tr>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Jawatan</strong></td>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px" ><strong>Tarikh Dilantik</strong></td>
                         <td colspan="2"  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"  ><strong>Nama Majikan</strong></td>
                       <?php if($pengalaman) {
                          foreach ($pengalaman as $key=>$pengalamans) { ?>
                          <tr>
                          <td><?= $pengalamans->PrevEmpRemarks?></td>
                          <td><?= $pengalamans->tarikhDilantik?></td>
                          <td colspan="2"><?= $pengalamans->OrgNm?></td>
                          </tr>
               
                        <?php } }
                       else{
                    ?>
                </tr>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    </tr>
                    <tr>
                       <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="4">KELAYAKAN AKADEMIK</td></th>  
                    </tr>
                    
                   <tr>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Institut</strong></td>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px" ><strong>Tahap Pendidikan</strong></td>
                         <td colspan="1"  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"  ><strong>Major</strong></td>
                         <td colspan="1"  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"  ><strong>Nama Sijil</strong></td>
                         <?php if($sijil) {
                        foreach ($sijil as $key=>$sijils) { ?>
                          <tr>
                          <td><?=  ucwords(strtolower($sijils->institut->InstNm))?></td>
                          <td><?=  ucwords(strtolower($sijils->pendidikanTertinggi->HighestEduLevel))?></td>
                          <td><?=  ucwords(strtolower($sijils->major->MajorMinor))?></td>
                          <td><?=  $sijils->EduCertTitle?></td>
                          </tr>
                        <?php } }
                        else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    </tr>
                       <tr>
                       <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="4">WARIS DEKAT</td></th>
                    </tr>
                     <tr>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Nama</strong></td>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px" ><strong>Persaudaraan</strong></td>
                         <td colspan="2"  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"  ><strong>Alamat</strong></td>
                          <?php if($waris) {
                          foreach ($waris as $wariss) { ?>
                          <tr>
                          <td><?= $wariss->FmyNm?></td>
                          <td><?= $wariss->hubunganKeluarga->RelNm?></td>
                          <td colspan="2"><?= $wariss->FmyAddr1. $wariss->FmyAddr2?></td>
                          </tr>
                          
                               <?php } }
                      else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    </tr>
                  
                </table>
            </div> 
               <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <tr>
                      <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="4">KENYATAAN PERKHIDMATAN</td></th>
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Kakitangan</th>
                        <td><?= ucwords(strtolower($nama->CONm))?></td> 
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMSPER</th>
                        <td> <?=  $nama->COOldID?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Layak Dimasukkan Ke Dalam Perjawatan Berpencen</th>
                        <td colspan="3"> <?= $pencen->tarikhMula ?></td> 
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Dimasukkan Ke Dalam Jawatan Berpencen</th>
                        <td colspan="3"> <?= $pencen->tarikhMula ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Sampai Umur Dihadkan</th>
                        <td colspan="3"> <?= $bersara->tarikhKuatkuasa?></td> 
                    </tr>
                    
               </table>

              <table class="table table-sm table-bordered jambo_table table-striped"> 
                  <tr>
                      <th <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="7">BUTIR-BUTIR PERKHIDMATAN</th></td>
                  </tr>
                  <tr>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" width="10px"><strong>Bil</strong></td>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Kebenaran</strong></td>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Butir-butir perubahan atau lain-lain hal mengenai Kakitangan (Lihat Panduan 5)</strong></td>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Nama Jawatan, Peringkat dan/atau Kelas (Lihat Panduan 5)</strong></td>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Tarikh Mulai Daripada</strong></td>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Berpencen Tak Berpencen, Peruntukan Terbuka</strong></td>
                         <td style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Gaji Sebulan (Lihat Panduan 6)</strong></td>
                     </tr> 
                     <tr>
                          <?php if($model) {
                          foreach ($model as $key=>$models) { ?>
                          <tr>
                              <td style="width:10px"><?= $key+1?></td>
                          <td><?php if($models->rujukan_surat != null){
                               echo  $models->rujukan_surat."\n".'bth:'.date("d.m.Y",  strtotime($models->tarikh_surat));
                               }else{
                               echo 'UMS(PER)'.$anugerahs->kakitangan->COOldID."\n".'bth:'.date("d.m.Y",  strtotime($models->tarikh_surat))."\n".$models->t_lpg_id;   
                               }?>
                          <td><?= $models->remark?></td>
                          <td> <?= $models->gredJawatan->nama; ?> <?= $models->gredJawatan->gred; ?></td>
                          <td><?= $models->tarikhMulai ?></td>
                          <td><?php if($models->isPencen == 1){
                                echo 'Berpencen';
                            }else{
                                echo 'Tidak Berpencen';
                            } ?></td>
                           <td> <?= $models->gajiSebulan2?></td>
                   
                          </tr>
               
                        <?php } }
                       else{
                    ?>
                </tr>
                    <tr>
                        <td colspan="7" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                </table>  
  
               <div class="x_content">    
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                  <tr>
                       <th class="col-md-3 col-sm-3 col-xs-12" <td style="text-align:center; background-color:#2290F0; color:#FFFFFF" colspan="5">HALAMAN KELAKUAN</td></th>
                    </tr>
                     <tr>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"><strong>Tarikh</strong></td>
                         <td  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px" ><strong>Kebenaran</strong></td>
                         <td colspan="2"  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"  ><strong>Butir-butir Pujian, Teguran atau Tindakan Tatatertib</strong></td>
                         <td colspan="2"  style="text-align:center; background-color:#707070; color:#FFFFFF" height="25px"  ><strong>Tandatangan Pegawai yang Berkuasa</strong></td>
                         <?php if($anugerah) {
                          foreach ($anugerah as $key=>$anugerahs) { ?>
                          <tr>
                          <td><?= $anugerahs->tarikhMulai?></td>
                          <td><?php if($anugerahs->rujukan_surat != null){
                               echo  $anugerahs->rujukan_surat."\n".'bth:'.date("d.m.Y",  strtotime($anugerahs->tarikh_surat));
                               }else{
                               echo 'UMS(PER)'.$anugerahs->kakitangan->COOldID."\n".'bth:'.date("d.m.Y",  strtotime($anugerahs->tarikh_surat))."\n".$anugerahs->t_lpg_id;   
                               }?>
                          <td colspan="2"><?= $anugerahs->remark?></td>
                          <td colspan="2"></td>
                          </tr>
               
                        <?php } }
                       else{
                    ?>
                </tr>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    </tr>
                </table>  
              </div>
             
             
                       </div>
        </div>
</div>

          



             