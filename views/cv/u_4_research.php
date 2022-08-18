<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">RESEARCH <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th colspan="8">Role: Leader</th> 
                </tr>
                <tr>
                    <th>No</th>  
                    <th style="width: 40%;">Title</th> 
                    <th>Head-researchers <br/>(CO-researchers)</th> 
                     <th style="width: 10%;">Date</th> 
                    <th>Status</th> 
                    <th>Source of Funds (Agency Name)</th> 
                    <th>Amount</th> 
                </tr>  
                <?php
                $research = $biodata->researchLeader;
                if ($research) {
                    $counter = 0;
                    foreach ($research as $research) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td style="word-break: break-all;"><?= $research->Title ? $research->Title : '-'; ?></td> 
                            <td><?= $research->Researchers ? ucwords(strtolower($research->Researchers)) : '-'; ?></td> 
                            <td><?= $research->StartDate ? $research->StartDate : '-'; ?> - <?= $research->EndDate ? $research->EndDate : '-'; ?></td>
                            <td><?= $research->ResearchStatus ? $research->ResearchStatus : '-'; ?></td>
                            <td><?= $research->AgencyName ? $research->AgencyName : '-'; ?></td>
                            <td><?= $research->Amount ? '(RM' . number_format($research->Amount, 2) . ')' : ' '; ?></td>

                        </tr> 
                        <?php
                    }
                } else {
                    ?>
                         <tr>
                            <td class="text-center" colspan="8">No Information</td>
                         </tr>
                    <?php
                }
                ?>
            </table>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th colspan="8">Role: Member</th> 
                </tr>
                <tr>
                    <th>No</th> 
                    <th style="width: 40%;">Title</th>
                    <th>Head-researchers <br/>(CO-researchers)</th> 
                     <th style="width: 10%;">Date</th> 
                    <th>Status</th> 
                    <th>Source of Funds (Agency Name)</th> 
                    <th>Amount</th> 
                </tr>  
                <?php
                $research = $biodata->researchMember;
                if ($research) {
                    $counter = 0;
                    foreach ($research as $research) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td style="word-break: break-all;"><?= $research->Title ? $research->Title : '-'; ?></td> 
                            <td><?= $research->Researchers ? ucwords(strtolower($research->Researchers)) : '-'; ?></td> 
                            <td><?= $research->StartDate ? $research->StartDate : '-'; ?> - <?= $research->EndDate ? $research->EndDate : '-'; ?></td>
                            <td><?= $research->ResearchStatus ? $research->ResearchStatus : '-'; ?></td>
                            <td><?= $research->AgencyName ? $research->AgencyName : '-'; ?></td>
                            <td><?= $research->Amount ? '(RM' . number_format($research->Amount, 2) . ')' : ' '; ?></td>

                        </tr> 
                        <?php
                    }
                } else {
                    ?>
                         <tr>
                            <td class="text-center" colspan="8">No Information</td>
                         </tr>
                    <?php
                }
                ?>
            </table>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th colspan="8">Role: No Data</th> 
                </tr>
                <tr>
                    <th>No</th>  
                    <th style="width: 40%;">Title</th>
                    <th>Head-researchers <br/>(CO-researchers)</th> 
                     <th style="width: 10%;">Date</th> 
                    <th>Status</th> 
                    <th>Source of Funds (Agency Name)</th> 
                    <th>Amount</th> 
                </tr>  
                <?php
                $research = $biodata->researchNoData;
                if ($research) {
                    $counter = 0;
                    foreach ($research as $research) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td style="word-break: break-all;"><?= $research->Title ? $research->Title : '-'; ?></td> 
                            <td><?= $research->Researchers ? ucwords(strtolower($research->Researchers)) : '-'; ?></td> 
                            <td><?= $research->StartDate ? $research->StartDate : '-'; ?> - <?= $research->EndDate ? $research->EndDate : '-'; ?></td>
                            <td><?= $research->ResearchStatus ? $research->ResearchStatus : '-'; ?></td>
                            <td><?= $research->AgencyName ? $research->AgencyName : '-'; ?></td>
                            <td><?= $research->Amount ? '(RM' . number_format($research->Amount, 2) . ')' : ' '; ?></td>

                        </tr> 
                         <?php
                    }
                } else {
                    ?>
                         <tr>
                            <td class="text-center" colspan="8">No Information</td>
                         </tr>
                    <?php
                }
                ?>
            </table>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th colspan="8">Role: N/A</th> 
                </tr>
                <tr>
                    <th>No</th> 
                    <th style="width: 40%;">Title</th>
                    <th>Head-researchers <br/>(CO-researchers)</th> 
                     <th style="width: 10%;">Date</th> 
                    <th>Status</th> 
                    <th>Source of Funds (Agency Name)</th> 
                    <th>Amount</th> 
                </tr>  
                <?php
                $research = $biodata->researchNA;
                if ($research) {
                    $counter = 0;
                    foreach ($research as $research) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td style="word-break: break-all;"><?= $research->Title ? $research->Title : '-'; ?></td> 
                            <td><?= $research->Researchers ? ucwords(strtolower($research->Researchers)) : '-'; ?></td> 
                            <td><?= $research->StartDate ? $research->StartDate : '-'; ?> - <?= $research->EndDate ? $research->EndDate : '-'; ?></td>
                            <td><?= $research->ResearchStatus ? $research->ResearchStatus : '-'; ?></td>
                            <td><?= $research->AgencyName ? $research->AgencyName : '-'; ?></td>
                            <td><?= $research->Amount ? '(RM' . number_format($research->Amount, 2) . ')' : ' '; ?></td>

                        </tr> 
                        <?php
                    }
                } else {
                    ?>
                         <tr>
                             <td class="text-center" colspan="8">No Information</td>
                         </tr>
                    <?php
                }
                ?>
            </table>
        </div> 
    </div> 
</div>  
