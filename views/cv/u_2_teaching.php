<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">TEACHING</p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <?php
        foreach ($biodata->pengajaranKategoriSelf as $type) {
            $typeN = $type->KATEGORIPELAJAR? $type->KATEGORIPELAJAR:'TIADA MAKLUMAT';
            ?>

            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>   
                        <th colspan="7">CATEGORY: <?= $typeN; ?></th>   
                    </tr>
                    <tr>   
                        <th>No.</th>   
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>No. Of Students</th>
                        <th>Section</th> 
                        <th>Credit Hour</th> 
                        <th>Session</th>  
                    </tr>
                    <?php
                    $pengajaran = $biodata->pengajaranbyKategori;
                    if ($pengajaran) {
                        $counter = 0;
                        foreach ($pengajaran as $pengajaran) {
                            $check = $pengajaran->KATEGORIPELAJAR ? $pengajaran->KATEGORIPELAJAR : '';
                            if ($check == $typeN) {

                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td> 
                                    <td> <?= $pengajaran->SMP07_KodMP ? $pengajaran->SMP07_KodMP : ' '; ?> </td> 
                                    <td> <?= $pengajaran->NAMAKURSUS ? $pengajaran->NAMAKURSUS : ' '; ?> </td> 
                                    <td> <?= $pengajaran->BILPELAJAR ? $pengajaran->BILPELAJAR : ' '; ?> </td> 
                                    <td> <?= $pengajaran->SEKSYEN ? $pengajaran->SEKSYEN : ' '; ?> </td> 
                                    <td> <?= $pengajaran->JAMKREDIT ? $pengajaran->JAMKREDIT : ' '; ?> </td> 
                                    <td> <?= $pengajaran->SESI ? $pengajaran->SESI : ' '; ?> </td> 
                                </tr>

                                <?php
                            }
                        }
                    }
                    ?>  
                </table>
            </div> 
            <?php } ?>
            <br/> 

            <?php
//            $pengajaranM = $biodata->userlnpt ? $biodata->userlnpt->pengajaranManual : '';
//            if ($pengajaranM) {
            ?>
    <!--                <span style="color: red;">** Information taken from LNPT UMS </span>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">

                            <tr> 
                                <th class="text-center" colspan="15">TEACHING MANUAL</th> 
                            </tr>  
                            <tr>   
                                <th>No.</th>  
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>No. Of Students</th>
                                <th>Section</th> 
                                <th>Credit Hour</th> 
                                <th>Session</th> 
                            </tr> -->

            <?php
//                        $counter = 0;
//                        foreach ($pengajaranM as $pengajaranM) {
//                            $counter = $counter + 1;
            ?> 

    <!--                            <tr>
                                    <td><?php // $counter;   ?></td>  
                                    <td> <?php // $pengajaranM->kod_kursus ? $pengajaranM->kod_kursus : ' ';   ?> </td> 
                                    <td> <?php // $pengajaranM->nama_kursus ? $pengajaranM->nama_kursus : ' ';   ?> </td> 
                                    <td> <?php // $pengajaranM->bil_pelajar ? $pengajaranM->bil_pelajar : ' ';   ?> </td> 
                                    <td> <?php // $pengajaranM->seksyen ? $pengajaranM->seksyen : ' ';   ?> </td> 
                                    <td> <?php // $pengajaranM->jam_kredit ? $pengajaranM->jam_kredit : ' ';   ?> </td> 
                                    <td> <?php // $pengajaranM->sesi ? $pengajaranM->sesi : ' ';   ?> </td>  
                                </tr>-->

            <?php
//                        }
            ?>
            <!--                    </table>
                            </div>-->
            <?php
//            } else {
////                echo 'No data - (SUMBER + elnpt.tbl_pengajaran_pembelajaran)<br/>';
//            }
            ?> 



    </div> 
</div>  
</div>  


