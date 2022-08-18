<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i>&nbsp;<strong>Maklumat Akitiviti</strong></h2>
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
                        'nama:html',    // description attribute in HTML
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
                        'catatan:html',    // description attribute in HTML
                        'statusText:html',    // description attribute in HTML
                        'create_dt:datetime', // creation date formatted as datetime
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user"></i>&nbsp;<strong>Senarai Calon</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!$calon) { ?>
                    <div class="tile-stats" style="padding: 1px">
                        <h4 class="text-center">Not available at the moment..</h4>
                    </div>
                <?php } else { ?>
                    <?php foreach ($calon as $calons) { ?>
                        <div class="tile-stats" style="padding: 10px">
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($calons->icno)) ?>.jpeg" class="text-center" style="width: 90px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <p><strong>Nama : </strong><?= $calons->kakitangan->CONm; ?></p>
                                        <p><strong>Jawatan : </strong><?= $calons->kakitangan->jawatan->fname; ?> </p>
                                        <p><strong>JFPIB : </strong><?= $calons->kakitangan->department->fullname; ?></p>
                                        <p><strong>Jawatan Pentadbiran : </strong><?= $calons->jwtnPentadbiran; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-users"></i>&nbsp;<strong>Senarai Pengundi</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <div class="" style="font-size:30px;">Jumlah telah undi : <?= $completed . '/' . $total ?> (<?= round(($completed / $total) * 100,2) ?>%)</div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">ICNO</th>
                                <th class="text-center">Jawatan</th>
                                <th class="text-center">Status Survey</th>
                            </tr>
                        </thead>
                        <?php if ($pengundi) { ?>
                            <?php foreach ($pengundi as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                    <td><strong><?= $v->kakitangan->CONm ?></strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $v->icno ?></strong></td>
                                    <td><strong><?= $v->kakitangan->jawatan->fname ?></strong></td>
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