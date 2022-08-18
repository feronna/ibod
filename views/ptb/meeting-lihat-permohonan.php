<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
error_reporting(0);
?>
<?php
$endDateLantik = date_create($model->applicant->endDateLantik);
$now = date_create(date('d-m-Y'));
$diff = date_diff($now, $endDateLantik);
$stringBalance = "$diff->d  hari, $diff->m  bulan, $diff->y tahun";

$date1=date_create($model->tempooh->ApmtStatusStDt);
$date2=date_create($model->applicant->endDateLantik);
$tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');

 $a = [
     null => [
         'effective_date' => 'Tiada Rekod',
        
        ]
     
    
 ];

$word = [
    1 => [
        'name' => 'Nama Ketua Pentadbiran',
        'tindakan' => 'Tindakan Ketua Pentadbiran',
        'status' => 'Status Persetujuan',
        'catatan' => 'Catatan Pensetuju',
        'update' => 'Tarikh dan Masa Persetujuan',
    ],


    2 => [
        'name' => 'Nama Ketua JFPIU',
        'tindakan' => 'Tindakan Ketua JFPIU',
        'status' => 'Status Perakuan',
        'catatan' => 'Catatan Peraku',
        'update' => 'Tarikh dan Masa Perakuan',
    ]
];

?>
<div class="col-md-12">
    <?php echo $this->render('/ptb/_menu'); ?>
</div>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <form id="w0" class="form-horizontal form-label-left" action="" method="post">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pemohon
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->applicant->CONm ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->applicant->ICNO?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->applicant->COOldID ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Negeri Asal
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->states->State?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara Asal
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->countrys->Country?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Permohonan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <form id="w0" class="form-horizontal form-label-left" action="">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pemohonan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?=$model->created?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Permohonan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->type->name ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU Baharu yang dimohon
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->newDepartment->fullname ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Campus Baharu yang dimohon
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->newCampus->campus_name?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Permohonan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                             <textarea class="form-control" rows="5" disabled><?= $model->reason?></textarea>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan<span class="required"></span>
                </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->file!= NULL){?>
                     <u data-toggle="tooltip" title="Klik Untuk Muat Turun"><?php echo $model->displayLink ?> </u>
                    <?php }else{
                        echo "Tiada Dokumen Sokongan Disertakan";
                    }
