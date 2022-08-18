<?php
error_reporting(0);
?>

<div class="row"> 
    <div class="x_panel">
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">No</th>
                    <th class="text-center">Programme</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Level</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Point</th>
                </tr>
               </thead>
                <?php
                if ($model) { $bil1=1;?>
                    <?php foreach ($model as $l) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_latihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->tarikhmulalatihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_peringkat; ?></td>
                            <td class="text-center"><?php echo $l->kategori->rck_deskripsi_aktiviti; ?></td>
                            <td class="text-center"><?php echo $l->vcl_jum_mata; ?></td>
                        </tr>
                <?php } }?>
            </table>
    </div>
        </div>
    </div>
</div>



