<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\kemudahan\Reftujuan;
use app\models\cbelajar\TblPrestasi;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
error_reporting(0);
$this->title = 'Permohonan Cuti Belajar';
?> 

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>


<p align="right">  <?= Html::a('Back', ['lkk/senarailkk'], ['class' => 'btn btn-primary btn-sm']) ?></p>




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
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-info alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:white">
                          <h5 style="color:white">
                              <i class="fa fa-question-circle" style="color:white"></i> 
                              PLEASE MAKE SURE ALL THE FIELDS ARE FILLED IN CORRECTLY:</h5>
                          <tr>
                             <td width="50px" height="20px"><center>1.</center></td> 
                        <td><small><strong> PROGRESS REPORT</strong></small> </td>
                          </tr>
                         
                        
                        
                         </table>
                </div>
            </div>


<div class="x_panel">

        <div class="x_title">
            <h5><strong><i class='fa fa-clipboard'></i> REGISTRATION'S GUIDELINES</strong></h5>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
      
            <b style="color:red">PLEASE FILL THE PROGRESS REPORT.
                DO CLICK THE BUTTON AS PREPARED:</b><br> 
             </div>
            
            <br>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:blue;color:white">
<!--                <p> STEP 1</p><p>-->
            </p></li>
            <a href="gambar">
                 <?php if($model->status_borang == NULL){ ?>
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/borang-lkp-latihan-industri?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
                 </a><?php } else {?>
                     <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/lihat-lkp-ir?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
                     
            <?php     }
?>
           
            
        </ul>
    </div>
   
            
            
            
            
            
            
        </div>

                                        <div class="clearfix"></div>
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
        <h5><strong><i class="fa fa-user-circle"></i> STUDENT'S DETAIL</strong></h5> 
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
                    <th class="col-md-3 col-sm-3 col-xs-12">LEVEL OF STUDY:</th>
                    <td><?php
                        if ($model->pengajian->tahapPendidikan) {
                            echo strtoupper($model->pengajian->tahapPendidikan);
                        }
                        ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACE OF STUDY APPROVED:</th>
                    <td>(From) <?= strtoupper($model->pengajian->tarikhmula); ?> (to) <?= strtoupper($model->pengajian->tarikhtamat); ?> (at) 
                         <?php if ($model->pengajian->l) { ?>
                            <?= ucwords(strtoupper($model->pengajian->l->renewTempat)) ?>


                        <?php
                        } else {
                            ?>

                            <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>
                        <?php } ?> (<?= strtoupper($model->pengajian->tempohpengajian); ?>)  </td> 
                </tr>
                <?php
                foreach ($model->pengajian->lanjutan as $l) {
                    ?>
                    <tr>


                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH PELANJUTAN <?= $l->idlanjutan ?></th>
                        <td>

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id' => $l->id])->one()->stlanjutan) ?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id' => $l->id])->one()->ndlanjutan) ?> (<?= strtoupper($l->tempohlanjutan); ?>)</td>
                    </tr><?php } ?>
               
             
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
        <h5><strong><i class="fa fa-check-square"></i> STAFF'S REPORT</strong></h5> 
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

                        <?php if ($model->dokumen_sokongan) { ?>
                            <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                               href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><u>Download Document</u></a><br>
                               <?php
                           } else {
                               echo '<i>No Data</i>' . '<br>';
                           }
                           ?></td>



                </tr>
                
                <tr class="headings">
                    <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR'S JUSTIFICATION:</th>
                    <td class="text-justify"> 

                        <?php if ($model->dokumen_sokongan2) { ?>
                            <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                               href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><u>Download Document</u></a><br>
                               <?php
                           } else {
                               echo '<i>No Data</i>' . '<br>';
                           }
                           ?></td>



                </tr>




            </table>
        </div> 


    </div>
</div>







<div class="x_panel" style="display: <?php echo $view; ?>">   <div class="x_content" >
        <div class="x_title">
            <h5 ><strong><i class="fa fa-check-square"></i> VERIFICATION </strong></h5>


            <div class="clearfix"></div>
        </div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>VERIFICATION</center></th></thead>

                    <tr class="headings">



                        <?php // $model->agree = 0;  ?> 


                        <td class="col-sm-2 text-center">
                            <div >
                                <?php $model->agree = 1; ?>
                                <?= $form->field($model, 'agree')->checkbox(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>                            <p class="text-justify"><h5 style="color:black;" ><br> 
                                    &nbsp;I confirm the above information is true.

                                </h5> 
                                <center><p style="color:black;">Date Of Submit: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                            </div>
                        </td>


                </table>
        </div> </div></div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $vieww; ?>"> 
        <div class="x_panel">
            <div class="x_title">
                <h5 ><strong><i class="fa fa-check-square"></i> DEAN/DIRECTOR'S VERIFICATION </strong></h5>


                <div class="clearfix"></div>
            </div> 
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <th scope="col" colspan=12"  style="background-color:lightseagreen;;color:white"><center>DEAN/DIRECTOR'S VERIFICATION STATUS</center></th>

                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12"> VERIFICATION STATUS:</th>
                            <td> <?= $model->status_jfpiu; ?></td>
                            </td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION:</th>
                            <td> <?= $model->ulasan_jfpiu; ?>  </td>

                        </tr>

                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">VERIFICATION DATE:</th>
                            <td> <?= $model->verify_dt; ?></td>

                        </tr>

                    </table>
                </div>  

            </div>  </div>
    </div> 
</div>
    <div class="x_panel" style="display: <?php echo $edit; ?>">   <div class="x_content" >
            <div class="x_title">
                <h5 ><strong><i class="fa fa-check-square"></i> VERIFICATION </strong></h5>


                <div class="clearfix"></div>
            </div> 
        </div>
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>VERIFICATION</center></th></thead>

                    <tr class="headings">



                        <?php // $model->agree = 0;  ?> 


                        <td class="col-sm-2 text-center">
                            <div >
                                <?php $model->agree = 1; ?>
                                <?= $form->field($model, 'agree')->checkbox(['disabled' => false])->label(false); ?> <p>&nbsp;&nbsp;</p>                            <p class="text-justify"><h5 style="color:black;" ><br> 
                                    &nbsp;I confirm the above information is true.

                                </h5> 
                                <center><p style="color:black;">Date of Submit: <?php echo $model->tarikh_mohon; ?></p></center><br/>

                            </div>
                        </td>


                </table>
                <div class="customer-form">  
                    <div class="form-group" align="center">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                            <br>
                            <?=
                            Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Submit'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2',
                                'data' => ['confirm' => 
                          ' PLEASE MAKE SURE ALL THE FIELDS ARE FILLED IN CORRECTLY,BEFORE SUBMIT AND IF YOU ARE IN SEMESTER 4, DO SUBMIT YOUR EVIDENCE/JUSTIFICATION FROM SEMESTER 1- 3. THANK YOU']])
                            ?>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>
                </div>
        </div> </div>






<?php ActiveForm::end(); ?>
   




