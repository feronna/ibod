<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> 
     LAPOR DIRI TAMAT TEMPOH PENGAJIAN LANJUTAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
</div>
        <div class="x_panel">

<div class="col-md-12 col-xs-12"> 
        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
                  <?php if($model->biasiswa->jenisCd == 3)
    {?>
          
            <b style="color:red">JIKA ANDA BELUM SELESAI, TAJAAN KPT:</b><br> 
            <div align="justify"><strong>
            
           1. SILA PILIH STATUS PENGAJIAN ANDA JIKA BELUM SELESAI.</strong><br> </div>
            <div align="justify"><strong>
            
           2. MASUKKAN MAKLUMAT TARIKH JANGKAAN TAMAT PENGAJIAN DAN JUSTIFIKASI. SILA MUAT NAIK BORANG PERSETUJUAN PEMOTONGAN GAJI.</strong><br> </div>
            <div align="justify"><strong>
            
           3. KLIK BUTANG ELAUN AKHIR PENGAJIAN UNTUK TUNTUTAN.</strong><br> </div>
            <div align="justify"><strong>
    4. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> </div><?php } else{?>
            
            <br>
            
             <b style="color:red">JIKA ANDA BELUM SELESAI, TAJAAN UMS/LUAR:</b><br> 
            <div align="justify"><strong>
            
           1. SILA PILIH STATUS PENGAJIAN ANDA JIKA BELUM SELESAI.</strong><br> </div>
            <div align="justify"><strong>
            
           2. MASUKKAN MAKLUMAT TARIKH JANGKAAN TAMAT PENGAJIAN DAN JUSTIFIKASI. SILA MUAT NAIK BORANG PERSETUJUAN PEMOTONGAN GAJI.</strong><br> </div>
          
            <div align="justify"><strong>
           3. KLIK BUTANG PENGESAHAN UNTUK MENGHANTAR BORANG LAPOR DIRI ANDA.</strong><br> </div>
    </div><?php }?>
</div></div>
    <div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
<!--    <div class="x_title">
        <h2><strong><i class="fa fa-check-square"></i> PANDUAN PERMOHONAN</strong><br/>
        <small>Sila Klik Setiap Butang Untuk Hantar Permohonan</small></h2>
            
            <div class="clearfix"></div>
        </div>-->
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app',' <i class="fa fa-graduation-cap"></i> STATUS PENGAJIAN'), ['lapordiri/borang-belum-selesai'], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

