<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
error_reporting(0);
?> 
<style>
    fieldset.scheduler-border {
        border: 1px groove #062f49 !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>
  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 
<p align="right"> 
    <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-borang-tesis', 'id'=>$model->id,
                    'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Perakuan Elaun Tesis'
                ]);
                ?><?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?> </p> 

    <div class="x_panel">  
    <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
             PERMOHONAN TUNTUTAN ELAUN TESIS</5> 
        <div class="clearfix"></div> 
    </div> 
</div>

 <div class="x_panel">
          <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-user-circle'></i>
                MAKLUMAT PERIBADI</h5></legend> 
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
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. TELEFON:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">EMEL:</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT:</th>
                        <td><?= $model->kakitangan->alamatTetap ? $model->kakitangan->alamat->alamatPenuh : '-'; ?></td> 
                    </tr>
                     <tr>
                        <th style="width:10%" align="right">PROGRAM:</th>
                        <td><?= ucwords(strtoupper($model->lapor->claim->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                     <tr>
                        <th style="width:10%" align="right">PERINGKAT PENGAJIAN:</th>
                        <td> <?php if($model->claim->tahapPendidikan)
                                {
                                 echo strtoupper($model->claim->tahapPendidikan);
                                         
                                }
                                
                              
?></td> 
                    </tr>
                                       
                    <tr> 
                                
                        <th align="right">TEMPAT PENGAJIAN:</th>
                        <td style="width:60%">
                                  <?php echo strtoupper($model->claim->InstNm); ?></td></tr>
                     <tr> 
                                
                        <th align="right">TEMPOH PENAJAAN KPT:</th>
                        <td style="width:40%">
                        <?= strtoupper($model->claim->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->claim->tarikhtamat)?> (<?= strtoupper($model->claim->tempohtajaan);?>)</td></tr>
                     
                      <tr> 

                        <th align="right">TAJUK TESIS:</th>
                        <td style="width:60%">
                            <?php 
                            if($model->claim->tajuk_tesis)
                            {
                                echo strtoupper($model->claim->tajuk_tesis);
                            }
                            else
                            {
                                echo '<i>Tidak Berkaitan</i>';
                            }
?></td></tr>
                </table>
            </div> 

        </div>
        </div>
<?php if($model->lapor->claim->tajaan->jenisCd == 3) {?>
               <div class="x_panel">
  <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-th-list'></i>
                MAKLUMAT PERMOHONAN</h5></legend> 
               
        <div class="x_content">
         <?php if($model->status_semakan == "Dokumen Tidak Lengkap"){?>   <p align="left"><?php
     
    echo Html::button('Muatnaik Semula Dokumen <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['lapordiri/update-borang-tesis', 'id'=> $model->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 
 
 ?></p><?php }?>
           
        <div class="table-responsive">
            
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS - KPT</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                       1. Surat Senat/ Skrol/ Transkrip penuh untuk pengesahan Jam Kredit > 6 jam bagi Sarjana:
                            :</th>
                     
                                                <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
2. Penyata Bank (yang tertera nama, nama bank, nombor akaun):</th>
                      
                           <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen2) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>
                        
                    </tr>
                                            <th class="col-md-6 col-sm-6 col-xs-12">
3. Salinan muka hadapan tesis yang disahkan oleh penyelia
</th>
     <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen3) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen3), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>
                           
                                        
                                        <tr colspan="2">     
                                
                                                   <th class="col-md-6 col-sm-6 col-xs-12">
  4. Satu salinan soft copy PDF dalam bentuk CD / pen drive                                 
                                                   </th>

                       <p style="color:red;"> ** Tuntutan hendaklah dibuat dalam tempoh 3 tahun dari tarikh mula penajaan bagi peringkat Sarjana dan 6
tahun dari tarikh mula penajaan bagi peringkat PhD atau Sarjana Perubatan.</p>
                     
                     <td  class="text-left" rowspan="2" style="color: green;"> <small><b>
                                        DIHANTAR KE BSM (PN. DAYANG NOORANIZAH) BERSAMA<BR> BORANG TUNTUTAN ELAUN TESIS
                                        (KPT) YANG DITANDATANGANI</b></small><br><bR>
                            <div class="table-responsive">

            <table class="table table-sm jambo_table table-striped">

                <tr>
                    <th style="color: red;font-size: 10px;">BORANG TUNTUTAN TESIS KPT </th>
                    <td style="color: green;font-size: 10px;"><a href="<?php echo Url::to('@web/' . 'files/tuntut_tesis.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                    </td>

                </tr>
            </table>
        </div></td>
                    
</tr>
                     
                </table>
            </div>  </div>  </div><?php }
