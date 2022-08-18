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

<p align="right">  <?= Html::a('Kembali Ke Senarai Laporan', ['lkk/senarailkk'], ['class' => 'btn btn-primary btn-sm']) ?></p>

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
            <td><small>STEP 1:<strong> PROGRESS REPORT</strong></small> </td>
            </tr>
            <tr>
                <td width="50px" height="20px"><center>2.</center></td> 
            <td><small>STEP 2: <strong>GOT SCHEDULE- COMPULSARY TO UPDATE THE GOT IN THE CURRENT SEMESTER TO 
                        PROCEED YOUR LKP SUBMISSION.  </strong></small></td>
            </tr>
            <tr>
                <td width="50px" height="20px"><center>3.</center></td> 
            <td><small>STEP 3: <strong>VERIFICATION - CHECK ALL THE FIELDS ARE FILLED IN CORRECTLY BEFORE VERIFY.  </strong></small></td>
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

        <b style="color:red">PLEASE FILL THE PROGRESS REPORT AND STUDENT ACHIEVEMENT PLAN. 
            DO CLICK THE BUTTON AS PREPARED:</b><br> 
    </div>

    <br>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 1</p><p>
                </p></li>
            <a href="gambar">
                <li style="#f2f2f2">
                    <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/lihat-permohonan?id=' . $model->reportID]) ?>
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
                <?php if ($model->pengajian->HighestEduLevelCd == 1) { ?>

                    <li style="#f2f2f2">
                        <p >
                            <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/achievement-phd?id=' . $model->reportID . '&icno=' . $icno]) ?></b>
                        </p></li>
                </a><?php } else { ?>


                <li style="#f2f2f2">
                    <p >
                        <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/achievement-master?id=' . $model->reportID . '&icno=' . $icno]) ?></b>
                    </p></li>                              
            <?php }
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
                    <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan?id=' . $model->reportID . '&icno=' . $icno])
            ?>
                        </b></p><p>



                    </p></li>
            </a>


        </ul>
    </div>
</div>

<div class="clearfix"></div>
<div class="x_panel">
    <?php if ($model->agree == 2) { ?>   <p align="right">
            <?= Html::a('Update Progress Report', ['lkk/borang-permohonan?id=' . $model->reportID], ['class' => 'btn btn-primary btn-sm']) ?></p><?php } ?>
     <?php if ($model->open == 2) { ?>   <p align="right">
            <?= Html::a('Update Progress Report', ['lkk/borang-permohonan?id=' . $model->reportID], ['class' => 'btn btn-primary btn-sm']) ?></p><?php } ?>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                <p align ="left"><i>Last Updated:</i><?= $model->tarikh_hantar ?></p>

                <th class="col-md-3 col-sm-3 col-xs-12">Semester:</th>
                <td><?= $model->semester; ?></td>
                <th class="col-md-3 col-sm-3 col-xs-12">Semester/Session:</th>
                <td><?= $model->semesterp; ?>/ (<?= $model->session; ?>)</td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Period:</th>
                    <td colspan="5">From <?= $model->report_fr; ?> To  <?= $model->report_to; ?> </td>

                </tr>




            </table>
        </div>   </div>  </div>



<div class="x_panel">
    <div class="x_title">
        <h2><strong>STUDENT'S DETAIL</strong></h2> 
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
                    <td><?= $model->pengajian->studentno; ?></td> 
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
                    <td>(From) <?= strtoupper($model->pengajian->tarikhmula); ?> (to)
                        <?= strtoupper($model->pengajian->tarikhtamat); ?> (at) 
                        <?php if ($model->pengajian->l) { ?>
                            <?= ucwords(strtoupper($model->pengajian->l->renewTempat)) ?>


                            <?php
                        } else {
                            ?>

                            <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>
                        <?php } ?>  </td> 
                </tr>

                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">FIELD OF STUDY:</th>
                    <td><?php
                        if (($model->pengajian->MajorCd == NULL) && ($model->pengajian->MajorMinor != NULL)) {
                            echo strtoupper($model->pengajian->MajorMinor);
                        } elseif (($model->pengajian->MajorCd != NULL) && ($model->pengajian->MajorMinor != NULL)) {
                            echo strtoupper($model->pengajian->MajorMinor);
                        } else {
                            echo strtoupper($model->pengajian->major->MajorMinor);
                        }
                        ?></td> 
                </tr>
