<div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
                                    if ($biodata->adminPosition) {
                                        $bil1 = 1;
                                        ?>
                                        <tr>
                                            <th class="text-center">Position</th> 
                                            <th class="text-center">Status</th>
                                            <!--<th class="text-center">Description</th>-->
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Campus</th>
                                            <th class="text-center">Position Assigned</th>
                                            <th class="text-center">Date</th> 
                                            <th class="text-center">Period</th> 
                                        </tr>
                                        <?php
                                        $y = 0;
                                        $m = 0;
                                        $d = 0;
                                        foreach ($biodata->adminPosition as $l) {
                                            ?>

                                            <tr>
                                                <td class="text-center"><?= $l->adminpos ? $l->adminpos->position_name : ''; ?></td> 
                                                <td class="text-center"><?= $l->jobStatus0 ? $l->jobStatus0->jobstatus_desc : ''; ?></td>
                                                <!--<td class="text-center"><?php // $l->description ? $l->description : '';        ?></td>-->
                                                <td class="text-center"><?= $l->dept ? $l->dept->fullname : ''; ?></td>
                                                <td class="text-center"><?= $l->campus ? $l->campus->campus_name : ''; ?> </td>
                                                <td class="text-center" style="width: 10%;"><?= $l->appoinment_date ? $l->appoinment_date : ''; ?></td>
                                                <td class="text-center" style="width: 10%;"><?= $l->start_date ? $l->start_date : ''; ?> - <?= $l->end_date ? $l->end_date : ''; ?></td> 
                                                <td class="text-center" style="width: 10%;"><?= $l->tempoh ? $l->tempoh : ''; ?></td>

                                                <?php
                                                $curdays = 29;
                                                if ($l->getTempohType('%d') > 29) {
                                                    $curdays = $l->getTempohType('%d');
                                                }
                                                $y = $y + $l->getTempohType('%y');
                                                $m = $m + $l->getTempohType('%m');
                                                $d = $d + $l->getTempohType('%d');
                                                ?> 
                                            </tr>

                                            <?php
                                        }
                                        $dtoadd = intdiv($d, $curdays);
                                        $dbal = fmod($d, $curdays);

                                        $mtoadd = intdiv(($m + $dtoadd), 12);
                                        $mbal = fmod(($m + $dtoadd), 12);

                                        $totaly = $y + $mtoadd;
                                        ?>
                                        <tr>
                                            <td class="text-right" colspan="6">Total Period: </td>
                                            <td class="text-center"><?= $totaly . ' Year ' . $mbal . ' Month ' . $dbal . ' Day ' ?></td>
                                            <?php
                                        }
                                        ?>
                                </table>
                            </div>