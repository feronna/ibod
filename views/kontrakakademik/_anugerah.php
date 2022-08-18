        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> List of Awards</strong></h2>
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
                                    <th class="text-center">Name of Award</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Awarded By</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Date</th>
                                </tr>
                           </thead>
                            <?php
                            if ($model->anugerah) { $bil1=1;?>
                                <?php foreach ($model->anugerah as $l) {
                                    if(date_format(date_create($l->AwdCfdDt), "Y") > (date('Y')-3)){?>
                                <tr>
                                    <td class="text-center"><?php echo $l->namaAnugerah->Awd; ?></td>
                                    <td class="text-center"><?php echo $l->gelaran->Title; ?></td>
                                    <td class="text-center"><?php echo $l->dianugerahkanOleh->CfdBy; ?></td>
                                    <td class="text-center"><?php echo $l->kategoriAnugerah->AwdCat; ?></td>
                                    <td class="text-center"><?php echo $l->awdCfdDt; ?></td>
                                </tr>

                                    <?php }} }else { ?>
                                <tr>
                                    <td colspan="5"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>