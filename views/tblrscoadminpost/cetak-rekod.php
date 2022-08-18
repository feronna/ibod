<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php

error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 
<div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
    <div class="profile_img text-center">
        <div id="crop-avatar"> 
          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
        </div>
    </div>
</div>

<div class="x_panel" style=" text-align:center">
    <div class="x_content"> 
              
    <span class="required" style="color:#062f49;">
        <strong>
        <center>

        <?= strtoupper('
        <br/><u> 
        PROFIL JAWATAN PENYANDANG
        '); ?>
                        
        </strong></center>
    </span> 
    </div>
</div>
   
<h6><b>MAKLUMAT PERIBADI</b></h6>
<table class="table" style="font-size: 10px;font-family:Arial;"> 
    <tbody>
    <tr style="background-color:lightseagreen;color:white">      
        <th colspan="5" class="text-center"> 
            <p style="font-size: 12px;"><?= strtoupper($biodata->CONm); ?></p> 
        </th>
    </tr>
    <tr>
        <th rowspan="8" class="text-center">
        <center>
            <div class="profile_img">
                <div id="crop-avatar"> <br/><br/>
                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="90" height="120">
                </div>
            </div> 
        </center>
        </th>  
    </tr> 
    <tr>
        <th style="width:20%">ICNO</th> 
            <td style="width:20%"><?= strtoupper($biodata->ICNO);?></td> 
        <th>STATUS</th>
            <td><?= strtoupper($biodata->Status ? $biodata->serviceStatus->ServStatusNm : 'Not Set') ?></td>
    </tr>
    <tr> 
        <th style="width:20%">JAWATAN HAKIKI</th>
            <td style="width:20%"><?= \strtoupper($biodata->jawatan->nama . " (" . $biodata->jawatan->gred . ")"); ?></td> 
        <th width="20%">JAWATAN PENTADBIRAN</th>
            <td><?php
                if ($biodata->adminpos) {
                    echo strtoupper($biodata->adminpos->adminpos->position_name);
                } else {
                    echo '-';
                }
            ?>
            </td>  
    </tr>
    <tr>  
        <th style="width:20%">JABATAN SEMASA</th>
            <td style="width:20%"><?= strtoupper($biodata->department->fullname);?></td>
        <th width="20%">JABATAN PENTADBIRAN</th>
            <td><?php
                if ($biodata->adminpos) {
                    echo strtoupper($biodata->adminpos->dept->fullname);
                } else {
                    echo '-';
                }
            ?>
            </td> 
    </tr>                
    <tr>   
        <th>STATUS JAWATAN HAKIKI</th>
            <td><?= strtoupper($biodata->statusLantikan->ApmtStatusNm) ?></td>
        <th style="width:20%">STATUS JAWATAN PENTADBIRAN</th>
            <td style="width:20%">
            <?php
                if ($biodata->adminpos) {
                    echo strtoupper($biodata->adminpos->jobStatus0->jobstatus_desc);
                } else {
                    echo '-';
                }
            ?>
            </td> 
    </tr>
    <tr> 
        <th style="width:20%"></th>
            <td style="width:20%"></td>
        <th style="width:20%">TARIKH MULA LANTIKAN</th>
            <td style="width:20%"><?php
                if ($biodata->adminpos) {
                    echo strtoupper($biodata->adminpos->tarikhmula);
                } else {
                    echo '-';
                }
            ?></td>
    </tr>
    <tr> 
        <th style="width:20%"></th>
            <td style="width:20%"></td>
        <th style="width:20%">TARIKH TAMAT LANTIKAN</th>
            <td style="width:20%"> 
            <?php
                if ($biodata->adminpos) {
                    echo strtoupper($biodata->adminpos->tarikhtamat);
                } else {
                    echo '-';
                }
            ?>
            </td>
    </tr>
    </tbody>
</table> 

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i> MAKLUMAT LANTIKAN (JAWATAN HAKIKI)</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <?php
                $lantikan = $biodata->lantikan;
                if($lantikan){ ?>
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">STATUS LANTIKAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH MULA LANTIKAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH TAMAT LANTIKAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($lantikan as $lantikan) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($lantikan->statusLantikan->ApmtStatusNm); ?></td>
                        <td class="text-center"><?= strtoupper($lantikan->tarikhMulaLantikan); ?></td>
                        <td class="text-center"><?= strtoupper($lantikan->tarikhTamatLantikan);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>              
        </div>
              <?php }?>
    </div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i> MAKLUMAT SANDANGAN (JAWATAN HAKIKI)</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <?php
                $sandangan = $biodata->allSandangan;
                if($sandangan){ ?>
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">GRED JAWATAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">STATUS SANDANGAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JENIS LANTIKAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH MULA SANDANGAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($sandangan as $sandangan) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($sandangan->gredJawatan->fname); ?></td>
                        <td class="text-center"><?= strtoupper($sandangan->statusSandangan->sandangan_name); ?></td>
                        <td class="text-center"><?= strtoupper($sandangan->jenisLantikan->ApmtTypeNm); ?></td>
                        <td class="text-center"><?= strtoupper($sandangan->tarikhmulasandangan);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>              
        </div>
              <?php }?>
    </div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i> MAKLUMAT PENGESAHAN</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <?php
                $pengesahan = $biodata3;
                if($pengesahan){ ?>
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">STATUS PENGESAHAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH MULA</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($pengesahan as $pengesahan) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($pengesahan->statusPengesahan->ConfirmStatusNm); ?></td>
                        <td class="text-center"><?= strtoupper($pengesahan->tarikhmula);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>              
        </div>
              <?php }?>
    </div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i> MAKLUMAT AKADEMIK</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <?php
                $akademik = $biodata->akademik;
                if($akademik){ ?>
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TAHAP PENDIDIKAN </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIDANG</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">UNIVERSITI/INSTITUSI</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">KELAS/CGPA</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH DIANUGERAHKAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TAJAAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($akademik as $akademik) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($akademik->tahapPendidikan); ?></td>
                        <td class="text-center"><?= strtoupper($akademik->namaMajor);?></td>
                        <td class="text-center"><?= strtoupper($akademik->namainstitut);?></td>
                        <td class="text-center"><?= strtoupper($akademik->OverallGrade);?></td>
                        <td class="text-center"><?= strtoupper($akademik->confermentDt);?></td> 
                        <td class="text-center"><?= strtoupper($akademik->Sponsorship);?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>              
        </div>
              <?php }?>
    </div>
</div>
</div>

<!--<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-book"></i> MAKLUMAT PENEMPATAN</strong></h6>
        <div class="clearfix"></div>
    </div>   
        <?php
                $penempatan = $biodata->allPenempatan;
                if($penempatan){ ?>
        <div>
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH MULA</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JFPIB</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">KAMPUS</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">CATATAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $bil=1; foreach ($penempatan as $penempatan) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($penempatan->tarikhMula); ?></td>
                        <td class="text-center"><?= strtoupper($penempatan->department->fullname);?></td>
                        <td class="text-center"><?= strtoupper($penempatan->kampus->campus_name);?></td>
                        <td class="text-center"><?= strtoupper($penempatan->reasonPenempatan->name);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>              
        </div>
              <?php }?>
    </div>
</div>
</div>-->

<!--<div style="page-break-before:always">&nbsp;</div> -->

<div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-list"></i> MAKLUMAT LANTIKAN PENTADBIRAN</strong></h6>
        <div class="clearfix"></div>
    </div>           
        <div>          
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                    <tr>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL </th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NO IC</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NAMA STAF</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAWATAN PENTADBIRAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">PROGRAM PENGAJARAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">CATATAN</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAFPIB</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">KAMPUS</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH KUATKUASA</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TARIKH TAMAT</th>
                        <th class="column-title text-center"  style="background-color:lightseagreen;color:white">STATUS</th> 
                    </tr>
                </thead>               
                <?php                
                 $bil=1;                
                 if($biodata2){
                    foreach ($biodata2 as $models) {              
                ?>  
                <tr>
                    <td class="text-center" style="width:5%;"><?= $bil++; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->ICNO; ?></td>
                    <td class="text-center" style="width:10%;"><?= strtoupper($models->kakitangan->CONm); ?></td>
                    <td class="text-center" style="width:13%;"><?= strtoupper($models->adminpos->position_name); ?></td>
                    <td class="text-center" style="width:12%;">
                        <?php if($models->program!= NULL){?>  

                        <?= strtoupper($models->program->NamaProgram); ?>

                        <?php }else{
                        echo "-";
                        }?>
                    </td>
                    <td class="text-center" style="width:15%;"><?= strtoupper($models->description); ?></td>
                    <td class="text-center" style="width:15%;"><?= strtoupper($models->dept->fullname); ?></td>
                    <td class="text-center" style="width:10%;"><?= strtoupper($models->campus->campus_name); ?></td>
                    <td class="text-center" style="width:12%;"><?= strtoupper($models->tarikhmula); ?></td>
                    <td class="text-center" style="width:12%;"><?= strtoupper($models->tarikhtamat); ?></td>
                    <td class="text-center" style="width:8%;"><?= strtoupper($models->displayflag->flagstatuss); ?></td>
                </tr>
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="12" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
        </div>    
</div>

<div class="x_panel">
    <div class="x_title">
        <h6><strong><i class="fa fa-list"></i> MYJD</strong></h6>
        <div class="clearfix"></div>
    </div>           
        <div>          
            <table class="table table-bordered jambo_table" style="font-size: 10px;font-family:Arial;" >
        <tr>
            <td colspan="6" style="text-align:center; background-color:lightseagreen" color="white" height="25px"><strong>  MAKLUMAT UMUM </strong></td>
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
            <td><?= strtoupper($deskripsi->applicant->jawatan->gred)?></td>
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
            <td><?=strtoupper( $deskripsi->applicant->department->fullname)?></td>
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
            <td colspan="6"  style="text-align:center; background-color:lightseagreen" color="white"   height="25px"  ><strong> TUJUAN PEWUJUDAN JAWATAN </strong></td>
        </tr>

        <tr> <td colspan="6" style="text-align:justify"><?php echo ucwords(strtolower($deskripsi->kata_kerja)) ?>  <?php echo $deskripsi->object?>  <?php echo $deskripsi->tujuan?></td></tr>

        <tr>
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"><strong>Bil.</strong></td>
            <td colspan="2"  style="text-align:center; background-color:lightseagreen" color="white" height="25px" ><strong>AKAUNTABILITI</strong></td>
            <td colspan="3"  style="text-align:center; background-color:lightseagreen" color="white" height="25px"  ><strong>TUGAS UTAMA</strong></td>
        </tr>
        
            <?php   foreach ($akauntabiliti as $key=>$item){ ?>
        
        <tr>
            <td><?= $key+1?></td>
            <td colspan="2">   <?php echo ucwords(strtolower($item->kata_kerja)) ?> <?= $item->object?> <?= $item->description?></td>
            <td colspan="3"> <?= $item->TugasUtama3($item->id)?></td>
        </tr> 

           <?php } ?>

        <tr>
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"><strong>Bil.</strong></td>
            <td  colspan="2" style="text-align:center; background-color:lightseagreen" color="white" height="25px"><strong>DIMENSI</strong></td>
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"  colspan="3"><strong>SKOP</strong></td>
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
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"><strong>Bil.</strong></td>
            <td  colspan="2" style="text-align:center; background-color:lightseagreen" color="white" height="25px"><strong>KELAYAKAN AKADEMIK / IKHTISAS</strong></td>
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"  colspan="3"><strong>BIDANG</strong></td>
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
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"><strong>Bil.</strong></td>
            <td  style="text-align:center; background-color:lightseagreen" color="white" height="25px" colspan="6"><strong> SYARAT TAMBAHAN</strong></td>
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
            <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px"><strong>Bil.</strong></td>
            <td  style="text-align:center; background-color:lightseagreen" color="white" height="25px" colspan="6"><strong> KOMPETENSI</strong></td>
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
             <td  style="text-align:center; background-color:lightseagreen" color="white"   height="25px" ><strong>Bil.</strong></td>
             <td  style="text-align:center; background-color:lightseagreen" color="white"  height="25px" colspan="6"><strong>PENGALAMAN</strong></td>
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
</div>

<p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
