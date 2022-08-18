<?php
use app\models\kehadiran\TblWarnaKad;

?>
<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">  
                            <tr>
                                <th class="text-center" rowspan="2">Year</th>
                                <th class="text-center" colspan="3">Color Card</th> 
                                <th class="text-center" rowspan="2">Achievement</th> 
                            </tr> 
                            <tr> 
                                <th class="text-center">YELLOW</th> 
                                <th class="text-center">GREEN</th> 
                                <th class="text-center">RED</th> 
                            </tr> 
                            <?php
                            for ($i = 0; $i <= 2; $i++) {
                                $tahun = date('Y') - $i;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $tahun ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'YELLOW') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'GREEN') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'RED') ?></td> 
                                    <td class="text-center"><?= TblWarnaKad::prestasiWarnaKad($tahun, $biodata->ICNO) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>