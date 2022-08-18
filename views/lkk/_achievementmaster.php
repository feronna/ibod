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
 <p align="right"><?= Html::a('Kembali', ['lkk/senarailkk'], 
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
 <div class="tile-stats" style='padding:10px'>
                        <div class="x_content">

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>INFO</u> </strong></font><br><br>

                                <strong>
                                    
                                IF YOU HAVING TROUBLE ON SAVING THE STEP 1 OR STEP 3 SUCH AS WHEN YOU CLICK THE
                                BUTTON SAVE, IT MAKE YOU RETURN TO THE LOGIN PAGE, DO CLEAR YOU CACHE ON THE BROWSER SETTING
                                AND TRY TO LOGIN BACK.</strong>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>

                            </div>
                                 
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
                     <td><small>STEP 2: <strong>GOT SCHEDULE- 
                                    COMPULSARY TO UPDATE THE GOT IN THE CURRENT SEMESTER TO 
                                    PROCEED YOUR LKP SUBMISSION. BUT IF YOU ARE IN SEMESTER 4, DO SUBMIT YOUR
                                    EVIDENCE/JUSTIFICATION FROM SEMESTER 1- 3.</strong></small></td>
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
            <h5><strong><i class='fa fa-check-square-o'></i> STUDENT ACHIEVEMENT PLAN GUIDELINES</strong></h5>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
      
            <b style="color:red">PLEASE FILL THE PROGRESS REPORT AND STUDENT ACHIEVEMENT PLAN. 
                DO CLICK THE BUTTON AS PREPARED:</b><br> 
             </div>
            
            <br>
              <br>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 1</p><p>
            </p></li>
            <a href="gambar">
                 <?php if($model->status_borang != "Complete"){ ?>
            <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/borang-permohonan?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
                 </a><?php } else {?>
                     <li style="#f2f2f2">
                <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/lihat-permohonan?id='.$model->reportID]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
                     
            <?php     }
?>
           
            
        </ul>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 2 </p><p>
            </p></li> 
            <a href="pengajian-tinggi">
                                <?php if($model->pengajian>HighestEduLevelCd == 1){ ?>

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/achievement-phd?id='.$model->reportID.'&icno='.$icno]) ?></b>
            </p></li>
                                </a><?php } else{?>
                                    

            <li style="#f2f2f2">
                <p >
                    <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/achievement-master?id='.$model->reportID.'&icno='.$icno]) ?></b>
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
                <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan?id='.$model->reportID.'&icno='.$icno]) ?>
                </b></p><p>
                    
                    
               
            </p></li>
            </a>
           
            
        </ul>
    </div>
        </div>

                                        <div class="clearfix"></div>




    
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

             
                <div class="x_content ">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='5%'>BIL</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='50%'>ACTIVITY</th>
                                    <th class="text-center" colspan="2" >ACTION</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle">EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                                                  <th class="text-center" rowspan="2" style="vertical-align:middle">DEAN'S / DIRECTOR'S COMMENT</th>
                                    <th class="text-center" rowspan="2" >ACTION</th>

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
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['id' => $kpi->id, 'icno' => $icno])->orderBy(['created_dt' => SORT_DESC])->one();
                                     
                                ?>
                                <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-justify"><?php echo $kpi->activity; ?></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 1) {
                                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 2) {
                                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                                if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one()) {


                                                    if ($dean->namafile) {
                                                        echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean->namafile), true) . '" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>'
                                                        ;
                                                    } else {
                                                        echo '<small>'.strtoupper($dean->comment).'</small>';
                                                    }
                                                }
//    else{
//     
//    echo Html::button('ADD EVIDENCE <i class="fa fa-plus" aria-hidden="true"></i>', 
//                    ['id' => 'modalButton', 
//                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id='.$model->reportID.'&icno='.$icno.'&i='.$kpi->id.'&sem=1']),
//                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
//                 ;
                                                ?></p></td>
                                         <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno,'sem'=>1])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                                    <small><?= strtoupper($c->d_comment)?></small><br/>
                                     
                                    
                          <?php  }}
                                ?>
                            </td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                echo
                                                     Html::button(' <i class="fa fa-edit fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
                                                    'class' => 'btn btn-primary btn-xs mapBtn']);
