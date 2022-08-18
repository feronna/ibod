<?php if ($biodata->jawatan->job_category == 1) { ?>

    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped">   
            <tr>
                <th>No.</th>
                <th style="width: 15%;">Group</th> 
                <th>Area</th> 
                <th style="width: 10%;">Date Approved</th>   
            </tr>  
            <?php
            $kepakaran = $biodata->kepakaran;
            if ($kepakaran) {
                $counter = 0;
                foreach ($kepakaran as $kepakaran) {
                    $counter = $counter + 1;
                    ?> 

                    <tr>
                        <td><?= $counter; ?></td>
                        <td><?= $kepakaran->Groups ? $kepakaran->Groups : ' '; ?></td>
                        <td><?= $kepakaran->Area ? $kepakaran->Area : ''; ?></td> 
                        <td><?= $kepakaran->TarikhLulus ? DATE('Y-m-d', strtotime($kepakaran->TarikhLulus)) : ''; ?></td>   
                    </tr> 
                    <?php
                }
            } else {
                ?> 
                <tr>
                    <td colspan="4" class="text-center">No Information</td>
                </tr> 
            <?php }
            ?>
            <tr>
                <td colspan="4" class="text-center"><b>Source</b>: SMPPI</td>
            </tr>
        </table>
    </div>
<?php } else { ?>

    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped">   
            <tr>
                <th>No.</th>
                <th>Cluster</th>
                <th>Major</th>  
            </tr>
            <?php
            $bidangkepakaran = $biodata->bidangKepakaran;
            if ($bidangkepakaran) {
                $counter = 0;
                foreach ($bidangkepakaran as $bidangkepakarankakitangan) {
                    $counter = $counter + 1;
                    ?>

                    <tr>
                        <td><?= $counter; ?></td>
                        <td><?= $bidangkepakarankakitangan->klusterid ? $bidangkepakarankakitangan->bidangKepakaran->kluster : 'Tidak Berkaitan'; ?></td>
                        <td><?= $bidangkepakarankakitangan->bidang; ?></td>   
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="3" class="text-center">No Information</td>                     
                </tr>
            <?php }
            ?>
            <tr>
                <td colspan="4" class="text-center"><b>Source</b>: HrOnline</td>
            </tr>
        </table>
    </div>

<?php } ?>