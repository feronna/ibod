<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
$this->title = 'Permohonan Cuti Belajar'; 
error_reporting(0);
?> 

<?php echo $this->render('/cutibelajar/_topmenu');?>
                        <p align="right">  <?= Html::a('Kembali', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']) ?></p>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="x_panel">
     <div class="col-md-12 col-sm-12 col-xs-12">


   
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PERIBADI</strong></h5>
   
   
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
                <h5><?=  strtoupper($biodata->CONm); ?>
                |
                <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></h5>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?= strtoupper($biodata->jawatan->fname);?> | 
                        <?= strtoupper($biodata->department->fullname);?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $biodata->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $biodata->COOldID; ?></td>  

                    </tr>
                    <tr> 

                       
                        <th style="width:20%">TARIKH LANTIKAN</th>
                        <td style="width:20%"><?= $biodata->displayStartLantik; ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($biodata->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo $biodata->confirmDt->tarikhMula;
                                    } else {
                                        echo 'Tiada Maklumat';
                                    }
                                    ?></td>
                        <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                        <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent);  ?></td>


                    </tr>
                     
                    <tr> 
                        
                        <th>EMEL</th>
                        <td><?= $biodata->COEmail; ?></td> 
                        <th style="width:20%">NO. TELEFON</th>
                        <td style="width:20%"><?= $biodata->COHPhoneNo; ?></td>
                    </tr>
                    
                    
                     
                </tbody>
            </table> 
        </div> 
        <br/>

    </div>
</div> 
 </div>
                        <div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN YANG DIPOHON</strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($pengajian){
        foreach ($pengajian as $pengajian) {
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($pengajian->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
                    </tr>
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->MajorMinor);
                        }
                        elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->major->MajorMinor);
                        }
?></td>
                          <?php }?> 
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($pengajian->modeID)
                                  {echo strtoupper($pengajian->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo $pengajian->emel_penyelia; ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohpengajian);?>)</td>
                        </tr>
                        
                         <tr> 
                     
                        <th style="width:10%" align="right">STATUS KETUA JABATAN/DEKAN</th>
                        <td style="width:40%">
                        <?= strtoupper($kontrak->statusjfpiu)?> </td>
                        </tr>
                          
                     
                    
                  
                
                    
                        
                  
                    
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <?php if(($pengajian->HighestEduLevelCd == 1) ||
                ($pengajian->HighestEduLevelCd == 202)|| 
                            ($pengajian->HighestEduLevelCd == 20) && 
                            ($pengajian->modeStudy == "SEPARUH MASA")){
                        
                        ?>
                    <h5> <strong><center>SEMAKAN SYARAT CUTI BELAJAR SEPARUH MASA - AKADEMIK  | UNIT PENGAJIAN LANJUTAN (UPL)</center></strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                
                 <div class="form-group" align="text-center">
                   
             
                <div class="x_content collapse">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">Bil</th>
                                    <th class="text-center" rowspan="2">Perkara</th>
                                    <th class="text-center" colspan="2">Tindakan</th>
                               
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Ya</th>
                                    <th class="column-title text-center">Tidak</th>
                                </tr>
                                    
                            </thead>
                            <?php
                            if ($separuh) 
                            { $no=0;
//                            echo app\models\cbelajar\TblPermohonan::find()->where(['icno'=>$icno])->one()->status_jfpiu;

//                           echo app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO'=>$icno])->orderBy(['ConfirmStatusStDt'=>SORT_DESC])->one()->ConfirmStatusCd;

                                foreach ($separuh as $p) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $p->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->one();
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $p->syarat; ?></td>
                                    <td class="text-center"><input type="radio" name="<?=$p->syarat_id.'semak_phd'?>" value="y" <?php if(eval('return '.$p->checking. ';')== 1){echo "checked";}?>></td>
                                    
                                    <td class="text-center"><input type="radio" name="<?=$p->syarat_id.'semak_phd'?>" value="n"<?php if(eval('return '.$p->checking. ';')=== false){echo "checked";}?>></td>
                                   
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <center><?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar Semakan' ,['class' => 'btn btn-primary btn-sm', 'name' => 'hantar']) ?>
                            <a style="color: green; font-weight: bold"><?php echo $message;?></a>


        
                    </div>
                           
                </div>
                    </div>
            
            </div>
           
            </div>
        </div>

</div>    

                <?php }?>


            
                        






<?php ActiveForm::end(); ?>

  



