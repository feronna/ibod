<?php

use app\models\survey\TblCalon;
use app\models\survey\TblVotes;
use yii\helpers\Html;
use yii\widgets\DetailView;;

?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
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
                        'nama:html',    // description attribute in HTML
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
                    ],
                ]);
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered" witdh="100px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Nombor Calon</th>
                                <th class="text-center" colspan="2">Maklumat Calon</th>
                                <th class="text-center">Syor</th>
                                <th class="text-center">Membuat Syor</th>
                            </tr>
                        </thead>
                        <?php if ($calon) { ?>

                            <?php foreach ($calon as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center" width="10px">
                                        <p style="margin-top: 40px;"><strong><?= $bil++ ?></strong></p>
                                    </td>
                                    <td class="text-center" style="text-align:center" width="70px">
                                        <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($v->icno)) ?>.jpeg" class="text-center" style="width: 70px">
                                    </td>
                                    <td>
                                        <strong>Nama</strong> : <?php echo $v->kakitangan->CONm; ?><br>
                                        <strong>UMSPER</strong> : <?php echo $v->kakitangan->COOldID; ?><br>
                                        <strong>Jawatan</strong> : <?php echo $v->kakitangan->jawatan->fname; ?><br>
                                        <strong>Jawatan Pentadbiran</strong> : <?php echo $v->jwtnPentadbiran; ?>
                                    </td>
                                    <td><?= $v->syor; ?></td>
                                    <td class="text-center">
                                        <p style="margin-top: 10px;font-size:30px;font-weight:bold;">
                                            <?= Html::a('<i class="fa fa-pencil-square-o"></i>', ['syor', 'id' => $v->id]); ?>
                                        </p>
                                    </td>
                                </tr>
                            <?php } ?>

                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <hr>
                <div class="text-center">
                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['senarai-aktiviti'], ['class' => 'btn btn-danger']) ?>
                </div>
                </ul>
            </div>
        </div>
    </div>
</div>