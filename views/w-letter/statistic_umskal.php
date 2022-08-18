<?= $this->render('menu') ?>  


    <div class="x_panel"> 
        <div class="x_title">
            <h2>Rekod Bulan <?= $month; ?> (2020)</h2>   
            <div class="clearfix"></div>
        </div>
        <div class="x_content">  
                 
         <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
           
                    <tr>  
                        <th>UMSKAL</th> 
                        <th>JUMLAH KAKITANGAN</th>
                        <?php
                        $day = cal_days_in_month(CAL_GREGORIAN, $month, 2020);
                        for ($i = 1; $i <= $day; $i++) {
                            ?>
                            <th> <?= $i; ?></th>  
                        <?php } ?> 
                        <th style="width:1px;white-space:nowrap">Total by Month (Department)</th> 
                    </tr>  
                <tr> 
                    <td style="width:1px;white-space:nowrap">E100</td> 
                    <td rowspan="3" class="text-center"><?= $permohonan->getJumlahKakitanganbyname('KESELAMATAN'); ?></td>  
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayUmskal('UMSKAL', $i, $month,'E100'); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthUmskal('UMSKAL', $month,'E100'); ?></td>   
                </tr> 
                 <tr> 
                    <td style="width:1px;white-space:nowrap">E40</td> 

                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayUmskal('UMSKAL', $i, $month,'E40'); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthUmskal('UMSKAL', $month,'E40'); ?></td>   
                </tr>
                 <tr> 
                    <td style="width:1px;white-space:nowrap">NE30</td> 

                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayUmskal('UMSKAL', $i, $month,'NE30'); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthUmskal('UMSKAL', $month,'NE30'); ?></td>   
                </tr>
                 
            </table>
        </div>
        </div>
    </div>    

