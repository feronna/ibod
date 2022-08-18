<?php

use yii\helpers\Html;
?> 

<?= $this->render('menu') ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2>Jadual <?= $department->fullname; ?> - <?= $month . '/' . date('Y'); ?></h2>   

        <p align="right">
            <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        </p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table">
                <thead>
                    <tr class="headings"> 
                        <th>Bil</th> 
                        <th>Nama</th> 
                        <?php
                        $day = cal_days_in_month(CAL_GREGORIAN, $month, 2020);
                        for ($i = 1; $i <= $day; $i++) {
                            ?>
                            <th> <?= $i; ?></th>  
                        <?php } ?>  
                    </tr> 
                </thead>
                <?php
                if ($user) {
                    $counter = 0;
                    foreach ($user as $user) {
                        $counter = $counter + 1;
                        ?> 
                        <tr> 
                            <td><?= $counter; ?></td> 
                            <td style="width:1px;white-space:nowrap"><?= $user->CONm; ?></td> 

                            <?php
                            $wfo = 0;
                            for ($i = 1; $i <= $day; $i++) {
                                if ($permohonan->getStatusWorkingReportBsm($user->ICNO, $month, $i) == 0) {
                                    $bg = "#ffffff";
                                    $color = "#2A3F54";
                                } else {
                                    $bg = "#2A3F54";
                                    $color = "#ffffff";
                                    $wfo++;
                                }
                                ?>
                                <th style="color:<?= $color ?>" bgcolor=<?= $bg; ?>><?= $permohonan->getStatusWorkingReportBsm($user->ICNO, $month, $i); ?></th>  
                            <?php } ?>  


                        </tr> 


                    <?php }
                    ?> 
                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">JUMLAH ESSENTIAL 100%</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getTotalEssential('E100', $i, $month); ?></th>  
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">JUMLAH ESSENTIAL 30%</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getTotalEssential('E30', $i, $month);?></th>  
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">JUMLAH NON-ESSENTIAL 10%</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getTotalEssential('NE10', $i, $month); ?></th>  
                        <?php } ?>
                    </tr>
                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">JUMLAH NON-ESSENTIAL</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getTotalEssential('NE', $i, $month); ?></th>  
                        <?php } ?>
                    </tr>
                    <tr> 

                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">JUMLAH KESELURUHAN</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getWorkingbyDayBsm($department->id, $i, $month); ?></th>  
                        <?php } ?>
                    </tr>

                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">PERATUS KEHADIRAN JFPIU</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getWorkingPercentBsm($department->id, $i, $month); ?></th>  
                        <?php } ?>
                    </tr>

                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">BILANGAN KAKITANGAN JFPIU</td> 

                        <td colspan="<?= $day; ?>" style="color:red;" class="text-center"><?= $total_user; ?></td> 
                    </tr>

                <?php } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                <?php }
                ?>
            </table>
        </div> 

    </div>
</div>    

