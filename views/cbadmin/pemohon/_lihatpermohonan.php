<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<div class="x_panel">
        <div class="x_content"> 
              
            <span class="required" style="color:black;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PENGAJIAN LANJUTAN KAKITANGAN AKADEMIK
 '); ?>
                        
                </strong> </center>
            </span> 
        </div>
    </div>
 <div class="x_panel">

        <div class="x_content">
            <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> <i class="fa far fa-print"></i> ', ['/cutisabatikal/generate-permohonan', 'id' =>$model->id, 'ICNO'=>$model->icno, 'takwim_id'=>$model->iklan_id ], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Cetak Permohonan'
                ]);
                ?>
    </div>
            
        <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT PERIBADI</center></th></thead>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">Taraf Perkahwinan: </th>
                        <td><?=  ($model->kakitangan->displayTarafPerkahwinan) ?> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JFPIU:</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">No. Tel Bimbit: </th>
                        <td><?=  ucwords(strtolower($model->kakitangan->COHPhoneNo)) ?></td>  
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan & Gred:</th>
                        <td><?= $model->kakitangan->jawatan->nama ." (". ($model->kakitangan->jawatan->gred). ")"; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">Emel: </th>
                        <td><?= ($model->kakitangan->COEmail) ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">Umur:</th>
                        <td><?=date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt))." ". "Tahun"?></td> 
                    </tr>
                    
                  
                   <tr>
                           <th class="col-md-2 col-sm-3 col-xs-12">Tarikh Lantikan: </th>
                           <td><?=  ($model->kakitangan->displayStartLantik) ?></td>  
                           <th class="col-md-2 col-sm-3 col-xs-12 text-left">Tarikh Disahkan Dalam Perkhidmatan: </th>
                           <td>
                               <?php if(!empty($model->kakitangan->confirmpengesahan->tarikhmula )):?>
                                    <?php echo $model->kakitangan->confirmpengesahan->tarikhmula ?></a>
                                          
                                            <?php endif;?>
                           </td>
                   </tr>

                     
                </table>
            </div>   </div>  </div>
   

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
            <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT AKADEMIK</center></th></thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Tahap Pendidikan </th>
                        <th class="column-title text-center">Bidang</th>
                        <th class="column-title text-center">Universiti / Institusi</th>
                        <th class="column-title text-center">Kelas / CGPA</th>
                        <th class="column-title text-center">Tarikh Dianugerahkan</th>
                        <th class="column-title text-center">Tajaan</th>
                        
                    </tr>

                    <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $akademik->tahapPendidikan; ?></td>
                            <td><?= $akademik->namaMajor;?></td>
                            <td><?= $akademik->namainstitut;?></td>
                            <td><?= $akademik->OverallGrade;?></td>
                            <td><?= $akademik->confermentDt;?></td> 
                            <td><?= $akademik->Sponsorship;?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>
                 
             </div>
              <?php }?>
    </div>
</div>

</div>
<!--- Maklumat Pengajian -->
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
        
                 
         
           <div>
                <form id="w0" class="form-horizontal form-label-left" action="">
                    <?php if($model->study){ ?>
                        
                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT PENGAJIAN YANG DIPOHON</center></th>
                       </thead>
                    <tr class="headings">
                        <th class="column-title">Nama Universiti:</th>
                        <td><?= $model->study->InstNm; ?>
                         <th class="column-title">Negara:</th>
                        <td colspan="8"><?= $model->study->negara->Country; ?>
                    </tr>
                    
                   <tr scope="col" colspan=12">
                        <th class="column-title">Peringkat Pengajian:</th>
                        <td colspan="8"><?= $model->study->pendidikanTertinggi->HighestEduLevel; ?>
                    </tr>
                    
                    <tr class="headings">
                        <th class="column-title">Mod Pengajian:</th>
                        <td colspan="5"><?= $model->study->mod->studyMode; ?>
                        <th class="column-title">Bidang Pengajian:</th>
                        <td colspan="5"><?= $model->study->major->MajorMinor; ?>
                    </tr>
                    
                    <tr class="headings">
                        <th class="column-title">Tarikh Pengajian:</th>
                        <td colspan="5"><?= $model->study->tarikhmula; ?> <b>Hingga</b> <?= $model->study->tarikhtamat; ?>
                        <th class="column-title">Tempoh Pengajian:</th>
                        <td colspan="5"><?= $model->tempohpengajian; ?>
                    </tr>
                    
                     <tr class="headings">
                        <th class="column-title">Tajuk Penyelidikan:</th>
                        <td colspan="3"><?= $model->study->tajuk_tesis; ?> 
                        <th class="column-title">Nama Penyelia:</th>
                        <td ><?= $model->study->nama_penyelia; ?>
                        <th class="column-title">Emel Penyelia:</th>
                        <td colspan="2"><?= $model->study->emel_penyelia; ?>
                    </tr>
                    
                    <tbody>

                    </table>
                        <?php }
      else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian yang dipohon</b></td>                     
                    </tr>
                  <?php  
                } 
                 if($model->study){ 
                        $id= $model->study->id;
                    }
                    else
                    {
                        $id= "";
                    }?> 
                        
                      
                     <p align="right">  <?= Html::a('Kemaskini Maklumat', ['update1', 'id'=>$id], ['class' => 'btn btn-warning btn-xs']) ?> </p>

             </div>
             
    </div>
    </div>