//                                                Html::button('<small>YES</small><i class="fa fa-check fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-success btn-xs mapBtn'])
//                                                . '&nbsp;' . Html::button('<small>NO</small><i class="fa fa-times fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['justifikasi?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-danger btn-xs mapBtn'])
                                                
                                                ?></p></td> 
                                    </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                        
                  
                    </div>
            
            </div>
           
            </div>
        </div>
</div>
</div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
<h5 style='color:green'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 2</strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                
                 <div class="form-group" align="text-center">

             
                <div class="x_content ">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                               <tr class="headings">
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='5%'>BIL</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='50%'>ACTIVITY</th>
                                    <th class="text-center" colspan="2" >ACTION</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle">EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                                                                        <th class="text-center" rowspan="2" style="vertical-align:middle">DEAN'S / DIRECTOR'S COMMENT</th>

                                    <th class="text-center" rowspan="2" >ACTION</th>

                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center" width='5%'>YES</th>
                                    <th class="column-title text-center" width='5%'>NO</th>
                                </tr>
                                    
                            </thead>
                            <?php
                            if ($sem2) 
                            { $no=0;?>
                            
                                <?php foreach ($sem2 as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['id' => $kpi->id, 'idsem' => $kpi->id, 'icno' => $icno])->orderBy(['created_dt' => SORT_DESC])->one();
                                     
                                ?>
                                <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-justify"><?php echo $kpi->activity; ?></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 1) {
                                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 2) {
                                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                                if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one()) {


                                                    if ($dean->namafile) {
                                                        echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean->namafile), true) . '" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>'
                                                        ;
                                                    } else {
                                                        echo '<small>'.strtoupper($dean->comment).'</small>';
                                                    }
                                                }

                                                ?></p></td>
                                         <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno,'sem'=>2])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                                    <small><?= strtoupper($c->d_comment)?></small><br/>
                                     
                                    
                          <?php  }}
                                ?>
                            </td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                echo
                                                     Html::button(' <i class="fa fa-edit fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
                                                    'class' => 'btn btn-primary btn-xs mapBtn']);
//                                                Html::button('<small>YES</small><i class="fa fa-check fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-success btn-xs mapBtn'])
//                                                . '&nbsp;' . Html::button('<small>NO</small><i class="fa fa-times fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['justifikasi?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-danger btn-xs mapBtn'])
//                                                ;
                                                ?></p></td> 
                                    </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                        
                        
                    </div>
            
            </div>
           
            </div>
        </div>
</div>
</div>

                                        

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
<h5 style='color:green'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 3</strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                
                 <div class="form-group" align="text-center">
<!--                    <h2>  <span class="label label-success">SEMESTER 1</span></h2>-->

             
                <div class="x_content ">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='5%'>BIL</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='50%'>ACTIVITY</th>
                                    <th class="text-center" colspan="2" >ACTION</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle">EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                                  <th class="text-center" rowspan="2" style="vertical-align:middle">DEAN'S / DIRECTOR'S COMMENT</th>
                                  <th class="text-center" rowspan="2" >ACTION</th>

                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center" width='5%'>YES</th>
                                    <th class="column-title text-center" width='5%'>NO</th>
                                </tr>
                                    
                            </thead>
                            <?php
                            if ($sem3) 
                            { $no=0;?>
                            
                                <?php foreach ($sem3 as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['id' => $kpi->id, 'icno' => $icno])->orderBy(['created_dt' => SORT_DESC])->one();
                                     
                                ?>
                                <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-justify"><?php echo $kpi->activity; ?></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 1) {
                                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 2) {
                                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                                if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])
                                                        ->orderBy(['created_dt' => SORT_DESC])->one()) {


                                                    if ($dean->namafile) {
                                                        echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean->namafile), true) . '" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>'
                                                        ;
                                                    } else {
                                                        echo '<small>'.strtoupper($dean->comment).'</small>';
                                                    }
                                                }
