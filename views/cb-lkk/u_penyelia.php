<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 <p align="right"><?= Html::a('Back', ['student-list'], 
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
            <h5><strong><i class='fa fa-clipboard'></i> GUIDELINES</strong></h5>
            <div class="clearfix"></div>     
        </div>
<!--        <div class="x_content"> 
      
            <b style="color:red">PLEASE FILL THE PROGRESS REPORT AND STUDENT ACHIEVEMENT PLAN. 
                DO CLICK THE BUTTON AS PREPARED:</b><br> 
             </div>
            
            <br>-->
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 1</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['view-penyelia?i='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div>
            
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 2 </p><p>
            </p></li> 
            <a href="pengajian-tinggi">
                                <?php if($model->pengajian->HighestEduLevelCd == 1){ ?>

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/sv-phd?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>
                                </a><?php } else{?>
                                    

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/sv-master?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>                              
                            <?php    }
?>
           
        </ul>
    </div> 
   
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 3</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('SUPERVISOR RATING', ['rating?i='.$model->reportID.'&id='.$model->icno]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div>
            
        </div>
 
 <div class="x_panel">

        <div class="x_content">
            <div class="x_title">
           <strong><i class="fa fa-th-list"></i> SEMESTER DETAILS</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMESTER:</th>
                        <td><?= $model->semester; ?></td>
                       
                    </tr>
                    <tr>
                       
                        <th class="col-md-3 col-sm-3 col-xs-12">SESSION:</th>
                        <td><?= $model->session; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD:</th>
                        <td colspan="5">FROM <?= strtoupper($model->reportfr); ?> TO  <?= strtoupper($model->reportto); ?></td>
                    
                    </tr>
                   
                    

                     
                </table>
            </div>   </div>  </div>
   
      

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
                        <th class="col-md-3 col-sm-3 col-xs-12">STUDENT ID:</th>
                        <td><?= $model->pengajian->studentno;?></td> 
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
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACE OF STUDY APPROVED:</th>
                        <td>FROM <?= strtoupper($model->pengajian->tarikhmula); ?> TO <?= strtoupper($model->pengajian->tarikhtamat); ?> AT  <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>  </td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FIELD OF STUDY:</th>
                        <td><?php
                        
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
?></td> 
                    </tr>
<tr> 
                                
                          <th class="col-md-3 col-sm-3 col-xs-12">MODE OF STUDY:</th>
                        <td>
                            
                                  <?php if($model->pengajian->modeID)
                                  {echo strtoupper($model->pengajian->mod->studyMode);}
                                  
                                  else{
                                      echo "No Record";
                                  }
?></td></tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td><?= strtoupper($model->pengajian->nama_penyelia) ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">THESIS TITLE:</th>
                        <td><?= strtoupper($model->pengajian->tajuk_tesis)?></td> 
                    </tr>
                    

                     
                </table>
            </div> 

        </div>
        </div>
 <?php if($model->pengajian->modeID == 1)
{?>
        

<div class='x_panel'>
     <div class="x_title">
       <strong><i class="fa fa-check-square"></i> SUPERVISOR COMMENT</strong>
                    <div class="clearfix"></div>
        </div>
    

                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>RESEARCH PROGRESS</center></th>
                    </tr>
                    <tr>
                         <th ><center>DESCRIPTION</center></th>
                         <th ><center>COMPLETED BY STUDENT</center></th>
                         <th width="40%"><center>ADVISOR/SUPERVISOR'S COMMENT</center></th>

                        
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Stage of Research:</th>
                        <td>
                             
                                    <?php $model->research ?>
                                 </td>
                        
                        <td class="text-justify">
                            <strong>Agree student at the stated level?</strong>
                            <?php
                                        echo $form->field($model,'a1')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                        </td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                        <td><?= $model->ms_semester?> </td>
                        <td class="text-justify">
                            <strong>Was there any discussion to set the milestone?</strong>
                            <?php
                                        echo $form->field($model,'a2')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                        <?= $form->field($model, 'p_komen')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>

</td>

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                        <td><?= $model->ms_achieved?> </td>
                        <td class="text-justify">
                            <strong>Are you satisfied with the student’s achievement?</strong>
                            <?php
                                        echo $form->field($model,'a3')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                        <?= $form->field($model, 'k2')->textArea(['placeholder'=>'Reason','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        State if you encountered any other problems in
                        relation to your research:</th>
                        <td><?= $model->research_problem?> </td>
                        <td class="text-justify">
                        <strong>Can the research problem be solved?</strong>
                        <?php
                                    echo $form->field($model,'a4')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                    ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k3')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                       </td>                    
                  </tr>
                  
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        Have you discussed these problems with your
                        Advisor / Supervisory Committee?:</th>
                        <td><?= $model->discussed_problem; ?> </td>
                        <td class="text-justify">
                        <strong>Have you been informed of the problem faced?</strong>
                        <?php
                                    echo $form->field($model,'a5')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                    ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k4')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>  
                   </tr>
                   
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        State the number of discussions held with your
                        Advisor /Supervisory Commitee?:</th>
                          <td><?= $model->no_ofdiscuss; ?> times<small><br> <i style="color:red"> Latest Date of Discussions:</i>
                                <b><?php if($model->dt_sv)
                                {?><?= $model->dtsv; ?>
                                <?php } else {
                                    echo "No Record";
                                }
?>
                                    </b></small></td> 
                        <td class="text-justify">
                        <strong>Did the student really make an effort to discuss?</strong>
                        <?php
                                    echo $form->field($model,'a6')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 

                                                ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k5')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>  

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         State any national/international seminar, workshop
                         or conference attended this semester:</th>
                        <td><?= $model->activity_sem; ?></td> 
                        <td class="text-justify">
                        <strong>Agree student attend the stated item(s)?</strong>
                        <?php
                                    echo $form->field($model,'a7')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                    ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k6')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        Publication(s) in this semester:</th>
                        <td><?= $model->publications; ?></td>
                        <td class="text-justify">
                        <strong>Agree student publish the stated item(s)?</strong>
                        <?php
                                    echo $form->field($model,'a8')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                                ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k7')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                    </td>
 
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion:</th>
                        <td><?= strtoupper($model->extime); ?></td> 
                        <td class="text-justify">
                            <strong>Agree student expected date of completion?  </strong>
                            <?php
                                        echo $form->field($model,'a9')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                         <?= $form->field($model, 'k8')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  Research Report (Please describe achievements based on target set for this semester):
                        </th>
                        <td colspan='5'><?= $model->achievement_report; ?> 
                        </td>
                    </tr>
                </table>
                     
            </div> 
     <div class="form-group">
                <div class="col-md-9 col-sm-9col-xs-12 col-md-offset-3">
                     
                    <p align="right">    <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?></p>
                   
                </div>
     </div>
 </div>
<?php }?>
<?php if($model->pengajian->modeID == 2)
{?>
        <div class="x_panel">
        <div class="x_title">
            <strong><i class="fa fa-bar-chart-o"></i> STUDENT'S RESULT</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>COURSEWORK</center></th>
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                        <td><?php if($model->cw_cgpa == NULL)
                        {
                            echo "<i>No Data</i>";
                        }else{
                            echo $model->cw_gpa;
                        }?>

</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                        <td><?php if($model->cw_cgpa == NULL)
                        {
                            echo "<i>No Data</i>";
                        }else{
                            echo $model->cw_cgpa;
                        }?>

</td> 
                       
                    </tr>
                    
                    
                    
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
                        
                        <td class="text-justify"> 
                            
                                     <?php
                                    if ($model->dokumen_sokongan) { ?>
                              <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><u>Download Document</u></a><br>
                                    <?php } else {
                                        echo '<i>No Data</i>'.'<br>';
                                        } ?></td>
                            
                            
                            

                            
                        
                    </tr>
                  
                    

                     
                </table>
            </div> 

            
        </div>
        </div>

<div class='x_panel'>
     <div class="x_title">
       <strong><i class="fa fa-check-square"></i> SUPERVISOR COMMENT</strong>
                    <div class="clearfix"></div>
        </div>
    

                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>RESEARCH PROGRESS</center></th>
                    </tr>
                    <tr>
                         <th ><center>DESCRIPTION</center></th>
                         <th ><center>COMPLETED BY STUDENT</center></th>
                         <th width="40%"><center>ADVISOR/SUPERVISOR'S COMMENT</center></th>

                        
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Stage of Research:</th>
                        <td>
                             
                                    <?php $model->research ?>
                                 </td>
                        
                        <td class="text-justify">
                            <strong>Agree student at the stated level?</strong>
                            <?php
                                        echo $form->field($model,'a1')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                        </td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                        <td><?= $model->ms_semester?> </td>
                        <td class="text-justify">
                            <strong>Was there any discussion to set the milestone?</strong>
                            <?php
                                        echo $form->field($model,'a2')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                        <?= $form->field($model, 'p_komen')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>

</td>

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                        <td><?= $model->ms_achieved?> </td>
                        <td class="text-justify">
                            <strong>Are you satisfied with the student’s achievement?</strong>
                            <?php
                                        echo $form->field($model,'a3')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                        <?= $form->field($model, 'k2')->textArea(['placeholder'=>'Reason','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        State if you encountered any other problems in
                        relation to your research:</th>
                        <td><?= $model->research_problem?> </td>
                        <td class="text-justify">
                        <strong>Can the research problem be solved?</strong>
                        <?php
                                    echo $form->field($model,'a4')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                    ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k3')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                       </td>                    
                  </tr>
                  
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        Have you discussed these problems with your
                        Advisor / Supervisory Committee?:</th>
                        <td><?= $model->discussed_problem; ?> </td>
                        <td class="text-justify">
                        <strong>Have you been informed of the problem faced?</strong>
                        <?php
                                    echo $form->field($model,'a5')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                    ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k4')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>  
                   </tr>
                   
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        State the number of discussions held with your
                        Advisor /Supervisory Commitee?:</th>
                          <td><?= $model->no_ofdiscuss; ?> times<small><br> <i style="color:red"> Latest Date of Discussions:</i>
                                <b><?php if($model->dt_sv)
                                {?><?= $model->dtsv; ?>
                                <?php } else {
                                    echo "No Record";
                                }
?>
                                    </b></small></td> 
                        <td class="text-justify">
                        <strong>Did the student really make an effort to discuss?</strong>
                        <?php
                                    echo $form->field($model,'a6')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 

                                                ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k5')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>  

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         State any national/international seminar, workshop
                         or conference attended this semester:</th>
                        <td><?= $model->activity_sem; ?></td> 
                        <td class="text-justify">
                        <strong>Agree student attend the stated item(s)?</strong>
                        <?php
                                    echo $form->field($model,'a7')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                    ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k6')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        Publication(s) in this semester:</th>
                        <td><?= $model->publications; ?></td>
                        <td class="text-justify">
                        <strong>Agree student publish the stated item(s)?</strong>
                        <?php
                                    echo $form->field($model,'a8')->
                                    dropDownList(['1' => 'Yes ',
                                                  '2' => 'No', 
                                                ],['prompt'=>'Options'])->label(false);
                        ?>
                        <?= $form->field($model, 'k7')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                    </td>
 
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion:</th>
                        <td><?= strtoupper($model->extime); ?></td> 
                        <td class="text-justify">
                            <strong>Agree student expected date of completion?  </strong>
                            <?php
                                        echo $form->field($model,'a9')->
                                        dropDownList(['1' => 'Yes ',
                                                      '2' => 'No', 

                                                    ],['prompt'=>'Options'])->label(false);
                            ?>
                         <?= $form->field($model, 'k8')->textArea(['placeholder'=>'Comment','maxlength' => true, 'rows' => 2])->label(false); ?>
                        </td>
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  Research Report (Please describe achievements based on target set for this semester):
                        </th>
                        <td colspan='5'><?= $model->achievement_report; ?> 
                        </td>
                    </tr>
                </table>
                     
            </div> 
     <div class="form-group">
                <div class="col-md-9 col-sm-9col-xs-12 col-md-offset-3">
                     
                    <p align="right">    <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?></p>
                   
                </div>
     </div>
 </div>
<?php }?>
<p align="right"> 
    
    <?php if($model->pengajian->HighestEduLevelCd == 1){ ?>
    
    <?= Html::a('Next', ['lkk/sv-phd?i='.$model->reportID.'&id='.$model->icno ], 
         ['class' => 'btn btn-primary btn-sm']) ?></p><?php }else{?>
              
    <?= Html::a('Next', ['lkk/sv-master?i='.$model->reportID.'&id='.$model->icno ], 
         ['class' => 'btn btn-primary btn-sm']) ?>
  <?php       }
?>
     <?php ActiveForm::end(); ?>


   




