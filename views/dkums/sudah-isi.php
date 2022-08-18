<?php

use yii\helpers\Html;

$this->title = 'Senarai kakitangan yang telah mengisi DKUMS';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-briefcase"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                    <tr class="headings">
                        <th class="text-center">Bil</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Gred/Jawatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $m) { ?>
                            <tr>
                                <td><?= $bil++ ?></td>
                                <td><?= $m->kakitangan->CONm; ?></td>
                                <td><?= $m->kakitangan->jawatan->fname; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3">-- No Data --</td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>
</div>