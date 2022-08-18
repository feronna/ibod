<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;
?>

<!--<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li>Senarai pengesahan ketidakpatuhan</li>
    </ol>
</div>-->


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan GCR dan CBTH</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table"  style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <!-- <th class="text-center">Pilih</th> -->
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama Kakitangan</th>
                                <th class="text-center">Tarikh</th>
                                <th class="text-center">GCR di Mohon</th>
                                <th class="text-center">CBTH di Mohon</th>
                                <th class="text-center">Semak Baki Cuti</th>
                                <th class="text-center">Semak Ketidakpatuhan</th>
                                <th class="text-center">Semak Laporan Bulanan</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <?php if ($gcr) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'login-form',
                                        'options' => ['class' => 'form-horizontal'],
                                    ])
                            ?>
                            <?php foreach ($gcr as $senarai) { ?>
                                <tr>
                                    <!-- <td class="text-center"  style="text-align:center"><?= $form->field($senarai, 'id[]')->checkbox(['value'=>$senarai->id, 'label' => '', 'class' => 'checkId']); ?></td> -->
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->kakitangan->CONm; ?></td>
                                    <td class="text-center"><?php echo $senarai->tarikhmohon; ?></td>
                                    <td class="text-center"><?php echo $senarai->gcr_applied; ?></td>
                                    <td class="text-center"><?php echo $senarai->cbth_applied; ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-eye">', ["cuti/supervisor/set-leave", 'id' => $senarai->pemohon_icno]); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-eye">', ["kehadiran/sup-mth-rpt"]); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-eye">', ["kehadiran/senarai_kakitangan"]); ?></td>
                                    <td class="text-center"> <?= Html::button('<i class="fa fa-edit"></i>  ', ['value' => Url::to(['cuti/supervisor/sv-gcr-verify', 'id' => $senarai->id]), 'class' => 'mapBtn']); ?></td>

                                </tr>
                            <?php } ?>

                            <!-- <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button> -->
                            <!-- <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Sahkan Permohonan', ['class' => 'btn btn-primary']) ?> -->
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="align-center text-center"><i>Belum ada Permohonan</i></td>
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
