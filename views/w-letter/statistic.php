<?= $this->render('menu') ?>  


    <div class="x_panel"> 
        <div class="x_title">
            <h2>Rekod Bulan <?= $month; ?> (2020)</h2>   
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="headings"> 
                            <th>Department</th> 
                            <?php
                            $day = cal_days_in_month(CAL_GREGORIAN, $month, 2020);
                            for ($i = 1; $i <= $day; $i++) {
                                ?>
                                <th> <?= $i; ?></th>  
                            <?php } ?> 
                            <th style="width:1px;white-space:nowrap">Total by Month (Department)</th> 
                        </tr> 
                    </thead>
                    <?php
                    if ($department) {
                        $counter = 0;
                        foreach ($department as $department) {
                            $counter = $counter + 1;
                            $bg = "#FFFFFF";
                            ?>

                            <tr> 
                                <td style="width:1px;white-space:nowrap" bgcolor=<?= $bg; ?>><?= $department->fullname; ?></td> 

                                <?php for ($i = 1; $i <= $day; $i++) { ?>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->getTotalByDeptDay($department->id, $i, $month); ?></td>  
                                <?php } ?> 
                                    <td class="text-center" bgcolor=<?= $bg; ?>><?= $permohonan->getTotalByMonth($department->id, $month); ?></td>  

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
        </div>
    </div>    

