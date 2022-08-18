
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Annual Attendance Report</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Year</th>
                                    <th class="text-center">Late In</th>
                                    <th class="text-center">Incomplete</th>
                                    <th class="text-center">Absent</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                    <?php 
                    for($i=0; $i<=2 ; $i++){
                      $tahun = date('Y')-$i; ?>
                          <tr>
                            <td class="text-center"><?= $tahun ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1)?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 3) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 4) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1) +
                            $model->kehadiran($tahun, 3)+ 
                            $model->kehadiran($tahun, 4)
                            ?></td>
                        </tr><?php 
                    }
                    ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>