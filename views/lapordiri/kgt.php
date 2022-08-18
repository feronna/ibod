<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 
<p align="right"> 
    <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-borang', 'id'=>$model->id,
                    'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Perakuan HPG'
                ]);
                ?><?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?> </p> 

    <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN TUNTUTAN HADIAH PERGERAKAN GAJI (HPG)
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
 <div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT KAKITANGAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div>   
        <div class="x_content">
            
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. KAD PENGENALAN:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. PEKERJA:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JABATAN/SEKSYEN:</th>
                        <td><?= strtoupper($model->kakitangan->department->fullname); ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JAWATAN</th>
                        <td><?= strtoupper($model->kakitangan->jawatan->nama); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GRED:</th>
                        <td><?= $model->kakitangan->jawatan->gred; ?></td> 
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH LANTIKAN DS45:</th>
                        <td><?= strtoupper($model->kakitangan->displayStartLantik); ?></td> 
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARAF JAWATAN:</th>
                        <td><?= strtoupper($model->kakitangan->statusLantikan->ApmtStatusNm) ?></td> 
                    </tr>
                    
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">N0. TELEFON:</th>
                        <td><?= strtoupper($model->kakitangan->COHPhoneNo); ?></td> 
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">EMEL:</th>
                        <td><?= ($model->kakitangan->COEmail); ?></td> 
                    </tr>
                     
                </table>
            </div>   </div>  </div>
 </div>
<div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

   
            

                    <div class="x_content ">

                 <div class="table-responsive">
                       <?php if($model->study2){
        
                ?>  
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->study2->tahapPendidikan)
                                {
                                 echo strtoupper($model->study2->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                               
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study2->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($model->study2->MajorCd == NULL) && ($model->study2->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->study2->MajorMinor);
                        }
                        elseif (($model->study2->MajorCd != NULL) && ($model->study2->MajorMinor != NULL))  {
                            echo   strtoupper($model->study2->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->study2->major->MajorMinor);
                        }
?></td>
                      
                    
                     
                        <tr>
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->study2->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study2->tarikhtamat)?> (<?= strtoupper($model->study2->tempohtajaan);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->biasiswa->nama_tajaan)); ?></td> 
                    </tr>
                     <tr> 
                                
                        <th style="width:10%" align="right">TARIKH LAPOR DIRI</th>
                        <td>
                                  <?php echo strtoupper($model->lapor->dtlapor); ?></td></tr>
                    
                    <tr> 
                     
                        <th style="width:10%" align="right">TARIKH DIANUGERAHKAN PHD</th>
                        <td>
                        <?= strtoupper($model->lapor->dtselesai)?> </td>
                        </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian yang dipohon</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                     
                    
                  
                
                    
      
                            </thead>
                        

                                
                      
                        </table>

                    </div> 

        </div></div>
  </div>
           <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
   
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>SALINAN DOKUMEN SOKONGAN</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            SALINAN SIJIL IJAZAH/PENGESAHAN SENAT
                            :</th>
                     
                                                <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>


                        
                    </tr>
                   
                     
                 

                    
                    

                     
                </table>
            </div>  </div>  </div>

<div class="row"> 
<div class="col-xs-12 col-md-12 col-lg-12">

      <div class="x_panel">   <div class="x_content">
                <div class="x_title">
   <h5><strong><i class="fa fa-check-square"></i> PERAKUAN KAKITANGAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN KAKITANGAN</center></th></thead>

                    <tr class="headings">

                    
                
              
              

                    <td class="col-sm-2 text-center">
                        <div >
                             
                <p class="text-justify"><h5><br> 
                   <strong>Saya mengaku segala maklumat dan dokumen yang disertakan adalah benar dan saya bersetuju sekiranya maklumat ini didapati palsu, permohonan ini akan terbatal dan saya boleh dikenakan tindakan tatatertib disebabkan tidak jujur/amanah seperti yang diperuntukkan di 
                       dalam Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 (Akta 605). </strong>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_m; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
</div> </div> 
        <!--           view dyanamic end here--> 

  <?php if($model->status_j == "Telah ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52")    
   {?>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $vieww;?>"> 
    <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PERJAWATAN AKADEMIK</center></th>
               
                
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Semakan:</th>
                        <td colspan="4"> <?= $model->status_j;?>  </td>

                        
                    </tr>
                    
                    <tr>
                     <th class="col-md-3 col-sm-3 col-xs-12">Melalui Jawatan Kuasa Pemilih:</th>
                        <td colspan="3">Bil: (<?= $model->bil;?>)  </td>
                        <td colspan="5">Tahun: <?= $model->year;?>  </td>

                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Catatan:</th>
                        <td  colspan="4"> <?= $model->ulasan_j;?>  </td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat:</th>
                        <td  colspan="4"> <?= $model->dt_mesy;?></td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Kuatkuasa:</th>
                        <td  colspan="4"> <?= $model->dt_kuat;?></td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Diperakukan:</th>
                        <td  colspan="4"> <?= $model->app_dt;?></td>

                    </tr>
          
                </table>
            </div>  
        
       </div>  </div>
</div>     
   </div><?php } else{?>
       <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" > 
    <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PERJAWATAN AKADEMIK</center></th>
               
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Semakan:</th>
                        <td colspan="4"> <?= $model->status_j;?>  </td>

                        
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Catatan:</th>
                        <td  colspan="4"> <?= $model->ulasan_j;?>  </td>

                    </tr>
                    
                    
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Diperakukan:</th>
                        <td  colspan="4"> <?= $model->app_dt;?></td>

                    </tr>
               
          
                </table>
            </div>  
        
       </div>  </div>
</div>     
   </div>
       
  <?php }
