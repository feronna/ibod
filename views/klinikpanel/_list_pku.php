<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th class="text-center">Bil</th>
                <th class="text-center">Nama Pusat</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">No. Telefon</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach ($pku as $pkus) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= strtoupper($pkus->nama); ?></td>
                    <td class="text-center"><?= strtoupper($pkus->alamat);?></td>
                    <td class="text-center"><?= strtoupper($pkus->telefon);?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>