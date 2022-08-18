 <?php 
 use yii\helpers\Html;
use Yii;

error_reporting(0);
 ?> 
<div class="x_panel">
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

<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PERIBADI</strong></h5>
        <p align="right"> 
            <?php
            echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i> Lihat CV', [ 'cv/view-cv',  'id' => sha1($biodata->ICNO),
                'title' => 'personal',], [
                'class' => 'btn btn-primary btn-sm',
                'target' => '_blank',
            ]);
            ?>
            <?php 
            echo Html::a('<i class="fa fa-print"></i> Cetak Borang', ['cetak-rekod', 'id'=>$biodata->ICNO,
                'target'=>'_blank'], [
                'class'=>'btn btn-primary btn-sm', 
                //'target'=>'_self', 
                'target' => '_blank',
                'data-toggle'=>'tooltip', 
                //'title'=>'Rekod Keseluruhan'
            ]);
            ?>  
            <?= \yii\helpers\Html::a('Kembali', ['admin-view', 'id' => $biodata->ICNO], ['class' => 'btn btn-primary btn-sm']) ?>
            <?php //echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>
        </p> 
        <div class="clearfix"></div>
    </div>
    
    <div class="col-md-3 col-sm-3  profile_left"> 
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
            </div>
        </div> 
        <br/> 
    </div>
    
    <div class="col-md-9 col-sm-9 col-xs-9">
        <div class="col-md-12 col-sm-12 col-xs-12">   
            <br/>
<!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->    
            <table class="table" style="width:100%">  
                <thead>
                <tr>
                    <th colspan="4" class="text-center">
                    <h5><?=  strtoupper($biodata->CONm); ?></h5>
                    </th>
                </tr>
                </thead>
                <tbody>
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
                        <th style="width:20%">STATUS JAWATAN HAKIKI</th>
                        <td style="width:20%">
                            <?= strtoupper($biodata->statusLantikan->ApmtStatusNm) ?>
                        </td>  
                        <th>STATUS JAWATAN PENTADBIRAN</th>
                        <td>
                            <?php
                                if ($biodata->adminpos) {
                                    echo strtoupper($biodata->adminpos->jobStatus0->jobstatus_desc);
                                } else {
                                    echo '-';
                                }
                             ?>
                        </td>
                    </tr>
<!--                    <tr> 
                        <th style="width:20%"></th>
                        <td style="width:20%"></td>
                        <th style="width:20%">TEMPOH LANTIKAN</th>
                        <td style="width:20%"> 
                            <php
                                if ($biodata->adminpos) {
                                    echo strtoupper($biodata->adminpos->tarikhmula);
                                } else {
                                    echo '-';
                                }
                            ?> 
                            HINGGA
                            <php
                                if ($biodata->adminpos) {
                                    echo strtoupper($biodata->adminpos->tarikhtamat);
                                } else {
                                    echo '-';
                                }
                            ?>
                        </td>
                    </tr>-->
                    <tr> 
                        <th style="width:20%"></th>
                        <td style="width:20%"></td>
                        <th style="width:20%">TARIKH MULA LANTIKAN</th>
                        <td style="width:20%">
                            <?php
                                if ($biodata->adminpos) {
                                    echo strtoupper($biodata->adminpos->tarikhmula);
                                } else {
                                    echo '-';
                                }
                            ?>
                        </td>
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
        </div> 
        <br/>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> MAKLUMAT LANTIKAN (JAWATAN HAKIKI)</strong></h5>
        <div class="clearfix"></div>
    </div>   
        <?php
                $lantikan = $biodata->lantikan;
                if($lantikan){ ?>
    <div class="x_content">          
        <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
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
                        <td class="text-center"><?= strtoupper($lantikan->tarikhMulaLantikan);?></td>
                        <td class="text-center"><?= strtoupper($lantikan->tarikhTamatLantikan);?></td>
                    </tr>
                <?php } ?>
                </tbody>
        </table>              
    </div>
              <?php }?>
</div>

