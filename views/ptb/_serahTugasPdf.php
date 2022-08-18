<div style="margin-bottom: 20px;font-size: 11px">
    <table>
        <tr>
            <td>NAMA</td>
            <td>: <?= $model->pemohon_name?></td>
        </tr>
        <tr>
            <td>JAWATAN</td>
            <td>: <?=  strtoupper($model->position)?> GRED&nbsp;<?=  strtoupper($model->gred)?></td> 
        </tr>
         <tr>
            <td>JFPIU</td>
            <td>: <?=  strtoupper($model->oldDepartment->fullname)?></td>
        </tr>
      
    </table>
</div>

<table class="table table-sm table-bordered table-striped">
    <tr>
         <th class="text-center">Bil</th>
         <th class="text-center">Senarai Tugas</th>
         <th class="text-center">Tugas Belum Selesai</th>
         <th class="text-center">Kedudukan Sekarang</th>
         <th class="text-center">Tindakan Susulan</th>
         <th class="text-center">Rujukan Fail</th>
         <th class="text-center">Senarai Harta Benda</th>
         <th class="text-center">Maklumat Kewangan</th>
         <th class="text-center">Catatan</th>
     
    </tr>
    <?php foreach ($lihatNota as $key => $lihatNota) { ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->senarai_tugas ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->tugas_belum_selesai ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->kedudukan_sekarang ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->tindakan_susulan ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->rujukan_fail ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->senarai_harta_benda ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->kedudukan_kewangan ?></td>
            <td class="text-center"  style="text-align:center"><?= $lihatNota->catatan ?></td>

        </tr>
    <?php } ?>
</table>