?>
                </div>
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <form id="w0" class="form-horizontal form-label-left" action="">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= $model->applicant->jawatan->nama ?> <?= ($model->applicant->jawatan->gred) ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">J / F / P / I / U
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->applicant->department->fullname?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Lantikan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->lantikan->ApmtStatusNm ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php if($model->lantikan->ApmtStatusCdMM == 1){
                      echo 'Umur Bersara';
                       } else{
                        echo 'Tempoh Berkhidmat';
                    }
                    ?>
                        </label>
                      
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?php if($model->lantikan->ApmtStatusCdMM == 1){
                      echo $model->rekomen->RetireAgeCd; echo "&nbsp;";
                      echo '(';   echo $model->rekomen->umurBersara->RetireAgeDesc;  echo ')';
                       } else{
                        echo $tempoh;
                    }
                    ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php if($model->lantikan->ApmtStatusCdMM == 1){
                      echo 'Tarikh Bersara';
                       } else{
                        echo 'Baki Sebelum Tamat Kontrak ';
                    }
                    ?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                          
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php if($model->lantikan->ApmtStatusCdMM == 1){
                        echo $model->rekomen->tarikhKuatkuasa;
                       } else{
                        echo $stringBalance;
                    }
                    ?> " disabled="">
                                <div class="help-block"></div>
                            
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Penempatan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <form id="w0" class="form-horizontal form-label-left" action="">
                    <table class="table table-bordered jambo_table">
                        <thead>
                        <tr class="headings">
                            <th class="column-title">Bil</th>
                            <th class="column-title">Tarikh Mula Penempatan </th>
                            <th class="column-title">JFPIU</th>
                            <th class="column-title">Kampus</th>
                            <th class="column-title">Tempoh Penempatan Semasa</th>
                             <th class="column-title">Catatan</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $bil=1; foreach ($penempatan as $tempat) { ?>
                            <tr>
                                <td><?= $bil++ ?></td>
                                <td><?= $tempat->date_start; ?></td>
                                <td><?= $tempat->department->fullname ;?></td>
                                <td><?= $tempat->campus->campus_name;?></td>
                                 
                               <td><?php
                                     
                                     $date1=date_create($tempat->date_start);
                                     $date2=date_create($date);
                                      $tempohPenempatan = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
                                      $date = $tempat->date_start;
                                         //$tempoh = round($tempo/365, 1);
                                       echo $tempohPenempatan;?></td>
                               <td><?= $tempat->remark;?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

                   
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> Deskripsi Tugas Pemohon</strong></h2>
             <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
          <div class="x_content collapse">
                  <div class="table-responsive">
                <table class="table table-sm table-bordered">
                       
                    <tr>
                        <th colspan="4"><strong> MAKLUMAT UMUM </strong></td>
                        
                    </tr>
                     <tr>
                     <td><strong>GELARAN JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatan)?></td>
                     <td><strong>KETUA PERKHIDMATAN</strong></td>
                     <td>KETUA PENGARAH PENDIDIKAN TINGGI</td>
                     </tr>
                     <tr>
                     <td><strong>RINGKASAN GELARAN JAWATAN</strong></td>
                     <td><?=strtoupper( $deskripsi->ringkasan_gelaran )?></td>
                     <td><strong>KEDUDUKAN DI WARAN PERJAWATAN</strong></td>
                     <td>TIDAK BERKENAAN</td>
                     </tr>
                     <tr>
                         <td><strong>GRED JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->gred_jawatan) ?></td>
                     <td><strong>BIDANG UTAMA</strong></td>
                     <td><?= strtoupper($deskripsi->bidang_utama) ?></td>
                     </tr>
                     <tr>
                      <td><strong>GRED JD</strong></td>
                     <td><?= strtoupper($deskripsi->applicant->jawatan->gred)?></td>
                     <td><strong>SUB BIDANG</strong></td>
                     <td><?= strtoupper($deskripsi->sub_bidang) ?></td>
                     </tr>
                     <tr>
                         <td><strong>STATUS JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->status_jawatan)?></td>
                     <td><strong>DISEDIAKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->name) ?></td>
                     </tr>
                    <tr>
                        <td><strong>HIRARKI 1 (BAHAGIAN)</strong></td>
                     <td><?=strtoupper( $deskripsi->applicant->department->fullname)?></td>
                     <td><strong>DISEMAK OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->department->ppBiodata->CONm)?></td>
                     </tr>
                      <tr>
                          <td><strong>HIRARKI 2 (CAWANGAN /SEKTOR/ UNIT)</strong></td>
                     <td><?= strtoupper($deskripsi->hirarki_2)?></td>
                     <td><strong>DILULUSKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->department->chiefBiodata->CONm) ?></td>
                     </tr>
                    <tr>
                        <td><strong>SKIM PERKHIDMATAN</strong></td>
                     <td><?= strtoupper($deskripsi->skim_perkhidmatan)?></td>
                     <td><strong>TARIKH DOKUMEN</strong></td>
                     <td><?= strtoupper($deskripsi->created_at)?></td>
                     </tr>
                   <tr>
                        <th colspan="4"><strong> TUJUAN PEWUJUDAN JAWATAN</strong></td>
                        
                    </tr>
                     <tr>
                         <td align= "center"colspan="4"><?= strtoupper($deskripsi->tujuan)?></td>
                    </tr>
                    
                    
                </table>
                 
                      <table class="table table-sm table-bordered">
           
                            <tr>
                         <th>Bil.</th>
                         <th colspan="2"><strong>AKAUNTABILITI</strong>
                          <th colspan="2"><strong>TUGAS UTAMA</strong></td>
                  
                    </tr>
                  <?php if($akauntabiliti) {
                    
                   foreach ($akauntabiliti as $key=>$item){
                    
                ?>
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="2">
                            <?= strtoupper($item->description)?>
                           <td colspan="2">
                             <?= strtoupper($item->TugasUtama2($item->id))?></td>
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
                      
                      
                      
            <div class="x_content collapse">
                      <table class="table table-sm table-bordered">
                    <tr>
                         <th><strong>Bil.</strong></td>
                          <th colspan="2"><strong>DIMENSI</strong></td>
                          <th colspan="2"><strong>SKOP</strong></td>
                   
                    </tr>
                               <?php if($lihatDimensi) {
                    
                   foreach ($lihatDimensi as $key=>$item){?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="2">
                            <?= strtoupper($item->dimensi)?><td colspan="2">
                             <?=strtoupper($item->dimensi_utama)?>
                            
                            </td>
                             
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
                         <th><strong>Bil.</strong></td>
                         <th colspan="5"><strong>KELAYAKAN AKADEMIK / IKHTISAS</strong></td>
                    
                    </tr>
                          <?php if($ikhtisas) {
                    
                   foreach ($ikhtisas as $key=>$item){?>
                        <tr>
                         <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                            <?= strtoupper($item->ikhtisas)?>
                         
                           </td>
                           
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
                             <th>Bil. </th>
                        <th colspan="4"><strong> KOMPETENSI</strong></td>
                        
                    </tr>
                    
                    <?php if($lihatKompetensi) {
                    
                   foreach ($lihatKompetensi as $key=>$item){?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                            <?= strtoupper($item->kompetensi)?></td>
                
                           </tr>
                        
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
                         <th>Bil.</th>
                         <th colspan="4"><strong>PENGALAMAN</strong></td>
                  
                    </tr>
                  <?php if($pengalaman) {
                    
                   foreach ($pengalaman as $key=>$item){
                    
                ?>
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="3">
                            <?= strtoupper($item->pengalaman)?></td>
                              </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
              
                      </table></div>
 </div>
 </div>
</div>
</div>
 </div>    

<div class="row">
    <?php if(!is_null($prevRec)): ?>
        <?php foreach ($prevRec as  $prev):?>
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-users"></i><?= $word[$prev->type]['tindakan'] ?></strong></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="w0" class="form-horizontal form-label-left" action="" method="post">
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"><?=$word[$prev->type]['update'] ?>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?php  if ($prev->agree !== null){
                    echo ($prev->agree === 0)? ' TIDAK SETUJU' : 'SETUJU';
                  }else{
                    echo 'BELUM DIAMBIL TINDAKAN';
                 }
                ?>" disabled>
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"><?= $word[$prev->type]['name'] ?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?= $prev->staff->CONm ?>" disabled>
                                </div>
                            </div>
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"><?= $word[$prev->type]['status'] ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?php  if ($prev->agree != null){
                    echo ($prev->agree == 1)? 'SETUJU' : 'TIDAK SETUJU';
                  }else{
                    echo 'BELUM DIAMBIL TINDAKAN';
                 }
                ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $word[$prev->type]['catatan'] ?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control" rows="5" disabled><?= $prev->notes ?></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                        </form>
                    </div>


                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
