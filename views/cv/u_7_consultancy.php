<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>   
<br/>
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">CONSULTANCY <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <?php
        $data = array($biodata->outreachingInternational, $biodata->outreachingNational, $biodata->outreachingUniversity, $biodata->outreachingNoData);
        for ($i = 0; $i < count($data); $i++) {

            $outreaching = $data[$i];
            if ($outreaching) {
                ?>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr>
                            <th colspan="10">CONSULTANCY</th>  
                        </tr>  
                        <tr>
                            <th>No.</th>
                            <th style="width: 15%;">Level</th> 
                            <th>Title</th>  
                            <th style="width: 10%;">Roles</th>
                            <th style="width: 10%;">Roles (Details)</th>
                            <th>Category</th>  
                            <th style="width: 10%;">Date</th> 
                            <th style="width: 15%;">Source (Amount)</th>  
                            <th>Status</th> 
                            <th>Verified</th> 
                        </tr>  
                        <?php
                        $counter = 0;
                        foreach ($outreaching as $outreaching) {
                            $counter = $counter + 1;
                            ?> 

                            <tr>
                                <td><?= $counter; ?></td>
                                <td><?= $outreaching->Peringkat ? $outreaching->Peringkat : ' '; ?></td>
                                <td><?= $outreaching->Tajuk ? $outreaching->Tajuk : ''; ?></td>  
                                <td><?= $outreaching->Keahlian ? $outreaching->Keahlian : ''; ?></td>  
                                <td><?= $outreaching->Peranan ? $outreaching->Peranan : ''; ?></td> 
                                <td><?= $outreaching->ConsultationType ? $outreaching->ConsultationType : ''; ?></td>
                                <td><?= $outreaching->TarikhMula ? $outreaching->TarikhMula : ' '; ?> <?= $outreaching->TarikhAkhit ? $outreaching->TarikhAkhit : ' '; ?></td>
                                <td><?= $outreaching->Jumlah ? '(RM' . sprintf('%0.2f', $outreaching->Jumlah) . ')' : ' '; ?></td>
                                <td><?= $outreaching->Status ? $outreaching->Status : ''; ?></td>
                                <td>
                                    <?php
                                    if ($outreaching->StatusPengesahan == 'V') {
                                        echo 'Yes';
                                    }
                                    ?>
                                </td>
                            </tr> 
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/> 
                <?php
            } else {
//            echo 'No data - (SUMBER + Ext_PPI04_Perundingan) <br/>';
            }
        }
        ?> 

    </div> 

</div>  
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">CONSULTANCY (CLINICAL) <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>  
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  

        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">   
                <tr>
                    <th>No.</th>
                    <th style="width: 15%;">Type</th> 
                    <th>Title</th> 
                    <th style="width: 10%;">Status</th> 
                    <th style="width: 10%;">Date</th>   
                    <th style="width: 10%;">Time (Start-End)</th>  
                    <th style="width: 10%;">Hour</th> 
                    <th>Verified</th> 
                </tr>  
                <?php
                $outreaching = $biodata->outreachingClinical;
                if ($outreaching) {
                    $counter = 0;
                    $totalHour = 0;
                    foreach ($outreaching as $outreaching) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>
                            <td><?= $outreaching->JenisRawatan ? $outreaching->JenisRawatan : ' '; ?></td>
                            <td><?= $outreaching->Rawatan ? $outreaching->Rawatan : ''; ?></td> 
                            <td><?= $outreaching->Status ? $outreaching->Status : ''; ?></td>  
                            <td><?= $outreaching->TarikhMula ? $outreaching->TarikhMula : ' '; ?></td> 
                            <td><?= $outreaching->JamMula ? Yii::$app->formatter->asTime($outreaching->JamMula) : ' '; ?> <?= $outreaching->JamTamat ? ' - ' . Yii::$app->formatter->asTime($outreaching->JamTamat) : ' '; ?></td> 
                            <td class="text-center">
                                <?php
                                $hour = $outreaching->JumlahJam ? $outreaching->JumlahJam : 0;
                                echo $hour;
                                $totalHour = $totalHour + $hour;
                                ?> 
                            </td> 
                            <td>
                                <?php
                                if ($outreaching->ApproveStatus == 'V') {
                                    echo 'Yes';
                                }
                                ?>
                            </td>
                        </tr> 
                        <?php
                    }
                    ?>
                    <tr>
                        <th colspan="6" class="text-right">Total Hour</th>
                        <th class="text-center"><?= $totalHour; ?></th>
                        <td></td>
                    </tr>
                    <?php
                } else {
                    ?> 
                    <td colspan="8" class="text-center">No Information</td>
                <?php }
                ?>
            </table>
        </div>
        <br/>  

    </div> 

</div>  
