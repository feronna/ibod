<?php

use app\models\elnpt\elnpt2\TblHijau;

$numOfCols = (sizeof($ruberik)  < 3) ? sizeof($ruberik) : 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>

<div class="row v2">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> <?= ($bahagian->id == 10) ? 'Pemberat' : 'Skor' ?></strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <?php
                    $tbl = new TblHijau();
                    $tmp = $tbl->getTable($bahagian->id - 1, ($bahagian->id == 9) ? 1 : null);
                    foreach ($ruberik as $ind => $a) {
                        if (!isset($tmp[$ind])) {
                            continue;
                        }
                    ?>
                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                            <strong><?= ($bahagian->id == 10) ? '' : strtoupper($a->aspek) ?></strong>
                            <p>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="text-align:center"><?php echo implode('</th><th class="text-center" style="text-align:center">', array_keys(current($tmp[$ind]))); ?></th>
                                    </tr>
                                </thead>
                                <?php foreach ($tmp[$ind] as $row) : array_map('htmlentities', $row); ?>
                                    <tr>
                                        <td><?php echo implode('</td><td class="text-center" style="text-align:center">', $row); ?></td>
                                    </tr>
                                <?php endforeach; ?>
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