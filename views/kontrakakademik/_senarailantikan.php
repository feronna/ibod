<div class="row"> 
            <div class="x_panel">
       
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> List of Appointments</strong></h2>
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
                                <th class="text-center">No</th>
                                <th class="text-center">Status of Appointment</th>
                                <th class="text-center">Date of Appointment</th>
                                <th class="text-center">Date of Expiry</th>
                            </tr>
                            </thead>
                            <?php 
                            if ($model->lantikan) { $bil=1;?>
                                <?php foreach ($model->lantikan as $l) { ?>
                            <tr>
                                <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                <td class="text-center"><?php echo $l->statusLantikan->ApmtStatusNm; ?></td>
                                <td class="text-center"><?php echo $l->tarikhmulalantikan; ?></td>
                                <td class="text-center"><?php echo $l->tarikhtamatlantikan; ?></td>
                            </tr>
                                <?php } ?>
                            <?php } else { ?>

                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>