else{?>
    <div class="x_panel">
  <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-th-list'></i>
                MAKLUMAT PERMOHONAN</h5></legend> 
               
        <div class="x_content">
         <?php if($model->status_semakan == "Dokumen Tidak Lengkap"){?>   <p align="left"><?php
     
    echo Html::button('Muatnaik Semula Dokumen <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['lapordiri/update-borang-tesis', 'id'=> $model->id]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 
 
 ?></p><?php }?>
           
        <div class="table-responsive">
            
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS </center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                       1. Surat Senat/ Skrol/ Transkrip penuh untuk pengesahan Jam Kredit > 6 jam bagi Sarjana:
                            :</th>
                     
                                                <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
2. Penyata Bank (yang tertera nama, nama bank, nombor akaun):</th>
                      
                           <td class="text-justify">
<?php
                                    if ($model->dokumen2) { ?>
                              <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen2), true); ?>" target="_blank" ><u>Muat Turun Dokumen</u></a><br>
                                    <?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 
                                                        

                           </td>
                        
                    </tr>
                                            <th class="col-md-6 col-sm-6 col-xs-12">
3. Salinan muka hadapan tesis yang disahkan oleh penyelia
</th>
                            <td  class="text-left" rowspan="2" style="color: green;"> <small><b>
                                        DIHANTAR KE BSM (PN. DAYANG NOORANIZAH)</b></small><br><bR>
                            <div class="table-responsive">

           
        </div></td>
                                        
<!--                                        <tr>     
                                
                                                   <th class="col-md-6 col-sm-6 col-xs-12">
  4. Satu salinan soft copy PDF dalam bentuk CD / pen drive                                 
                                                   </th></tr>-->

                       <p style="color:red;"> ** Tuntutan hendaklah dibuat dalam tempoh 3 tahun dari tarikh mula penajaan bagi peringkat Sarjana dan 6
tahun dari tarikh mula penajaan bagi peringkat PhD atau Sarjana Perubatan.</p>
                     
                    
                    

                     
                </table>
</div>  </div>  </div><?php
    
    
}
?>
<div class="row"> 
<div class="col-xs-12 col-md-12 col-lg-12">

      <div class="x_panel">   <div class="x_content">
                  <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-check-square'></i>
                PERAKUAN KAKITANGAN</h5></legend> 
        <div>

                <table>
        <tr>
            

            <td> 
        <center><div class="product_price"   style="width: 1000px; height: 70px;"> 

                    <p style="color:black;font-family:'Arial';font-size: 12px;text-align: center;" >Saya <?= $model->kakitangan->CONm ?>
                            No. Kad Pengenalan: <u><?= $model->kakitangan->ICNO; ?></u>
        mengaku segala maklumat dan dokumen yang disertakan adalah benar. 
                        </p>
                    
                    <p style="color:black;text-align:center">Tarikh Mohon: <?php echo $model->tarikh_m;?></p><br/>
                      
            </div></center>
            </td>
        </tr>
    </table>
        </div> </div></div>
</div> </div>  
        <!--           view dyanamic end here--> 

        
    
<div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 

       <div class="x_panel">
<p align ="left"><?php // Html::a('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', ['', 'id' => $eduhighest->id],
//  ['class' => 'btn btn-default'])
           echo Html::button('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-semakan?id='.$model->id]),
                     'class' => 'btn btn-primary btn-sm mapBtn'])                               
                   ;?> </p>

        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
               
                <th scope="col" colspan=12"  style="background-color:white;"><center>SEMAKAN UNIT PENGEMBANGAN PROFESIONALISME</center></th>

                   
                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMAKAN PERMOHONAN:
                            </th>
                        <td class="text-justify">                                        
                 <?= strtoupper($model->status_semakan);?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CATATAN:</th>
                        <td> <?= strtoupper($model->catatan);?> 
</td> 
                    </tr>
                        

                        
                    </tr>

                    
                    

                     
                </table>
      </div>  </div>  </div></div></div>
          <?php if($model->status_semakan === "Updated" || $model->status_semakan === "TUNGGU SEMAKAN")
      {?>
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
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan' => 'TIDAK LAYAK DIPERTIMBANGKAN', 'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
      </div><?php }?>
    </div>
</div>
 </div>
     <?php ActiveForm::end(); ?>
   




