<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use app\models\kemudahan\Reftujuan; 
use app\models\cbelajar\TblPrestasi;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Department;
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */
$this->title = 'Permohonan Cuti Belajar'; 
?> 

  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div>
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
 <p align="right"><?= Html::a('Back', ['cutibelajar/senarai-staff-fakulti-pp'], 
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
        
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 1</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/tindakan-pp?i='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div>
      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 2</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('SUPERVISOR RATING', ['cb-lkk/pp-view-rating?i='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 3 </p><p>
            </p></li> 
            <a href="pengajian-tinggi">
                                <?php if($model->pengajian->HighestEduLevelCd == 1){ ?>

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/p-achievement-phd?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>
                                </a><?php } else{?>
                                    

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/p-achievement-master?i='.$model->reportID.'&id='.$model->icno ]) ?></b>
            </p></li>                              
                            <?php    }
?>
           
        </ul>
    </div>
     <?php if(Department::find()->where([ 'pp' => Yii::$app->user->getId()])->exists())
     {?>
     <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 4</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan-pp?id='.$model->reportID.'&icno='.$model->icno]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div><?php }?>
        </div>
 
 

 <div class="x_panel">
<div class="x_title">
           <strong><i class="fa fa-th-list"></i> SEMESTER DETAILS</strong> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMESTER:</th>
                        <td><?= $model->semester; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12">SESSION:</th>
                        <td><?= $model->session; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD:</th>
                        <td colspan="5">FROM <?= $model->report_fr; ?> TO  <?= $model->report_to; ?> </td>
                    
                    </tr>
                   
                    

                     
                </table>
            </div>   </div>  </div>
   
      

      <div class="x_panel">
        <div class="x_title">
            <strong><i class="fa fa-user-o"></i> STUDENT DETAILS</strong> 
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
                        <td><?php if($b->tahapPendidikan)
                                {
                                 echo strtoupper($b->tahapPendidikan);
                                }
                   ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACE OF STUDY APPROVED:</th>
                        <td>(FROM) <?= strtoupper($b->tarikhmula); ?> (TO) <?= strtoupper($b->tarikhtamat); ?> (AT) 
                       <?= ucwords(strtoupper($b->InstNm)) ?>  </td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FIELD OF STUDY:</th>
                        <td><?php
                        
                        if(($b->MajorCd == NULL) && ($b->MajorMinor != NULL))
                        {
                                echo  strtoupper($b->MajorMinor);
                        }
                        elseif (($b->MajorCd != NULL) && ($b->MajorMinor != NULL))  {
                            echo   strtoupper($b->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($b->major->MajorMinor);
                        }
?></td> 
                    </tr>
                    <?php 
                         foreach($b->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th class="col-md-3 col-sm-3 col-xs-12">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td>

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?> (<?= strtoupper($l->tempohlanjutan);?>)</td>
                         </tr><?php }?>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td><?= strtoupper($model->pengajian->nama_penyelia) ?></td> 
                    </tr> 
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SUPERVISOR EMAIL:</th>
                        <td><?= ($model->pengajian->emel_penyelia) ?></td> 
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
            <strong><i class="fa fa-bar-chart-o"></i> STUDENT RESULT</strong> 
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
                                 echo $model->a1;
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
                                 echo $model->a2;
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
                                 echo $model->a3;
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
                                 echo $model->a4;
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
                                 echo $model->a5;
                             } ?>
                    <?= $model->k4;?></p>
                        </td>  
                   </tr>
                   
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                        State the number of discussions held with your
                        Advisor /Supervisory Commitee?:</th>
                        <td><?= $model->no_ofdiscuss; ?> times<small><br> <i> Latest Date of Discussions:</i>
                                <b><?php if($model->dt_sv)
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
                                 echo $model->a6;
                             } ?>
                    <?= $model->k5;?></p>
                        </td>  

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         State any national/international seminar, workshop
                         or conference attended this semester:</th>
                        <td><?= $model->activity_sem; ?></td> 
                        <td class="text-justify">
                            <strong>Agree student attend the stated item(s)?</strong><br>
                         <p style="color:green;"><?php if($model->a7 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo $model->a7;
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
                                 echo $model->a8;
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
                                 echo $model->a9;
                             } ?>
                    <?= $model->k8;?></p>
                        </td>
                    </tr>
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                         Research Report (Please describe achievements based on target set for this semester):
                        </th>
                        <td colspan='5'><?= $model->achievement_report; ?> 
                        </td>
                    </tr>
                </table>
                     
            </div> 
     
 </div>
        
<p align="right"> 
    
  
    
    <?= Html::a('Next', ['cb-lkk/pp-view-rating?i='.$model->reportID], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>


     <?php ActiveForm::end(); ?>
   




