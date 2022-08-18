<?php

use app\models\survey\TblPengundi;
use yii\helpers\Html;

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
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Catatan</th>
                                <th class="text-center">Jawatan</th>
                                <th class="text-center">Tarikh/Masa</th>
                                <th class="text-center">Take Survey</th>
                                <th class="text-center">Status Survey</th>
                            </tr>
                        </thead>
                        <?php if ($aktiviti) { ?>
                            <?php foreach ($aktiviti as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $v->catatan ?></strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $v->adminPosition->position_name ?></strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $v->full_date ?></strong></td>
                                    <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-check-square-o"></i>', ['vote', 'key' => hash('sha256',$v->id)], ['class' => '']) ?>
                                    <td class="text-center" style="text-align:center"><strong><?= TblPengundi::statusVote($v->id,$icno) ?></strong></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>