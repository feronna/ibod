<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;


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
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-penerbangan', 'id'=>$model->id,
                   'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Permohonan Tiket Penerbangan'
                ]);
                ?>
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
<!--  <div class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
           
          
                 <div class="x_title">
            <h4>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN CUTI BELAJAR KAKITANGAN AKADEMIK</u></h4><br/>
            
           <p align ="right">
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
                 
        
        </div>
    </div>
</div>
</div> -->
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PERMOHONAN TEMPAHAN TIKET PENERBANGAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
 <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
            
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td><?= $model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Pekerja:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan / Seksyen:</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $model->kakitangan->jawatan->nama; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gred:</th>
                        <td><?= $model->kakitangan->jawatan->gred; ?></td> 
                    </tr>
                    
                   
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Taraf Jawatan:</th>
                        <td><?= $model->kakitangan->statusLantikan->ApmtStatusNm ?></td> 
                    </tr>
                    
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Emel:</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                    </tr>
                     
                </table>
            </div>   </div>  </div>

           <div class="x_panel">
            <div class="x_title">
                <h2><strong>Maklumat Penumpang Lain</strong></h2> 
                
                <div class="clearfix"></div>
            </div>
                
                            
   <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                     <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" width="5%" rowspan="2">Bil.</th>
                                    <th class="text-center"  width="40%">Nama</th>
                                    <th class="text-center">Umur</th>
                                    <th class="text-center" width="30%">No. MyKAD/MyPR/KPT/Sijil Lahir</th>
                                    <th class="text-center" colspan="3">Jenis</th>
                                  
                                </tr>
                     </thead>
                     <?php
                    if ($penumpang2) {
                        $counter = 0;
                        foreach ($penumpang2 as $penumpang2) {
                            $counter = $counter + 1;
                            ?>
                        
                           <tr>
                                <td class="text-center"><?= $counter; ?></td>
                                <td class="text-center"><?= $penumpang2->jp_nama; ?></td>
                                <td class="text-center"><?= $penumpang2->umur.' '."Tahun"?></td> 
                                <td class="text-center"><?= $penumpang2->jp_icno; ?></td> 
                                <td class="text-center" colspan="2"><?= $penumpang2->jp_hubungan; ?></td>
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
                </table>
   </div>
        </div>
        <!--           view dyanamic end here--> 

        
                
 
      
<div class="x_panel">
            <div class="x_title">
                <h2><strong>Jadual Penerbangan Yang Dirancang / Ditempah</strong></h2>
                
                <div class="clearfix"></div>
            </div>
         
   <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                     <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" width="5%" rowspan="2">Bil.</th>
                                    <th class="text-center" colspan="3">Pelepasan</th>
                                    <th class="text-center" colspan="3">Ketibaan</th>
                                    <th class="text-center">Jenis Tempahan</th>
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Tarikh</th>
                                    <th class="column-title text-center">Destinasi</th>
                                    <th class="column-title text-center">Masa</th>
                                    <th class="column-title text-center">Tarikh</th>
                                    <th class="column-title text-center">Destinasi</th>
                                    <th class="column-title text-center">Masa</th>
                                    <th class="column-title text-center">(S/P/A)</th>

                                </tr>
                            </thead>
                    <?php
                    if ($jadualTempahan) {
                        $counter = 0;
                        foreach ($jadualTempahan as $jadualTempahan) {
                            $counter = $counter + 1;
                            ?>
                        
                           <tr>
                                <td class="text-center"><?= $counter; ?></td>
                                <td class="text-center"><?= $jadualTempahan->tarikhberlepas; ?></td> 
                                <td class="text-center"><?= $jadualTempahan->dest_berlepas ?></td>
                                <td class="text-center"><?= $jadualTempahan->masa_berlepas ?></td>
                                <td class="text-center"><?= $jadualTempahan->tarikhtiba; ?></td> 
                                <td class="text-center"><?= $jadualTempahan->dest_tiba ?></td>
                                <td class="text-center"><?= $jadualTempahan->masa_tiba ?></td>
                                <td class="text-center"><?= $jadualTempahan->jenistempahan->jenisTempahan ?></td>
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
                </table>
   </div>
            
            
        </div>
        <!--           view dyanamic end here--> 

        
<!--               <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            

        
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                </div>
            </div>
            
            
        </div>
    </div>
</div>     
</div> -->
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
                          SALINAN SURAT TAWARAN CUTI BELAJAR/ SURAT KELULUSAN PELANJUTAN TEMPOH CUTI BELAJAR:
                            </th><?php
                 if ($model->upload->dokumen2) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen2), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                     
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                           SALINAN PASSPORT/KAD PENGENALAN:
                            </th><?php
                 if ($model->upload->dokumen) { ?>
        <td class="text-center"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->upload->dokumen), true); ?>" target="_blank" >
       <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong> </a><br>                            
       <?php } else {
        echo '<td class="text-center"><b>TIADA MAKLUMAT</b></td>'.'<br>';
        }?></td></tr>
                            
                   
                    
       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CADANGAN AIRLINES :</th>
                        <td><?php if($model->cadangan_airlines){?>
                            <?= strtoupper($model->cadangan_airlines);?>
                        <?php } else {
                            echo "TIADA MAKLUMAT";
                        }
?></td> 

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
                   <strong>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi 
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</strong>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
</div> </div>
 <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" > 
    <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> HASIL SEMAKAN PERMOHONAN</strong><br><br>
       </h5>
   
   
</div>
        
    
    <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $vieww;?>"> 



        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PENGAJIAN LANJUTAN</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->status_bsm;?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. PERUNTUKAN:</th>
                        <td> <?= strtoupper($model->no_peruntukan);?> 
</td> 
                    </tr>
                        

                        
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH DISEMAK:</th>
                        <td> <?= strtoupper($model->ver_date);?> 
</td> 
                    </tr>

                    
                    

                     
                </table>
        </div>  </div>  </div></div></div></div></div>     
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" > 
    <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> SEMAKAN KELULUSAN</strong><br><br>
       </h5>
   
   
</div>
        
    
    <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $viewww;?>"> 



        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN KETUA BAHAGIAN SUMBER MANUSIA</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->status_kj;?> </td>
                     </tr>
                     
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">ULASAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->ulasan_kj;?> </td>
                     </tr>

                        
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH DIPERAKUKAN:</th>
                        <td> <?= strtoupper($model->app_date);?> 
</td> 
                    </tr>

                    
                    

                     
                </table>
        </div>  </div>  </div></div></div>
<div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 

       <div class="x_panel">


        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PENTADBIRAN KEWANGAN BSM</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->status_a;?> </td>

                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">ULASAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= $model->ulasan_a;?> </td>

                        
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH DISEMAK:</th>
                        <td> <?= strtoupper($model->ad_dt);?> 
</td> 
                    </tr>

                    
                    

                     
                </table>
        </div>  </div>  </div></div></div>
        
 <div class="row">
  <!-- Semakan Admin BSM -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check-square-o"></i> SEMAKAN UNIT PENTADBIRAN KEWANGAN BSM</strong></h5>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Semakan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model,'status_a')->label(false)->widget(Select2::classname(), [
                        'data' => ['DITEMPAH' => 'TELAH DITEMPAH', 'TIDAK LAYAK' => 'TIDAK LAYAK DIPERTIMBANGKAN'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dimajukan untuk pertimbangan JK Pengajian Lanjutan Akademik"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Dokumen Tidak Lengkap"){
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH KOS PENERBANGAN : <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_a')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
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
     <?php ActiveForm::end(); ?>
   
    </div></div>