//    else{
//     
//    echo Html::button('ADD EVIDENCE <i class="fa fa-plus" aria-hidden="true"></i>', 
//                    ['id' => 'modalButton', 
//                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id='.$model->reportID.'&icno='.$icno.'&i='.$kpi->id.'&sem=1']),
//                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
//                 ;
                                                ?></p></td>
                                         <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno,'sem'=>3])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                                    <small><?= strtoupper($c->d_comment)?></small><br/>
                                     
                                    
                          <?php  }}
                                ?>
                            </td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                echo
                                                     Html::button(' <i class="fa fa-edit fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
                                                    'class' => 'btn btn-primary btn-xs mapBtn']);
//                                                Html::button('<small>YES</small><i class="fa fa-check fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-success btn-xs mapBtn'])
//                                                . '&nbsp;' . Html::button('<small>NO</small><i class="fa fa-times fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['justifikasi?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-danger btn-xs mapBtn'])
                                               
                                                ?></p></td> 
                                    </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                        
                        
                    </div>
            
            </div>
           
            </div>
        </div>
</div>
</div>
                                     
 <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
<h5 style='color:green'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 4</strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                
                 <div class="form-group" align="text-center">

             
                <div class="x_content ">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='5%'>BIL</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle" width='50%'>ACTIVITY</th>
                                    <th class="text-center" colspan="2" >ACTION</th>
                                    <th class="text-center" rowspan="2" style="vertical-align:middle">EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                                               <th class="text-center" rowspan="2" style="vertical-align:middle">DEAN'S / DIRECTOR'S COMMENT</th>
                                    <th class="text-center" rowspan="2" >ACTION</th>

                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center" width='5%'>YES</th>
                                    <th class="column-title text-center" width='5%'>NO</th>
                                </tr>
                                    
                            </thead>
                            <?php
                            if ($sem4) 
                            { $no=0;?>
                            
                                <?php foreach ($sem4 as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\LkkDean::find()->where(['id' => $kpi->id, 'icno' => $icno])->orderBy(['created_dt' => SORT_DESC])->one();
                                     
                                ?>
                                <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-justify"><?php echo $kpi->activity; ?></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 1) {
                                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])
                                                        ->orderBy(['created_dt' => SORT_DESC])->one();


                                                if ($dean->result == 2) {
                                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p></td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])
                                                        ->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                                if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno, 'dokumen' => $kpi->id])
                                                        ->orderBy(['created_dt' => SORT_DESC])->one()) {


                                                    if ($dean->namafile) {
                                                        echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean->namafile), true) . '" target="_blank" >
                                <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>'
                                                        ;
                                                    } else {
                                                        echo '<small>'.strtoupper($dean->comment).'</small>';
                                                    }
                                                }
//    else{
//     
//    echo Html::button('ADD EVIDENCE <i class="fa fa-plus" aria-hidden="true"></i>', 
//                    ['id' => 'modalButton', 
//                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id='.$model->reportID.'&icno='.$icno.'&i='.$kpi->id.'&sem=1']),
//                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
//                 ;
                                                ?></p></td>
                                         <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno,'sem'=>4])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                                    <small><?= strtoupper($c->d_comment)?></small><br/>
                                     
                                    
                          <?php  }}
                                ?>
                            </td>
                                        <td class="text-center">
                                            <p align="center">
                                                <?php
                                                echo
                                                     Html::button(' <i class="fa fa-edit fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
                                                    'class' => 'btn btn-primary btn-xs mapBtn']);
//                                                Html::button('<small>YES</small><i class="fa fa-check fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-success btn-xs mapBtn'])
//                                                . '&nbsp;' . Html::button('<small>NO</small><i class="fa fa-times fa-xs" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['justifikasi?id=' . $model->reportID . '&icno=' . $icno . '&i=' . $kpi->id . '&sem=1']),
//                                                    'class' => 'btn btn-danger btn-xs mapBtn'])
//                                                ;
                                                ?></p></td> 
                                    </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>

                        </table>
                        
                        
                    </div>
            
            </div>
           
            </div>
        </div>
</div>
</div>
   
                                     


<?php ActiveForm::end(); ?>

  



