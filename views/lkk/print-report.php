<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" media="print" href="bootstrap.css" />
<?php
use yii\helpers\Html; 


use yii\helpers\Url; 

error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 
     
     
     
     <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
                        </div>
                    </div>
      </div>

       <div class="x_panel">
        <div class="x_content"> 
      
              <p align="center"><strong>UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA</strong></p> 
              <p align="center"><strong><u>LAPORAN KEMAJUAN PENGAJIAN | <i>STUDENT PROGRESS REPORT</i></u></strong></p> 
             
        </div>
    </div>
   
<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> SEMESTER DETAILS<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
            
          
            <tr>
            <td width="20%"><strong><font size="2">SEMESTER (AUTO SET):</font></strong></td>
            <td><font size="2"> <?= $model->semester ?></font>
            <td width="15%"><strong><font size="2">SESSION:</font></strong></td>
            <td><font size="2"><?= $model->semesterp?> / <?= $model->session ?></font></td>
            
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">PERIOD:</font></strong></td>
            <td colspan="3"><font size="2">                            
                            From <?= $model->report_fr; ?> To  <?= $model->report_to; ?> </td>
            </tr>
               
           
</table>

            </div>

<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> STUDENT'S DETAILS<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
            <tr>
          
            <td width="35%"><font size="2"><strong>FULL NAME:</font></strong></td>
            <td><font size="2"><?= ucwords(strtoupper($model->kakitangan->CONm)); ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">NO. KP:</font></strong></td>
            <td><font size="2"><?= $model->kakitangan->ICNO; ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">UMSPER:</font></strong></td>
            <td><font size="2"><?= $model->kakitangan->COOldID; ?></font></td>
            </tr>
            <tr>
            <td width="35%"><strong><font size="2">STUDENT NUMBER:</font></strong></td>
            <td><font size="2"><?= $model->pengajian->studentno; ?></font></td>
            </tr>
            
             <tr>
            <td width="35%"><strong><font size="2">LEVEL OF STUDY:</font></strong></td>
            <td><font size="2"> <?php if($model->pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($model->pengajian->tahapPendidikan);
                                         
                                }
                                
                              
                                ?> </font></td>
            </tr>
           
            
            <tr>
            <td width="35%"><strong><font size="2">PERIOD AND PLACED OF STUDY APPROVED:</font></strong></td>
            <td><font size="2">(FROM) <?= strtoupper($model->pengajian->tarikhmula); ?> (TO) <?= strtoupper($model->pengajian->tarikhtamat); ?> (<?= strtoupper($model->pengajian->tempohpengajian);?>) (AT) 
              <?= ucwords(strtoupper($model->pengajian->InstNm)) ?></font>  </td> 
            </tr>
            
             <tr>
            <td width="35%"><strong><font size="2">FIELD OF STUDY :</font></strong></td>
            <td><font size="2"> <?php
                        
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
?></font></td>
            </tr>
                
            <tr>
            <td width="35%"><strong><font size="2">SUPERVISOR NAME:</font></strong></td>
            <td><font size="2"><?= strtoupper($model->pengajian->nama_penyelia) ?></font></td>
            </tr>
            <tr>
            <td width="35%"><strong><font size="2">SUPERVISOR EMAIL:</font></strong></td>
            <td><font size="2"><?= ($model->pengajian->emel_penyelia) ?></font></td>
            </tr>
            <tr>
            <td width="35%"><strong><font size="2">THESIS TITLE:</font></strong></td>
            <td><font size="2"><?= strtoupper($model->pengajian->tajuk_tesis) ?></font></td>
            </tr>
            
            
</table>

            </div>
<div class="x_panel">
    <div class="x_title">
   <h6><strong><i class="fa fa-th-list"></i> EXTENSION DETAILS</strong></h6>
   
   <hr>
</div>
<div>
<form id="w0" class="form-horizontal form-label-left" action="">
<table class="table table-sm table-bordered">
       
        <tr class="headings">
           <th width="50px" height="20px"><font size="2">BIL</th>
            <th ><font size="2">