?>
        <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 

       <div class="x_panel">


        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PENGEMBANGAN PROFESIONALISME</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->status_semakan;?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CATATAN:</th>
                        <td> <?= strtoupper($model->ulasan_bsm);?> 
</td> 
                    </tr>
                        

                        
                    </tr>

                    
                    

                     
                </table>
        </div>  </div>  </div></div></div>
                <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
    <h5 ><strong><i class="fa fa-bar-chart"></i> REKOD PERGERAKAN GAJI</strong><br><br>
        </div>
        <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-hpg', 'id'=>$model->id
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
-->            </p>
        <div class="x_content">
         
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings">
                    <th>BULAN PERGERAKAN</th>
                    <th>JENIS PERGERAKAN</th>
                    <th>TARIKH MULA</th>
                  
<!--                    <th class="text-center">Tindakan</th>   -->
                </tr>
                </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= strtoupper($alamatkakitangan->bulanPergerakan->name) ?></td>
                    <td><?= strtoupper($alamatkakitangan->jenisPergerakan->name)?></td>
                    <td><?= strtoupper($alamatkakitangan->tarikhMula)?></td>
                   
               
                    
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
  <!-- Semakan Admin BSM -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list-alt"></i> Hasil Semakan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Semakan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model,'status_semakan')->label(false)->widget(Select2::classname(), [
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan' => 'TIDAK LAYAK DIPERTIMBANGKAN'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dimajukan untuk pertimbangan JK Pengajian Lanjutan Akademik"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Tidak Layak Dipertimbangkan"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>
          <div class="form-group"  align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
    </div>
</div>
 </div>
          <?php if($model->status_semakan == "Layak Dipertimbangkan")    
   {?>
        <div class="row">

    
  <div class="col-md-12 col-sm-12 col-xs-12 ">   



<div class="x_panel">

<div class="x_title">
   <h5><strong><i class="fa fa-legal"></i> PENGIRAAN PEMBERIAN HPG</strong></h5>
   <div class="clearfix"></div>
</div>
    <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-kgt', 'id'=>$model->id
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
-->            </p>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead style="background-color:lightseagreen;color:white">
       
        <tr class="headings">
            <th class="column-title text-center">STATUS </th>
           <th class="column-title text-center">NILAI 1 KGT (DS45)</th>
           <th class="column-title text-center">PERATUSAN BIW</th>
           <th class="column-title text-center">PERGERAKAN GAJI TAHUNAN BARU</th>
           <th class="column-title text-center">GAJI BAHARU</th>
           <th class="column-title text-center">BIW</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($nd){ ?>
        <?php $bil=1; foreach ($nd as $nd) { ?>
        <tr>

<td class="text-center"><?= strtoupper($nd->statuss); ?> BAGI TAHUN <?= $nd->tahuna?></td>
<td class="text-center"> RM<?=$nd->nilai_kgt * 3?></td>
<td class="text-center"><?= strtoupper($nd->status_kgt); ?>%</td>
<td class="text-center"><?= strtoupper($nd->bulan_barukgt); ?> <?= strtoupper($nd->tahunb); ?></td>
<td class="text-center">RM<?= ($nd->kakitangan->gajiBasic2) + ($nd->nilai_kgt * 3); ?></td>
<td class="text-center">RM<?= round(($nd->kakitangan->gajiBasic2) + ($nd->nilai_kgt * 3)) * ($nd->status_kgt / 100); ?></td>

<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                        <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
       
        



 </table>
</form>           </div>
    
    <!-- div for row-->
          <!-- div for well-->
</div>
   
                
                    </div>
   </div><?php }?>
        
         <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
   <h5><strong><i class="fa fa-money"></i> MAKLUMAT GAJI</strong></h5>
   <div class="clearfix"></div>
</div>
    
            <table class="table table-sm table-bordered">
                <?php if($c)
                {?>
                <tr>
                   <th <td width="50px" height="20px"><strong>BIL</strong></td></th>
                     <th class="text-center">JENIS PENDAPATAN</th>
                   <th <td width="200px" height="20px"><strong>GAJI ASAL [TERKINI]</strong></td></th>
                   <th <td width="200px" height="20px"><strong>GAJI BARU HPG</strong></td></th>

                </tr>
                
                
            
                   <?php foreach ($c as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td>RM<?= $item->MPDH_PAID_AMT?></td>

                           </tr>

                <?php endforeach; ?>
             
                <?php foreach ($model2 as $key=>$item): ?>
                      
                           
                               <tr><td>
                             <td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td></td>
                               </tr>
                    
                <?php endforeach; ?>
                <?php }else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                  } ?>
            </table>
        </div>
    </div></div>
        
        
     <?php ActiveForm::end(); ?>
   




