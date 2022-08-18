<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>   
<br/>
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">SUPERVISION (UMS)  
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php
        $penyeliaan = $biodata->penyeliaanPHD;

        if ($penyeliaan) {
            ?> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">  
                    <tr>
                        <th colspan="10">Level : PHD</th>  
                    </tr>
                    <tr> 
                        <th style="width: 2%;">No.</th> 
                        <th>Student Name</th>  
                        <th>No Matric</th>  
                        <th>Faculty</th>  
                        <th>Program</th> 
                        <th>Role</th> 
                        <th style="width: 10%;">Date</th>
                        <th>Status</th>   
                        <th>Method Study</th>   
                        <th>PASCA/PLUMS</th>   
                    </tr> 
                    <?php
                    $counter = 0;
                    foreach ($penyeliaan as $penyeliaan) {

                        $counter = $counter + 1;
                        ?>  

                        <tr>   
                            <th><?= $counter; ?>.</th> 
                            <td><?= $penyeliaan->SMP01_Nama ? $penyeliaan->SMP01_Nama : ' '; ?></td>
                            <td><?= $penyeliaan->SMP01_Nomatrik ? $penyeliaan->SMP01_Nomatrik : ' '; ?> </td>  
                            <td><?= $penyeliaan->SMP01_Fakulti ? $penyeliaan->SMP01_Fakulti : ' '; ?></td>  
                            <td><?= $penyeliaan->SMP01_Kursus ? $penyeliaan->SMP01_Kursus : ' '; ?></td> 
                            <td><?= $penyeliaan->NamaBI ? $penyeliaan->NamaBI : ' '; ?></td> 
                            <td><?= $penyeliaan->SMP01_SesiDaftar ? $penyeliaan->SMP01_SesiDaftar : ' '; ?></td> 
                            <td><?= $penyeliaan->StatusBI ? $penyeliaan->StatusBI : ' '; ?></td>  
                            <td><?= $penyeliaan->MethodStudyName ? $penyeliaan->MethodStudyName : ' '; ?></td>  
                            <td><?= $penyeliaan->PASCA_PLUMS ? $penyeliaan->PASCA_PLUMS : ' '; ?></td> 
                        </tr> 

                        <?php
                    }
                    ?>
                </table>
            </div>
            <br/>
            <?php
        } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
        }
        ?> 

        <?php
        $penyeliaanM = $biodata->penyeliaanMASTER;

        if ($penyeliaanM) {
            ?> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">  
                    <tr>
                        <th colspan="10">Level : MASTER</th>  
                    </tr>
                    <tr> 
                        <th style="width: 2%;">No.</th> 
                        <th>Student Name</th>  
                        <th>No Matric</th>  
                        <th>Faculty</th>   
                        <th>Program</th> 
                        <th>Role</th>   
                        <th style="width: 10%;">Date</th>
                        <th>Status</th>   
                        <th>Method Study</th>
                        <th>PASCA/PLUMS</th>
                    </tr> 
                    <?php
                    $counter = 0;
                    foreach ($penyeliaanM as $penyeliaan) {

                        $counter = $counter + 1;
                        ?>  

                        <tr>   
                            <th><?= $counter; ?>.</th> 
                            <td><?= $penyeliaan->SMP01_Nama ? $penyeliaan->SMP01_Nama : ' '; ?></td>
                            <td><?= $penyeliaan->SMP01_Nomatrik ? $penyeliaan->SMP01_Nomatrik : ' '; ?> </td>  
                            <td><?= $penyeliaan->SMP01_Fakulti ? $penyeliaan->SMP01_Fakulti : ' '; ?></td> 
                            <td><?= $penyeliaan->SMP01_Kursus ? $penyeliaan->SMP01_Kursus : ' '; ?></td> 
                            <td><?= $penyeliaan->NamaBI ? $penyeliaan->NamaBI : ' '; ?></td> 
                            <td><?= $penyeliaan->SMP01_SesiDaftar ? $penyeliaan->SMP01_SesiDaftar : ' '; ?></td> 
                            <td><?= $penyeliaan->StatusBI ? $penyeliaan->StatusBI : ' '; ?></td>  
                            <td><?= $penyeliaan->MethodStudyName ? $penyeliaan->MethodStudyName : ' '; ?></td> 
                            <td><?= $penyeliaan->PASCA_PLUMS ? $penyeliaan->PASCA_PLUMS : ' '; ?></td> 
                        </tr> 

                        <?php
                    }
                    ?>
                </table>
            </div>
            <br/>
            <?php
        } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
        }
        ?> 



    </div> 

