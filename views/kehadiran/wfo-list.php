<?php

use yii\helpers\Html;
use app\models\w_letter\TblPermohonan;
use app\models\umsshield\SelfRisk;

$this->title = 'Senarai Staff yang bekerja di Pejabat (WFO) pada ' . date("d/m/Y", strtotime($date));
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
                        <th class="text-center">Surat ?</th>
                        <th class="text-center">Shield ?</th>
                        <th class="text-center">Jana Surat WFO</th>
                    </tr>
                </thead>
                <?php if ($model) { ?>

                    <?php foreach ($model as $v) { ?>
                        <tr>

                            <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                            <td><strong><?= $v->CONm ?></strong></td>
                            <td><strong><?= $v->jawatan->fname; ?></strong></td>
                            <td><strong><?= (TblPermohonan::ExistApplicationWfo($v->ICNO, $date)) ? 'ADA' : 'TIADA' ?></strong></td>
                            <td style="background-color:<?=SelfRisk::shieldStatus($v->ICNO)?>;color: black;text-align: center"><strong></strong><?= SelfRisk::shieldStatus($v->ICNO)?></td>
                            <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-envelope"></i>', ['kehadiran/jana-surat-wfo','icno'=>$v->ICNO, 'date' => $date], ['class' => '']) ?></td>
                        </tr>
                    <?php } ?>

                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="align-center text-center"><i>No Record Found!</i></td>
                    </tr>
                <?php } ?>
            </table>

        </div>

    </div>
</div>