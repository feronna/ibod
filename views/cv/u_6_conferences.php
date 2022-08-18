<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">CONFERENCES <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  

        <?php
        $data = array($biodata->persidanganAhliPanel, $biodata->persidanganKetuaSesi, $biodata->persidanganKeynoteSpeaker, $biodata->persidanganPembentang
            , $biodata->persidanganPembentangJemputan, $biodata->persidanganPembentangPoster, $biodata->persidanganPengerusi
            , $biodata->persidanganPeserta, $biodata->persidanganTiadaData);
        for ($i = 0; $i < count($data); $i++) {

            $persidangan = $data[$i];
            if ($persidangan) {
                ?> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <tr> 
                            <th>No.</th>  
                            <th>Role</th>  
                            <th style="width: 30%;">Article's Title</th>
                            <th>Conference/Seminar Title</th>  
                            <th style="width: 10%;">Date</th>
                            <th style="width: 10%;">Level</th>
                            <th style="width: 15%;">Venue</th> 
                            <th style="width: 10%;">Status</th>
                        </tr> 

                        <?php
                        $counter = 0;
                        foreach ($persidangan as $persidangan) {
                            $counter = $counter + 1;
                            ?> 

                            <tr>
                                <td><?= $counter; ?></td>  
                                <td><?= $persidangan->Peranan ? ucwords(strtolower($persidangan->Peranan)) : ' '; ?></td> 
                                <td><?= $persidangan->TajukKertas ? ucwords(strtolower($persidangan->TajukKertas)) : ' '; ?> </td>  
                                <td><?= $persidangan->TajukPersidangan ? ucwords(strtolower($persidangan->TajukPersidangan)) : ' '; ?></td> 
                                <td><?= $persidangan->Mula ? $persidangan->Mula : ''; ?> - <?= $persidangan->Tamat ? $persidangan->Tamat : ''; ?></td>
                                <td><?= $persidangan->Peringkat ? ucwords(strtolower($persidangan->Peringkat)) : ' '; ?></td> 
                                <td><?= $persidangan->Tempat ? ucwords(strtolower($persidangan->Tempat)) : ' '; ?> </td>
                                <td><?= $persidangan->StatusConference ? ucwords(strtolower($persidangan->StatusConference)) : ' '; ?> </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//                echo '<br/> No data - (SUMBER + dbo.vw_Conference)';
            }
        }
        ?>  

    </div> 
</div>  
