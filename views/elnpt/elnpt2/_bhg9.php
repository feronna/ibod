<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center">BIL.</th>
            <th class="text-center">KATEGORI KEPIMPINAN</th>
            <th class="text-center">SUMBER INPUT</th>
            <th class="text-center">BILANGAN</th>
        </tr>
        <?php
        if (empty($data)) {
        ?>
            <tr>
                <td colspan="6">Tiada rekod dijumpai.</td>
            </tr>
            <?php } else {
            $cnt = 1;
            foreach ($data as $ind => $dt) { ?>
                <tr>
                    <td class="text-center"><?= $cnt; ?></td>
                    <td><?= $dt['desc']; ?></td>
                    <td class="text-center"><?= $dt['sumber']; ?></td>
                    <td class="text-center"><?= $dt['bilangan']; ?></td>
                </tr>
        <?php $cnt++;
            }
        } ?>
    </table>
</div>
<hr>
<p><i>* Skor mentoring diambil kira untuk pensyarah gred DS53/DS54/DG54/DU54/DU56/VK sahaja.</i></p>