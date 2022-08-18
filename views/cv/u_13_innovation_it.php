<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">TECHNOLOGY INNOVATION <span style="color: red;">** Information taken from LNPT UMS (MANUAL) </span></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <?php
        $inovasi2 = $biodata->teknologiInvasi;
        if ($inovasi2) {
            $level = $biodata->teknologiInvasiLevel;
            foreach ($level as $level) {
                $levelN = $level->tahap_penyertaan;
                ?> 
                <div class="table-responsive"> 
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr> 
                            <th>Level</th> 
                            <th colspan="4"><?= $levelN; ?></th>  
                        </tr>
                        <tr> 
                            <th>No.</th>    
                            <th style="width: 10%;">Role</th>  
                            <th style="width: 50%;">Title</th>  
                            <th>Category</th> 
                            <th style="width: 15%;">Amount</th> 
                        </tr> 
                        <?php
                        $counter = 0;
                        foreach ($inovasi2 as $inovasi) {
                            $check = $inovasi->tahap_penyertaan ? $inovasi->tahap_penyertaan : ' ';
                            if ($check == $levelN) {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td>   
                                    <td><?= $inovasi->peranan ? $inovasi->peranan : ' '; ?></td> 
                                    <td><?= $inovasi->nama_projek ? $inovasi->nama_projek : ' '; ?></td> 
                                    <td><?= $inovasi->kategori ? $inovasi->kategori : ' '; ?></td>  
                                    <td><?= $inovasi->amaun ? '(RM' . sprintf('%0.2f', $inovasi->amaun) . ')' : ' '; ?></td>
                                </tr>



                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            }
        }
        ?>


    </div> 
</div>  
