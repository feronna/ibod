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
                    <td style="width:1px;white-space:nowrap">BENDAHARI</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('BN'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('BN', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('BN', $month); ?></td>   
                </tr> 
                 <tr> 
                    <td style="width:1px;white-space:nowrap">JTMK</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('JTMK'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('JTMK', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('JTMK', $month); ?></td>   
                </tr>
                
                <tr>  
                    <td style="width:1px;white-space:nowrap">JPP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('JPP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('JPP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('JPP', $month); ?></td>   
                </tr>
                <tr>  
                    <td style="width:1px;white-space:nowrap">PNRF</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PNRF'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PNRF', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PNRF', $month); ?></td>   
                </tr> 
                
                <tr>  
                    <td style="width:1px;white-space:nowrap">HEP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('HEP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('HEP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('HEP', $month); ?></td>   
                </tr> 
                
                <tr>  
                    <td style="width:1px;white-space:nowrap">PPDM</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPDM'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPDM', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPDM', $month); ?></td>   
                </tr> 
                
                <tr>  
                    <td style="width:1px;white-space:nowrap">BPG</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('BPG'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('BPG', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('BPG', $month); ?></td>   
                </tr> 
                
                <tr>  
                    <td style="width:1px;white-space:nowrap">KKTM</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('KKTM'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('KKTM', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('KKTM', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">KKTF</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('KKTF'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('KKTF', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('KKTF', $month); ?></td>   
                </tr>
                
                <tr>  
                    <td style="width:1px;white-space:nowrap">KOLEJ KINGFISHER</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('KINGFISHER'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('KINGFISHER', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('KINGFISHER', $month); ?></td>   
                </tr>
            </table>
        </div> 
        
        
    </div>
</div>    

