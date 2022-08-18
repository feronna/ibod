<div class="col-md-3 col-sm-3 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-calendar"></i>&nbsp;Upcoming Events</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="bdwT-0">No</th>
                                <th class="bdwT-0">Name</th>
                                <th class="bdwT-0">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php $i=1; foreach($upevent as $s){?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td></td>
                                </tr>
                                <?php }?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>