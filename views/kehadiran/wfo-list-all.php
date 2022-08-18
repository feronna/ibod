<?php

use app\models\kehadiran\TblWfh;
use yii\helpers\Html;
use app\models\w_letter\TblPermohonan;
use app\models\umsshield\SelfRisk;
use yii\helpers\VarDumper;

$this->title = 'Senarai Staff yang bekerja di Pejabat (WFO) pada ' . date("d/m/Y", strtotime($date));
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-briefcase"></i>&nbsp;<strong><?= Html::encode($this->title) . ' : ' . count($model) ?></strong></h2>
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
                        <th class="text-center">JFPIB</th>
                        <th class="text-center">Gred/Jawatan</th>
                        <th class="text-center">Surat ?</th>
                        <!-- <th class="text-center">Shield ?</th> -->
                    </tr>
                </thead>
                <?php //if ($model) { ?>

                    <?php //foreach ($model as $v) { ?>
                        <tr>

                            <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                            <td><strong><?php //echo $v->CONm ?></strong></td>
                            <td><strong><?php //echo $v->department->fullname; ?></strong></td>
                            <td><strong><?php //echo $v->jawatan->fname; ?></strong></td>
                            <td><strong><?php //echo (TblPermohonan::ExistApplicationWfo($v->ICNO, $date)) ? 'ADA' : 'TIADA' ?></strong></td>
                            <!-- <td style="background-color:<?php //echo SelfRisk::shieldStatus($v->ICNO) ?>"></td> -->
                        </tr>
                    <?php //} ?>

                <?php //} else { ?>
                    <tr>
                        <td colspan="5" class="align-center text-center"><i>No Record Found!</i></td>
                    </tr>
                <?php //} ?>
            </table>

        </div>

    </div>
</div>