<div class="table-responsive">
    <?php
    if ($biodata->medicalCertificate) {
        $cert = $biodata->medicalCertificate;
        ?>
        <table class="table table-sm table-bordered jambo_table table-striped">  
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Date Awarded</th>
                <th>Certificate No.</th>
                <th>Date</th> 
                <th>Awarded By</th>
                <th>Verified</th> 
            </tr> 
            <?php
            foreach ($cert as $cert) {
                ?>
                <tr>
                    <td><?= $cert->title ?></td>
                    <td><?= $cert->certType ? $cert->certType->certType : '-'; ?></td>
                    <td><?= $cert->dateAwd ?></td>
                    <td><?= $cert->certNo ?></td>
                    <td><?= $cert->fullDate ?></td> 
                    <td><?= $cert->awardBy ?></td>
                    <td><?= $cert->isVerified? 'Yes':'No'; ?></td> 
                </tr>

            <?php } ?> 
        </table>
    <?php } ?>
</div>