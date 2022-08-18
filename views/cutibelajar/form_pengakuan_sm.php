<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

error_reporting(0);
$this->title = 'Permohonan Cuti Belajar'; 
?> 

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="row"><div class="x_panel">
        <div class="x_content">  
            <div class="row">
                
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-pemohon']) ?></li>
        <li>Pengakuan Pemohon</li>
    </ol>
</div>
            
         
            <span class="required" style="color:green;">
                Makluman:<br/>
                <strong>
                    <?= strtoupper('
    1. Sila pastikan Maklumat Peribadi, Maklumat Akademik, Maklumat Pengajian, Pembiayaan / Pinjaman, dan Maklumat Keluarga yang diisi adalah tepat dan benar. <br/>
    2. Manakala, Maklumat Pengajian dan Pembiayaan / Pinjaman boleh dikemaskini di pautan Maklumat Pengajian dan Pembiayaan / Pinjaman di bahagian Menu Pengajian Lanjutan. <br/>
    3. Sila semak status permohonan di Menu Semakan Permohonan dan pastikan tarikh permohonan adalah terkini.
 '); ?>
                </strong> 
            </span> 
        </div>
</div>
    <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
      UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
      PERMOHONAN PENGAJIAN LANJUTAN SEPARUH MASA KAKITANGAN AKADEMIK
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
                <center> <?php
                       
                        if ($img) {
                            echo Html::img($img->getImageUrl().$img->filename, [
                                'class' => 'img-thumbnail',
                                'width' => '150',
                                'width' => '150',
                            ]);
                        }
                                                 echo Html::a('<i class="fa fa-edit"></i>', ['cbelajar/gambar-separuh-masa', 'id'=> $iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']);

                        ?>  </center>
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
                <h5><?=  strtoupper($biodata->CONm); ?> |
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
                        <td style="width:20%"><?= strtoupper($biodata->displayStartLantik); ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($biodata->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo strtoupper($biodata->confirmDt->tarikhMula);
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
 <div class="x_panel">
<div class="col-xs-12 col-md-12 col-lg-12">
       
              <div class="x_title">
                <h5><strong><i class="fa fa-book"></i> MAKLUMAT AKADEMIK</strong>
                
                <?= Html::a('KEMASKINI', ['pendidikan/view'], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?> </h5>

                <div class="clearfix"></div>
            </div>
            <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                      
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center">TAHAP PENDIDIKAN </th>
                        <th class="column-title text-center">BIDANG</th>
                        <th class="column-title text-center">UNIVERSITI/INSTITUSI</th>
                        <th class="column-title text-center">KELAS/CGPA</th>
                        <th class="column-title text-center">TARIKH DIANUGERAHKAN</th>
                        <th class="column-title text-center">TAJAAN</th>
                        
                    </tr>
 </thead>
                    <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td><?= strtoupper($akademik->namaMajor);?></td>
                            <td><?= strtoupper($akademik->namainstitut);?></td>
                            <td><?= strtoupper($akademik->OverallGrade);?></td>
                            <td class="text-center"><?= strtoupper($akademik->confermentDt);?></td> 
                            <td ><?= strtoupper($akademik->namapenaja);?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>

             </div>
              <?php }
              else{?>
                  <tr>
                  <p style="color:red"><b> SILA ISI MAKLUMAT AKADEMIK ANDA</b></p>
                      <td class="text-center"><b> TIADA MAKLUMAT</b></td>
                               

                        </tr>
   <?php           }
?>
    </div>
</div>

    
<div class="x_panel">
      <div class="x_content">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="x_title">
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN YANG DIPOHON</strong>
        <?= Html::a('KEMASKINI', ['cbelajar/maklumat-pengajian-separuh-masa', 'id' => $iklan->id], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?>
</h5>
   
   
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
                                  <?php echo ($pengajian->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohpengajian);?>)</td>
                        </tr>
                              <?php }     else{
                    ?>
                    <tr>
                        <td class="text-center"><b>TIADA MAKLUMAT</b></td>                     
                    </tr>
                  <?php  
                } ?> 
                     
                    
                  
                
                    
      
                            </thead>
                        

                                
                      
                        </table>

                    </div> 

        </div></div>



</div>
</div>
   <div class="x_panel">
    <div class="x_content">

                              <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="x_title">
   <h5 ><strong><i class="fa fa-money"></i> MAKLUMAT BIASISWA/PEMBIAYAAN YANG DIPOHON</strong>                          
 <?= Html::a('KEMASKINI', ['cbelajar/maklumat-biasiswa-separuh-masa', 'id' => $iklan->id], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?> </p>

   </h5>
   
   
   <div class="clearfix"></div>
</div>
              <?php 
                  
              if($biasiswa){ ?>
 <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                       
                    <tr class="headings">
                        
                       
                        <th class="column-title text-center">NAMA AGENSI/TAJAAN </th>
                        <th class="column-title text-center">JENIS TAJAAN</th>
                        <th class="column-title text-center">JUMLAH AMAUN (RM)</th>
                       
                    </tr>
</thead>
                
                <tbody>

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td class="text-center"><?= $biasiswa->nama_tajaan; ?></td>
                            <td class="text-center"><?=  $biasiswa->bantuan->bentukBantuan;?></td>
                            <td class="text-center"><?=  $biasiswa->amaunBantuan;?></td>
                            
                           
                        
                        </tr>
                    <?php } ?>
                        
                </tbody>

</table>
             


          
        </div>   
     <?php }
      else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>TIADA MAKLUMAT</b></td>                     
                    </tr>
                  <?php  
                } ?> 

      

                              </div></div></div>
        
   
    

    <div class="x_panel">
<div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => app\models\cbelajar\TblDokumen::find()->where(['status' => 1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
              <div class="x_title">

<h5> <strong><i class="fa fa-paperclip"></i> DOKUMEN YANG WAJIB DIMUATNAIK</strong> </h5>
    <i style="color:red">Pastikan Salinan Dokumen Dibawah dimuatnaik kesemuanya untuk memudah proses permohonan anda</i>

                           <?= Html::a('KEMASKINI', ['/cbelajar/senarai-dokumen-sm?id='.$iklan->id], ['class' => 'btn btn-success btn-xs', 'target'=>'_blank']) ?> </h5>
         
                     
<div class="clearfix"></div>     </div>               <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:5%'],
                            'header' => 'BIL.'],
                                

                                        [
                                            'label' => 'NAMA DOKUMEN',
                                            'value' => function($model) {
                                               return  $model->nama_dokumen;
                                            },
                                        ],

                                        

                                         [
                                            'header' => 'STATUS DOKUMEN',
                                            'class' => 'yii\grid\ActionColumn',                            
                                             'headerOptions' => ['style' => 'width:5%'],

                                            'template' => '{muatnaik}',
                                            'buttons' => [
                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
                                                {
                                                    if ($model->checkUpload($model->id, $iklan->id)) {
                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
                                                    } else {
                                                        return '<i class="fa fa-times fa-lg" aria-hidden="true" style="color: red"></i>';
                                                    }
                                                }
                                        ],
                                                
                                          'headerOptions' => ['class' => 'text-center'],
                                          'contentOptions' => ['class' => 'text-center'],
                                        ],
                                                    

                                        // [
                                        //     'label' => 'Status',
                                            
                                        // ],

                                            ],
                                        ]);

                                           
                                     
                                        ?>
                                    </div>
                           
