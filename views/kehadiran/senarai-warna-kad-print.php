<h4><strong>Senarai Warna kad kakitangan ( <?=$month?> / <?=$year?> )</strong></h4>


<table class="table table-bordered" style="width: 100%;font-size: 12px;">
    <tr>
        <th style="background-color:grey" class="text-center">Bil</th>
        <th style="background-color:grey" class="text-center">Nama Kakitangan</th>
        <th style="background-color:grey" class="text-center">Gred</th>
        <th style="background-color:grey" class="text-center">Ketidakpatuhan</th>
        <th style="background-color:grey" class="text-center">Diterima</th>
        <th style="background-color:grey" class="text-center">Tidak Diterima</th>
        <th style="background-color:grey" class="text-center">Warna Kad</th>
    </tr>
    <?php if ($warnakad_model) { ?>
        <?php foreach ($warnakad_model as $senarai) { ?>
            <tr>
                <td class="text-center" style="text-align:center"><?php echo $bil++ ?></td>
                <td><?php echo ucwords(strtolower($senarai->kakitangan->CONm)); ?></td>
                <td><?php echo $senarai->kakitangan->jawatan->gred; ?></td>
                <td class="text-center"><?php echo $senarai->ketidakpatuhan; ?></td>
                <td class="text-center"><?php echo $senarai->approved; ?></td>
                <td class="text-center"><?php echo $senarai->disapproved; ?></td>
                <td class="text-center" style="width:16px;background-color:<?= $senarai->color ?>"><?= strtoupper($senarai->color) ?></td>
            </tr>
        <?php } ?>

    <?php } else { ?>
        <tr>
            <td colspan="7" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
        </tr>
    <?php } ?>
</table>
