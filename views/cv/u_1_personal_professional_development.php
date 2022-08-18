<?php
                    if ($biodata->jawatan->job_category == 1) {
                        $komp = $biodata->kompetensiAcademic;
                    } else {
                        $komp = $biodata->kompetensiAdmin;
                    }
                    foreach ($komp as $kompetensi) {
                        if ($biodata->idpKehadiran) {
                            ?>
                            <div class="table-responsive"> 
                                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                    <tr>
                                        <th class="text-center" style="width: 10%;">No.</th>  
                                        <th class="text-center" style="width: 15%;">Date</th>  
                                        <th><?= $kompetensi->kategori_nama_bi; ?> (2020 - 2022)</th>   
                                    </tr> 

                                    <?php
                                    $bil1 = 1;
                                    $arr = array();
                                    $date = date('Y');
                                    $date2 = date('Y') - 2;

                                    foreach ($biodata->idpKehadiran as $l) {
                                        if ($l->kategoriKursusID == $kompetensi->kategori_id) {
                                            if (date("Y", strtotime($l->tarikhMasa)) >= $date2 && date("Y", strtotime($l->tarikhMasa)) <= $date) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>

                                                    <td class="text-center"><?= $l->tarikhMasa ? date("Y-m-d", strtotime($l->tarikhMasa)) : ' '; ?></td>

                                                    <td><?= $l->slotID ? ucwords(strtolower($l->sasaran9->sasaran4->sasaran3->tajukLatihan)) : ' '; ?></td>

                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <?php
                        }
                    }
                    ?>    
