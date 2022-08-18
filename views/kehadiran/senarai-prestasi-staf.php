<?php

use app\models\kehadiran\TblWarnaKad;

$limit = ini_get('memory_limit');
ini_set('memory_limit', -1);
// ... do heavy stuff
ini_set('memory_limit', $limit);

?>

<div class="table-responsive">
    <table class="table table-striped table-sm jambo_table table-bordered">
        <thead>
            <tr class="headings">
                <th class="text-center">Bil</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Gred / Jawatan</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">JAFPIB</th>
                <th class="text-center">Prestasi Kehadiran <?=$year;?></th>
            </tr>
        </thead>
        <?php


 foreach ($biodata as $bio) { ?>
            <tr>
                <td class="text-center" style="text-align:center"><?= $bil++; ?></td>
                <td class="text-center" style="text-align:left"><?= $bio->CONm; ?></td>
                <td class="text-center" style="text-align:left"><?= $bio->jawatan->fname; ?></td>
                <td class="text-center" style="text-align:left"><?= $bio->jawatan->shortCat; ?></td>
                <td class="text-center" style="text-align:left"><?= $bio->department->fullname; ?></td>
                <td class="text-center" style="text-align:left"><?= TblWarnaKad::prestasiWarnaKad($year,$bio->ICNO); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>