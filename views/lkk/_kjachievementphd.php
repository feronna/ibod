<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

$this->title = 'Permohonan Cuti Belajar';
error_reporting(0);
?> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


<p align="right"><?= Html::a('Back', ['cb-lkk/kj-view-rating?i=' . $model->reportID . '&id=' . $model->icno], ['class' => 'btn btn-primary btn-sm'])
?></p>




<div class="x_panel">
    <div class="x_content">  
        <span class="required" style="color:#062f49;">
            <strong>
                <center><?= strtoupper('
      UNIT PENGEMBANGAN PROFESIONALISME | SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> GRADUATE ON TIME SCHEDULE
 '); ?>
            </strong> </center>
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
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 1</p><p>
                </p></li>
            <a href="gambar">
                <li style="#f2f2f2">
                    <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/tindakan-kj?i=' . $model->reportID]) ?>
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
                    <p><b>             <?= Html::a('SUPERVISOR RATING', ['cb-lkk/kj-view-rating?i=' . $model->reportID]) ?>
                        </b></p><p>



                    </p></li>
            </a>


        </ul><?php }
        else {?>
        
           <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 2 </p><p>
                </p></li> 
            <a href="pengajian-tinggi">
                <?php if ($model->pengajian->HighestEduLevelCd == 1) { ?>

                    <li style="#f2f2f2">
                        <p >
                            <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/kj-achievement-phd?i=' . $model->reportID . '&id=' . $model->icno]) ?></b>
                        </p></li>
                </a><?php } else { ?>


                <li style="#f2f2f2">
                    <p >
                        <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/kj-achievement-master?i=' . $model->reportID . '&id=' . $model->icno]) ?></b>
                    </p></li>                              
            <?php }
            ?>

        </ul> 
  <?php      }
?>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <?php if($model->pengajian->nama_penyelia != "Non")
        {?>
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 3 </p><p>
                </p></li> 
            <a href="pengajian-tinggi">
                <?php if ($model->pengajian->HighestEduLevelCd == 1) { ?>

                    <li style="#f2f2f2">
                        <p >
                            <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/kj-achievement-phd?i=' . $model->reportID . '&id=' . $model->icno]) ?></b>
                        </p></li>
                </a><?php } else { ?>


                <li style="#f2f2f2">
                    <p >
                        <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/kj-achievement-master?i=' . $model->reportID . '&id=' . $model->icno]) ?></b>
                    </p></li>                              
            <?php }
            ?>

        </ul>
        <?php }
        else{?>
            <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 3</p><p>
                </p></li>
            <a href="gambar">
                <li style="#f2f2f2">
                    <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan-kj?id=' . $model->reportID . '&icno=' . $model->icno]) ?>
                        </b></p><p>



                    </p></li>
            </a>


        </ul>
            
    <?php    }
?>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <?php if($model->pengajian->nama_penyelia != "Non"){?>
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 4</p><p>
                </p></li>
            <a href="gambar">
                <li style="#f2f2f2">
                    <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan-kj?id=' . $model->reportID . '&icno=' . $model->icno]) ?>
                        </b></p><p>



                    </p></li>
            </a>


        </ul><?php }?>
    </div>
</div>

