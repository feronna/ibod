<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> LNPT</strong></h2>
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
                                    <th class="text-center">Average Mark</th>
                                </tr>
                            </thead>
                                <tr>
                                    <td class="text-center"><?php echo date('Y')-1; ?></td>
                                    <td class="text-center"><?= $model->markahlnpt(date('Y')-1)=='0'? '': $model->markahlnpt(date('Y')-1); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo date('Y')-2; ?></td>
                                    <td class="text-center"><?= $model->markahlnpt(date('Y')-2); ?></td>
                                </tr>
                                <tr>
                                   <td class="text-center"><?php echo date('Y')-3; ?></td>
                                   <td class="text-center"><?= $model->markahlnpt(date('Y')-3); ?></td>
                                </tr>
                         </table>
                    </div>
                </div>
            </div>
        </div>