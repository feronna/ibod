<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
<!--                                    <th class="text-center">Research Title</th>
                                    <th class="text-center">Funder</th>
                                    <th class="text-center">Grant Amount (RM)</th>
                                    <th class="text-center">Year Awarded</th>
                                    <th class="text-center">Period of Funding</th>
                                    <th class="text-center">Leader / Member</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Status</th>-->
                                      <th class="text-center">Tajuk Penyelidikan</th>
<!--                                    <th class="text-center">Funder</th>-->
                                    <th class="text-center">Geran Penyelidikan</th>
<!--                                    <th class="text-center">Year Awarded</th>
                                    <th class="text-center">Period of Funding</th>-->
                                    <th class="text-center">Penyelidik Utama atau Kedua</th>
<!--                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>-->
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                             <?php
                            if ($model->penyelidikan) { $bil1=1;?>
                                <?php foreach ($model->penyelidikan as $l) {?>
                                 <tr>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AgencyName; ?></td>-->
                                    <td class="text-center"><?php echo $l->GrantTypeDecs; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Y; ?></td>
                                    <td class="text-center"><?php if($l->Duration){echo $l->Duration.' Months';} ?></td>-->
                                    <td class="text-center"><?php echo $l->MembershipStatus; ?></td>
<!--                                    <td class="text-center"><?php echo $l->startDate; ?></td>
                                    <td class="text-center"><?php echo $l->endDate; ?></td>-->
                                    <td class="text-center"><?php echo $l->ResearchStatus; ?></td>
                                </tr>

                            <?php } }else { ?>
                                <tr>
                                    <td colspan="9"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>