<div class="clearfix"></div>
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

    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>


        <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 1 </strong> </h5>

        <div class="clearfix"></div>
    </div>    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead style="background-color:lightseagreen;color:white" >
                    <tr class="headings">
                        <th class="text-center" rowspan="2" width='5%'> BIL.</th>
                        <th class="text-center" rowspan="2" width='30%'> ACTIVITY</th>
                        <th class="text-center" colspan="2" > ACTION</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle" width='20%'>EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                        <th class="text-center" rowspan="2"> DEAN'S / DIRECTOR COMMENT</th>


                    </tr>
                    <tr class="headings">
                        <th class="column-title text-center"> YES </th>
                        <th class="column-title text-center">NO</th>
                    </tr>
                </thead>
                <?php
                if ($sem) {
                    $no = 0;
                    ?>

                    <?php
                    foreach ($sem as $dok) {
                        $no++;

//                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'idsem'=> $dok->id, 'icno'=>$id])->one();
                        $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-justify"><?php echo $dok->activity; ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '1') {
                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                }
                                ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '2') {
                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                }
                                ?></td>

                            <td class="text-center">
                                <p align="center">
                                    <?php
                                    $dean2 = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                    if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one()) {
                                        if ($dean2->namafile) {
                                            echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
      href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean2->namafile), true) . '" target="_blank" >
      <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>';
                                        }
                                    }
                                    echo '<br>' . $dean2->comment;
                                    ?></p></td>

                            <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $id,'sem'=>1])->orderBy(['create_dt' => SORT_DESC])->one();
                                if($c->d_comment)
                                 {?>
                               <?= strtoupper($c->d_comment)?><br/>
                                     
                                    <?=
                                    Html::button('Edit Comment <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['edit-comment-sem1?id=' . $model->reportID . '&icno=' . $id . '&sem=1']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            } else{?>
                                 
                                    <?=
                                    Html::button('COMMENT <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['comment-sem1?id=' . $model->reportID . '&icno=' . $id . '&sem=1']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            }}
                                ?>
                            </td>

                        </tr>

                        <?php
                    }

//                             }
                }
                ?>
            </table>
        </div>   


    </div>
</div>


<div class="x_panel">

    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>


        <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 2 </strong> </h5>

        <div class="clearfix"></div>
    </div>    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead style="background-color:lightseagreen;color:white" >
                    <tr class="headings">
                        <th class="text-center" rowspan="2" width='5%'> BIL.</th>
                        <th class="text-center" rowspan="2" width='30%'> ACTIVITY</th>
                        <th class="text-center" colspan="2" > ACTION</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle" width='20%'>EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                        <th class="text-center" rowspan="2"> DEAN'S / DIRECTOR COMMENT</th>


                    </tr>
                    <tr class="headings">
                        <th class="column-title text-center"> YES </th>
                        <th class="column-title text-center">NO</th>
                    </tr>
                </thead>
                <?php
                if ($sem2) {
                    $no = 0;
                    ?>

                    <?php
                    foreach ($sem2 as $dok) {
                        $no++;

//                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'idsem'=> $dok->id, 'icno'=>$id])->one();
                        $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->one();
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-justify"><?php echo $dok->activity; ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '1') {
                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                }
                                ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '2') {
                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                }
                                ?></td>

                            <td class="text-center">
                                <p align="center">
                                    <?php
                                    $dean2 = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                    if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one()) {
                                        if ($dean2->namafile) {
                                            echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
      href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean2->namafile), true) . '" target="_blank" >
      <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>';
                                        }
                                    }
                                    echo '<br>' . $dean2->comment;
                                    ?></p></td>

                            <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $id,'sem'=>2])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                               <?= strtoupper($c->d_comment)?><br/>
                                     
                                    <?=
                                    Html::button('Edit Comment <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['edit-comment-sem2?id=' . $model->reportID . '&icno=' . $id . '&sem=2']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            } else{?>
                                 
                                    <?=
                                    Html::button('COMMENT <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['comment?id=' . $model->reportID . '&icno=' . $id . '&sem=2']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            }}
                                ?>
                            </td>

                        </tr>

                        <?php
                    }
                }
                ?>



            </table>
        </div> 


    </div>