<tr> 
                                
                          <th class="col-md-3 col-sm-3 col-xs-12">MODE OF STUDY</th>
                        <td>
                            
                                  <?php if($model->pengajian->modeID)
                                  {echo strtoupper($model->pengajian->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
<?php if($model->pengajian->modeID == 2){?>
<tr> 
                                
                          <th class="col-md-3 col-sm-3 col-xs-12">CURRENT MODE OF STUDY</th>
                        <td>
                            
                                  <?php if($model->modeID)
                                  {echo strtoupper($model->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr><?php }?>
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
                    <td><?= strtoupper($model->pengajian->tajuk_tesis) ?></td> 
                </tr>



            </table>
        </div> 

    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2><strong>SUPERVISOR'S DETAIL</strong></h2> 
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
<?php if($model->pengajian->modeID == 2)
{?>
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
                    <td><?= $model->result_cw; ?> 
                    </td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                    <td><?= $model->cw_gpa ?> 
                    </td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                    <td><?= $model->cw_cgpa ?> 
                    </td> 
                </tr>



                <tr class="headings">
                    <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
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




            </table>
        </div> 


    </div>
</div>

<?php if($model->pengajian->nama_penyelia != "Non")
{?>
<div class="x_panel">

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
                    <p style="color:green;"> <?php
                        if ($model->a1 == "1") {
                            echo "Yes";
                        } elseif ($model->a1 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?></p>

                </td>
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                <td><?= $model->ms_semester ?> 
                </td> 
                <td class="text-justify">
                    <strong>Was there any discussion to set the milestone?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a2 == "1") {
                            echo "Yes";
                        } elseif ($model->a2 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->p_komen; ?></p>
                </td>
            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                <td><?= $model->ms_achieved ?> </td> 
                <td class="text-justify">
                    <strong>Are you satisfied with the student’s achievement?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a3 == "1") {
                            echo "Yes";
                        } elseif ($model->a3 == "w") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k2; ?></p>
                </td>

            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">State if you encountered any other problems in
                    relation to your research
                    :</th>
                <td><?= $model->research_problem ?> </td>
                <td class="text-justify">
                    <strong>Can the research problem be solved?</strong><br>
                    <p style="color:green;"><?php
                        if ($model->a4 == "1") {
                            echo "Yes";
                        } elseif ($model->a4 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k3; ?></p>
                </td> 
            </tr><tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  Have you discussed these problems with your
                    Advisor / Supervisory Committee?
                    :</th>
                <td><?= $model->discussed_problem; ?> 
                </td> <td class="text-justify">
                    <strong>Have you been informed of the problem faced?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a5 == "1") {
                            echo "Yes";
                        } elseif ($model->a5 == 2) {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k4; ?></p>
                </td>
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  State the number of discussions held with your
                    Advisor /Supervisory Commitee?

                    :</th>
                <td><?= $model->no_ofdiscuss; ?> times<small><br><b> <i style="color:red"> Latest Date of Discussions:</i>
                            <?php if ($model->dt_sv) {
                                ?><?= $model->dtsv; ?>
                                <?php
                            } else {
                                echo "No Record";
                            }
                            ?>
                        </b></small></td> 
                <td class="text-justify">
                    <strong>Did the student really make an effort to discuss?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a6 == "1") {
                            echo "Yes";
                        } elseif ($model->a6 == 2) {
                            echo "NO";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k5; ?></p>
                </td>
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  State any national/international seminar, workshop
                    or conference attended this semester:
                </th>
                <td><?= $model->activity_sem; ?> 

                </td> 
                <td class="text-justify">
                    <strong>Agree student attend the stated item(s)?</strong><br>
                    <p style="color:green;"><?php
                        if ($model->a7 == "1") {
                            echo "Yes";
                        } elseif ($model->a7 == 2) {
                            echo 'No';
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k6; ?></p>
                </td>
            </tr>


            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  Publication(s) in this semester:

                </th>
                <td><?= $model->publications; ?> 

                </td>
                <td class="text-justify">
                    <strong>Agree student publish the stated item(s)?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a8 == "1") {
                            echo "Yes";
                        } elseif ($model->a8 == 2) {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k7; ?></p>
                </td>

            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion::

                </th>
                <td><?php
                    if (!$model->completion_date) {
                        echo "-";
                    } else {
                        ?>
                        <?= $model->completion_date; ?> 
                    <?php }
                    ?>


                </td> 
                <td class="text-justify">
                    <strong>Agree student expected date of completion?  </strong><br>
                    <p style="color:green;">  <?php
                        if ($model->a9 == "1") {
                            echo "Yes";
                        } elseif ($model->a9 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k8; ?></p>
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
</div>
<?php }
 else {?>
     <div class="x_panel">

    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr>
                <th colspan='5'><center>RESEARCH PROGRESS</center></th>
            </tr>
            <tr>
                <th ><center>DESCRIPTION</center></th>
            <th ><center>COMPLETED BY STUDENT</center></th>


            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Stage of Research:</th>
                <td>

                    <?php $model->research ?>
                </td>
                
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                <td><?= $model->ms_semester ?> 
                </td> 
                
            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                <td><?= $model->ms_achieved ?> </td> 
               

            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">State if you encountered any other problems in
                    relation to your research
                    :</th>
                <td><?= $model->research_problem ?> </td>
                
            </tr><tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  Have you discussed these problems with your
                    Advisor / Supervisory Committee?
                    :</th>
                <td><?= $model->discussed_problem; ?> 
                </td> 
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  State the number of discussions held with your
                    Advisor /Supervisory Commitee?

                    :</th>
                <td><?= $model->no_ofdiscuss; ?> times<small><br><b> <i style="color:red"> Latest Date of Discussions:</i>
                            <?php if ($model->dt_sv) {
                                ?><?= $model->dtsv; ?>
                                <?php
                            } else {
                                echo "No Record";
                            }
                            ?>
                        </b></small></td> 
                
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  State any national/international seminar, workshop
                    or conference attended this semester:
                </th>
                <td><?= $model->activity_sem; ?> 

                </td> 
               
            </tr>


            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  Publication(s) in this semester:

                </th>
                <td><?= $model->publications; ?> 

                </td>
                
            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion::

                </th>
                <td><?php
                    if (!$model->completion_date) {
                        echo "-";
                    } else {
                        ?>
                        <?= $model->completion_date; ?> 
                    <?php }
                    ?>


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
</div>
  <?php                      
}}?>

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
                    <td><?= $model->result_cw; ?> 
                    </td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">GPA:</th>
                    <td><?= $model->cw_gpa ?> 
                    </td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">CGPA:</th>
                    <td><?= $model->cw_cgpa ?> 
                    </td> 
                </tr>



                <tr class="headings">
                    <th class="col-md-3 col-sm-3 col-xs-12">EXAMINATION TRANSCRIPT:</th>
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




            </table>
        </div> 


    </div>
</div><?php }?>

<?php if($model->pengajian->modeID == 1){?>


<div class="x_panel">

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
                    <p style="color:green;"> <?php
                        if ($model->a1 == "1") {
                            echo "Yes";
                        } elseif ($model->a1 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?></p>

                </td>
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) set for the current semester:</th>
                <td><?= $model->ms_semester ?> 
                </td> 
                <td class="text-justify">
                    <strong>Was there any discussion to set the milestone?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a2 == "1") {
                            echo "Yes";
                        } elseif ($model->a2 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->p_komen; ?></p>
                </td>
            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                <td><?= $model->ms_achieved ?> </td> 
                <td class="text-justify">
                    <strong>Are you satisfied with the student’s achievement?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a3 == "1") {
                            echo "Yes";
                        } elseif ($model->a3 == "w") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k2; ?></p>
                </td>

            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">State if you encountered any other problems in
                    relation to your research
                    :</th>
                <td><?= $model->research_problem ?> </td>
                <td class="text-justify">
                    <strong>Can the research problem be solved?</strong><br>
                    <p style="color:green;"><?php
                        if ($model->a4 == "1") {
                            echo "Yes";
                        } elseif ($model->a4 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k3; ?></p>
                </td> 
            </tr><tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  Have you discussed these problems with your
                    Advisor / Supervisory Committee?
                    :</th>
                <td><?= $model->discussed_problem; ?> 
                </td> <td class="text-justify">
                    <strong>Have you been informed of the problem faced?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a5 == "1") {
                            echo "Yes";
                        } elseif ($model->a5 == 2) {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k4; ?></p>
                </td>
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  State the number of discussions held with your
                    Advisor /Supervisory Commitee?

                    :</th>
                <td><?= $model->no_ofdiscuss; ?> times<small><br><b> <i style="color:red"> Latest Date of Discussions:</i>
                            <?php if ($model->dt_sv) {
                                ?><?= $model->dtsv; ?>
                                <?php
                            } else {
                                echo "No Record";
                            }
                            ?>
                        </b></small></td> 
                <td class="text-justify">
                    <strong>Did the student really make an effort to discuss?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a6 == "1") {
                            echo "Yes";
                        } elseif ($model->a6 == 2) {
                            echo "NO";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k5; ?></p>
                </td>
            </tr>
            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  State any national/international seminar, workshop
                    or conference attended this semester:
                </th>
                <td><?= $model->activity_sem; ?> 

                </td> 
                <td class="text-justify">
                    <strong>Agree student attend the stated item(s)?</strong><br>
                    <p style="color:green;"><?php
                        if ($model->a7 == "1") {
                            echo "Yes";
                        } elseif ($model->a7 == 2) {
                            echo 'No';
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k6; ?></p>
                </td>
            </tr>


            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">  Publication(s) in this semester:

                </th>
                <td><?= $model->publications; ?> 

                </td>
                <td class="text-justify">
                    <strong>Agree student publish the stated item(s)?</strong><br>
                    <p style="color:green;"> <?php
                        if ($model->a8 == "1") {
                            echo "Yes";
                        } elseif ($model->a8 == 2) {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k7; ?></p>
                </td>

            </tr>

            <tr>
                <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion::

                </th>
                <td><?php
                    if (!$model->completion_date) {
                        echo "-";
                    } else {
                        ?>
                        <?= $model->completion_date; ?> 
                    <?php }
                    ?>


                </td> 
                <td class="text-justify">
                    <strong>Agree student expected date of completion?  </strong><br>
                    <p style="color:green;">  <?php
                        if ($model->a9 == "1") {
                            echo "Yes";
                        } elseif ($model->a9 == "2") {
                            echo "No";
                        } else {
                            echo " ";
                        }
                        ?>&nbsp;
                        <?= $model->k8; ?></p>
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
</div><?php }?>
<?php if($model->pengajian->modeID == 5){?>
<div class="x_panel">
    <div class="x_title">
        <h2><strong>STUDENT'S REPORT</strong></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th colspan='5'><center>WRITING REPORT</center></th>
                </tr>
                  



                <tr class="headings">
                    <th class="col-md-3 col-sm-3 col-xs-12">CURRENT SEMESTER REPORT:</th>
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




            </table>
        </div> 


    </div>
</div><?php }?>
<?php ActiveForm::end(); ?>
   




