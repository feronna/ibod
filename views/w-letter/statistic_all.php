<?= $this->render('menu') ?>  


<div class="x_panel"> 
    <div class="x_title">
        <h2>ESSENTIAL SERVICE 100%</h2>   
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

<div class="x_panel"> 
    <div class="x_title">
        <h2>ESSENTIAL SERVICE 40%</h2>   
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

<div class="x_panel"> 
    <div class="x_title">
        <h2>NON-ESSENTIAL SERVICE 30%</h2>   
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
                    <td style="width:1px;white-space:nowrap">FSSA</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FSSA'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FSSA', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FSSA', $month); ?></td>   
                </tr> 
                <tr> 
                    <td style="width:1px;white-space:nowrap">FKJ</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FKJ'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FKJ', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FKJ', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">FPL</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FPL'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FPL', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FPL', $month); ?></td>   
                </tr>
                <tr>  
                    <td style="width:1px;white-space:nowrap">FKI</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FKI'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FKI', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FKI', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">FSSK</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FSSK'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FSSK', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FSSK', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">FPEP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FPEP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FPEP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FPEP', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">FKAL</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FKAL'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FKAL', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FKAL', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">FPP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FPP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FPP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FPP', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">FSMP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('FSMP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('FSMP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('FSMP', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">IPMB</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('IPMB'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('IPMB', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('IPMB', $month); ?></td>   
                </tr>

                <tr> 
                    <td style="width:1px;white-space:nowrap">IPB</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('IPB'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('IPB', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('IPB', $month); ?></td>   
                </tr> 
                <tr> 
                    <td style="width:1px;white-space:nowrap">IBTP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('IBTP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('IBTP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('IBTP', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">BORIIS</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('BORIIS'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('BORIIS', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('BORIIS', $month); ?></td>   
                </tr>
                <tr>  
                    <td style="width:1px;white-space:nowrap">PPIB</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPIB'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPIB', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPIB', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PASCA</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PASCA'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PASCA', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PASCA', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PPST</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPST'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPST', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPST', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PERPUSTAKAAN </td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PERPUSTAKAAN'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PERPUSTAKAAN', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PERPUSTAKAAN', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PPPI</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPPI'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPPI', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPPI', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PIPS</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PIPS'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PIPS', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PIPS', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">PLUMS</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PLUMS'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PLUMS', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PLUMS', $month); ?></td>   
                </tr>
                <tr> 
                    <td style="width:1px;white-space:nowrap">PML</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PML'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PML', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PML', $month); ?></td>   
                </tr> 
                <tr> 
                    <td style="width:1px;white-space:nowrap">SUKAN</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('SUKAN'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('SUKAN', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('SUKAN', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">PKPP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PKPP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PKPP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PKPP', $month); ?></td>   
                </tr>
                <tr>  
                    <td style="width:1px;white-space:nowrap">PKPKA</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PKPKA'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PKPKA', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PKPKA', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PKA</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PKA'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PKA', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PKA', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PIUMS</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PIUMS'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PIUMS', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PIUMS', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PENERBIT </td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PENERBIT'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PENERBIT', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PENERBIT', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PKLM</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PKLM'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PKLM', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PKLM', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PKLI</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PKLI'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PKLI', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PKLI', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">PEP</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PEP'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PEP', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PEP', $month); ?></td>   
                </tr>
                <tr> 
                    <td style="width:1px;white-space:nowrap">ECOCAMPUS</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('ECOCAMPUS'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('ECOCAMPUS', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('ECOCAMPUS', $month); ?></td>   
                </tr> 
                <tr> 
                    <td style="width:1px;white-space:nowrap">CIEW</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('CIEW'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('CIEW', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('CIEW', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">PPUU</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPUU'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPUU', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPUU', $month); ?></td>   
                </tr>
                <tr>  
                    <td style="width:1px;white-space:nowrap">PPPG</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPPG'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPPG', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPPG', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">PPSKK</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('PPSKK'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('PPSKK', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('PPSKK', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">CANSELORI</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('CANSELORI'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('CANSELORI', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('CANSELORI', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">AUDIT</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('AUDIT'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('AUDIT', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('AUDIT', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">BSM</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('BSM'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('BSM', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('BSM', $month); ?></td>   
                </tr> 

                <tr>  
                    <td style="width:1px;white-space:nowrap">BPA</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('BPA'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('BPA', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('BPA', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">BPQ</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('BPQ'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('BPQ', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('BPQ', $month); ?></td>   
                </tr>

                <tr>  
                    <td style="width:1px;white-space:nowrap">GAH</td> 
                    <td class="text-center"><?= $permohonan->getJumlahKakitanganbyname('GAH'); ?></td> 
                    <?php for ($i = 1; $i <= $day; $i++) { ?>
                        <td><?= $permohonan->getTotalByDeptDayE('GAH', $i, $month); ?></td>  
                    <?php } ?> 
                    <td class="text-center"><?= $permohonan->getTotalByMonthE('GAH', $month); ?></td>   
                </tr>
            </table>
        </div>  

    </div>
</div>  

<div class="x_panel"> 
        <div class="x_title">
            <h2>NON-ESSENTIAL SERVICE 30% (UMSKAL)</h2>   
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





