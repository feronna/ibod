<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th class="text-center">Bil</th>
                <th class="text-center">Pemohon</th>
                <th class="text-center">Tarikh</th>
                <th class="text-center">Syif Dipohon</th>
                <th class="text-center">Syif Sekarang</th>
                <th class="text-center">Catatan Permohonan</th>
                <th class="text-center">Penganti</th>
                <th class="text-center">Status Perakuan Penganti</th>
                <th class="text-center">Status Perakuan Pelulus</th>
                <th class="text-center">Catatan Pelulus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($syif as $models) { ?>
                <tr>
                    <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->pemohon->CONm ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->formattarikh ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->shifts->jenis_shifts ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->currshift->jenis_shifts ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->alasan_penukaran ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->penganti->CONm ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->status ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->statuslulus ?></td>
                    <td class="text-center"  style="text-align:center"><?= $models->catatan_pelulus ?></td>




                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>