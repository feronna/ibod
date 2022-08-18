<?php

use yii\helpers\Html;
?> 

<?= $this->render('menu') ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2>Jadual <?= $department->fullname; ?> - <?= date('m') . '/' . date('Y'); ?></h2>   
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
                        $day = cal_days_in_month(CAL_GREGORIAN, date('m'), 2020);
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
                                if ($permohonan->getStatusWorkingReport($user->ICNO, $i) == 0) {
                                    $bg = "#ffffff";
                                    $color = "#2A3F54";
                                } else {
                                    $bg = "#2A3F54";
                                    $color = "#ffffff";
                                    $wfo++;
                                }
                                ?>
                                <th style="color:<?= $color ?>" bgcolor=<?= $bg; ?>><?= $permohonan->getStatusWorkingReport($user->ICNO, $i); ?></th>  
                            <?php } ?>  


                        </tr> 


                    <?php }
                    ?> 
                    <tr> 
                        
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">JUMLAH KESELURUHAN</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getWorkingbyDay($department->id, $i); ?></th>  
                        <?php } ?>
                    </tr>
                    
                     <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">PERATUS KEHADIRAN JFPIU</td> 

                        <?php for ($i = 1; $i <= $day; $i++) { ?>
                            <th style="color:red;"><?= $permohonan->getWorkingPercent($department->id, $i); ?></th>  
                        <?php } ?>
                    </tr>
                    
                    <tr> 
                        <td colspan="2" style="color:#ffffff;" bgcolor="#2A3F54">BILANGAN KAKITANGAN JFPIU</td> 

                        <td colspan="<?=$day;?>" style="color:red;" class="text-center"><?= $total_user; ?></td> 
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

