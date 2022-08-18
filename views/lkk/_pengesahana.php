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
    
    <?php if($model->pengajian->HighestEduLevelCd == 1){ ?>
    
    <?= Html::a('Back', ['lkk/a-achievement-phd?i='.$model->reportID.'&id='.$model->icno ], 
         ['class' => 'btn btn-primary btn-sm']) ?></p><?php }else{?>
              
    <?= Html::a('Back', ['lkk/a-achievement-master?i='.$model->reportID.'&id='.$model->icno ], 
         ['class' => 'btn btn-primary btn-sm']) ?>
  <?php       }
?>
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
            <h5><strong><i class='fa fa-check-square-o'></i> STUDENT ACHIEVEMENT PLAN GUIDELINES</strong></h5>
            <div class="clearfix"></div>     
        </div>
        
     <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 1</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/adminview?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div>
      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
           <?php if($model->pengajian->nama_penyelia != "Non")
        {?>
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 2</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('SUPERVISOR RATING', ['cb-lkk/a-view-rating?i='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul><?php }
 else {?>
     <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 2 </p><p>
            </p></li> 
            <a href="pengajian-tinggi">
                                <?php if($model->pengajian->HighestEduLevelCd == 1){ ?>

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/a-achievement-phd?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>
                                </a><?php } else{?>
                                    

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/a-achievement-master?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>                              
                            <?php    }
?>
           
        </ul><?php
 }?>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <?php if($model->pengajian->nama_penyelia != "Non")
        {?>
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 3 </p><p>
            </p></li> 
            <a href="pengajian-tinggi">
                                <?php if($model->pengajian->HighestEduLevelCd == 1){ ?>

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/a-achievement-phd?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>
                                </a><?php } else{?>
                                    

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/a-achievement-master?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>                              
                            <?php    }
?>
           
        </ul><?php }
        else{?>
        
          <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 3</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan-admin?id='.$model->reportID.'&icno='.$model->icno]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>  
      <?php  }
?>
    </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
                <?php if($model->pengajian->nama_penyelia != "Non")
                {?>
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 4</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan-admin?id='.$model->reportID.'&icno='.$model->icno]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
                </ul><?php }?>
    </div>
        </div>
 <div class="x_panel">

        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Semester:</th>
                        <td><?= $model->semester; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12">Session:</th>
                        <td><?= $model->semesterp?> / (<?= $model->session; ?>)</td> 
                    </tr>
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
                        <th class="col-md-3 col-sm-3 col-xs-12">STUDENT NAME:</th>
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
                        <td>(From) <?= strtoupper($model->pengajian->tarikhmula); ?> (to) <?= strtoupper($model->pengajian->tarikhtamat); ?> (at) 
                     <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>  </td> 
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
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td><?= strtoupper($model->pengajian->nama_penyelia) ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR EMAIL:</th>
                        <td><?= $model->pengajian->emel_penyelia?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">THESIS TITLE:</th>
                        <td><?= strtoupper($model->pengajian->tajuk_tesis)?></td> 
                    </tr>
                    

                     
                </table>
            </div> 

        </div>
        </div>
<div class="x_panel">
    <div class="x_title">
            <h5><strong><i class="fa fa-user-secret"></i> SUPERVISOR'S DETAIL</strong></h5> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">NAME:</th>
                    <td><?= strtoupper($s->nama); ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">EMAIL:</th>
                    <td><?= $s->emel; ?></td> 
                </tr>

                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">POSITION:</th>
                    <td><?= $s->jawatan; ?></td> 
                </tr>

                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">DIVISION/FACULTY.:</th>
                    <td><?= $s->jabatan; ?></td> 
                </tr>

                


            </table>
        </div> 

    </div>
</div>
<?php if($model->pengajian->modeID == 1){?>
        
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
                            <strong>Agree student at the stated level?</strong><br>
                            <p style="color:green;"> <?php if($model->a1 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                                 } ?></p>

                        </td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                        <td style='white-space:pre-line;'><?= $model->ms_semester?> </td>
                        <td class="text-justify">
                            <strong>Was there any discussion to set the milestone?</strong><br>
                            <p style="color:green;"> <?php if($model->a2 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                             <?= $model->p_komen;?></p>
</td>

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                        <td><?= $model->ms_achieved?> </td>
                        <td class="text-justify">
                            <strong>Are you satisfied with the student’s achievement?</strong><br>
                            <p style="color:green;"> <?php if($model->a3 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                            <?= $model->k2;?></p>
                        </td>
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        State if you encountered any other problems in
                        relation to your research:</th>
                        <td><?= $model->research_problem?> </td>
                        <td class="text-justify">
                        <strong>Can the research problem be solved?</strong><br>
                         <p style="color:green;"><?php if($model->a4 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                        <?= $model->k3;?></p>
                        </td>                    
                  </tr>
                  
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        Have you discussed these problems with your
                        Advisor / Supervisory Committee?:</th>
                        <td><?= $model->discussed_problem; ?> </td>
                        <td class="text-justify">
                        <strong>Have you been informed of the problem faced?</strong><br>
                        <p style="color:green;"> <?php if($model->a5 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k4;?></p>
                        </td>  
                   </tr>
                   
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        State the number of discussions held with your
                        Advisor /Supervisory Commitee?:</th>
                        <td><?= $model->no_ofdiscuss; ?> times<small><br><b> <i style="color:red"> Latest Date of Discussions:</i>
                                <?php if($model->dt_sv)
                                {?><?= $model->dtsv; ?>
                                <?php } else {
                                    echo "No Record";
                                }
?>
                                    </b></small></td> 
                        <td class="text-justify">
                        <strong>Did the student really make an effort to discuss?</strong><br>
                        <p style="color:green;"> <?php if($model->a6 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k5;?></p>
                        </td>  

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         State any national/international seminar, workshop
                         or conference attended this semester:</th>
                        <td style='white-space:pre-line;'><?= $model->activity_sem; ?></td> 
                        <td class="text-justify">
                            <strong>Agree student attend the stated item(s)?</strong><br>
                         <p style="color:green;"><?php if($model->a7 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k6;?></p>
                        </td>
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        Publication(s) in this semester:</th>
                        <td style='white-space:pre-line;'><?= $model->publications; ?></td>
                        <td class="text-justify">
                        <strong>Agree student publish the stated item(s)?</strong><br>
                        <p style="color:green;"> <?php if($model->a8 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k7;?></p>
                    </td>
 
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion:</th>
                        <td><?= strtoupper($model->extime); ?></td> 
                        <td class="text-justify">
                            <strong>Agree student expected date of completion?  </strong><br>
                           <p style="color:green;">  <?php if($model->a9 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k8;?></p>
                        </td>
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         Research Report (Please describe achievements based on target set for this semester):
                        </th>
                        <td colspan='5' style='white-space:pre-line;'><?= $model->achievement_report; ?> 
                        </td>
                    </tr>
                </table>
                     
            </div> 
     
</div><?php }?>
            <?php if($model->pengajian->modeID == 3){?>
        <div class="x_panel">
        <div class="x_title">
            <h2><strong>STUDENT'S RESULT</strong></h2> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>COURSEWORK</center></th>
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">RESULT:</th>
                        <td><?= $model->result_cw?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                        <td><?= $model->cw_gpa?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                        <td><?= $model->cw_cgpa?> 
</td> 
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
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
                    
                   

                    

                     
                </table>
            </div> 

            
        </div>
        </div>
       <?php }?>
<?php if($model->pengajian->modeID == 2){?>
        <div class="x_panel">
        <div class="x_title">
            <h2><strong>STUDENT'S RESULT</strong></h2> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>COURSEWORK</center></th>
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">RESULT:</th>
                        <td><?= $model->result_cw?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                        <td><?= $model->cw_gpa?> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                        <td><?= $model->cw_cgpa?> 
</td> 
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
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
                            <strong>Agree student at the stated level?</strong><br>
                            <p style="color:green;"> <?php if($model->a1 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                                 } ?></p>

                        </td>

                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                        <td><?= $model->ms_semester?> </td>
                        <td class="text-justify">
                            <strong>Was there any discussion to set the milestone?</strong><br>
                            <p style="color:green;"> <?php if($model->a2 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                             <?= $model->p_komen;?></p>
</td>

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                        <td><?= $model->ms_achieved?> </td>
                        <td class="text-justify">
                            <strong>Are you satisfied with the student’s achievement?</strong><br>
                            <p style="color:green;"> <?php if($model->a3 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                            <?= $model->k2;?></p>
                        </td>
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        State if you encountered any other problems in
                        relation to your research:</th>
                        <td><?= $model->research_problem?> </td>
                        <td class="text-justify">
                        <strong>Can the research problem be solved?</strong><br>
                         <p style="color:green;"><?php if($model->a4 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                        <?= $model->k3;?></p>
                        </td>                    
                  </tr>
                  
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        Have you discussed these problems with your
                        Advisor / Supervisory Committee?:</th>
                        <td><?= $model->discussed_problem; ?> </td>
                        <td class="text-justify">
                        <strong>Have you been informed of the problem faced?</strong><br>
                        <p style="color:green;"> <?php if($model->a5 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k4;?></p>
                        </td>  
                   </tr>
                   
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        State the number of discussions held with your
                        Advisor /Supervisory Commitee?:</th>
                        <td><?= $model->no_ofdiscuss; ?> times<small><br><b> <i style="color:red"> Latest Date of Discussions:</i>
                                <?php if($model->dt_sv)
                                {?><?= $model->dtsv; ?>
                                <?php } else {
                                    echo "No Record";
                                }
?>
                                    </b></small></td> 
                        <td class="text-justify">
                        <strong>Did the student really make an effort to discuss?</strong><br>
                        <p style="color:green;"> <?php if($model->a6 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k5;?></p>
                        </td>  

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         State any national/international seminar, workshop
                         or conference attended this semester:</th>
                        <td style='white-space:pre-line;'><?= $model->activity_sem; ?></td> 
                        <td class="text-justify">
                            <strong>Agree student attend the stated item(s)?</strong><br>
                         <p style="color:green;"><?php if($model->a7 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k6;?></p>
                        </td>
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                        Publication(s) in this semester:</th>
                        <td><?= $model->publications; ?></td>
                        <td class="text-justify">
                        <strong>Agree student publish the stated item(s)?</strong><br>
                        <p style="color:green;"> <?php if($model->a8 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k7;?></p>
                    </td>
 
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion:</th>
                        <td><?= strtoupper($model->extime); ?></td> 
                        <td class="text-justify">
                            <strong>Agree student expected date of completion?  </strong><br>
                           <p style="color:green;">  <?php if($model->a9 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k8;?></p>
                        </td>
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         Research Report (Please describe achievements based on target set for this semester):
                        </th>
                        <td colspan='5' style='white-space:pre-line;'><?= $model->achievement_report; ?> 
                        </td>
                    </tr>
                </table>
                     
            </div> 
     
</div><?php }?>
<div class="x_panel">

        <div class="x_content" >
            <div class="x_title">
            <h5><strong><i class="fa fa-edit"></i> SUPERVISOR'S COMMENT AND RATING SUMMARY</strong></h5> 
                    <div class="clearfix"></div>
        </div>
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION:</th>
                        <td><?= $model->p_comment; ?></td>
                       
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">OVERALL PERFORMANCE:</th>
                        <td colspan="5">
                            <?php 
                      $c = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>5])->one();
                     $b = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>7])->one();
                     $a = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>6])->one();
                     $d = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>4])->one();
                     $e = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>3])->one();
                     $f = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>2])->one();
                      $g = \app\models\cbelajar\Rating::find()->where(['idLkk' => $model->reportID,'idKriteria'=>1])->one();
        $total = ($a->p_komen + $b->p_komen + $c->p_komen + $d->p_komen
                                  + $e->p_komen + $f->p_komen + $g->p_komen);                                
if($model->status_r =="DONE")
                                 {?>
                                    <strong style="color:red"><?= round(($total / 56) * 100) ;?>%
                                    </strong><br/>
                                    
                                     
                                    
                          <?php  }                                ?> </td>
                    
                    </tr>
                   
                    

                     
                </table>
            </div>   </div>  </div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $vieww;?>"> 
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
                        <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION [FOR STAFF]:</th>
                        <td> <?= $model->ulasan_jfpiu;?>  </td>

                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION [FOR BSM]:</th>
                        <td><?php if($model->ulasan_dekan){?> <?= $model->ulasan_dekan;?>
                            
                            <?php } else{ 
                                
                                echo 'No Comment';
                            }
?>  </td>

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
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                <th scope="col" colspan=12"  style="background-color:white;"><center>BSM VERIFICATION STATUS</center></th>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> VERIFICATION STATUS:</th>
                        <td> <?= $model->status_bsm;?></td>
</td> 
                    </tr>
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION:</th>
                        <td> <?= $model->catatan;?>  </td>

                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">VERIFICATION DATE:</th>
                        <td> <?= $model->ver_date;?></td>

                    </tr>
          
                </table>
            </div>  
        
       </div>  </div>
</div>     
</div>
<div class="x_panel">   <div class="x_content" >
        <div class="x_title">
   <h5 ><strong><i class="fa fa-check-square"></i> PERAKUAN </strong></h5>
   
   
   <div class="clearfix"></div>
</div> 
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead style="background-color:lightseagreen;color:white">
                    <th scope="col" colspan=12">
                    <center>PERAKUAN PEMOHON</center></th></thead>

                    <tr class="headings">

                    
                
                        <?php // $model->agree = 0; ?> 
              

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
  <!-- Perakuan Ketua Jabatan -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check"></i> BSM VERIFICATION STATUS</strong></h5>
            
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"> VERIFICATION STATUS<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_bsm')->label(false)->widget(Select2::classname(), [
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">COMMENT/RECOMMENDATION <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
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
   




