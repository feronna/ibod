<?php

use app\models\cuti\CutiUmum;
use app\models\cuti\TblRecords;

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="clearfix">
             
             <table class="table">
                 <tr>
                     <td class="text-center" style="color:black; background-color:#00FF00">Cuti Rehat Kakitangan</td>
                     <td class="text-center" style="color:black; background-color:#0abcff">Cuti Umum</td>
                     <td class="text-center" style="color:black; background-color:#808080">Sabtu/Ahad</td>
                     <td class="text-center" >There are <?= $total ?> Staff That Taken Leave on <?= TblRecords::viewBulan($month); ?>,<?= $year ?></td>
                 </tr>
             </table>
             <table class="table table-bordered table-condensed table-striped table-sm jambo_table">

                 <thead>
                     <tr>

                         <th class="column-title">Bil</th>
                         <th class="column-title text-center">Name</th>
                         <!-- <th class="column-title ">Leave Type</th> -->
                         
                         <?php for ($i = 1; $days >= $i; $i++) { ?>
                             <?php 
                                if ($i < 10) { ?>

                                 <th class="column-title text-center"><?php echo '0' . $i ?></th>

                             <?php  } else { ?>
                                 <th class="column-title text-center"><?php echo $i ?></th>

                             <?php  } ?>
                         <?php  } ?>

                     </tr>
                 </thead>
                 <?php foreach ($baki as $data) { ?>
                     <tr>
                         <td class="text-left"><?= $bil++ ?></td>
                         <td class="text-left"><?= $data->kakitangan->CONm ?></td>
                         <?php for ($i = 1; $days >= $i; $i++) { ?>

                             <?php
                             if($i < 10){ #ni pun sama 2x5 10 juta.. buddduhh!
                                 $day = "0{$i}";
                            } else {
                                $day = $i;
                            }
                             $cuti = TblRecords::getLeaveRecord($data->icno, $year, $month, $day);
                             $public_h = CutiUmum::getCutiUmum("$year-$month-$day");

                             if ($public_h) { ?>
                                 <td class="text-left" style="background-color:#0abcff"></td>
                             <?php } else if (date("l", strtotime("$year-$month-$day")) == 'Sunday' || date("l", strtotime("$year-$month-$day")) == 'Saturday') { ?>
                                 <td class="text-left" style="background-color:#808080"></td>
                             <?php  } elseif ($cuti) { ?>
                                 <td class="text-left" style="background-color:#00FF00"></td>
                             <?php  } else { ?>
                                 <td class="text-left"></td>
                             <?php  } ?>
                         <?php  } ?>
                     </tr>
                 <?php  } ?>
             </table>
         </div>