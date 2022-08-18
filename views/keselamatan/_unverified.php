<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Laporan Yang Perlu Pengesahan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table"  style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Pegawai Bertugas</th>
                                <th class="text-center">Tarikh Syif</th>
                                <th class="text-center">Syif</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                           
                            <?php foreach ($report as $r) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td class="text-center"  style="text-align:center"><?= $r->pm->CONm?></td>
                                    <td class="text-center"><?php echo $r->date; ?></td>
                                    <td class="text-center"><?php echo $r->syif; ?></td>
                                        <td class="text-center"><?php echo $r->verified_stat; ?></td>
                               
                                    <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["keselamatan/verifying-report", 'syif'=>$r->syif,'date' => $r->date,'id'=>Yii::$app->user->identity->ICNO]); ?></td>

                                </tr>
                            <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });

JS;
$this->registerJs($script, View::POS_END);
?>
