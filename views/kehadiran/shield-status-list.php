<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai kakitangan Seliaan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Gred / Jawatan</th>
                                <td class="text-center">Shields Status</td>
                                <td class="text-center">Tarikh/Masa Jawab</td>
                                <td class="text-center">Tamat Pada</td>
                            </tr>
                        </thead>
                        <?php foreach ($staff as $s) { ?>
                            <tr>
                                <td><?= $bil++ ?></td>
                                <td><?= $s->CONm ?></td>
                                <td><?= $s->jawatan->fname ?></td>
                                <?php if ($s->shields) { ?>
                                    <td style="background-color:<?= $s->shields->color; ?>;color: black;text-align: center"><?= $s->shields->color; ?></td>
                                    <td><?= $s->shields->tarikh ?></td>
                                    <td><?= $s->shields->endTarikh ?></td>
                                <?php } else { ?>
                                    <td colspan="3" style="color: black;text-align: center"><strong>--BELUM ISI SHIELDS--</strong></td>
                                <?php } ?>
                            </tr>

                        <?php } ?>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>