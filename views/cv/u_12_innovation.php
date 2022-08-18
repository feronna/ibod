<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">INNOVATION <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  
 

        <?php
        $data2 = array($biodata->inovasiLeader, $biodata->inovasiMember, $biodata->inovasiPresenter, $biodata->inovasiProfessionalService);
        for ($i = 0; $i < count($data2); $i++) {

            $inovasi = $data2[$i];
            if ($inovasi) {
                ?> 
                <div class="table-responsive"> 
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr> 
                            <th>No.</th>  
                            <th style="width: 10%;">Membership</th>
                            <th style="width: 10%;">Role</th>  
                            <th style="width: 40%;">Title</th> 
                            <th style="width: 10%;">Date</th> 
                            <th>Organisasi</th> 
                            <th style="width: 10%;">Status</th> 
                        </tr> 

                        <?php
                        $counter = 0;
                        foreach ($inovasi as $inovasi) {
                            $counter = $counter + 1;
                            ?> 

                            <tr>
                                <td><?= $counter; ?></td>  
                                <td><?= $inovasi->Keahlian ? $inovasi->Keahlian : ' '; ?></td>
                                <td><?= $inovasi->Peranan ? $inovasi->Peranan : ' '; ?></td>  
                                <td><?= $inovasi->Tajuk ? $inovasi->Tajuk : ' '; ?></td>
                                <td><?= $inovasi->TarikhMula ? Yii::$app->formatter->asDate($inovasi->TarikhMula, 'yyyy-MM-dd') : ' '; ?> - <?= $inovasi->TarikhAkhit ? Yii::$app->formatter->asDate($inovasi->TarikhAkhit, 'yyyy-MM-dd') : ' '; ?></td>
                                <td><?= $inovasi->Organisasi ? $inovasi->Organisasi : ' '; ?></td>  
                                <td><?= $inovasi->Status ? $inovasi->Status : ' '; ?></td>
                            </tr>



                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//            echo '<br/> No data - (SUMBER + dbo.Ext_PPI11_Inovasi)';
            }
        }
        ?> 
 

    </div> 
</div>  