DATE OF EXTENSION OF STUDY LEAVE </th>
            <th><font size="2">DURATION </th>
            <th><font size="2">EXTENSION TIME TO</th>
            <th><font size="2">JUSTIFICATION</th>

        </tr>
        
        
        

    <tbody>
        
         <?php
         
                 if($b->lanjut){ ?>
        <?php $bil=1; foreach ($b->lanjut as $l) { ?>
<tr>
<td class="text-center"><font size="2"><?= $bil++ ?></td>
<td><font size="2"> <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?></td>
<td class="text-center">
<font size="2">
<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?></td>

<td class="text-center"><font size="2"><?= $l->idlanjutan; ?></td>

<td class="text-center"><font size="2"><?= $l->justifikasi; ?></td>

            
</tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><font size="2"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        
        



 </table>
</form>           </div>
</div>  
<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> STUDENT'S RESULT<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
     <tr>
         <th colspan='6'><center><font size="2">COURSEWORK</font></center></th>
                    </tr>
            <tr>
          
            <td width="35%"><font size="2"><strong>GPA:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->cw_gpa?> </font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">CGPA:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->cw_cgpa?> </font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">EXAMINATION SCRIPT:</font></strong></td>
            <td colspan='5'><font size="2"> <?php
                                    if ($model->dokumen_sokongan) { ?>
                              <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                        href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download Document </u></small></strong></a><br>
                                  
                                    <?php } else {
                                        echo '<i>No Data</i>'.'<br>';
                                    } ?></font></td>
            </tr>
            
            
            
</table>

            </div>
&nbsp;<br><br><br><br><br>
<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> SUPERVISOR COMMENT<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
     <tr>
         <th colspan='6'><center><font size="2">RESEARCH PROGRESS</font></center></th>
                    </tr>
                     <tr>
                         <th ><font size="2"><center>DESCRIPTION</center></th>
                         <th ><font size="2"><center>COMPLETED BY STUDENT</center></th>
                         <th width="40%"><font size="2"><center>ADVISOR/SUPERVISOR'S COMMENT</center></th>

                        
                    </tr>
          
            
            <tr>
          
            <td width="35%"><font size="2"><strong>Stage of Research:</font></strong></td>
            <td><font size="2"><?php $model->research ?> </font></td>
            <td>
                <strong><font size='2'>Agree student at the stated level?</strong><br>
                            <font size='2'><p style="color:green;"> <?php if($model->a1 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                                 } ?></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Milestone(s) set for the current semester:</font></strong></td>
            <td ><font size="2">                                  <?= $model->ms_semester?>
 </font></td>
            <td>
                <strong><font size='2'>Was there any discussion to set the milestone?</strong><br>
                            <font size='2'><p style="color:green;"> <?php if($model->a2 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                             <?= $model->p_komen;?></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Milestone(s) achieved? :</font></strong></td>
            <td ><font size="2">                                <?= $model->ms_achieved?> 
 </font></td>
            <td>
                <strong><font size='2'>Are you satisfied with the student’s achievement?</strong><br>
                            <font size='2'>  <p style="color:green;"> <?php if($model->a3 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                            <?= $model->k2;?></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">State if you encountered any other problems in
                        relation to your research:</font></strong></td>
            <td ><font size="2">                              <?= $model->research_problem?>
 </font></td>
            <td>
                <strong><font size='2'>Can the research problem be solved?</strong><br>
                            <font size='2'>  <p style="color:green;"><?php if($model->a4 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                        <?= $model->k3;?></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2"> Have you discussed these problems with your
                        Advisor / Supervisory Committee?:</font></strong></td>
            <td ><font size="2">                             <?= $model->discussed_problem; ?>
 </font></td>
            <td>
                <strong><font size='2'>Have you been informed of the problem faced?</strong><br>
                            <font size='2'>  <p style="color:green;"><?php if($model->a5 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k4;?></p></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">State the number of discussions held with your
                        Advisor /Supervisory Commitee?:</font></strong></td>
            <td ><font size="2">                             <?= $model->no_ofdiscuss; ?> times<small><br><b> <i style="color:red"> Latest Date of Discussions:</i>
                                <?php if($model->dt_sv)
                                {?><?= $model->dtsv; ?>
                                <?php } else {
                                    echo "No Record";
                                }
?>
 </font></td>
            <td>
                <strong><font size='2'>Did the student really make an effort to discuss?</strong><br>
                            <font size='2'>  <p style="color:green;"><?php if($model->a6 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k5;?>
                  </p></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">State any national/international seminar, workshop
                         or conference attended this semester:</font></strong></td>
            <td ><font size="2">                           <?= $model->activity_sem; ?>
 </font></td>
            <td>
                <strong><font size='2'>Agree student attend the stated item(s)?</strong><br>
                            <font size='2'>  <p style="color:green;"><?php if($model->a7 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k6;?>
                  </p></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Publication(s) in this semester:</font></strong></td>
            <td ><font size="2">                          <?= $model->publications; ?>
 </font></td>
            <td>
                <strong><font size='2'>Agree student publish the stated item(s)?</strong><br>
                            <font size='2'>  <p style="color:green;"><?php if($model->a8 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k7;?>
                  </p></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">Expected date of completion:</font></strong></td>
            <td ><font size="2">                        <?= strtoupper($model->extime); ?>
 </font></td>
            <td>
                <strong><font size='2'>Agree student expected date of completion?</strong><br>
                            <font size='2'>  <p style="color:green;"><?php if($model->a9 == "1"){
                                 echo "Yes";
                                 
                             } else{
                                 echo " ";
                             } ?>
                    <?= $model->k8;?>
                  </p></p>

                        </td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2"> Research Report (Please describe achievements based on target set for this semester):</font></strong></td>
            <td colspan="5" ><font size="2">   <?= $model->achievement_report; ?>                   
 </font></td>
            
            </tr>
            <tr>
            <td width="35%"><strong><font size="2"> Submission Date:</font></strong></td>
            <td colspan="5" ><font size="2">   <?= $model->tarikh_hantar; ?>                   
 </font></td>
            
            </tr>
            
            
            
</table>

            </div>
<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> SUPERVISOR'S COMMENT AND RATING SUMMARY<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
    
            <tr>
          
            <td width="35%"><font size="2"><strong>COMMENT/RECOMMENDATION:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->p_comment; ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><strong><font size="2">OVERALL PERFORMANCE:</font></strong></td>
            <td  colspan='5'><font size="2"><?php 
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
                                    
                                     
                                    
                          <?php  }                                ?></font></td>
            </tr>
            
            <tr>
            <td width="35%"><font size="2"><strong>VERIFICATION DATE:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->r_dt;?></font></td>
            </tr>
            
            
</table>

            </div>

<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> DEAN/DIRECTOR'S VERIFICATION STATUS<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
    
            <tr>
          
            <td width="35%"><font size="2"><strong>VERIFICATION STATUS:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->status_jfpiu;?></font></td>
            </tr>
            
             <tr>
          
            <td width="35%"><font size="2"><strong>COMMENT/RECOMMENDATION:</font></strong></td>
            <td  colspan='5'><font size="2"> <?= $model->ulasan_jfpiu;?></font></td>
            </tr>
            <tr>
            <td width="35%"><font size="2"><strong>VERIFICATION DATE:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->verify_dt;?></font></td>
            </tr>
            
            
            
            
            
            
</table>

            </div>

<div class="x_panel">
            
            <div class="x_title">
                <h6><strong><i class="fa fa-user"></i> BSM REVIEW STATUS<hr></strong></h6>
           
            </div>
<table class="table table-sm table-bordered">
    
            <tr>
          
            <td width="35%"><font size="2"><strong>BSM STATUS:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->status_bsm;?></font></td>
            </tr>
            
             <tr>
          
            <td width="35%"><font size="2"><strong>COMMENT/RECOMMENDATION:</font></strong></td>
            <td  colspan='5'><font size="2"> <?= $model->catatan;?></font></td>
            </tr>
            <tr>
            <td width="35%"><font size="2"><strong>VERIFICATION DATE:</font></strong></td>
            <td  colspan='5'><font size="2"><?= $model->ver_date;?></font></td>
            </tr>
            
            
            
            
            
            
</table>

            </div>

     <p align="right"><font size="2">   <?php echo "[DATE OF PRINT:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
