<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url; 

$this->title = 'Permohonan Cuti Belajar'; 
error_reporting(0);
?> 
<?php echo $this->render('/cutibelajar/_topmenu');?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
 <p align="right"><?= Html::a('Kembali', ['lkk/senaraitindakan'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
      UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PROGRESS REPORT
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
<div class="x_panel">

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
            <h5><strong><i class="fa fa-th-list"></i> STUDENT'S DETAIL</strong></h5> 
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
                        <td><?= $model->studentno;?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">IC NO.:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">LEVEL OF STUDY:</th>
                        <td><?php if($p->tahapPendidikan)
                                {
                                 echo strtoupper($p->tahapPendidikan);
                                }
                   ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACE OF STUDY APPROVED:</th>
                        <td>(FROM) <?= strtoupper($p->tarikhmula); ?> (TO) <?= strtoupper($p->tarikhtamat); ?> (at)  <?= ucwords(strtoupper($p->InstNm)) ?>  </td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FIELD OF STUDY:</th>
                        <td><?php
                        
                        if(($p->MajorCd == NULL) && ($p->MajorMinor != NULL))
                        {
                                echo  strtoupper($p->MajorMinor);
                        }
                        elseif (($p->MajorCd != NULL) && ($p->MajorMinor != NULL))  {
                            echo   strtoupper($p->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($p->major->MajorMinor);
                        }
?></td> 
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAME OF SUPERVISOR:</th>
                        <td><?= strtoupper($model->sv_name) ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">THESIS TITLE:</th>
                        <td><?= strtoupper($model->thesis_title)?></td> 
                    </tr>
                    

                     
                </table>
            </div> 

        </div>
        </div>

        <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-sticky-note-o"></i> STUDENT'S RESULT</strong></h5> 
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

<div class="x_panel">
<div class="x_title">
            <h5><strong><i class="fa fa-bar-chart"></i> RESEARCH PROGRESS</strong></h5> 
                    <div class="clearfix"></div>
        </div>
                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    
                   
                     <tr>
                         <th colspan='5'><center>RESEARCH PROGRESS</center></th>
                    </tr>
 <tr>
                         <th width="40%" ><center>DESCRIPTION</center></th>
                         <th width="30%"  ><center>COMPLETED BY STUDENT</center></th>
                         <th width="30%" ><center>ADVISOR/SUPERVISOR'S COMMENT</center></th>

                        
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            MILESTONE(S) SET FOR THE CURRENT SEMESTER:</th>
                        <td><?= $model->ms_semester?> 
                        <td><?= $model->p_komen?> 

</td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">MILESTONE(S) ACHIEVED? :</th>
                        <td><?= $model->ms_achieved?> </td>
                        <td><?= $model->p_komen?> </td> 

                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            STATE IF YOU ENCOUNTERED ANY OTHER PROBLEMS IN 
                            RELATION TO YOUR RESEARCH:</th>
                        <td><?= $model->research_problem?> </td>
                        <td><?= $model->p_komen?> 
</td> 
                    </tr><tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            HAVE YOU DISCUSSED THESE PROBLEMS
                            WITH YOUR ADVISOR/SUPERVISORY COMMITTEE?
                           
:</th>
                        <td><?= $model->discussed_problem; ?> </td>
                         <td><?= $model->p_komen?> 

</td> 
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12"> 
                            STATE THE NUMBER OF DISCUSSIONS HELD WITH YOUR 
                            ADVISOR/SUPERVISORT COMMITTEE?
                            

:</th>
                        <td><?= $model->no_ofdiscuss; ?> 
                            
                        </td> 
                                              <td><?= $model->p_komen?> 

</td> 
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  
                          STATE ANY NATIONAL/INTERNATIONAL SEMINAR,
                          WORKSHOP, OR CONFERENCE ATTENDED THIS SEMESTER:
                           
</th>
                        <td><?= $model->activity_sem; ?> 
                            
                        </td> 
                                              <td><?= $model->p_komen?> 

</td> 
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            PUBLICATIONS(S) IN THIS SEMESTER:

</th>
                        <td><?= $model->publications; ?> 
                            
                        </td>
                                              <td><?= $model->p_komen?> 

</td> 
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            EXPECTED DATE OF COMPLETION:

</th>
                        <td><?= $model->completion_date; ?> 
                        </td> 
                                              <td><?= $model->p_komen?> 

</td> 
                    </tr>
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            RESEARCH REPORT <br>
                            <small>Please describe achievements based on 
                            target set for this semester:</small>
                           


</th>
                        <td colspan='5'><?= $model->achievement_report; ?> 
                            
                        </td>
                        
                    </tr>
                      <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                            SUPERVISOR'S REVIEW:</th>
                        <td class="text-justify" colspan="2"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                     href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download Document </u></small></strong></a><br>
                        

                        
                    </tr>
                    
                     
                </table>
            </div> 
            </div>
<div class="x_panel">

          <div class="x_title">
                    
              
                    <h5> <strong><center>TO BE COMPLETED BY DEAN/DIRECTOR (EMPLOYER)</center></strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>    <div class="x_content ">
                 <div class="table-responsive">
                                         <h2> <span class="label label-info">MASTER'S CANDIDATE</span> |  <span class="label label-success">SEMESTER 1</span></h2>

                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white" >
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">BIL</th>
                                    <th class="text-center" rowspan="2">ACTIVITY</th>
                                    <th class="text-center" colspan="2">ACTION</th>
                                    <th class="text-center" rowspan="2">COMMENT</th>

                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">YES</th>
                                    <th class="column-title text-center">NO</th>
                                </tr>
                                    
                            </thead>
                         <?php
                            if ($sem) 
                            { $no=0;?>
                            
                                <?php foreach ($sem as $dok) { $no++; 
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['idsem' => $kpi->id, 'icno' => $icno])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->activity; ?></td>
                                    <td class="text-center"><?php if($mod->result === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->result === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
              }          ?>
                        </table>
                    </div>   <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Semakan', ['/cutibelajar/generate-semakan-syarat-doktoral', 'id' =>$kontrak->reportID, 'ICNO'=>$kontrak->icno, 'takwim_id'=>$kontrak->iklan_id], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    //'data-toggle'=>'tooltip', 
                    //'title'=>'Will open the generated PDF file in a new window'
                ]);
                ?>
              </div>     </div></div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                <div class="x_title">
<!--                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>-->
<h5> <strong><i class="fa fa-check"></i> TO BE COMPLETED BY DEAN/DIRECTOR (EMPLOYER)</center></strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                
                 <div class="form-group" align="text-center">
                    <h2> <span class="label label-info">MASTER'S CANDIDATE</span> |  <span class="label label-success">SEMESTER 1</span></h2>

             
                <div class="x_content ">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">BIL</th>
                                    <th class="text-center" rowspan="2">ACTIVITY</th>
                                    <th class="text-center" colspan="2">ACTION</th>
                                    <th class="text-center" rowspan="2">COMMENT</th>

                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">YES</th>
                                    <th class="column-title text-center">NO</th>
                                </tr>
                                    
                            </thead>
                            <?php
                            if ($sem) 
                            { $no=0;?>
                            
                                <?php foreach ($sem as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['id' => $kpi->id, 'icno' => $icno])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->activity; ?></td>
                                    <td class="text-center"><input type="radio" name="<?=$kpi->id.'result'?>" value="y" <?php if($mod->result){if($mod->result === 'y'){echo "checked";}}?>></td>
                                    <td class="text-center"><input type="radio" name="<?=$kpi->id.'result'?>" value="n" <?php if($mod->result){if($mod->result === 'n'){echo "checked";}}?>></td>
                                    <td class="text-justify"><textarea id="komen" class="form-control" name="<?= $mod->id?>"><?= $mod->comment?></textarea></td> 

                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">COMMENTS/RECOMMENDATIONS:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($kontrak, 'jfpiu')->textArea(['maxlength' => true, 'rows' => 10])->label(false); ?>
                </div>
            </div>
                        <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <center><?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;SUBMIT' ,['class' => 'btn btn-primary btn-sm', 'name' => 'hantar']) ?>
                            <a style="color: green; font-weight: bold"><?php echo $message;?></a>


        
                    </div>
                </div>
                    </div>
            
            </div>
           
            </div>
        </div>
</div>
</div>



<?php ActiveForm::end(); ?>

  



