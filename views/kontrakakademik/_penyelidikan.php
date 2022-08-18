
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Research</strong></h2>
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
                                    <th class="text-center">Research Title</th>
                                    <th class="text-center">Funder</th>
                                    <th class="text-center">Grant Amount (RM)</th>
                                    <th class="text-center">Year Awarded</th>
                                    <th class="text-center">Period of Funding</th>
                                    <th class="text-center">Leader / Member</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                             <?php
                            if ($model->penyelidikan) { $no=0;?>
                                <?php foreach ($model->penyelidikan as $l) {$no++;?>
                                 <tr>
                                     <td class="text-center"><?=$no?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center"><?php echo $l->AgencyName; ?></td>
                                    <td class="text-center"><?php echo number_format($l->Amount,2); ?></td>
                                    <td class="text-center"><?php echo $l->Y; ?></td>
                                    <td class="text-center"><?php if($l->Duration){echo $l->Duration.' Months';} ?></td>
                                    <td class="text-center"><?php echo $l->Membership; ?></td>
                                    <td class="text-center"><?php echo $l->startDate; ?></td>
                                    <td class="text-center"><?php echo $l->endDate; ?></td>
                                    <td class="text-center"><?php echo $l->researchstatus; ?></td>
                                </tr>

                            <?php } }else { ?>
                                <tr>
                                    <td colspan="9"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
        </div>
    </div>
</div>