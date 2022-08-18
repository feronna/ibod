<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
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
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-borang-akhir', 'id'=>$model->id,
                    'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Perakuan EAP'
                ]);
                ?><?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?> </p> 
    <div class="x_panel">  
    <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
             PERMOHONAN TUNTUTAN ELAUN AKHIR PENGAJIAN</5> 
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
                        <td><?= ucwords(strtoupper($model->lapor->study2->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                     <tr>
                        <th style="width:10%" align="right">PERINGKAT PENGAJIAN:</th>
                        <td> <?php if($model->studysemasa->tahapPendidikan)
                                {
                                 echo strtoupper($model->studysemasa->tahapPendidikan);
                                         
                                }
                                
                              
?></td> 
                    </tr>
                                       
                    <tr> 
                                
                        <th align="right">TEMPAT PENGAJIAN:</th>
                        <td style="width:60%">
                                  <?php echo strtoupper($model->studysemasa->InstNm); ?></td></tr>
                     <tr> 
                                
                        <th align="right">TEMPOH PENAJAAN KPT:</th>
                      <td style="width:40%">
                        <?= strtoupper($model->studysemasa->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($model->studysemasa->tarikhtamat)?> (<?= strtoupper($model->studysemasa->tempohtajaan);?>)</td></tr>
                      <tr> 
                                
                        <th align="right">TAJUK TESIS:</th>
                        <td style="width:60%">
                                  <?php echo strtoupper($model->studysemasa->tajuk_tesis); ?></td></tr>
                      <tr> 
                                
                        <th align="right">MOD PENGAJIAN</th>
                        <td>
                            
                                  <?php if($model->studysemasa->modeID)
                                  {echo strtoupper($model->studysemasa->mod->studyMode);}
                                  
                                  else{
                                      echo "<i>Tiada Maklumat</i>";
                                  }
?></td></tr>
                </table>
            </div> 

        </div>
        </div>

           <div class="x_panel">
<fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-th-list'></i>
                    MAKLUMAT PERMOHONAN</h5>
           </legend> 
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS - KPT</center></th>

                     <tr class="headings">
                        
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                      BORANG PENGESAHAN KELAYAKAN ELAUN AKHIR PENGAJIAN
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
                        <th class="col-md-3 col-sm-3 col-xs-12">
                      BORANG TUNTUTAN KPT EAP
                            :</th>
                     
                                                       <td class="text-justify"> 
                                                    
                                                    <?php
                                    if ($model->dokumen4) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen4), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
<?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 

                                                </td>


                        
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                   SALINAN TIKET PENERBANGAN:
                            :</th>
                     
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
                    <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                   BOARDING PASS:
                            :</th>
                     
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


                        
                    </tr>
                               
                                            
                     
                    
                    

                     
                </table>
            </div>  </div>  </div>

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
                 <?= $model->status_semakan;?> </td>
<tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CATATAN:</th>
                        <td> <?= strtoupper($model->catatan);?> 
</td> 
                    </tr>
                        

                        
                    </tr>

                    
                    

                     
                </table>
      </div>  </div>  </div></div></div>
        <!--           view dyanamic end here--> 
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
        
                

   




