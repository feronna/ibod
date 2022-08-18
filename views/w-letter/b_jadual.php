<?php

use yii\helpers\Html; 
?> 

<?= $this->render('menu') ?> 
<div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel"> 
        <div class="x_title">
            <h2>Jadual <?=$department->fullname; ?> - <?= date('m').'/'.date('Y'); ?></h2>   
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table">
                    <thead>
                        <tr class="headings"> 
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
                                <td><?= $user->CONm; ?></td> 

                                <?php
                                for ($i = 1; $i <= $day; $i++) {
                                    if ($permohonan->getStatusWorking($user->ICNO, $i) == 0) {
                                        $bg = "#ffffff";
                                        $color = "#2A3F54";
                                    } else {
                                        $bg = "#2A3F54";
                                        $color = "#ffffff";
                                    }
                                    ?>
                                <th style="color:<?= $color ?>" bgcolor=<?= $bg; ?>><?= $permohonan->getStatusWorking($user->ICNO, $i); ?></th>  
                                <?php } ?>  

                            </tr> 

                        <?php }
                        ?> 


                    <?php } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Tiada Rekod</td>                     
                        </tr>
                    <?php }
                    ?>
                </table>
            </div>
            
            <div class="form-group text-right"> 
                <br/><br/>
            <?= Html::a('Hantar', ['mohon-by-jabatan', 'dept' => $department->id], ['class' => 'btn btn-primary']); ?>  
        </div>
            
        </div>
    </div>   
</div>
 

