<?php
$pengalaman = $biodata->pengalaman;
if ($pengalaman) {
    ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr>
                <th>No.</th> 
                <th>Position</th> 
                <th>Organization Name</th>
                <th>Sector</th> 
                <th>Type</th> 
                <th>Carry Services</th> 
                <th style="width: 10%;">Start Date</th>
                <th style="width: 10%;">End Date</th>
            </tr> 
            <?php
            $counter = 0;
            foreach ($pengalaman as $pengalaman) {
                $counter = $counter + 1;
                ?> 

                <tr>
                    <td><?= $counter; ?></td> 
                    <td><?= $pengalaman->PrevEmpRemarks ? $pengalaman->PrevEmpRemarks : ''; ?></td>
                    <td><?= $pengalaman->OrgNm ? $pengalaman->OrgNm : ''; ?></td>
                    <td> <?= $pengalaman->OccSectorCd ? $pengalaman->sektorPekerjaan->OccSector : ''; ?> </td>    
                    <td> <?= $pengalaman->CorpBodyTypeCd ? $pengalaman->jenisBadanMajikan->CorpBodyType : ''; ?> </td>
                    <td> <?php
                        if ($pengalaman->WithServices) {
                            if ($pengalaman->WithServices == 1) {
                                echo 'Ya';
                            } else {
                                echo 'Tidak';
                            }
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($pengalaman->PrevEmpStartDt == "0000-00-00") {
                            echo '';
                        } else {
                            echo $pengalaman->PrevEmpStartDt;
                        }
                        ?> 
                    </td>  
                    <td><?php
                        if ($pengalaman->PrevEmpEndDt == "0000-00-00") {
                            echo '';
                        } else {
                            echo $pengalaman->PrevEmpEndDt;
                        }
                        ?> 
                    </td>
                </tr> 

                <?php
            }
            ?>
        </table>
    </div>

    <?php
}
?>