<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> MAKLUMAT SANDANGAN (JAWATAN HAKIKI)</strong></h5>
        <div class="clearfix"></div>
    </div>   
        <?php
                $sandangan = $biodata->allSandangan;
                if($sandangan){ ?>
    <div class="x_content">          
        <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
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

<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> MAKLUMAT PENGESAHAN</strong></h5>
        <div class="clearfix"></div>
    </div>   
        <?php
                $pengesahan = $biodata3;
                if($pengesahan){ ?>
    <div class="x_content">          
        <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
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

<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> MAKLUMAT AKADEMIK</strong></h5>
        <div class="clearfix"></div>
    </div>   
        <?php
                $akademik = $biodata->akademik;
                if($akademik){ ?>
        <div class="x_content"> 
            <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TAHAP PENDIDIKAN </th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIDANG</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">UNIVERSITI / INSTITUSI</th>
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

<!--<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> MAKLUMAT PENEMPATAN</strong></h5>
        <div class="clearfix"></div>
    </div>   
        <?php
                $penempatan = $biodata->allPenempatan;
                if($penempatan){ ?>
        <div class="x_content"> 
            <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
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
</div>-->

<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-list"></i> MAKLUMAT LANTIKAN PENTADBIRAN</strong></h5>
        <div class="clearfix"></div>
    </div>           
    <div class="x_content">          
        <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead>
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
<!--                    <th>ID</th>-->
                    <th class="text-center">BIL </th>
                    <th class="text-center">NO IC</th>
                    <th class="text-center">NAMA STAF</th>
                    <th class="text-center">JAWATAN PENTADBIRAN</th>
                    <th class="text-center">PROGRAM PENGAJARAN</th>
                    <th class="text-center">CATATAN</th>
                    <th class="text-center">JAFPIB</th>
                    <th class="text-center">KAMPUS</th>
                    <th class="text-center">TARIKH KUATKUASA</th>
                    <th class="text-center">TARIKH TAMAT</th>
                    <th class="text-center">STATUS</th> 
                </tr>
                </thead>    
                <?php 
                 
                 $bil=1;
                 if($biodata2){
                 
                    foreach ($biodata2 as $models) {
                
                ?>     
                <tr>
                    <td class="text-center" style="width:5%;"><?= $bil++; ?></td>
                    <td class="text-center" style="width:5%;"><?= $models->ICNO; ?></td>
                    <td class="text-center" style="width:10%;"><?= strtoupper($models->kakitangan->CONm); ?></td>
                    <td class="text-center" style="width:10%;"><?= strtoupper($models->adminpos->position_name); ?></td>
                    <td class="text-center" style="width:10%;"><?php if(strtoupper($models->program!= NULL)){?>  
                        
                                                                <?= strtoupper($models->program->NamaProgram); ?>
                        
                                                                <?php }else{
                                                                echo "TIADA REKOD";
                                                                }?>
                    </td>
                    <td class="text-center" style="width:15%;"><?= strtoupper($models->description); ?></td>
                    <td class="text-center" style="width:13%;"><?= strtoupper($models->dept->fullname); ?></td>
                    <td class="text-center" style="width:10%;"><?= strtoupper($models->campus->campus_name); ?></td>
                    <td class="text-center" style="width:10%;"><?= strtoupper($models->tarikhmula); ?></td>
                    <td class="text-center" style="width:13%;"><?= strtoupper($models->tarikhtamat); ?></td>
                    <td class="text-center" style="width:8%;"><?= strtoupper($models->displayflag->flagstatus); ?></td>
<!--                    <td class="text-center" style="width:8%;"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-lantikan', 'id' => $models->id]) ?></td>  -->
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
        <h5 ><strong><i class="fa fa-list"></i> TERMA RUJUKAN JAWATAN PENTADBIRAN</strong></h5>
        <div class="clearfix"></div>
    </div>           
    <div class="x_content">          
        <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
               
                
        </table>
    </div>    
</div>

<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-list"></i> MYJD</strong></h5>
        <div class="clearfix"></div>
    </div> 
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <td style="width:700px; height:20px"<th class="column-title text-center" colspan="5"><strong> MAKLUMAT UMUM </strong></td></th>
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

                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <td style="width:700px; height:20px"<th class="column-title text-center" colspan="5"><strong> TUJUAN PEWUJUDAN JAWATAN </strong></td></th>
                </tr>
                <tr> <td colspan="6" style="text-align:justify"><?php echo ucwords(strtolower($deskripsi->kata_kerja))?>  <?php echo ucwords(strtolower($deskripsi->object))?>  <?php echo ucwords(strtolower($deskripsi->tujuan))?></td></tr>

                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center"<td style="width:50px; height: 20px">Bil.</strong></td></th>
                    <th class="column-title text-center" colspan="2"<td style="width:200px; height: 20px"><strong>AKAUNTABILITI</strong></td></th>
                    <th class="column-title text-center" colspan="2" <td style="width:500px; height: 20px">TUGAS UTAMA</strong></td></th>
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

                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center"<td style="width:50px; height: 20px">Bil.</strong></td></th>
                    <th class="column-title text-center" colspan="2" <td style="width:200px; height: 20px">DIMENSI</strong></td></th>
                    <th class="column-title text-center" colspan="3"<td style="width:500px; height: 20px">SKOP</strong></td></th>
                </tr>
                
                <?php if($lihatDimensi) {

                foreach ($lihatDimensi as $key=>$item){?>
                
                <tr>
                    <td align="center"><?= $key+1?></td>
                    <td colspan="2">
                    <?= ucwords(strtolower($item->dimensi))?>
                    <td colspan="2">
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
                
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center"<td   height="25px"><strong>Bil.</strong></td></th>
                    <th class="column-title text-center" colspan="2" <td  colspan="2" height="25px"><strong>KELAYAKAN AKADEMIK / IKHTISAS</strong></td></th>
                    <th class="column-title text-center" colspan="2" <td   height="25px"  colspan="3"><strong>BIDANG</strong></td></th>
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

                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center">Bil.</th>
                    <td style="width:700px; height:20px"<th class="column-title text-center" colspan="5"><strong> SYARAT TAMBAHAN </strong></td></th>
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

                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center">Bil. </th>
                    <td style="width:700px; height:20px"<th class="column-title text-center" colspan="5"><strong> KOMPETENSI </strong></td></th>
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

                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center">Bil.</th>
                    <td style="width:700px; height:20px"<th class="column-title text-center" colspan="5"><strong> PENGALAMAN </strong></td></th>
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


<!--<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-list"></i> MYJD</strong></h5>
        <div class="clearfix"></div>
    </div>           
    <div class="x_content">   
<?php //echo $this->render(['deskripsi-tugas-admin', 'icno' => $id]); ?>
    </div>    
</div>-->