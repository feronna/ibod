<?php

use yii\helpers\Html;
use yii\grid\GridView;
error_reporting(0);
?>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Senarai Belum Memohon</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>      
            <div class="clearfix"></div>      
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">No IC</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jawatan</th>
                    <th class="text-center">JFPIU</th>
                    <th class="text-center">Taraf Jawatan</th>
                    <th class="text-center">Tarikh Mula Lantikan</th>
                    <th class="text-center">Tarikh Tamat Lantikan</th>
                </tr>
                </thead>
                <?php
                $bil = '1';
                if($layak){
                    foreach ($biodata as $biodatas){
                    $tarikhmula = date_format(date_create($biodatas->startDateLantik),'Y-m-d');
                    if($biodatas->jawatan->job_category=="2" && $tarikhmula >= $layak->start_lantikan && $tarikhmula <= $layak->end_lantikan){
                    $model = \app\models\pengesahan\Pengesahan::find()->where(['icno' => $biodatas->ICNO])->one();  
                      if(!$model){?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $biodatas->ICNO; ?></td>
                            <td class="text-center"><?php echo $biodatas->CONm; ?></td>
                            <td class="text-center"><?php echo $biodatas->jawatan->nama; ?></td>
                            <td class="text-center"><?php echo $biodatas->department->shortname; ?></td>
                            <td class="text-center"><?php echo $biodatas->statusLantikan->ApmtStatusNm; ?></td>
                            <td class="text-center"><?php echo $biodatas->startDateLantik; ?></td>
                            <td class="text-center"><?php echo $biodatas->endDateLantik; ?></td>
                        </tr>
                     <?php }
                    }
                    }
                    } ?>
            </table>
            </div>
        </div>
    </div>
</div>