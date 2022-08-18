<?php
//$date = new DateTime('2000-08-01', new DateTimeZone('Asia/Kuala_Lumpur'));
//echo $date->format('Y-M-d') . "\n";die;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
//use yii;
?>
<html>
    <style>
        .div {
            font-family: Tahoma,serif;
            font-size:10pt;
        }
    </style>


        </div>
    <body>
        <!--no rujukan-->
         <div style="        
             position: absolute;
            width: 333px;
               bottom: 87.7%;
               left: 37.55%;
               text-align: left;
               font-size:12.5px;">
<?php echo $model->no_rujukan; ?></div>
         <!--tarikh mesyuarat-->
          <div style="        
               position: absolute;
               width: 333px;
               bottom: 66.1%;
               left: 34.25%;
               text-align: left;
               font-size:13px;
               ">
                   <?php 
//                   $today = date('d M Y');
                 
                   $month = date('m');
                   if($month == 3){
                       $m = "Mac";
                   }elseif($month == 5){
                       $m = "Mei";
                    }elseif($month == 8){
                       $m = "Ogos";
                    }
                    elseif($month == 10){
                       $m = "Okt";
                    }elseif($month == 12){
                       $m = "Dis";
                    }else{
                        $m = date('M');
                    }
                    $d = date('d');$y = date('Y');
//                   echo $d.'.'.$m.' '.$y;
                            Yii::$app->formatter->locale = 'ms-MY';

                    echo $model->tarikh_m ? Yii::$app->formatter->format($model->tarikh_m, ['date', 'dd/MM/Y']) : '-';
                   ?>
        </div>
            <!--tarikh hari ni-->

        <div style="        
               position: absolute;
               width: 333px;
               bottom: 86.1%;
               left: 27.25%;
               text-align: left;
               font-size:13px;
               ">
                   <?php 
                   $today = date('d M Y');
                   $month = date('m');
                   if($month == 3){
                       $m = "Mac";
                   }elseif($month == 5){
                       $m = "Mei";
                    }elseif($month == 8){
                       $m = "Ogos";
                    }
                    elseif($month == 10){
                       $m = "Okt";
                    }elseif($month == 12){
                       $m = "Dis";
                    }else{
                        $m = date('M');
                    }
                    $d = date('d');$y = date('Y');
                   echo $d.' '.$m.' '.$y;
                   ?>
        </div>
        <!--nama penerima-->

        <div style="        
             position: absolute;
             width: 333px;
             bottom: 82.1%;
             left: 12.25%;
             text-align: left;
             font-weight:bold;
             text-transform: capitalize;">
<?php echo $model->kakitangan->CONm; ?>
        </div>
        <!--department-->
        <div style="        
             position: absolute;
             width: 443px;
             bottom: 78.1%;
             left: 12.40%;
             text-align: left;">
<?php

//echo 
$icno = $model->kepada;
//var_dump($icno);die;

        $deptid = Tblprcobiodata::findOne(['ICNO'=>$icno]);
//        var_dump($deptid->DeptId);die;
$deptname = Department::findOne(['id'=> $deptid->DeptId]);
//var_dump($deptname->fullname);die;
echo $deptname->fullname;
?>
        </div>
        <!--nama jawatan-->

        <div style="        
             position: absolute;
             width: 443px;
             bottom: 80.1%;
             left: 12.40%;
             ">
                 <?php
                 $gred = $model->kakitangan->gredJawatan;
                 $model = \app\models\hronline\GredJawatan::findOne(['id' => $gred]);
                 echo $model->nama;
                 ?>
        </div>
       
    </body>