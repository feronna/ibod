<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
error_reporting(0);
$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 
    <p align="right"> 
    
    
    <?= Html::a('Back', ['lkk/senaraitindakan'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
    
   <div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | 
     SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PROGRESS REPORT
 '); ?>
                </center>  </strong>
            </span> 
        </div>
    </div>
<div class="x_panel">

        <div class="x_title">
            <h5><strong><i class='fa fa-check-square-o'></i> STAFF ACHIEVEMENT PLAN GUIDELINES</strong></h5>
            <div class="clearfix"></div>     
        </div>
        
     
    
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
              
        <ul class="to_do">
            <li style="background-color:blue;color:white">
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan?id='.$model->reportID.'&icno='.$icno]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
                </ul>
    </div>
        </div>
 <div class="x_panel">

        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                   
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Period:</th>
                        <td colspan="5">From <?= $model->report_fr; ?> To  <?= $model->report_to; ?> </td>
                    
                    </tr>
                   
                    

                     
                </table>
            </div>   </div>  </div>
   
      

     <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-user-circle"></i> STAFF'S DETAIL</strong></h5> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FULL NAME:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMSPER:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    
                 
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">IC NO.:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                   
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACED OF STUDY APPROVED:</th>
                        <td>(FROM) <?= strtoupper($model->pengajian->tarikhmula); ?> (TO) <?= strtoupper($model->pengajian->tarikhtamat); ?> (<?= strtoupper($model->pengajian->tempohpengajian);?>) (AT) 
 <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>  </td> 
                    </tr>
                    
                   

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td><?= strtoupper($model->pengajian->nama_penyelia) ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR EMAIL:</th>
                        <td><?= ($model->pengajian->emel_penyelia) ?></td> 
                    </tr> 
                    
                     
                </table>
            </div> 

        </div>
        </div>



        <div class="x_panel">
       <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> STAFF REPORT</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>INDUSTRIAL TRAINING - IR'S REPORT</center></th>
                    </tr>
                    
                    
                    
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">REPORT:</th>
                        <td class="text-justify">
                            
                             <?php
                                    if ($model->dokumen_sokongan) { ?>
                              <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download Document </u></small></strong></a><br>
                                  
                                    <?php } else {
                                        echo '<i>No Data</i>'.'<br>';
                                    } ?>
                            
                        </td>

                            
                        
                    </tr>
                  <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR'S JUSTIFICATION:</th>
                        <td class="text-justify">
                            
                             <?php
                                    if ($model->dokumen_sokongan2) { ?>
                              <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download Document </u></small></strong></a><br>
                                  
                                    <?php } else {
                                        echo '<i>No Data</i>'.'<br>';
                                    } ?>
                            
                        </td>

                            
                        
                    </tr>
                  
                    

                     
                </table>
            </div> 

            
        </div>
        </div>
 

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
                <th scope="col" colspan=12"  style="background-color:white;"><center>DEAN/DIRECTOR'S VERIFICATION STATUS</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> VERIFICATION STATUS:</th>
                        <td> <?= $model->status_jfpiu;?></td>
</td> 
                    </tr>
                  <tr>
                      <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION<br> [FOR STAFF]:</th>
                        <td> <?= $model->ulasan_jfpiu;?>  </td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION<br>[FOR BSM]:</th>
                        <td> <?= $model->ulasan_dekan;?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">VERIFICATION DATE:</th>
                        <td> <?= $model->verify_dt;?></td>

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
            <h5><strong><i class="fa fa-check"></i> DEAN/DIRECTOR'S VERIFICATION STATUS</strong></h5>
            
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"> VERIFICATION STATUS<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakukan' => 'VERIFIED', 'Tidak Diperakukan' => 'NOT VERIFIED'],
                        'options' => ['placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION<br> [FOR STAFF]<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            
        </div>
  <div class="form-group"  align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
      <label class="control-label col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION<br> [FOR BSM]<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_dekan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
           <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
    </div>
</div>
        

    </div>


     <?php ActiveForm::end(); ?>
   




