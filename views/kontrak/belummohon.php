<?php

error_reporting(0);
?>

<?= $this->render('/kontrak/_topmenu') ?>

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
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jawatan</th>
                    <th class="text-center">JFPIU</th>
                    <th class="text-center">Taraf Jawatan</th>
                    <th class="text-center">Tarikh Mula Kontrak</th>
                    <th class="text-center">Tarikh Tamat Kontrak</th>
                </tr>
                </thead>
                <?php
                $bil = '1';
                if($layak){
                    foreach ($biodata as $biodatas){
                    $tarikhtamat = date_format(date_create($biodatas->endDateLantik),'Y-m-d');
                    if($biodatas->jawatan->job_category=="2" && $tarikhtamat >= $layak->min('start_tamatkontrak') && $tarikhtamat <= $layak->max('end_tamatkontrak')){
                        $end =$layak->max('end_bolehmohon');
                        $start = $layak->min('start_bolehmohon');
                      $model = \app\models\kontrak\Kontrak::find()->where(['icno' => $biodatas->ICNO])->andWhere(['and', "tarikh_m<='$end'", "tarikh_m>='$start'"])->one();  
                      if(!$model){?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $biodatas->CONm; ?></td>
                            <td class="text-center"><?php echo $biodatas->jawatan->nama; ?></td>
                            <td class="text-center"><?php echo $biodatas->department->shortname; ?></td>
                            <td class="text-center"><?php echo $biodatas->statusLantikan->ApmtStatusNm; ?></td>
                            <td class="text-center"><?php echo $biodatas->tarikhmulalantik; ?></td>
                            <td class="text-center"><?php echo $biodatas->tarikhtamatlantik; ?></td>
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