</div>
<?php
$mod3 = \app\models\cbelajar\LkkDean::find()->where(['parent_id' => 3, 'status' => "PHD", 'icno' => $id])->orderBy(['created_dt' => SORT_DESC])->one();
?>
<div class="x_panel">

    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>


        <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 3 </strong> </h5>

        <div class="clearfix"></div>
    </div>    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead style="background-color:lightseagreen;color:white" >
                    <tr class="headings">
                        <th class="text-center" rowspan="2" width='5%'> BIL.</th>
                        <th class="text-center" rowspan="2" width='30%'> ACTIVITY</th>
                        <th class="text-center" colspan="2" > ACTION</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle" width='20%'>EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                        <th class="text-center" rowspan="2"> DEAN'S / DIRECTOR COMMENT</th>


                    </tr>
                    <tr class="headings">
                        <th class="column-title text-center"> YES </th>
                        <th class="column-title text-center">NO</th>
                    </tr>
                </thead>
                <?php
                if ($sem3) {
                    $no = 0;
                    ?>

                    <?php
                    foreach ($sem3 as $dok) {
                        $no++;

//                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'idsem'=> $dok->id, 'icno'=>$id])->one();
                        $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-justify"><?php echo $dok->activity; ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '1') {
                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                }
                                ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '2') {
                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                }
                                ?></td>

                            <td class="text-center">
                                <p align="center">
                                    <?php
                                    $dean2 = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                    if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one()) {
                                        if ($dean2->namafile) {
                                            echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
      href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean2->namafile), true) . '" target="_blank" >
      <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>';
                                        }
                                    }
                                    echo '<br>' . $dean2->comment;
                                    ?></p></td>

                            <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $id,'sem'=>3])->orderBy(['create_dt' => SORT_DESC])->one();
                                if($c->d_comment)
                                 {?>
                               <?= strtoupper($c->d_comment)?><br/>
                                     
                                    <?=
                                    Html::button('Edit Comment <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['edit-comment-sem3?id=' . $model->reportID . '&icno=' . $id . '&sem=3']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            } else{?>
                                 
                                    <?=
                                    Html::button('COMMENT <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['comment-sem3?id=' . $model->reportID . '&icno=' . $id . '&sem=3']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            }}
                                ?>
                                
                            </td>

                        </tr>

                        <?php
                    }

//                             }
                }
                ?>
            </table>
        </div>  


    </div>
</div>


<div class="x_panel">

    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>


        <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 4 </strong> </h5>

        <div class="clearfix"></div>
    </div>    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead style="background-color:lightseagreen;color:white" >
                <th class="text-center" rowspan="2" width='5%'> BIL.</th>
                <th class="text-center" rowspan="2" width='30%'> ACTIVITY</th>
                <th class="text-center" colspan="2" > ACTION</th>
                <th class="text-center" rowspan="2" style="vertical-align:middle" width='20%'>EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                <th class="text-center" rowspan="2"> DEAN'S / DIRECTOR COMMENT</th>
                <tr class="headings">
                    <th class="column-title text-center"> YES </th>
                    <th class="column-title text-center">NO</th>
                </tr>
                </thead>
                <?php
                if ($sem4) {
                    $no = 0;
                    ?>

                    <?php
                    foreach ($sem4 as $dok) {
                        $no++;

//                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'idsem'=> $dok->id, 'icno'=>$id])->one();
                        $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-justify"><?php echo $dok->activity; ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '1') {
                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                }
                                ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '2') {
                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                }
                                ?></td>

                            <td class="text-center">
                                <p align="center">
                                    <?php
                                    $dean2 = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                    if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one()) {
                                        if ($dean2->namafile) {
                                            echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
      href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean2->namafile), true) . '" target="_blank" >
      <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>';
                                        }
                                    }
                                    echo '<br>' . $dean2->comment;
                                    ?></p></td>

                            <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $id,'sem'=>4])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                               <?= strtoupper($c->d_comment)?><br/>
                                     
                                    <?=
                                    Html::button('Edit Comment <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['edit-comment-sem4?id=' . $model->reportID . '&icno=' . $id . '&sem=4']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            } else{?>
                                 
                                    <?=
                                    Html::button('COMMENT <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['comment-sem4?id=' . $model->reportID . '&icno=' . $id . '&sem=4']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            }}
                                ?>
                            </td>

                        </tr>


                        <?php
                    }

//                             }
                }
                ?>
            </table>

        </div>   


    </div>
