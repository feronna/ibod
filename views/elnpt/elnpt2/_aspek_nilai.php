<?php

use yii\helpers\ArrayHelper;

?>

<div class="row v2">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">Aspek Penilaian</th>
                            <?php if ($bahagian->id != 10) { ?>
                                <th class="text-center col-md-2">Markah PYD</th>
                            <?php } ?>
                            <th class="text-center col-md-2">Markah PPP</th>
                            <th class="text-center col-md-2">Markah PPK</th>
                            <?php if ($bahagian->id == 10) { ?>
                                <th class="text-center col-md-2">Markah PEER</th>
                            <?php } ?>
                        </tr>
                        <?php foreach ($mrkh_bhg as $ind => $all) { ?>
                            <tr>
                                <th><?= $all['desc']; ?></th>
                                <?php if ($bahagian->id != 10) { ?>
                                    <th class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($all['markah_pyd']); ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub> </th>
                                <?php } ?>
                                <th class="col-md-1 text-center" style="text-align:center">

                                    <?= is_null($all['markah_ppp']) ? 'PPP' :  $all['markah_ppp'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

                                </th>
                                <th class="col-md-1 text-center" style="text-align:center">

                                    <?= is_null($all['markah_ppk']) ? 'PPK' :  $all['markah_ppk'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

                                </th>
                                <?php if ($bahagian->id == 10) { ?>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_peer']) ? 'PEER' :  $all['markah_peer'] ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

                                    </th>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th style="text-align:right">JUMLAH</th>
                            <?php if ($bahagian->id != 10) { ?>
                                <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_pyd')), 2); ?></th>
                            <?php } ?>
                            <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_ppp')), 2); ?></th>
                            <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_ppk')), 2); ?></th>

                            <?php if ($bahagian->id == 10) { ?>
                                <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_peer')), 2); ?></th>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>