<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kontrak\Kontrak;
use yii\helpers\ArrayHelper;

error_reporting(0);
$bil=1;

?>
<style>
th {
  background-color: #696969;
  color: white;
  text-align: left;
}

</style>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Borang Naziran</strong></h2>
            <div class="clearfix"></div>
        </div>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->biodata->CONm?>" disabled="">
                                <div class="help-block"></div>
                   </div>
                </div>
            </div>
                
    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                </label>
                 <div class="col-md-6 col-sm-6 col-xs-12">
                   <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->icno?>" disabled="">
                                <div class="help-block"></div>
                   </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->biodata->COOldID?>" disabled="">
                                <div class="help-block"></div>
                   </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
        
            <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="col-md-10 col-sm-10 col-xs-12">
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->biodata->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->biodata->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->biodata->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
              
            </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                     <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->kontrak->startdatelantik?>" disabled="">
               
                </div>
                 
                 
                
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 
               <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->kontrak->enddatelantik?>" disabled="">
                </div>
                
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Perkhidmatan<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
             
                      <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $model->kontrak->tempoh?>" disabled="">
                </div>
                
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Permohonan Pelanjutan Kali Ke <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?php echo $countlantikan?>" disabled="disabled">
                </div>
        </div>
    </div>
        </div>
    </div>
</div>
        <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Senarai Lantikan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Status Lantikan</th>
                    <th class="text-center">Tarikh Mula Lantikan</th>
                    <th class="text-center">Tarikh Tamat Lantikan</th>
                </tr>
                </thead>
                <?php 
                if ($lantikan) { ?>
                    <?php foreach ($lantikan as $l) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $l->statusLantikan->ApmtStatusNm; ?></td>
                            <td class="text-center"><?php echo $l->tarikhmulalantikan; ?></td>
                            <td class="text-center"><?php echo $l->tarikhtamatlantikan; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
    </div>
        </div>
    </div>
</div>
       
    <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Laporan Nilaian Prestasi Tahunan (LNPT)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
       <div class="table-responsive">
          <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Markah Purata</th>
                </tr>
               </thead>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-1; ?></td>
                            <td class="text-center"><?= $model->markahlnpt(date('Y')-1); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-2; ?></td>
                            <td class="text-center"><?= $model->markahlnpt(date('Y')-2); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-3; ?></td>
                            <td class="text-center"><?= $model->markahlnpt(date('Y')-3); ?></td>
                        </tr>
            </table>
    </div>
        </div>
    </div>
</div>
        
        <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Program Pembangunan Individu</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Tarikh</th>
                    <th class="text-center">Jenis Kompetensi</th>
                    <th class="text-center">Peringkat</th>
                    <th class="text-center">Kategori</th>
                </tr>
               </thead>
                <?php
                if ($latihan) { $bil1=1;?>
                    <?php foreach ($latihan as $l) { 
                        if ($l->senarailatihan->vcsl_tkh_mula >= $model->biodata->startDateLantik &&
                                $l->senarailatihan->vcsl_tkh_mula <= $model->biodata->endDateLantik) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_latihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->tarikhmulalatihan; ?></td>
                            <td class="text-center"><?php echo $l->jeniskompetensi->vcks_nama_kompetensi; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_peringkat; ?></td>
                            <td class="text-center"><?php echo $l->kategori->rck_deskripsi_aktiviti; ?></td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
    </div>
        </div>
    </div>
</div>
        
         <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Senarai Anugerah</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Nama Anugerah</th>
                    <th class="text-center">Gelaran</th>
                    <th class="text-center">Dianugerahkan Oleh</th>
                    <th class="text-center">Kategori</th>
                </tr>
               </thead>
                <?php
                if ($anugerah) { $bil1=1;?>
                    <?php foreach ($anugerah as $l) {?>
                        <tr>
                             <td class="text-center"><?php echo $l->namaAnugerah->Awd; ?></td>
                            <td class="text-center"><?php echo $l->gelaran->Title; ?></td>
                            <td class="text-center"><?php echo $l->dianugerahkanOleh->CfdBy; ?></td>
                            <td class="text-center"><?php echo $l->kategoriAnugerah->AwdCat; ?></td>
                        </tr>
                   
                <?php } }?>
            </table>
    </div>
        </div>
    </div>
</div>
        
        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Laporan Kehadiran Tahunan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lambat</th>
                    <th class="text-center">Tidak Lengkap</th>
                    <th class="text-center">Tidak Hadir</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                 <?php
                    for($i=0; $i<=2 ; $i++){
                      $tahun = date('Y')-$i; ?>
                          <tr>
                            <td class="text-center"><?= $tahun ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1)?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 3) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 4) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1) +
                            $model->kehadiran($tahun, 3)+ 
                            $model->kehadiran($tahun, 4)
                            ?></td>
                        </tr><?php 
                    }
                ?>
            </table>
        </div>
        </div>
    </div>
