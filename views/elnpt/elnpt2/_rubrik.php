<?php
$numOfCols = (sizeof($ruberik)  < 3) ? sizeof($ruberik) : 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>

<div class="row v2">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    foreach ($ruberik as $a) { ?>
                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                            <strong>RUBRIK <?= strtoupper($a->aspek) ?></strong>
                            <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th class="text-center"><?= ($bahagian->id == 10) ? 'PENILAIAN' : 'JULAT SKOR' ?></th>

                                    <th class="text-center">PERATUS MARKAH</th>
                                </tr>

                                <?php foreach ((($bahagian->id == 10) ? $a->getSkor() : $a->getPeratus($lpp->gredGuru->gred, $bahagian->id, ($bahagian->id == 1 || $bahagian->id == 4) ? $lpp->deptGuru->sub_of : null, ($bahagian->id == 1) ? $lpp->PYD : null))->all() as $ap) { ?>
                                    <tr>
                                        <td <?= ($bahagian->id == 10) ? ' ' : 'class="text-center" style="text-align:center"' ?>><?= ($bahagian->id == 10) ? $ap['desc'] :
                                                                                                                                        // Yii::$app->formatter->asDecimal($ap['min_skor'], 1)
                                                                                                                                        $ap['julat_skor']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= ($bahagian->id == 10) ? $ap['skor'] : $ap['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                            </p>
                        </div>

                    <?php
                        $rowCount++;
                        if ($rowCount % $numOfCols == 0) {
                            echo '</div><div class="row">';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>