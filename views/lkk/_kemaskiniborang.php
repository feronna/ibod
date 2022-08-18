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

//error_reporting(0);
?>
<?php $this->title = 'Borang Online';?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<p align="right">  <?= Html::a('Kembali', ['lkk/senaraisemakan'], 
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
<div class="tile-stats" style='padding:10px'>
                        <div class="x_content">

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>INFO</u> </strong></font><br><br>

                                <strong>
                                    
                                IF YOU HAVING TROUBLE ON SAVING THE STEP 1, STEP 2 AND STEP 3 SUCH AS 
                                WHEN YOU CLICK THE
                                BUTTON SAVE, IT MAKE YOU RETURN TO THE LOGIN PAGE, DO CLEAR YOU CACHE ON THE BROWSER SETTING
                                AND TRY TO LOGIN BACK.</strong>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>

                            </div>
                                 
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
                        <td><small>STEP 1:<strong> PROGRESS REPORT</strong></small> </td>
                          </tr>
                            <tr>
                             <td width="50px" height="20px"><center>2.</center></td> 
                        <td><small>STEP 2: <strong>GOT SCHEDULE- 
                                    COMPULSARY TO UPDATE THE GOT IN THE CURRENT SEMESTER TO 
                                    PROCEED YOUR LKP SUBMISSION. BUT IF YOU ARE IN SEMESTER 4, DO SUBMIT YOUR
                                    EVIDENCE/JUSTIFICATION FROM SEMESTER 1- 3.</strong></small></td>
                          </tr>
                         <tr>
                             <td width="50px" height="20px"><center>3.</center></td> 
                        <td><small>STEP 3: <strong>VERIFICATION - CHECK ALL THE FIELDS ARE FILLED IN CORRECTLY BEFORE VERIFY.  </strong></small></td>
                          </tr>
                        
                         </table>
                </div>
            </div>




                                        <div class="clearfix"></div>
                    

                                            
<div id="modal" class="fade modal" role="dialog" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<i class="fa fa-info-circle"></i>
</div>
<div class="modal-body">
<div id="modalContent"><div class="well"> . <div id="w1" class="kv-spin-center"><div class="kv-spin kv-spin-center"><div class="spinner" style="position: absolute; width: 0px; z-index: 2000000000; left: 50%; top: 50%;" role="progressbar"><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-0-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(0deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-1-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(36deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-2-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(72deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-3-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(108deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-4-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(144deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-5-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(180deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-6-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(216deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-7-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(252deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-8-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(288deg) translate(8px); border-radius: 2px;"></div></div><div style="position: absolute; top: -2px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-9-10;"><div style="position: absolute; width: 12px; height: 4px; background: blue none repeat scroll 0% 0%; box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center 0px; transform: rotate(324deg) translate(8px); border-radius: 2px;"></div></div></div>&nbsp;</div>
</div> .</div></div>
</div>

</div>
</div>
</div>                
<div class="x_panel">
    
<div class="x_title">
           <strong><i class="fa fa-th-list"></i> SEMESTER DETAILS</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="table-responsive" >
                <table class="table table-sm table-bordered jambo_table table-striped"> 

                 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12" colspan="2">SEMESTER:<br>
                            <small><i style="color:red">AUTO SET</i></small></th>
                        <td colspan="2"> 
                        <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12"  value="<?= $model->semester;?>" disabled="">
         </td>
</td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMESTER:<br>
                            <small><i style="color:red">IN STUDY</i></small></th>
                        <td> 
         <?=
                    $form->field($model, 'semesterp')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => '1', '2' => '2'],
                        'options' => ['placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "1"){
                        $("#ulasan").show();$("#ulasan1").hide();
                        }
                        else if($(this).val() == "2"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?> </td>
</td> <th class="col-md-3 col-sm-3 col-xs-12">SESSION:</th>
                        <td> <?= $form->field($model, 'session')->textInput(['maxlength' => true]) ->label(false);?>  </td>
                    </tr>
                
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
                        <th class="col-md-3 col-sm-3 col-xs-12">STUDENT NUMBER:</th>
                         <td colspan="2"> 
                        <input type="text" 
                               id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12"  
                               value="<?= $model->pengajian->studentno;?>" disabled="">
         </td>
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">IC NO.:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">LEVEL OF STUDY:</th>
                        <td><?php if($model->pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($model->pengajian->tahapPendidikan);
                                         
                                }
                                
                              
                                ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACED OF STUDY APPROVED:</th>
                        <td>(FROM) <?= strtoupper($model->pengajian->tarikhmula); ?> (TO) <?= strtoupper($model->pengajian->tarikhtamat); ?> (AT)  <?= ucwords(strtoupper($model->maklumat->InstNm)) ?>  </td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FIELD OF STUDY:</th>
                      <td>
                            
                         <?php
                        
                        if(($model->pengajian->MajorCd == NULL) && ($model->pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($model->pengajian->MajorMinor);
                        }
                        elseif (($model->pengajian->MajorCd != NULL) && ($model->pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($model->pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($model->pengajian->major->MajorMinor);
                        }
?>
                          
   
                      
                        </td> 
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td><?= strtoupper($model->pengajian->nama_penyelia) ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">THESIS TITLE:</th>
                        <td><?= strtoupper($model->pengajian->tajuk_tesis)?></td> 
                    </tr>
                     
                     <tr>
                         <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR EMAIL <br> <i><small style="color:red">*Only One</small></i>:</th>
                        <td> <?= $form->field($model->pengajian, 'emel_penyelia')->textInput(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">RESEARCH TITLE:</th>
                        <td> <?= $form->field($model->pengajian, 'tajuk_tesis')->textArea(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    

                     
                </table>
            </div> 

        </div>
        </div>
          <?php if($model->pengajian->modeID == 3){?>
        <div class="x_panel">
        <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> STUDENT'S RESULT</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5' style="background-color:lightseagreen;color:white"><center>COURSEWORK</center></th>
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Result:</th>
                        <td> <?php
            echo $form->field($model,'result_cw')->
            dropDownList(['PASSED' => 'PASSED',
                          'FAILED' => 'FAILED', 
                          'N/A'=>'NOT APPLICABLE',
                        
                        ],['prompt'=>'Current Result'])->label(false);
?>
</td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                        <td><?= $form->field($model, 'cw_gpa')->textInput(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                        <td><?= $form->field($model, 'cw_cgpa')->textInput(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    
                    
                    
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
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
                  
                    

                     
                </table>
            </div> 
        </div>
        </div>
          <?php }?>
                                        <?php if($model->pengajian->modeID == 1 || $model->pengajian->modeID == 4){?>
            <div class="x_panel">
                <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> RESEARCH PROGRESS</strong> 
                    <div class="clearfix"></div>
        </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5' style="background-color:lightseagreen;color:white"><center>RESEARCH PROGRESS</center></th>
                    </tr>
                    <tr>
                        <th  width="50%">
                            
                            PLEASE CHOOSE THE STAGE OF YOUR RESEARCH. YOU MAY CHOOSE MORE THAN 1:
                           </th>
                        <td>
                       <?php   
                       $data = ArrayHelper::map(app\models\cbelajar\TblResearch::find()->joinWith('r')->where
                               (['idLkk'=>$model->reportID])->asArray()->all(),'researchID', 'r.id'); 
////var_dump($data);die;
   $row=array();
foreach($data as $d)
{
     $row[]=$d;
     
}
?>
                     <?=Select2::widget([
                         'name'=> 'stage',
                         'value'=>$row,
                         
                 'data' => ArrayHelper::map(app\models\cbelajar\RefResearch::find()->all(),  'id', 'stage'),
                 'options' => ['placeholder' => 'Choose your research stage', 'class' => 'form-control col-md-7 col-xs-12',
                ],
                                    'pluginOptions' => [
                                        
//                                        'tags' => $row,
                                    'allowClear' => true,
                                        'multiple' => true,
                                    ],
                                ]);


                                ?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            MILESTONE(S) SET FOT THE CURRENT SEMESTER:</th>
                        <td><?= $form->field($model, 'ms_semester')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">MILESTONE(S) ACHIEVED? :</th>
                        <td><?= $form->field($model, 'ms_achieved')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
</td> 
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            STATE IF YOU ENCOUNTERED ANY OTHER PROBLEMS
                            IN RELATION TO YOUR RESEARCH
                            
:</th>
                        <td><?= $form->field($model, 'research_problem')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                    </tr><tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                            HAVE YOU DISCUSSED THESE PROBLEMS
                            WITH YOUR ADVISOR/ SUPERVISORY COMMITTEE?
                            
:</th>
                        <td><?= $form->field($model, 'discussed_problem')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                            STATE THE NUMBER OF DISCUSSIONS HELD WITH YOUR
                            ADVISORY / SUPERVISORY COMMITTEE AND THE LATEST DATE OF DISCUSSIONS
                           

:</th>
                        <td><?= $form->field($model, 'no_ofdiscuss')->textInput(['maxlength' => true, 'type'=> "number"]) ->label(false);?> 
                          
                             <?= $form->field($model, 'dt_sv')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true,
                                      ],
                                  ])
                         ->label(false);?>
 </td>
                      
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> 
                            
                            STATE ANY NATIONAL/ INTERNATIONAL SEMINAR,
                            WORKSHOP OR CONFERENCE ATTENDED THIS SEMESTER:
                           
</th>
                        <td><?= $form->field($model, 'activity_sem')->textArea(['maxlength' => true,'rows' => 10]) ->label(false);?> 
                            
                        </td> 
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            PUBLICATION(S) IN THIS SEMESTER:

</th>
                        <td><?= $form->field($model, 'publications')->textArea(['maxlength' => true]) ->label(false);?> 
                            
                        </td>
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            EXPECTED DATE OF COMPLETION:
</th>
                        <td>
                            
                 
                               <?= $form->field($model, 'completion_date')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true,
                                     ],
                                  ])
                         ->label(false);?>
                            
                        </td> 
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            
                            RESEARCH REPORT<br/> 
                            <i> <small style="color:red">(PLEASE DESCRIBE ACHIEVEMENTS BASED ON
                                    TARGET SET FOR THIS SEMESTER)</small></i>


</th>
                        <td><?= $form->field($model, 'achievement_report')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                        
                    </tr>
                    
                    
                </table>
            </div> 
        </div>
        

     
                                        <?php }?>
                                        
                                           <?php if($model->pengajian->modeID == 2){?>
        <div class="x_panel">
        <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> STUDENT'S RESULT</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5' style="background-color:lightseagreen;color:white"><center>COURSEWORK</center></th>
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Result:</th>
                        <td> <?php
            echo $form->field($model,'result_cw')->
            dropDownList(['PASSED' => 'PASSED',
                          'FAILED' => 'FAILED', 
                          'N/A'=>'NOT APPLICABLE',
                        
                        ],['prompt'=>'Current Result'])->label(false);
?>
</td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                        <td><?= $form->field($model, 'cw_gpa')->textInput(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                        <td><?= $form->field($model, 'cw_cgpa')->textInput(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                    
                    
                    
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
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
                  
                    

                     
                </table>
            </div> 
        </div>
        </div>
      
            <div class="x_panel">
                <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> RESEARCH PROGRESS</strong> 
                    <div class="clearfix"></div>
        </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5' style="background-color:lightseagreen;color:white"><center>RESEARCH PROGRESS</center></th>
                    </tr>
                    <tr>
                        <th  width="50%">
                            
                            PLEASE CHOOSE THE STAGE OF YOUR RESEARCH. YOU MAY CHOOSE MORE THAN 1:
                           </th>
                        <td>
                       <?php   
                       $data = ArrayHelper::map(app\models\cbelajar\TblResearch::find()->joinWith('r')->where
                               (['idLkk'=>$model->reportID])->asArray()->all(),'researchID', 'r.id'); 
////var_dump($data);die;
   $row=array();
foreach($data as $d)
{
     $row[]=$d;
     
}
?>
                     <?=Select2::widget([
                         'name'=> 'stage',
                         'value'=>$row,
                         
                 'data' => ArrayHelper::map(app\models\cbelajar\RefResearch::find()->all(),  'id', 'stage'),
                 'options' => ['placeholder' => 'Choose your research stage', 'class' => 'form-control col-md-7 col-xs-12',
                ],
                                    'pluginOptions' => [
                                        
//                                        'tags' => $row,
                                    'allowClear' => true,
                                        'multiple' => true,
                                    ],
                                ]);


                                ?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            MILESTONE(S) SET FOT THE CURRENT SEMESTER:</th>
                        <td><?= $form->field($model, 'ms_semester')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">MILESTONE(S) ACHIEVED? :</th>
                        <td><?= $form->field($model, 'ms_achieved')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
</td> 
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            STATE IF YOU ENCOUNTERED ANY OTHER PROBLEMS
                            IN RELATION TO YOUR RESEARCH
                            
:</th>
                        <td><?= $form->field($model, 'research_problem')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                    </tr><tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                            HAVE YOU DISCUSSED THESE PROBLEMS
                            WITH YOUR ADVISOR/ SUPERVISORY COMMITTEE?
                            
:</th>
                        <td><?= $form->field($model, 'discussed_problem')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                            STATE THE NUMBER OF DISCUSSIONS HELD WITH YOUR
                            ADVISORY / SUPERVISORY COMMITTEE AND THE LATEST DATE OF DISCUSSIONS
                           

:</th>
                        <td><?= $form->field($model, 'no_ofdiscuss')->textInput(['maxlength' => true, 'type'=> "number"]) ->label(false);?> 
                            <?=  
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_sv',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                      'placeholder' => 'Latest date of discussions held with your supervisor'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                           
                        ]
                    ]);
                    ?> 
                        </td> 
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> 
                            
                            STATE ANY NATIONAL/ INTERNATIONAL SEMINAR,
                            WORKSHOP OR CONFERENCE ATTENDED THIS SEMESTER:
                           
</th>
                        <td><?= $form->field($model, 'activity_sem')->textArea(['maxlength' => true,'rows' => 10]) ->label(false);?> 
                            
                        </td> 
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            PUBLICATION(S) IN THIS SEMESTER:

</th>
                        <td><?= $form->field($model, 'publications')->textArea(['maxlength' => true]) ->label(false);?> 
                            
                        </td>
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            EXPECTED DATE OF COMPLETION:
</th>
                        <td><?=  
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'completion_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?> 
                            
                        </td> 
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            
                            RESEARCH REPORT<br/> 
                            <i> <small style="color:red">(PLEASE DESCRIBE ACHIEVEMENTS BASED ON
                                    TARGET SET FOR THIS SEMESTER)</small></i>


</th>
                        <td><?= $form->field($model, 'achievement_report')->textArea(['maxlength' => true,'rows' => 6]) ->label(false);?> 
                            
                        </td> 
                        
                    </tr>
                    
                    
                </table>
            </div> 
        </div>
        

     
                                        <?php }?>
  
                                        
            
        
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Save'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
       
      
            <?php ActiveForm::end(); ?>
 


 