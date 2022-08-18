<?php

use yii\widgets\DetailView;
?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php

                echo DetailView::widget([
                    'model' => $aktiviti,
                    'attributes' => [
                        'full_date:html',    // description attribute in HTML
                        [                      // the owner name of the model
                            'attribute' => 'dept_id',
                            'value' => $aktiviti->jfpib->fullname,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'adminpos_id',
                            'value' => $aktiviti->adminPosition->ref_position_name,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'program_id',
                            'value' => $aktiviti->programText,
                        ],               // title attribute (in plain text)
                    ],
                ]);
                ?>
                <div class="" style="font-size:30px;">Jumlah telah undi : <?= $completed . '/' . $total ?> (<?= round(($completed / $total) * 100,2) ?>%)</div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jawatan</th>
                                <th class="text-center">JFPIB</th>
                                <th class="text-center">No. Kad Pengenalan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <?php if ($pengundi) { ?>
                            <?php foreach ($pengundi as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                    <td><strong><?= $v->kakitangan->displayTitleName ?></strong></td>
                                    <td><strong><?= $v->kakitangan->jawatan->fname ?></strong></td>
                                    <td><strong><?= $v->kakitangan->department->fullname ?></strong></td>
                                    <td><strong><?= $v->icno ?></strong></td>
                                    <td><strong><?= $v->statusText ?></strong></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>