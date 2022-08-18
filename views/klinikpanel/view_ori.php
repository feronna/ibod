<?php
use yii\helpers\Html;

?>
<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th class="text-center">Nama Klinik</th>
                <th class="text-center">Tarikh Rawatan</th>
                <th class="text-center">ICNO Kakitangan</th>
                <th class="text-center">ICNO Pesakit</th>
                <th class="text-center">Nama Pesakit</th>                              
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model as $models) { ?>
                <tr>
                    <td class="text-center"><?= $models->klinik->nama; ?></td>
                    <td class="text-center"><?= $models->rawatan_date; ?></td>
                    <td class="text-center"><?= $models->visit_icno; ?></td>
                    <td class="text-center"><?= $models->pesakit_icno; ?></td>
                    <td class="text-center"><?= $models->pesakit_name; ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr class="headings">
                <th class="text-center">Nama Ubat</th>
                <th class="text-center">Unit/Kuantiti</th>
                <th class="text-center">Jumlah Harga (RM)</th>                             
                <th class="text-center">Kos Konsultasi (RM)</th>                             
                <th class="text-center">Jumlah Tuntutan (RM)</th>                             
            </tr>
            <tbody>
            <?php if ($model)  { ?>
            <?php foreach ($model as $models) { ?>
            <tr class="headings">
                <td class="text-center"><?= $models->ubat->namaUbat->medNm; ?></td>
                <td class="text-center"><?= $models->ubat->tblmed_unit; ?></td>
                <td class="text-center"><?= $models->ubat->tblmed_price; ?></td>                             
                <td class="text-center"><?= $models->id_konsultasi; ?></td>                             
                <td class="text-center"><?= $models->jum_tuntutan; ?></td>                             
            </tr>
            <?php } ?>
            
            <?php } ?>
        </tbody>
    </table>
</div>