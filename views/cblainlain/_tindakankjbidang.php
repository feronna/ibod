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


            <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['/lanjutancb/cetak-permohonan', 'id' =>$iklan->id, 'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Permohonan Pelanjutan Tempoh Cuti Belajar'
                ]);
                ?><?= Html::a('Kembali', ['cblainlain/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div> 
            <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN PERTUKARAN BIDANG PENGAJIAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div> 
<div class="x_panel">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PERIBADI</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      
          <div class="col-md-3 col-sm-3  profile_left"> 
        

        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                               <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->kakitangan->ICNO)); ?>.jpeg" width="150" height="180"></center>

            </div>
        </div> 
        <br/> 
    </div>
        <br/> 
    <div class="col-md-9 col-sm-9 col-xs-9">

        <div class="col-md-12 col-sm-12 col-xs-12">   
            <br/>
<!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->
                   
            <table class="table" style="width:100%">
                
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h5><?=  strtoupper($model->kakitangan->CONm); ?> |
                <?=date("Y") - date("Y", strtotime($model->kakitangan->COBirthDt))." ". "TAHUN"?></h5>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?= strtoupper($model->kakitangan->jawatan->fname);?> | 
                        <?= strtoupper($model->kakitangan->department->fullname);?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $model->kakitangan->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $model->kakitangan->COOldID; ?></td>  

                    </tr>
                    <tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->displayStartLantik); ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($model->kakitangan->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($model->kakitangan->confirmDt) {
                                        echo strtoupper($model->kakitangan->confirmDt->tarikhMula);
                                    } else {
                                        echo '<i>Tiada Maklumat</i>';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($model->kakitangan->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th>EMEL</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $model->kakitangan->COHPhoneNo; ?></td>
                    </tr>
                    
                    
                     
                </tbody>
            </table> 
        </div> 
        <br/>

    </div>
</div>
<div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->study){
        
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->study->tahapPendidikan)
                                {
                                 echo strtoupper($model->study->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($model->kakitangan->jawatan->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($model->study->MajorCd == NULL) && ($model->study->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->study->MajorMinor);
                        }
                        elseif (($model->study->MajorCd != NULL) && ($model->study->MajorMinor != NULL))  {
                            echo   strtoupper($model->study->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->study->major->MajorMinor);
                        }
?></td>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($model->study->modeID)
                                  {echo strtoupper($model->study->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->study->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->study->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->study->tarikhtamat)?> (<?= strtoupper($model->study->tempohpengajian);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->tajaan->nama_tajaan)); ?></td> 
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
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>
                     PERMOHONAN PERTUKARAN BIDANG PENGAJIAN</center></th>
<tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN ASAL</th>
                        <td style="width:20%">
                            
                         <?php
                        
                        if(($model->maklumat->MajorCd == NULL) && ($model->maklumat->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->maklumat->MajorMinor);
                        }
                        elseif (($model->maklumat->MajorCd != NULL) && ($model->maklumat->MajorMinor != NULL))  {
                            echo   strtoupper($model->maklumat->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->maklumat->major->MajorMinor);
                        }
?>
                          
   
                      
                        </td>
                       </tr>
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">BIDANG PENGAJIAN BAHARU</th>
                        <td style="width:20%">
                            
                         <?php  if(($model->MajorCd == NULL) && ($model->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->major->MajorMinor);
                        }
                        elseif (($model->MajorCd != NULL) && ($model->MajorMinor != NULL))  {
                            echo   strtoupper($model->major->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->major->MajorMinor);
                        }  ?>
                          
   
                      
                        </td>
                          </tr>
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            SURAT KELULUSAN PERTUKARAN BIDANG PENGAJIAN<br>
                            <i>Dari Tempat Pengajian</i>:</th>
                     
                                                <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>


                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                       
                             SURAT SOKONGAN PENYELIA<br>
                            <i>Dari Tempat Pengajian</i>:</th>
                     
                                                <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <small>Klik Sini Untuk Muat Turun</small></a><br>


                        
                    </tr>
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">JUSTIFIKASI:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->catatan;?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PERMOHONAN:</th>
                        <td> <?= strtoupper($model->status_bsm);?> 
</td> 
                    </tr>
                        

                        
                    </tr>

                    
                    

                     
                </table>
            </div>  </div>  </div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>STATUS PERAKUAN KETUA JABATAN</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">STATUS PERAKUAN:</th>
                        <td> <?= $model->status_jfpiu;?></td>
</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ULASAN:</th>
                        <td> <?= $model->ulasan_jfpiu;?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH DIPERAKUKAN:</th>
                        <td> <?= $model->app_date;?></td>

                    </tr>
          
                </table>
            </div>  
        
       </div>  </div>
</div>     
</div>

 <div class="row">
  <!-- Perakuan Ketua Jabatan -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check"></i> PERAKUAN KETUA JABATAN</strong></h5>
            
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS PERAKUAN<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakukan' => 'PERMOHONAN DISOKONG', 'Tidak Diperakukan' => 'PERMOHONAN TIDAK DISOKONG'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Diperakukan"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Tidak Diperakukan"){
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
<!--        <div class="form-group" id="ulasan" style="display: none" align="center">
        <div style="width: 580px; height: 130px;border:2px solid red">
            <br><p align="left">&nbsp;Saya mengambil maklum bahawa telah menerima permohonan pelanjutan tempoh cuti belajar bagi <br>
               &nbsp;1. Tarikh dan tempoh cuti belajar sesuai.<br>
               &nbsp;2. Fungsi JFPIU tidak akan terjejas sepanjang ketidakberadaan kakitangan.<br>
               &nbsp;3. Saya bersetuju untuk memberi pelepasan kepada beliau tanpa staf gantian.</p>
            </div>
        </div>        -->
        <div class="form-group" id="ulasan1" style="display: none" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ULASAN <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
           <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
    </div>
</div>
        

    </div>
     <?php ActiveForm::end(); ?>
   

   




