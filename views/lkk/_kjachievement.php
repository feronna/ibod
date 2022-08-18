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
      UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> STUDENT ACHIEVEMENT PLAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>

<div class="x_panel">

        <div class="x_title">
            <h5><strong><i class='fa fa-check-square-o'></i> STUDENT ACHIEVEMENT PLAN GUIDELINES</strong></h5>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
      
            <b style="color:red">
                DO CLICK THE BUTTON AS PREPARED:</b><br> 
             </div>
            
            <br>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p > STEP 1</p><p>
            </p></li>
            <a href="gambar">
            <li style="#f2f2f2">
                
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/borang-permohonan?id='.$model->reportID]) ?>
</b></p><p>
            </p></li>
            </a>
           
            
        </ul>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 2 </p><p>
            </p></li> 
            <a href="pengajian-tinggi">
            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('ACHIEVEMENT PLAN', ['lkk/achievement']) ?></b>
            </p></li>
            </a>
           
        </ul>
    </div>
        </div>

                                        <div class="clearfix"></div>

<?php
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'status'=>"MASTER", 'icno'=>$model->icno])->one();
?>
<div class="x_panel">

          <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
           
              
              <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 1 </strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>    <div class="x_content collapse">
                 <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white" >
                                <tr class="headings">
                                    <th class="text-center" rowspan="2"> BIL.</th>
                                    <th class="text-center" rowspan="2"> ACTIVITY</th>
                                    <th class="text-center" colspan="2"> ACTION</th>
                                   <th class="text-center" rowspan="2" style="vertical-align:middle">EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>

                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center"> YES </th>
                                    <th class="column-title text-center">NO</th>
                                </tr>
                            </thead>
                         <?php
                            if ($sem) 
                            { $no=0;?>
                            
                                <?php foreach ($sem as $dok) { $no++;

                                $mod = \app\models\cbelajar\LkkDean::find()->where(['idsem'=> $dok->id])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->activity; ?></td>
                                    <td class="text-center"><?php  if($mod->result === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->result === 'n') {echo '&#10008;';} ?></td>
                                    <td class="text-center"><?php echo $mod->comment; ?></td>

                                </tr>
                                
                                <?php }
                               
//                             }
              }          ?>
                        </table>
                    </div>   

                <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     <tr>
                         <th colspan='5'><center>COMMENT</center></th>
                    </tr>
                   
  <tr>
                        
                        <td><?= $form->field($mod, 'd_comment')->textArea(['maxlength' => true, 'size'=>4]) ->label(false);?> 
                            
                        </td>
                        
                    </tr>
                    
                      
                </table>
                     <div class="form-group">
                <div class="col-md-9 col-sm-9col-xs-12 col-md-offset-3">
                     
                    <p align="right">    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></p>
                   
                </div>
    </div>
                     
            </div> 
            </div>
                </div>
    
<?php ActiveForm::end(); ?>

  