</div>
<?php
$mod4 = \app\models\cbelajar\LkkDean::find()->where(['parent_id' => 4, 'status' => "PHD", 'icno' => $model->icno])->orderBy(['created_dt' => SORT_DESC])->one();
?>
<div class="x_panel">

    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>


        <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 5 </strong> </h5>

        <div class="clearfix"></div>
    </div>    <div class="x_content ">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead style="background-color:lightseagreen;color:white" >
                    <tr class="headings">
                        <th class="text-center" rowspan="2" width='5%'> BIL.</th>
                        <th class="text-center" rowspan="2" width='30%'> ACTIVITY</th>
                        <th class="text-center" colspan="2" > ACTION</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle" width='20%'>EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                        <th class="text-center" rowspan="2"> DEAN'S / DIRECTOR COMMENT</th>


                    </tr>
                    <tr class="headings">
                        <th class="column-title text-center"> YES </th>
                        <th class="column-title text-center">NO</th>
                    </tr>
                </thead>
                <?php
                if ($sem5) {
                    $no = 0;
                    ?>

                    <?php
                    foreach ($sem5 as $dok) {
                        $no++;

//                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'idsem'=> $dok->id, 'icno'=>$id])->one();
                        $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-justify"><?php echo $dok->activity; ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '1') {
                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                }
                                ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '2') {
                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                }
                                ?></td>

                            <td class="text-center">
                                <p align="center">
                                    <?php
                                    $dean2 = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                    if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one()) {
                                        if ($dean2->namafile) {
                                            echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
      href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean2->namafile), true) . '" target="_blank" >
      <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>';
                                        }
                                    }
                                    echo '<br>' . $dean2->comment;
                                    ?></p></td>

                            <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $id,'sem'=>5])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {?>
                               <?= strtoupper($c->d_comment)?><br/>
                                     
                                    <?=
                                    Html::button('Edit Comment <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['edit-comment-sem5?id=' . $model->reportID . '&icno=' . $id . '&sem=5']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            } else{?>
                                 
                                    <?=
                                    Html::button('COMMENT <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['comment-sem5?id=' . $model->reportID . '&icno=' . $id . '&sem=5']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            }}
                                ?>
                            </td>

                        </tr>

                        <?php
                    }

//                             }
                }
                ?>
            </table>
        </div> 


    </div>
</div>

<?php
$mod6 = \app\models\cbelajar\LkkDean::find()->where(['parent_id' => 6, 'status' => "PHD", 'icno' => $model->icno])->orderBy(['created_dt' => SORT_DESC])->orderBy(['created_dt' => SORT_DESC])->one();
?>
<div class="x_panel">

    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>


        <h5 style='color:#A569BD'> <strong><i class="fa fa-bar-chart-o"></i> SEMESTER 6 </strong> </h5>

        <div class="clearfix"></div>
    </div>    <div class="x_content ">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead style="background-color:lightseagreen;color:white" >
                    <tr class="headings">
                        <th class="text-center" rowspan="2" width='5%'> BIL.</th>
                        <th class="text-center" rowspan="2" width='30%'> ACTIVITY</th>
                        <th class="text-center" colspan="2" > ACTION</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle" width='20%'>EVIDENCE/OUTPUT/<br>DATE SUBMITTED</th>
                        <th class="text-center" rowspan="2"> DEAN'S / DIRECTOR COMMENT</th>


                    </tr>
                    <tr class="headings">
                        <th class="column-title text-center"> YES </th>
                        <th class="column-title text-center">NO</th>
                    </tr>
                </thead>
                <?php
                if ($sem6) {
                    $no = 0;
                    ?>

                    <?php
                    foreach ($sem6 as $dok) {
                        $no++;

//                                $mod = \app\models\cbelajar\LkkDean::find()->where(['parent_id'=>1,'idsem'=> $dok->id, 'icno'=>$id])->one();
                        $dean = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-justify"><?php echo $dok->activity; ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '1') {
                                    echo ' <i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
                                }
                                ?></td>
                            <td class="text-center"><?php
                                if ($dean->result === '2') {
                                    echo ' <i class="fa fa-times  fa-lg" aria-hidden="true" style="color: red"></i>';
                                }
                                ?></td>

                            <td class="text-center">
                                <p align="center">
                                    <?php
                                    $dean2 = \app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one();
//var_dump($dean->namafile);die;
                                    if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $id, 'dokumen' => $dok->id])->orderBy(['created_dt' => SORT_DESC])->one()) {
                                        if ($dean2->namafile) {
                                            echo'<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
      href=" ' . Url::to(Yii::$app->FileManager->DisplayFile($dean2->namafile), true) . '" target="_blank" >
      <i class="fa fa-download"></i> <strong><small><u> Download  </u></small></strong></a>';
                                        }
                                    }
                                    echo '<br>' . $dean2->comment;
                                    ?></p></td>

                            <?php
                            if ($no == 1) {
                                ?>
                                <td rowspan='9'  class="text-center">

                                 <?php
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $id,'sem'=>6])->orderBy(['create_dt' => SORT_DESC])->one();
                                 
                                 
                                 if($c->d_comment)
                                 {?>
                               <?= strtoupper($c->d_comment)?><br/>
                                     
                                    <?=
                                    Html::button('Edit Comment <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['edit-comment-sem6?id=' . $model->reportID . '&icno=' . $id . '&sem=4']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            } else{?>
                                 
                                    <?=
                                    Html::button('COMMENT <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton',
                                        'value' => \yii\helpers\Url::to(['comment-sem6?id=' . $model->reportID . '&icno=' . $id . '&sem=4']),
                                        'class' => 'btn btn-primary btn-xs mapBtn'])
                                    ;
                            }}
                                ?>
                            </td>

                        </tr>

                        <?php
                    }

//                             }
                }
                ?>
            </table>
        </div>   


    </div>
</div>
<p align="right"> 



    <?= Html::a('Next', ['lkk/pengesahan-kj?id=' . $model->reportID . '&icno=' . $model->icno], ['class' => 'btn btn-primary btn-sm'])
    ?></p>
<?php ActiveForm::end(); ?>





