<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th class="text-center">Bil</th>
                <th class="text-center">Nama Tanggungan</th>
                <th class="text-center">No. KP / MyKid</th>
                <th class="text-center">Hubungan</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($keluarga)  { ?>
            <?php foreach ($keluarga as $keluargas) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= strtoupper($keluargas->FmyNm); ?></td>
                    <td class="text-center"><?= $keluargas->FamilyId;?></td>
                    <td class="text-center"><?= strtoupper($keluargas->hubunganKeluarga->RelNm);?></td>
                </tr>
            <?php } ?>
            <?php } else { ?>
                    <tr>
                    <td colspan="12" class="align-center text-center"><i>Tiada rekod keluarga</i></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
</div>