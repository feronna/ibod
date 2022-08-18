<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use app\models\ptb\TblPbpu;
error_reporting(0);
$tmp = TblPbpu::find()->select(['kali_ke', 'tarikh_mesyuarat'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>
<?php
$endDateLantik = date_create($model->application->applicant->endDateLantik);
$now = date_create(date('d-m-Y'));
$diff = date_diff($now, $endDateLantik);
$stringBalance = "$diff->d  hari, $diff->m  bulan, $diff->y tahun";

$date1=date_create($model->application->tempooh->ApmtStatusStDt);
$date2=date_create($model->application->applicant->endDateLantik);
$tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');



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
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->application->applicant->CONm ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->application->applicant->ICNO?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->application->applicant->COOldID ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Negeri Asal
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->application->states->State?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara Asal
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->application->countrys->Country?>" disabled="">
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
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->application->type->name ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU Baharu yang dimohon
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->application->newDepartment->fullname ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Campus Baharu yang dimohon
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?=$model->application->newCampus->campus_name ?>" disabled="">


                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Permohonan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                
                                 <textarea class="form-control" rows="5" disabled><?= $model->application->reason?></textarea>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->application->file!= NULL){?>
                     <u data-toggle="tooltip" title="Klik Untuk Muat Turun"><?php echo $model->application->displayLink ?> </u>
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
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= $model->application->applicant->jawatan->nama ?> (<?= $model->application->applicant->jawatan->gred ?>)" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">J / F / P / I / U
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->application->applicant->department->fullname?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Lantikan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->application->lantikan->ApmtStatusNm ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php if($model->application->lantikan->ApmtStatusCdMM == 1){
                      echo 'Umur Bersara';
                       } else{
                        echo 'Tempoh Berkhidmat';
                    }
                    ?>
                        </label>
                      
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?php if($model->application->lantikan->ApmtStatusCdMM == 1){
                      echo $model->application->rekomen->RetireAgeCd; echo "&nbsp;";
                      echo '(';   echo $model->application->rekomen->umurBersara->RetireAgeDesc;  echo ')';
                       } else{
                        echo $tempoh;
                    }
                    ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            <?php if($model->application->lantikan->ApmtStatusCdMM == 1){
                      echo 'Tarikh Bersara';
                       } else{
                        echo 'Baki Sebelum Tamat Kontrak ';
                    }
                    ?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                          
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php if($model->application->lantikan->ApmtStatusCdMM == 1){
                        echo $model->application->rekomen->tarikhKuatkuasa;
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
                        <th   <td style="width:700px; height:20px"<th colspan="5"><strong> MAKLUMAT UMUM </strong></td></th>
                    </tr>
                    <tr>
                        <td></td>
                     <td colspan="1" style="width:200px; height:20px"><strong>GELARAN JAWATAN</strong></td>
                     <td style="width:500px; height:20px"><?= strtoupper($deskripsi->jawatan)?></td>
                     <td style="width:200px; height:20px"><strong>KETUA PERKHIDMATAN</strong></td>
                     <td style="width:500px; height:auto">KETUA PENGARAH PENDIDIKAN TINGGI</td>
                     </tr>
                     <tr>
                              <td></td>
                     <td><strong>RINGKASAN GELARAN JAWATAN</strong></td>
                     <td><?=strtoupper( $deskripsi->ringkasan_gelaran )?></td>
                     <td><strong>KEDUDUKAN DI WARAN PERJAWATAN</strong></td>
                     <td>TIDAK BERKENAAN</td>
                     </tr>
                     <tr>
                              <td></td>
                         <td><strong>GRED JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatanss->gred) ?></td>
                     <td><strong>BIDANG UTAMA</strong></td>
                     <td><?= strtoupper($deskripsi->bidang_utama) ?></td>
                     </tr>
                     <tr>
                              <td></td>
                      <td><strong>GRED JD</strong></td>
                     <td><?= strtoupper($deskripsi->applicant->jawatan->gred)?></td>
                     <td><strong>SUB BIDANG</strong></td>
                     <td><?= strtoupper($deskripsi->sub_bidang) ?></td>
                     </tr>
                     <tr>
                              <td></td>
                         <td><strong>STATUS JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->status_jawatan)?></td>
                     <td><strong>DISEDIAKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->name) ?></td>
                     </tr>
                    <tr>
                             <td></td>
                        <td><strong>HIRARKI 1 (BAHAGIAN)</strong></td>
                     <td><?=strtoupper( $deskripsi->applicant->department->fullname)?></td>
                     <td><strong>DISEMAK OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaPerkhidmatan->CONm)?></td>
                     </tr>
                      <tr>
                               <td></td>
                          <td><strong>HIRARKI 2 (CAWANGAN /SEKTOR/ UNIT)</strong></td>
                     <td><?= strtoupper($deskripsi->hirarki_2)?></td>
                     <td><strong>DILULUSKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaJabatan->CONm) ?></td>
                     </tr>
                    <tr>
                             <td></td>
                        <td><strong>SKIM PERKHIDMATAN</strong></td>
                     <td><?= strtoupper($deskripsi->skim_perkhidmatan)?></td>
                     <td><strong>TARIKH DOKUMEN</strong></td>
                     <td><?= strtoupper($deskripsi->tarikhDokumen)?></td>
                     </tr>
                  
                    
                    <tr>
                        <th  colspan="5"<td style="width:500px; height: 20px">TUJUAN PEWUJUDAN JAWATAN</strong></td></th>
                        
                    </tr>
                     <tr> <td colspan="6" style="text-align:justify"><?php echo ucwords(strtolower($deskripsi->kata_kerja))?>  <?php echo ucwords(strtolower($deskripsi->object))?>  <?php echo ucwords(strtolower($deskripsi->tujuan))?></td></tr>
                    
                    <tr>
                           <th colspan="1" <td style="width:50px; height: 20px">Bil.</strong></td></th>
                          
                         <th colspan="2"<td style="width:200px; height: 20px"><strong>AKAUNTABILITI</strong></td></th>
                         <th  colspan="2" <td style="width:500px; height: 20px">TUGAS UTAMA</strong></td></th>
                  
                    </tr>
                  <?php if($akauntabiliti) {
                    
                   foreach ($akauntabiliti as $key=>$item){
                    
                ?>
                        <tr>
                            <td colspan="1"align="center"><?= $key+1?></td>
                            
                            <td colspan="2">
                          <?php echo ucwords(strtolower($item->kata_kerja))?> <?= ucwords(strtolower($item->object))?> <?= ucwords(strtolower($item->description))?>
                           <td colspan="2">
                             <?= $item->TugasUtama3($item->id)?></td>
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
                        <th  <td style="width:50px; height: 20px">Bil.</strong></td></th>
                         <th colspan="2" <td style="width:200px; height: 20px">DIMENSI</strong></td></th>
                         <th colspan="3"<td style="width:500px; height: 20px">SKOP</strong></td></th>
                   
                    </tr>
                               <?php if($lihatDimensi) {
                    
                   foreach ($lihatDimensi as $key=>$item){?>
                    <tr>
                            <td align="center"><?= $key+1?></td>
                            <td colspan="2">
                            <?= ucwords(strtolower($item->dimensi))?><td colspan="2">
                             <?= ucwords(strtolower($item->dimensi_utama))?>
                            
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
                        <th  <td   height="25px"><strong>Bil.</strong></td></th>
                        <th  <td  colspan="2" height="25px"><strong>KELAYAKAN AKADEMIK / IKHTISAS</strong></td></th>
                        <th   <td   height="25px"  colspan="3"><strong>BIDANG</strong></td></th>
                    </tr>
                          <?php if($ikhtisas) {
                    
                   foreach ($ikhtisas as $key=>$item){?>
                        <tr>
                         <td><?= $key+1?></td>
                         <td colspan="2"  height="25px" > <?= $item->refPendidikan->HighestEduLevel?></td>
                         <td colspan="3"  height="25px" > <?= $item->bidang?></td>
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
                         <th <td colspan="4"><strong>SYARAT TAMBAHAN</strong></td>
                      
                    </tr>
                    <?php if($syarat) {
                    
                   foreach ($syarat as $key=>$items){
                    
                ?>
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                         
                            <?= ucwords(strtolower($items->syarat_tambahan))?>
                      
                           </td>
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
                             <th>Bil. </th>
                        <th colspan="4"><strong> KOMPETENSI</strong></td>
                        
                    </tr>
                    
                    <?php if($lihatKompetensi) {
                    
                   foreach ($lihatKompetensi as $key=>$item){?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                            <?= ucwords(strtolower($item->kompetensi))?></td>
                
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
                            <td colspan="4">
                            <?= ucwords(strtolower($item->tempoh))?> <?= ucwords(strtolower($item->pengalaman))?></td>
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
                                    <input class="form-control" value="<?php  if ($prev->update != null){
                   echo  $prev->updates;
                  }else{
                    echo 'BELUM DIAMBIL TINDAKAN';
                 }
                ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"><?= $word[$prev->type]['name'] ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?= $prev->staff->CONm ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"><?= $word[$prev->type]['status'] ?><span class="required">*</span>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $word[$prev->type]['catatan'] ?><span class="required">*</span>
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
                         
 
                            
                         
                         
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-pencil"></i>Keputusan Mesyuarat</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Mesyuarat Kali Ke-<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'kali_ke')->textInput(['maxlength' => true, 'rows' => 4, 'value' => $tmp['kali_ke'], 'disabled' => 'disabled'])->label(false);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                   <?= $form->field($model, 'tarikh_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4, 'value' => date('d M Y', strtotime ($tmp['tarikh_mesyuarat'])), 'disabled' => 'disabled'])->label(false);
                        ?>
                    </div>         
                </div>
                    <div class="form-group inline">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Surat Rujukan<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="display: inline-block">
                            <label class="inline">UMS/PEND2.2/500-2/7/2 Jld.8 </label>
                            <?= Html::textInput('letter_reference', $model->application->letter_reference, ['class' => 'form-control inline', 'label' => 'UMS/PN2.2/P44/2']) ?>
                       
                        </div>
                    </div>
                
 
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Pelulus <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                        $form->field($model, 'agree')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'PERMOHONAN DILULUSKAN', 0 => 'PERMOHONAN DITOLAK'],
                            'options' => ['placeholder' => 'Pilih Kelulusan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Pelulus<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'notes')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Justifikasi<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= Select2::widget([
                            'name' => 'justifikasi',
                            'data' => $justification,
                            'options' => ['placeholder' => 'Sila pilih Justifikasi', 'default' => 0],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],

                        ]);; ?>
                    </div>
                </div>
                <div id="penyandang" style="display: none">
                   
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Jabatan Yang Diluluskan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?= Select2::widget([
                                'name' => 'approved_dept',
                                'data' => $departments,
                                'options' => ['placeholder' => 'Sila pilih peyandang', 'default' => 0],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'value' => $model->application->new_dept,
                            ]);; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Campus Yang Diluluskan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?= Select2::widget([
                                'name' => 'campus_id',
                                'data' => $campus,
                                'options' => ['placeholder' => 'Sila pilih Kampus', 'default' => 0],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'value' => $model->application->campus_id,
                            ]);; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Berkuatkuasa<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= DatePicker::widget([
                                'name' => 'effective_date',
                                'value' => date('d-m-Y'),
                                'template' => '{addon}{input}',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-M-yyyy'
                                ]
                            ]);?>
                        </div>
                    </div>
                
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <!--form-->
            </div>
        </div>
    </div>
</div>
                         

<script
        src="https://code.jquery.com/jquery-3.4.0.slim.min.js"
        integrity="sha256-ZaXnYkHGqIhqTbJ6MB4l9Frs/r7U4jlx7ir8PJYBqbI="
        crossorigin="anonymous"></script>
<script type="text/javascript">

    $( document ).ready(function() {
        var initVal = $('#recommendation-agree'),penyandang =  $('#penyandang');

        if(initVal.val() == 1){
            penyandang.show()
        }

    });

    var lulus = document.getElementById('recommendation-agree');
    lulus.onchange = function () {
        var penyandang = document.getElementById("penyandang");
        penyandang.style.display = (this.value == 0) ? "none":"block";
    }
</script>