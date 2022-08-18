<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use app\models\hronline\Department;
$this->title = 'Permohonan Cuti Belajar';
error_reporting(0);
?> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


<p align="right"><?= Html::a('Back', ['cb-lkk/pp-view-rating?i=' . $model->reportID . '&id=' . $model->icno], ['class' => 'btn btn-primary btn-sm'])
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
                    <p><b>             <?= Html::a('PROGRESS REPORT', ['lkk/tindakan-pp?id=' . $model->reportID]) ?>
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
                    <p><b>             <?= Html::a('SUPERVISOR RATING', ['cb-lkk/pp-view-rating?i=' . $model->reportID]) ?>
                        </b></p><p>



                    </p></li>
            </a>


        </ul>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:red;color:white">
                <p> STEP 3 </p><p>
                </p></li> 
            <a href="pengajian-tinggi">
                <?php if ($model->pengajian->HighestEduLevelCd == 1) { ?>

                    <li style="#f2f2f2">
                        <p >
                            <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/p-achievement-phd?i=' . $model->reportID . '&id=' . $model->icno]) ?></b>
                        </p></li>
                </a><?php } else { ?>


                <li style="#f2f2f2">
                    <p >
                        <b style='color:red'>             <?= Html::a('GOT SCHEDULE', ['lkk/p-achievement-master?i=' . $model->reportID . '&id=' . $model->icno]) ?></b>
                    </p></li>                              
            <?php }
            ?>

        </ul>
    </div>
    <?php if (Department::find()->where([ 'pp' => Yii::$app->user->getId()])->exists()){?>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
        <ul class="to_do">
            <li style="background-color:lightseagreen;color:white">
                <p> STEP 4</p><p>
                </p></li>
            <a href="gambar">
                <li style="#f2f2f2">
                    <p><b>             <?= Html::a('VERIFICATION', ['lkk/pengesahan-pp?id=' . $model->reportID . '&icno=' . $model->icno]) ?>
                        </b></p><p>



                    </p></li>
            </a>


        </ul>
    </div><?php }?>
</div>

<div class="clearfix"></div>


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
                        <th class="text-center" rowspan="2"> DEAN'S COMMENT</th>


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
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $model->icno,'sem'=>1])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {
                                     echo $c->d_comment;
                                 }
                                  else
                                    {
                                        echo 'No Comment Yet';
                                    }
                                
                                 
                                   
//                                    else {
//
//                                        echo Html::button('COMMENT <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                            'value' => \yii\helpers\Url::to(['comment?id=' . $dean2->parent_id . '&icno=' . $dean2->icno . '&sem=1']),
//                                            'class' => 'btn btn-primary btn-xs mapBtn'])
//                                        ;
//                                    }
                                }
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
                        <th class="text-center" rowspan="2"> DEAN'S COMMENT</th>


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
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $model->icno,'sem'=>2])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {
                                     echo $c->d_comment;
                                 }
                                  else
                                    {
                                        echo 'No Comment Yet';
                                    }
                                
                                 
                                   
//                                    else {
//
//                                        echo Html::button('COMMENT <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                            'value' => \yii\helpers\Url::to(['comment?id=' . $dean2->parent_id . '&icno=' . $dean2->icno . '&sem=1']),
//                                            'class' => 'btn btn-primary btn-xs mapBtn'])
//                                        ;
//                                    }
                                }
                                ?>
                            </td>

                        </tr>

    <?php }
} ?>



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
                        <th class="text-center" rowspan="2"> DEAN'S COMMENT</th>


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
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $model->icno,'sem'=>3])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {
                                     echo $c->d_comment;
                                 }
                                  else
                                    {
                                        echo 'No Comment Yet';
                                    }
                                
                                 
                                   
//                                    else {
//
//                                        echo Html::button('COMMENT <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                            'value' => \yii\helpers\Url::to(['comment?id=' . $dean2->parent_id . '&icno=' . $dean2->icno . '&sem=1']),
//                                            'class' => 'btn btn-primary btn-xs mapBtn'])
//                                        ;
//                                    }
                                }
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
                <th class="text-center" rowspan="2"> DEAN'S COMMENT</th>
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
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $model->icno,'sem'=>4])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {
                                     echo $c->d_comment;
                                 }
                                  else
                                    {
                                        echo 'No Comment Yet';
                                    }
                                
                                 
                                   
//                                    else {
//
//                                        echo Html::button('COMMENT <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                            'value' => \yii\helpers\Url::to(['comment?id=' . $dean2->parent_id . '&icno=' . $dean2->icno . '&sem=1']),
//                                            'class' => 'btn btn-primary btn-xs mapBtn'])
//                                        ;
//                                    }
                                }
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
                        <th class="text-center" rowspan="2"> DEAN'S COMMENT</th>


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
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $model->icno,'sem'=>5])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {
                                     echo $c->d_comment;
                                 }
                                  else
                                    {
                                        echo 'No Comment Yet';
                                    }
                                
                                 
                                   
//                                    else {
//
//                                        echo Html::button('COMMENT <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                            'value' => \yii\helpers\Url::to(['comment?id=' . $dean2->parent_id . '&icno=' . $dean2->icno . '&sem=1']),
//                                            'class' => 'btn btn-primary btn-xs mapBtn'])
//                                        ;
//                                    }
                                }
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
$mod6 = \app\models\cbelajar\LkkDean::find()->where(['parent_id' => 6, 'status' => "PHD", 'icno' => $model->icno])->orderBy(['created_dt' => SORT_DESC])->one();
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
                        <th class="text-center" rowspan="2"> DEAN'S COMMENT</th>


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
                                 
                                 $c = \app\models\cbelajar\DeanComment::find()->where(['icno' => $model->icno,'sem'=>6])->orderBy(['create_dt' => SORT_DESC])->one();
                                 if($c->d_comment)
                                 {
                                     echo $c->d_comment;
                                 }
                                  else
                                    {
                                        echo 'No Comment Yet';
                                    }
                                
                                 
                                   
//                                    else {
//
//                                        echo Html::button('COMMENT <i class="fa fa-edit" aria-hidden="true"></i>', ['id' => 'modalButton',
//                                            'value' => \yii\helpers\Url::to(['comment?id=' . $dean2->parent_id . '&icno=' . $dean2->icno . '&sem=1']),
//                                            'class' => 'btn btn-primary btn-xs mapBtn'])
//                                        ;
//                                    }
                                }
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



    <?= Html::a('Next', ['lkk/pengesahan-pp?id=' . $model->reportID . '&icno=' . $model->icno], ['class' => 'btn btn-primary btn-sm'])
    ?></p>
    <?php ActiveForm::end(); ?>





