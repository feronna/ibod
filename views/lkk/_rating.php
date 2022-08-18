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
 <p align="right"><?= Html::a('Kembali', ['lkk/senaraitindakan'], 
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
S        <div class="x_panel">

                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>RESEARCH PROGRESS</center></th>
                    </tr>
                    <tr>
                         <th ><center>DESCRIPTION</center></th>
                         <th ><center>COMPLETED BY STUDENT</center></th>
                         <th><center>ADVISOR/SUPERVISOR'S COMMENT</center></th>

                        
                    </tr>
  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Stage of Research:</th>
                        <td>
                             
                                    <?php $model->research ?>
                                 </td>
                        
                        <td class="text-justify">
                            <strong>Agree student at the stated level?</strong>
<?php
            echo $form->field($model,'p_komen')->
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
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>

                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Milestone(s) achieved? :</th>
                        <td><?= $model->ms_achieved?> </td>
                        
<td class="text-justify">
                            <strong>Are you satisfied with the student’s achievement?</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Reason(s).." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>
                    </tr>
                    
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">State if you encountered any other problems in
relation to your research
:</th>
                        <td><?= $model->research_problem?> </td>
<td class="text-justify">
                            <strong>Can the research problem be solved?
</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>                    </tr><tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  Have you discussed these problems with your
Advisor / Supervisory Committee?
:</th>
                        <td><?= $model->discussed_problem; ?> </td>
                        
                        <td class="text-justify">
                            <strong>Have you been informed of the problem faced?

</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>  

 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  State the number of discussions held with your
Advisor /Supervisory Commitee?

:</th>
                        <td><?= $model->no_ofdiscuss; ?> times
                            
                        </td> 
                        
<td class="text-justify">
                            <strong>Did the student really make an effort to discuss?


</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>  

                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  State any national/international seminar, workshop
or conference attended this semester:
</th>
                        <td><?= $model->activity_sem; ?> 
                            
                        </td> 
<td class="text-justify">
                            <strong>Agree student attend the stated item(s)?
</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>
 
                    </tr>
                

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  Publication(s) in this semester:

</th>
                        <td><?= $model->publications; ?> 
                            
                        </td>
<td class="text-justify">
                            <strong>Agree student publish the stated item(s)?

</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

</td>
 
                        
                    </tr>

                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Expected date of completion::

</th>
<td><?= strtoupper($model->extime); ?> 
                        </td> 
<td class="text-justify">
                            <strong>Agree student expected date of completion?


</strong>
<?php
            echo $form->field($model,'p_komen')->
            dropDownList(['1' => 'Yes ',
                          '2' => 'No', 
                          
                        ],['prompt'=>'Options'])->label(false);
?>
                        <textarea placeholder="Comment.." id="komen" class="form-control"><?= $model->p_komen?></textarea>

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
<div class='x_panel'>
     <div class="x_title">
       <strong><i class="fa fa-check-square"></i> TO BE COMPLETED BY SUPERVISOR</strong>
                    <div class="clearfix"></div>
        </div>
<div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped "> 
               
                     <tr class="headings">
                        <th class="text-center col-md-1" width="10%"  style="background-color:lightseagreen;color:white">NO</th>
                        <th class="column-title text-center" width="30%"  style="background-color:lightseagreen;color:white">CRITERIA</th>
                        <th class="text-center col-md-1" style="background-color:lightseagreen;color:white">SCALE</th>

                    </tr>
                     
             <?php
                            if ($rating) 
                            { $no=1;?>
                            
                                <?php foreach ($rating as $dok) { 
                                    
                                  
                                      
                          
//                                 $mod = \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id, 'idLanjutan'=> 37, 'iklan_id'=>15])->one();
//                                   $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $dok->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id])->one();
                                 
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td class="text-justify"><?php echo $dok->kriteria; ?></td>
                                    <td class="text-justify"><textarea id="komen" class="form-control" name="<?= $dok->id?>"><?= $mod->p_komen?></textarea></td> 

                                </tr>
                                
                                
                                    <?php 
                                    
                            }}?>
                 
                


                   
            

                    
                    

                     
                </table>
   <div class="form-group">
                <div class="col-md-9 col-sm-9col-xs-12 col-md-offset-3">
                     
                    <p align="right">    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></p>
                   
                </div>
    </div>
</div>
</div>

     <?php ActiveForm::end(); ?>
   




