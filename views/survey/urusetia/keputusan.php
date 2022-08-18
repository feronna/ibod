<?php

use app\models\survey\TblCalon;
use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-line-chart"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php foreach ($model as $aktiviti) { ?>
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Nama Aktiviti</th>
                                <th class="text-center">Tarikh Survey</th>
                                <th class="text-center">Survey Tamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><?= $aktiviti->nama ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $aktiviti->tarikhMula ?></strong></td>
                                <td class="text-center" style="text-align:center"><strong><?= $aktiviti->tarikhTamat ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table class="table table-striped table-sm jambo_table table-bordered">
                                        <!-- <tr class="headings">
                                            <th class="text-center">Calon</th>
                                            <th class="text-center">Maklumat</th>
                                            <th class="text-center">Jumlah Survey</th>
                                        </tr> -->
                                        <?php foreach (TblCalon::find()->where(['aktiviti_id' => $aktiviti->id])->all() as $calon) { ?>
                                            <tr>
                                                <td class="text-center" style="text-align:center" width="40px">
                                                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($calon->icno)) ?>.jpeg" class="text-center" style="width: 40px">
                                                </td>
                                                <td><?= $calon->kakitangan->displayTitleName ?></td>
                                                <td class="text-center" style="text-align:center;font-size:30px" width="150px"> 
                                                <strong><?= $calon->totalVote ?></strong>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>