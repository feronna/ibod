<?php

use app\models\kehadiran\TblWp;
use app\models\cuti\SetPegawai;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-striped jambo_table table-bordered table-sm" style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">BIL </th>
                                <th class="column-title text-center">NAMA KAKITANGAN</th>
                                <th class="column-title text-center">JAWATAN</th>
                                <th class="column-title text-center">JFPIB</th>
                                <th class="column-title text-center">PEG. PERAKU</th>
                                <th class="column-title text-center">PEG. LULUS</th>
                                <th class="column-title text-center">WP SEMASA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($biodata) { ?>
                                <?php foreach ($biodata as $bio) { ?>
                                    <tr>
                                        <td><?= $bil++; ?></td>
                                        <td><?= $bio->CONm; ?></td>
                                        <td class="text-center"><?= $bio->jawatan->gred; ?></td>
                                        <td class="text-center"><?= $bio->department->shortname; ?></td>
                                        <td><?= SetPegawai::DisplayPeraku($bio->ICNO); ?></td>
                                        <td><?= SetPegawai::DisplayPelulus($bio->ICNO); ?></td>
                                        <td class="text-center"><?= TblWp::curr_wp($bio->ICNO, 1); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="6"><i>TIADA KAKITANGAN SELIAAN</i></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


