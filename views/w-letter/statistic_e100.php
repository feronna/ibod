<?= $this->render('menu') ?>  


<div class="x_panel"> 
    <div class="x_title">
        <h2>ESSENTIAL SERVICE <?= $month; ?> (2020)</h2>   
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  

        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr>  
                    <th>DEPARTMENT</th> 
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
                    <td style="width:1px;white-space:nowrap">KESELAMATAN</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('KESELAMATAN'); ?></td>   
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('KESELAMATAN', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('KESELAMATAN', $month); ?></td>   
                </tr> 
                <tr> 
                    <td style="width:1px;white-space:nowrap">HUMS</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('HUMS'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('HUMS', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('HUMS', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">FPSK</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FPSK'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FPSK', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FPSK', $month); ?></td>   
                </tr>
                <tr>  
                    <td style="width:1px;white-space:nowrap">PKKP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PKKP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PKKP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PKKP', $month); ?></td>   
                </tr> 
            </table>
        </div> 


    </div>
</div>    