</div></div>
    
    
    
<!-- Dokumen Yang telah dimuatnaik-->
<div class="x_panel">
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
 <div class="form-group">
      <div class="x_title">
            <h5><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON</strong></h5>
           
            <div class="clearfix"></div>
        </div>
  <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php $model->agree = 1; ?>
                <br><?= $form->field($model, 'agree')->checkbox(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:light grey;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:light grey;">Tarikh Mohon: <?php echo $model->tarikhmohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
     <div class="col-sm-12 text-center">
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
         
         
        
             <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary ', 'name' => 'hantar1', 'value' => 'submit_2']) ?>

                
           
            <?= Html::a('Keluar', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-danger ']);?>
     
        </div>
    </div>
 </div>
</div>
</div>     
</div>
</div>
        <div class="x_panel">
            <div class="x_content">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
         <div class="x_title">
             <h5 ><center><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON</strong></center></h5>
           
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
 <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php // $model->agree = 1; ?>
                                <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>

<!--                <br>//<?= $form->field($model, 'agree')->checkbox()->label(false); ?> <p>&nbsp;&nbsp;</p>-->
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:black;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:black;">Tarikh Mohon: <?php echo $model->tarikhmohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
     <div>
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true, 'class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
            <?= Html::a('Keluar', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-danger ']);?>
     
        </div>
    </div>
 </div>
</div>
    </div>
            </div></div></div>
        <?= $form->field($model, 'icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
        <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>
        <?= $form->field($model, 'kali_ke')->hiddenInput(['value' => $iklan->kali_ke])->label(false); ?> 
        <?= $form->field($model, 'tarikh_mesyuarat')->hiddenInput(['value' => $iklan->tarikh_mesyuarat])->label(false); ?>  
    
     <?php ActiveForm::end(); ?>
<script>
                function checkTerms() {
                  // Get the checkbox
                  var checkBox = document.getElementById("checkbox1");

                  // If the checkbox is checked, display the output text
                  if (checkBox.checked === true){
                    document.getElementById("submitb").disabled = false;
                  } else {
                    document.getElementById("submitb").disabled = true;
                  }
                }
</script>