?>
    <?php if($model->biasiswa->jenisCd == 3)
    {?><?php
  
  echo Html::a(Yii::t('app',' <i class="fa fa-th-list"></i> ELAUN AKHIR PENGAJIAN'), ['lapordiri/tuntut-akhir'], ['class' => 'btn btn-primary btn-md']);


    ?><?php }?>
             <?php if($lapor)
    {?><?php

  echo Html::a(Yii::t('app',' <i class="fa fa-check"></i> PENGESAHAN'), ['lapordiri/pengesahan-belum-selesai','i'=>$lapor->laporID], ['class' => 'btn btn-primary btn-md']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);
  

    ?><?php } ?>
         </div>
    </div>
      </div>

    </div>
    <div class="x_panel">
    <div class="x_title">
   <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PEMOHON</strong></h5>
   
   
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
                                        echo 'Tiada Maklumat';
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
   <h5 ><strong><i class="fa fa-graduation-cap"></i> MAKLUMAT PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div>      

     <?php if($model->stud){
        
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($model->stud->tahapPendidikan)
                                {
                                 echo strtoupper($model->stud->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                               
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->stud->InstNm); ?></td></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($model->stud->MajorCd == NULL) && ($model->stud->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->stud->MajorMinor);
                        }
                        elseif (($model->stud->MajorCd != NULL) && ($model->stud->MajorMinor != NULL))  {
                            echo   strtoupper($model->stud->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->stud->major->MajorMinor);
                        }
?></td>
                      
                    
                     <tr> 
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($model->stud->modeID)
                                  {echo strtoupper($model->stud->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->stud->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($model->stud->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo $model->stud->emel_penyelia; ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($model->stud->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->stud->tarikhtamat)?> (<?= strtoupper($model->stud->tempohtajaan);?>)</td>
                        </tr>
                        <tr>
                        <th style="width:10%" align="right">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($model->stud->tajaan->nama_tajaan)); ?></td> 
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
    
<div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-exclamation-circle"></i> STATUS PENGAJIAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>STATUS PENGAJIAN TERKINI</center></th></thead>
              
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"><center>STATUS PENGAJIAN:</center</th>
                        <td><?=
                            $form->field($model, 'status_pengajian')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\cbelajar\RefStatus::find()->where(['cat'=>1])->all(), 'id', 'status_pengajian'),
                                'options' =>
                                ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12',
                                    'onchange' =>
                                    'javascript:if ($(this).val() == "1")
                                           {
                                                $("#lulus").show();$("#viva").hide();$("#tulis").hide();$("#lain").hide();$("#belum").hide();$("#rasmi").hide()
                                         }
                                        
                                          else if(($(this).val() == "2") || ($(this).val() == "3") || ($(this).val() == "4")
                                          || ($(this).val() == "5") || ($(this).val() == "6"))
                                         {
                                           $("#tulis").show();$("#viva").hide();$("#lulus").hide();$("#lain").hide();$("#belum").hide();$("#rasmi").hide();
                                           }
                                            else if($(this).val() == "5") 
                                         {
                                           $("#viva").show();$("#tulis").hide();$("#lulus").hide();$("#lain").hide();$("#belum").hide();$("#rasmi").hide();
                                           }
                                         
                                         

                                    else{
                                    $("#lulus").hide();$("#viva").hide();$("#tulis").hide();$("#lain").hide();$("#rasmi").hide();$("#belum").hide();
                                    }'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?> 
                          
                             
                             
                            
                            
                             

                        </td> 
                    </tr>



                </table>
                
        </div> </div></div>


    
 <div id="tulis" style="display: none">

<div class="x_panel">   <div class="x_content">
        <div class="x_title">
   <h5 ><strong><i class="fa fa-calendar"></i> TARIKH JANGKAAN DAN JUSTIFIKASI </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">

                    <th scope="col" colspan=12">
                    <center>TARIKH JANGKAAN BAGI PERKARA BERIKUT (JIKA BELUM SELESAI)</center></th></thead>
                    
                    <tr>
                        <th width="45%">Tarikh Jangkaan Hantar Tesis Terkini:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_tesis',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangka Viva:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_viva',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jangka Tamat Pengajian:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_endstudy',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Jangka Keputusan Rasmi:</th>
                        <td colspan="5"><?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_result',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?> </td>
                    </tr>

                    <tr>
                        <?php if($model->stud->HighestEduLevelCd == 999)
                        {?>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Temuduga:</th>
                        <td colspan="5"> <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'dt_iv',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?> </td><?php }?>
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Justifikasi:<br>
                            <small>- Sila Nyatakan % Penulisan (jika sedang menulis)<br>
                                - Major Correction / Minor Correction (jika telah viva)<br>
                                - Sebab lain</small></th>
                                    <td colspan="5"> <?= $form->field($model, 'catatan')->textArea(['maxlength' => true]) ->label(false);?></td>

                    </tr>
                                        
                    <tr>
                         <th  class="col-md-3 col-sm-3 col-xs-12">Borang Persetujuan Pemotongan Gaji:<br>
                         <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/gaji.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
                        Borang ini perlu dimuat turun dan diisi untuk persetujuan pemotongan gaji bagi yang belum selesai & telah lapor diri</th>
                     
                        <td><br><?= $form->field($model, 'file6')->fileInput()->label(false);?> </td>
</div>
                </tr>
                
                <tr>
                         <th  class="col-md-3 col-sm-3 col-xs-12">Borang Tuntutan Pelbagai - Kos Kuarantin (Luar Negara Sahaja):<br>
                         <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/borang tuntutan pelbagai - kos kuarantin.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
                        </th>
                     
                        <td><br><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
</div>
                </tr>
                   
</div>
                </table>
        </div> </div></div></div> 
        
      
        



    
<div class="customer-form">  
    <div class="form-group" align="center">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
            <br>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-disk"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])?>
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</div>   


<?php ActiveForm::end(); ?>
 


