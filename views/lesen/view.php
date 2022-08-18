<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lesen';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
  
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Tambah Lesen', ['tambahlesen'], ['class' => 'btn btn-primary']) ?>
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="headings">
                            <th>No. Lesen</th>
                            <th>Jenis Lesen</th>
                            <th>Kelas Lesen</th>
                            <th>Tarikh Dikeluarkan</th>
                            <th>Tarikh Luput</th>
                            <th>Yuran Pembaharuan</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <?php if ($lesen) {

                        foreach ($lesen as $lesenkakitangan) {

                    ?>

                            <tr>
                                <td><?= $lesenkakitangan->LicNo; ?></td>
                                <td><?= $lesenkakitangan->jenlesen; ?></td>
                                <td><?= $lesenkakitangan->kellesen; ?></td>
                                <td><?= $lesenkakitangan->firstLicIssuedDt; ?></td>
                                <td><?= $lesenkakitangan->licExpiryDt; ?></td>
                                <td><?= 'RM ' . $lesenkakitangan->LicRnwlFee; ?></td>
                                <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatlesen', 'id' => $lesenkakitangan->licId]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $lesenkakitangan->licId]) ?></td>
                            </tr>

                        <?php }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">Tiada Rekod</td>
                        </tr>
                    <?php
                    } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Nota :</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <ul>
                <li><span class="label label-primary"><i class="fa fa-eye" aria-hidden="true"></i></span> : Paparan penuh maklumat.</li>
                <li><span class="label label-primary"><i class="fa fa-pencil" aria-hidden="true"></i></span> : Mengemaskini maklumat yang salah.</li>
                <li>Sila tekan "Tambah Lesen" jika lesen diperbaruhi.</li>
            </ul>
        </div>
    </div>
</div>