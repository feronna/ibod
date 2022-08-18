<div class="table-responsive">
    <?php
    if ($biodata->badanprofesional) {
        $badanprofesional = $biodata->badanprofesional;
        ?>
        <table class="table table-sm table-bordered jambo_table table-striped">  
            <tr>
                <th>Name </th>
                <th>Level</th>
                <th>No. Membership</th>
                <th>Position</th>
                <th>Date</th>
                <th>Fee</th>
                <th>Verified</th> 
            </tr>  
            <?php
            if ($badanprofesional) {

                foreach ($badanprofesional as $badanprofesionalkakitangan) {
                    ?>

                    <tr>
                        <td><?= $badanprofesionalkakitangan->nambadanprofesional ?></td>
                        <td><?= $badanprofesionalkakitangan->peringkat ? $badanprofesionalkakitangan->peringkat->LvlNm : '-' ?></td>
                        <td><?= $badanprofesionalkakitangan->membership_no ? $badanprofesionalkakitangan->membership_no : '-' ?></td>
                        <td><?= $badanprofesionalkakitangan->jaw ?></td>
                        <td><?= $badanprofesionalkakitangan->tarikhmula ?> <?= $badanprofesionalkakitangan->ResignDt ? ' - ' . $badanprofesionalkakitangan->tarikhakhir : ''; ?></td>
                        <td><?= $badanprofesionalkakitangan->yuran ?></td> 
                        <td><?= $badanprofesionalkakitangan->isVerified ? 'Yes' : 'No'; ?></td>       
                    </tr>

                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="text-center">Tiada Rekod</td>                     
                </tr>
                <?php }
            ?>
        </table>
    <?php } ?>    
</div>