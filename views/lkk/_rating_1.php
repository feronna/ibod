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
        <div class="x_content"> 
      
            <b style="color:red">PLEASE FILL THE PROGRESS REPORT AND STUDENT ACHIEVEMENT PLAN. 
                DO CLICK THE BUTTON AS PREPARED:</b><br> 
             </div>
            
            <br>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
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
            <li style="background-color:red;color:white">
                <p> STEP 2</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('SUPERVISOR RATING', ['rating?i='.$model->reportID]) ?>
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
    <strong>SCALE'S GUIDELINE:</strong><br/>
    <small>Student’s rating for the following:<br>
        <i>(On a scale 1 to 8)</i>
    </small><br>
    <table width=100% style='font-family: monospace;'>
    <tr style='border-bottom: 1px solid #000;'>
        Very Poor<td>
            |
        </td><td>
            |
        </td><td>
            |
        </td><td>
            |
        </td><td>
            |
        </td>
        <td>
            |
        </td><td>
            |
        </td><td>
            |
        </td>
    </tr>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
    &nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;&nbsp;


    Excellent
    <tr>
        <td>
            1
        </td><td>
            2
        </td><td>
            3
        </td><td>
            4
        </td>
        <td>
            5
        </td><td>
            6
        </td><td>
            7
        </td><td>
            8
        </td>
    </tr>
    </table></div>
<div class='x_panel'>
     <div class="x_title">
       <strong><i class="fa fa-check-square"></i> TO BE COMPLETED BY SUPERVISOR</strong>
                    <div class="clearfix"></div>
        </div>
           <?php if($model->status_r == "DONE"){?>

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
                                   $mod = \app\models\cbelajar\Rating::find()->where(['idKriteria'=>$dok->id,'idLkk' => $model->reportID])->one();
                                 
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td class="text-justify"><?php echo $dok->kriteria; ?></td>
                                    <td class="text-justify">
                                    <?= $mod->p_komen;?></textarea></td> 

                                </tr>
                                
                                
                                    <?php 
                                    
                            }}?>
                 
                


                   
            

                    
                    

                     
                </table>
    
  
</div>
</div>
 
 <div class="x_panel">

                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th width="40%"><center>COMMENTS/RECOMMENDATIONS</center></th>
                      <td align="text-center"><?= strtoupper($model->p_comment);?> 

                    </tr>
                   
  <tr>
                      
      <td align="text-left" colspan="10"> Submit Date: <?= $model->c_date;?>
                            
                        </td>
                        
                    </tr>
                    
                      
                </table>
                     
                     
            </div> 
        </div><?php }else{?>
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
    
  
</div>
</div>
 
 <div class="x_panel">

                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>COMMENTS/RECOMMENDATIONS</center></th>
                    </tr>
                   
  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">  Comments/Recommendations:


</th>
                        <td><?= $form->field($model, 'p_comment')->textArea(['maxlength' => true, 'size'=>4]) ->label(false);?> 
                            
                        </td>
                        
                    </tr>
                    
                      
                </table>
                     <div class="form-group">
                <div class="col-md-9 col-sm-9col-xs-12 col-md-offset-3">
                     
                    <p align="right">    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></p>
                   
                </div>
    </div>
                     
            </div> 
            </div><?php }?>

     <?php ActiveForm::end(); ?>
   




