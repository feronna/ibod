<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">DESIGNER COMPETITION <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   

        <?php
        $data1 = array($biodata->pertandinganPerekaKetua, $biodata->pertandinganPerekaAhli);
        for ($i = 0; $i < count($data1); $i++) {

            $pereka = $data1[$i];
            if ($pereka) {
                ?> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr> 
                            <th style="width: 5%;">No.</th>  
                            <th style="width: 10%;">Role</th> 
                            <th style="width: 10%;">Year</th>
                            <th style="width: 50%;">Title</th>
                            <th>Level</th>   
                        </tr> 

                        <?php
                        $counter = 0;
                        foreach ($pereka as $pereka) {
                            $counter = $counter + 1;
                            ?>  
                            <tr>
                                <td><?= $counter; ?></td>  
                                <td><?= $pereka->Peranan ? $pereka->Peranan : ' '; ?></td> 
                                <td><?= $pereka->Tahun ? $pereka->Tahun : ' '; ?></td> 
                                <td><?= $pereka->KodPereka ? $pereka->KodPereka : ' '; ?></td> 
                                <td><?= $pereka->Tahap ? $pereka->Tahap : ' '; ?></td> 
                            </tr> 
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//            echo '<br/> No data - (SUMBER + dbo.vw_LNPT_PertandinganPereka)<br/>';
            }
        }
        ?> 

    </div> 
</div>  
