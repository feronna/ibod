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
      
            <b style="color:red">PLEASE FILL THE PROGRESS REPORT AND STUDENT ACHIEVEMENT PLAN. 
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
                                <?php if($b->HighestEduLevelCd == 1){ ?>

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('ACHIEVEMENT PLAN', ['lkk/achievement-phd']) ?></b>
            </p></li>
                                </a><?php } else{?>
                                    

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('ACHIEVEMENT PLAN', ['lkk/achievement']) ?></b>
            </p></li>                              
                            <?php    }
?>
           
        </ul>
    </div>
        </div>

                                        <div class="clearfix"></div>



<?php
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'icno'=>$icno])->one();
if($mod)
{?>
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

                                $mod = \app\models\cbelajar\LkkDean::find()->where(['idsem'=> $dok->id,'icno'=>$icno])->one();
                                     
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
                    </div>   <div class="pull-right">
                
</div>     </div></div><?php } else{?>
    
    <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
<h5 style='color:green'> <strong><i class="fa fa-bar-chart"></i> SEMESTER 1</strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                
                 <div class="form-group" align="text-center">
<!--                    <h2>  <span class="label label-success">SEMESTER 1</span></h2>-->

             
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='5%'>BIL</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='40%'>ACTIVITY</th>
                                    <th class="text-center" colspan="2" >ACTION</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle">EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>

                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center" width='5%'>YES</th>
                                    <th class="column-title text-center" width='5%'>NO</th>
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
                                    <td class="text-justify"><input type="text" id="tblprestasi-catatan" class="form-control" name="<?= $kpi->id?>">

                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                        
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
</div><?php }?>

<?php ActiveForm::end(); ?>

  