</div>

      
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php 
                  
              if($biasiswa){ ?>
 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT PEMBIAYAAN / PINJAMAN YANG DIPOHON</center></th></thead>
                    <tr class="headings">
                        
                       
                        <th class="column-title text-center">Nama Agensi / Tajaan </th>
                        <th class="column-title text-center">Bentuk Amaun</th>
                        <th class="column-title text-center">Jumlah Amaun (RM)</th>
                       
                    </tr>

              <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td class="text-center"><?= $biasiswa->nama_tajaan; ?></td>
                            <td class="text-center">     <?php  
                                    if ($biasiswa->BantuanCd == '4')
                                    {
                                      echo strtoupper($biasiswa->sponsor->bentukBantuan_ums);
                                    }
                                    elseif ($biasiswa->BantuanCd == '6')
                                    {
                                      echo strtoupper($biasiswa->sponsor->bentukBantuan_ums);
                                    }
                                    else
                                    {
                                      echo strtoupper($biasiswa->sponsor->bentukBantuan_ums);
                                    }
                                    
                                ?></td>
                            <td class="text-center">RM<?=  $biasiswa->amaunBantuan;?></td>
                            
                           
                        
                        </tr>
                    <?php } ?>
                        
                </tbody>

</table></form>
             


          
        </div>   
     <?php }
      else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pembiayaan / Pinjaman yang dipohon</b></td>                     
                    </tr>
                  <?php  
                } ?> 

                   

    </div>
</div>
  
</div>
 <!-- Maklumat Keluarga -->
 <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            <?php
                    $keluarga = $biodata->keluarga;
              if($keluarga){ ?>
 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                        <th scope="col" colspan=12">
                    <center>MAKLUMAT KELUARGA</center></th></thead>
                    <tr class="headings">
<!--                        <th class="column-title text-center">Bil</th>-->
                        <th class="column-title text-center">Nama </th>
                        <th class="column-title text-center">Hubungan</th>
                        <th class="column-title text-center">No. Kad Pengenalan </th>
                        <th class="column-title text-center">Umur </th>
                       
                    </tr>
                
                <tbody>

                    <?php $bil=1; foreach ($keluarga as $keluarga) { 
                        if( $keluarga->hubunganKeluarga->RelNm == "Suami" || $keluarga->hubunganKeluarga->RelNm == "Isteri" || $keluarga->hubunganKeluarga->RelNm == "Anak Kandung"){?>

                        <tr>

                            <td class="text-center"><?= $keluarga->FmyNm; ?></td>
                            <td class="text-center"><?= $keluarga->hubunganKeluarga->RelNm;?></td>
                            <td class="text-center"><?= $keluarga->FamilyId; ?></td>
                            <td class="text-center"><?=date("Y") - date("Y", strtotime($keluarga->FmyBirthDt))." " ."Tahun";?></td>
                            
                        
                        </tr>
                    <?php }} ?>
                </tbody>

                     </table>

                </form>


  <?php } ?>
            </div>
        </div>
    </div>
</div>


    
<!-- Dokumen yang dimuatnaik -->

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
              <?php if($dokumen){ ?>
            <div class="x_title">
                <h2><strong><i class="fa fa-list-alt"></i> Dokumen Yang Telah Dimuatnaik </strong></h2>
                
                <div class="clearfix"></div>
            </div>

 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">
<table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">DOKUMEN BAGI PERMOHONAN KPM </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
<!-- <h5><strong>DOKUMEN BAGI PERMOHONAN KPM</strong></h5>-->
                   <?php
                    if ($dokumen2) {
                        $counter = 0;
                        foreach ($dokumen2 as $dokumen2) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen2->nama_dokumen))&& (!empty($dokumen2->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen2->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen2->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen2->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen2->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </tbody>
                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">DOKUMEN BAGI PERMOHONAN PENGAJIAN LANJUTAN </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
<!--                  <h5><strong>DOKUMEN BAGI PERMOHONAN PENGAJIAN LANJUTAN</strong></h5>-->

                   <?php
                    if ($dokumen) {
                        $counter = 0;
                        foreach ($dokumen as $dokumen) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center" style="width:5%;"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen->nama_dokumen))&& (!empty($dokumen->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
<!--                                       <td class="text-center">
                                     <i class="fa fa-check-circle " aria-hidden="true" style="color: green"></i>
                                        </td>-->
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </tbody>

                     </table>

 <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">DOKUMEN BAGI PERMOHONAN LUAR NEGARA </th>
                        
                        
                       
                    </tr>

                </thead>
                <tbody>
<!--                  <h5><strong>DOKUMEN BAGI PERMOHONAN LUAR NEGARA</strong></h5>-->

                   <?php
                    if ($dokumen3) {
                        $counter = 0;
                        foreach ($dokumen3 as $dokumen3) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center" style="width:5%;"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen3->nama_dokumen))&& (!empty($dokumen3->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen3->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen3->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen3->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                      
                                            
                                         
                                      </td>
                                


<!--                                <td class="text-center">
                                <td class="text-center">
                                   

                                  <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> 
                                 
                                    
                                  </td>  -->
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </tbody>

                     </table>
                </form>



            </div>
        </div>
    </div>
</div>

      <?php } 
      else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Dokumen yang Dimuatnaik</b></td>                     
                    </tr>
                  <?php  
                } ?> 