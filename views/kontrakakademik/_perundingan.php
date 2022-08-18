
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Consultancy</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <i>[FROM SMP-PPI]</i>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if($model->icno == Yii::$app->user->getId()){?>
                    <h2 style="color:green">Filter by 'End Date' Based on Current Contract {<?= $model->startdatelantik?> - <?= $model->enddatelantik?>}</h2><?php }?>
            <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Consultancy Title</th>
                                    <th class="text-center">Funder</th>
                                    <th class="text-center">Grant Amount (RM)</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Leader / Member</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                             <?php
                            if ($model->perundingan) { $bil1=1;?>
                                <?php foreach ($model->perundingan as $l) {?>
                                <tr>
                                    <td class="text-center"><?= $bil1 ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center"><?php echo $l->Company; ?></td>
                                    <td class="text-center"><?php echo number_format($l->TotalCost, 2); ?></td>
                                    <td class="text-center"><?php echo $l->startDate; ?></td>
                                    <td class="text-center"><?php echo $l->endDate; ?></td>
                                    <td class="text-center"><?php echo $l->membership; ?></td>
                                    <td class="text-center"><?php echo $l->KeteranganBI_StatusPenyelidikan; ?></td>
                                </tr>

                            <?php $bil1++; } }else { ?>
                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>