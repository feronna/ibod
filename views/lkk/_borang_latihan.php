<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;    

error_reporting(0);
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

//error_reporting(0);
?>
<?php $this->title = 'Borang Online';?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<p align="right">  <?= Html::a('Kembali', ['lkk/senarailkk'], 
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
                 <?php if($model->status_borang != "Complete"){ ?>
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/borang-lkp-latihan-industri?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
                 </a><?php } else {?>
                     <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/lihat-permohonan-ir?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
                     
            <?php     }
?>
           
            
        </ul>
    </div>
   
            
            
            
            
            
            
        </div>

                                        <div class="clearfix"></div>
                    

                                            
               
<div class="x_panel">
    
<div class="x_title">
           <strong><i class="fa fa-th-list"></i> PERIOD DETAILS</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="table-responsive" >
                <table class="table table-sm table-bordered jambo_table table-striped"> 

                 
                   
                    
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD :</th>
                        <td colspan="1"> <b>FROM</b>  <?= $form->field($model, 'report_fr')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])
                         ->label(false);?>
 </td>
 <td colspan="1"><b> TO </b> <?= $form->field($model, 'report_to')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])
                         ->label(false);?>
                </td>
 
                    </tr>
               
                   
                </table>
           
        </div>
</div>
       <div class="x_panel">
        <div class="x_title">
           <strong><i class="fa fa-user-circle"></i> STUDENT'S DETAIL</strong>
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
                        <td><?= strtoupper($model->pengajian->tahapPendidikan); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACE OF STUDY APPROVED:</th>
                        <td>(FROM) <?= strtoupper($model->pengajian->tarikhmula); ?> (TO) <?= strtoupper($model->pengajian->tarikhtamat); ?> 
                          (AT) 
                          <?php  if($model->pengajian->l){?>
                                        
                                    <?= ucwords(strtoupper($model->pengajian->l->renewTempat)) ?>

                                        
                               <?php     }
                                    else
                                    {?>

                                    <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>
                                     <?php }?>
                        </td> 
                    </tr>
                    
                    
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td> <?= $form->field($b, 'nama_penyelia')->textArea(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                     <tr>
                         <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR EMAIL <br> <i><small style="color:red">*Only One</small></i>:</th>
                        <td> <?= $form->field($b, 'emel_penyelia')->textInput(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    </tr> 
                   
                    

                     
                </table>
            </div> 

        </div>
        </div>
       
        <div class="x_panel">
        <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> INDUSTRIAL TRAINING - IR'S REPORT</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5' style="background-color:lightseagreen;color:white"><center>REPORT</center></th>
                    </tr>
                 
                    
      
                    
                    
                    
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">REPORT:</th>
                        <td class="text-justify">
                        
                        <?php if($model->dokumen_sokongan)
                        {
                           ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><u>Download Document</u></a>
                       <?php }
                       else{?>
                           <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>

                     <?php  }
?>

                   
                        

                        
                    </tr>
                  <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR JUSTIFICATION:</th>
                        <td class="text-justify">
                        
                        <?php if($model->dokumen_sokongan2)
                        {
                           ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><u>Download Document</u></a>
                       <?php }
                       else{?>
                           <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td>

                     <?php  }
?>

                   
                        

                        
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
                          ' PLEASE MAKE SURE ALL THE FIELDS ARE FILLED IN CORRECTLY,BEFORE SUBMIT']])
                            ?>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>
                </div>
        </div> </div>
 
       
      
            <?php ActiveForm::end(); ?>
 


 