</div>
        

        
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Ulasan Naziran</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
          
        
         <div class="x_content">
     
                 <table class="table table-striped table-sm jambo_table table-bordered">
                    <tr>
                        <th <td colspan="7"><strong> A) PRESTASI DAN DISIPLIN</strong></td></th>
                        
                    </tr>
                     <tr>
                     <td style="width:10px; height: 30px;" ><strong>Bil</strong></td>
                     <td style="width:100px; height: 30px; text-align: center"><strong>Perkara</strong></td>
                     <td style="width:300px; height: 30px;  text-align: center"><strong>Tahap</strong></td>
                     <td colspan="4" style="text-align:center"><strong>Catatan</strong></td>
                     </tr>
                     <tr>
                         <td colspan="3"></td>
                     <td style="text-align:center"><strong>Staf</strong></td>
                     <td style="text-align:center"><strong>Rakan Setugas</strong></td>
                     <td style="text-align:center"><strong>Pegawai</strong></td>
                     <td style="text-align:center"><strong>Ketua Jabatan</strong></td>
                     </tr>
                     
                      <tr>
                     <td><strong>i)</strong></td>
                     <td><strong>LNPT</strong></td>
                     <td><strong>  
                             
                                <table class="table table-sm table-bordered">
                                 <tr>
                                   
                       <td> <?php 
                   if($model->markahlnpt(date('Y')-1) && $model->markahlnpt(date('Y')-2) && $model->markahlnpt(date('Y')-3) != null ) {
                        $purata = ($model->markahlnpt(date('Y')-1)*.45) + ($model->markahlnpt(date('Y')-2)*.35) + ($model->markahlnpt(date('Y')-3)*.20);
                        echo number_format((float)$purata, 2, '.', '')."%";
                        
                    }if (($model->markahlnpt(date('Y')-1) && $model->markahlnpt(date('Y')-2) != null ) && ($model->markahlnpt(date('Y')-3)) == null)  {
                        $purata = ($model->markahlnpt(date('Y')-1)*.60) + ($model->markahlnpt(date('Y')-2)*.40); 
                        echo  number_format((float)$purata, 2, '.', '')."%";
                        
                    }if (($model->markahlnpt(date('Y')-1) != null) && ($model->markahlnpt(date('Y')-2) == null) && ($model->markahlnpt(date('Y')-3)) == null)  {
                        $purata = ($model->markahlnpt(date('Y')-1));
                        echo number_format((float)$purata, 2, '.', ''). "%";
                        
                    }?></td>
                         <td><?php   if($purata >= 85){
                            echo '(Cemerlang)';
                        }
                    
                        if(($purata >= 80) && ($purata <= 84.9))
                         {
                            echo '(Sangat Memuaskan)';
                        } 
                        if(($purata >= 70) && ($purata <= 79.9))
                         {
                            echo '(Memuaskan)';
                        } 
                        if(($purata >= 60) && ($purata <= 69.9))
                         {
                            echo '(Kurang Memuaskan)';
                        }  
                        if($purata <= 60)
                         {
                            echo '(Tidak Memuaskan)';
                        } 
                    ?></td>
                       </tr>
                     </table>
                    </strong></td>
                     <td><?= $form->field($naziran, 'lnpt_staf')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'lnpt_kawan')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'lnpt_pegawai')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'lnpt_kj')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
                       <tr>
                     <td><strong>ii)</strong></td>
                     <td><strong>Kehadiran Tahun <?= $tahun = date('Y')?> (Diperakukan)</strong></td>
                     <td><strong>
                             
                             <table class="table table-sm table-bordered">
                                <tr>
                                 <td>Lambat</td>
                                 <td><?= $model->kehadiran($tahun, 1)?></td>
                                </tr>
                                 <tr>
                                 <td>Tidak Lengkap</td>
                                 <td><?= $model->kehadiran($tahun, 3)?></td>
                                </tr>
                                 <tr>
                                 <td>Tidak Hadir</td>
                                 <td><?= $model->kehadiran($tahun, 4)?></td>
                                </tr>
                                <tr>
                                    <th  <td style="text-align:right">Jumlah</td></th>
                                 <td><?= ($model->kehadiran($tahun, 1) +
                                          $model->kehadiran($tahun, 3)+ 
                                          $model->kehadiran($tahun, 4))?>
                                       <?php
                           
                            $kehadiranPeraku = $model->kehadiran($tahun, 1) +
                            $model->kehadiran($tahun, 3)+ 
                            $model->kehadiran($tahun, 4);
                            
                         if($kehadiranPeraku == 0){
                            echo '(Cemerlang)';
                        }
                    
                        if(($kehadiranPeraku >= 1) && ($kehadiranPeraku <= 3))
                         {
                            echo '(Sangat Memuaskan)';
                        } 
                        if(($kehadiranPeraku >= 4) && ($kehadiranPeraku <= 9))
                         {
                            echo '(Memuaskan)';
                        } 
                        if(($kehadiranPeraku >= 10) && ($kehadiranPeraku <= 18))
                         {
                            echo '(Kurang Memuaskan)';
                        }  
                        if($kehadiranPeraku > 18)
                         {
                            echo '(Tidak Memuaskan)';
                        } 
                        
                             ?>
                                </td>
                                </tr>
                             </table>
                        
                       </strong></td>
                     <td><?= $form->field($naziran, 'kehadiran_peraku_staf')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'kehadiran_peraku_kawan')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'kehadiran_peraku_pegawai')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'kehadiran_peraku_kj')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
                     
                         <tr>
                     <td><strong>ii)</strong></td>
                     <td><strong>Kehadiran Tahun <?= $tahun2 = date('Y')?> (Tidak Diperakukan)</strong></td>
                     <td><strong>
                                 <table class="table table-sm table-bordered">
                                <tr>
                                 <td>Lambat</td>
                                 <td><?= $model->kehadiranRejected($tahun, 1)?></td>
                                </tr>
                                 <tr>
                                 <td>Tidak Lengkap</td>
                                 <td><?= $model->kehadiranRejected($tahun, 3)?></td>
                                </tr>
                                 <tr>
                                 <td>Tidak Hadir</td>
                                 <td><?= $model->kehadiranRejected($tahun, 4)?></td>
                                </tr>
                                <tr>
                                    <th  <td style="text-align:right">Jumlah</td></th>
                                 <td><?= ($model->kehadiranRejected($tahun, 1) +
                                          $model->kehadiranRejected($tahun, 3)+ 
                                          $model->kehadiranRejected($tahun, 4));?>
                             
                         <?php
                           
                            $kehadiranReject = $model->kehadiranRejected($tahun, 1) +
                            $model->kehadiranRejected($tahun, 3)+ 
                            $model->kehadiranRejected($tahun, 4);
                            
                         if($kehadiranReject == 0){
                            echo '(Cemerlang)';
                        }
                    
                        if(($kehadiranReject >= 1) && ($kehadiranReject <= 3))
                         {
                            echo '(Sangat Memuaskan)';
                        } 
                        if(($kehadiranReject >= 4) && ($kehadiranReject <= 9))
                         {
                            echo '(Memuaskan)';
                        } 
                        if(($kehadiranReject >= 10) && ($kehadiranReject <= 18))
                         {
                            echo '(Kurang Memuaskan)';
                        }  
                        if($kehadiranReject > 18)
                         {
                            echo '(Tidak Memuaskan)';
                        } 
                        
                             ?>
                            
                        </td>
                           </tr>
                              
                        </table>
                       
                       </strong></td>
                     <td><?= $form->field($naziran, 'kehadiran_reject_staf')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'kehadiran_reject_kawan')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'kehadiran_reject_pegawai')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'kehadiran_reject_kj')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
                     
                       <tr>
                           <th colspan="7"><strong> B) KESESUAIAN TEMPAT KERJA</strong></td></th>
                        
                    </tr>
                     
                      <tr>
                     <td><strong>i)</strong></td>
                     <td><strong>Tugas Hakiki</strong></td>
                     <td><strong>   <?=
                        $form->field($naziran, 'tahap_tugas')->label(false)->widget(Select2::classname(), [
                        'data' => $tahapTugas,
                        'options' => ['placeholder' => 'Pilih Tahap', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?></strong></td>
                     <td><?= $form->field($naziran, 'tugas_staf')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'tugas_kawan')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'tugas_pegawai')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'tugas_kj')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
                           <tr>
                     <td><strong>i)</strong></td>
                     <td><strong>Lain-lain</strong></td>
                     <td><strong>  
                     <?= $form->field($naziran, 'lain_lain')->textarea(['maxlength' => true])->label(false) ?></strong></td>
                     <td><?= $form->field($naziran, 'lain_staf')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'lain_kawan')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'lain_pegawai')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'lain_kj')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
                     
                        <tr>
                        <th colspan="7"><strong> C) PRODUKTIVITI</strong></td>
                        </th>
                        </tr>
                     <tr>
                     <td><strong>i)</strong></td>
                     <td><strong>Optimum</strong></td>
                     <td><strong>  
                         <?=
                        $form->field($naziran, 'tahap_produktiviti')->label(false)->widget(Select2::classname(), [
                        'data' => $tahapProduktiviti,
                        'options' => ['placeholder' => 'Pilih Tahap', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?></strong></td>
                     <td><?= $form->field($naziran, 'pro_staf')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'pro_kawan')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'pro_pegawai')->textarea(['maxlength' => true])->label(false) ?></td>
                     <td><?= $form->field($naziran, 'pro_kj')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
                     
                       
                       <tr>
                           <th colspan="7"><strong> D) ULASAN KESELURUHAN</strong></td></th>
                        
                    </tr>
                 
                        
                       <tr>
                           <td colspan="7"> <?= $form->field($naziran, 'ulasan_keseluruhan')->textarea(['maxlength' => true])->label(false) ?></td>
                     </tr>
               </table>
             
             
        </div>
   
    </div>
</div>
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