</div>  

<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">SUPERVISION (EXTERNAL)  
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php
        $penyeliaanLPHD = $biodata->penyeliaan2PHDLuar;

        if ($penyeliaanLPHD) {
            ?> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">  
                    <tr>
                        <th colspan="8">Level : PHD</th>  
                    </tr>
                    <tr> 
                        <th style="width: 2%;">No.</th> 
                        <th>Student Name</th>  
                        <th>No Matric</th>  
                        <th>Institute Name</th>   
                        <th>Role</th> 
                        <th style="width: 10%;">Date</th> 
                    </tr> 
                    <?php
                    $counter = 0;
                    foreach ($penyeliaanLPHD as $penyeliaan) {

                        $counter = $counter + 1;
                        ?>  

                        <tr>   
                            <th><?= $counter; ?>.</th> 
                            <td><?= $penyeliaan->NamaPelajar ? $penyeliaan->NamaPelajar : ' '; ?></td>
                            <td><?= $penyeliaan->Nomatrik ? $penyeliaan->Nomatrik : ' '; ?> </td>  
                            <td><?= $penyeliaan->NamaInstitut ? $penyeliaan->NamaInstitut : ' '; ?></td>   
                            <td><?= $penyeliaan->TahapPenyeliaan ? $penyeliaan->TahapPenyeliaan : ' '; ?></td>
                            <td><?= $penyeliaan->TahunKonvokesyen ? $penyeliaan->TahunKonvokesyen : ' '; ?></td> 


                        </tr> 

                        <?php
                    }
                    ?>
                </table>
            </div>
            <br/>
            <?php
        } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
        }
        ?> 

        <?php
        $penyeliaanLM = $biodata->penyeliaan2MASTERLuar;

        if ($penyeliaanLM) {
            ?> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">  
                    <tr>
                        <th colspan="8">Level : MASTER</th>  
                    </tr>
                    <tr> 
                        <th style="width: 2%;">No.</th> 
                        <th>Student Name</th>  
                        <th>No Matric</th>  
                        <th>Institute Name</th>   
                        <th>Role</th> 
                        <th style="width: 10%;">Date</th> 
                    </tr> 
                    <?php
                    $counter = 0;
                    foreach ($penyeliaanLM as $penyeliaan) {

                        $counter = $counter + 1;
                        ?>  

                        <tr>   
                            <th><?= $counter; ?>.</th> 
                            <td><?= $penyeliaan->NamaPelajar ? $penyeliaan->NamaPelajar : ' '; ?></td>
                            <td><?= $penyeliaan->Nomatrik ? $penyeliaan->Nomatrik : ' '; ?> </td>  
                            <td><?= $penyeliaan->NamaInstitut ? $penyeliaan->NamaInstitut : ' '; ?></td>   
                            <td><?= $penyeliaan->TahapPenyeliaan ? $penyeliaan->TahapPenyeliaan : ' '; ?></td>
                            <td><?= $penyeliaan->TahunKonvokesyen ? $penyeliaan->TahunKonvokesyen : ' '; ?></td> 


                        </tr> 

                        <?php
                    }
                    ?>
                </table>
            </div>
            <br/>
            <?php
        } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
        }
        ?>  

    </div> 

</div>  



