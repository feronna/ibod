<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\TopMenuWidget;
?>

<?= $this->render('/keselamatan/_topmenu') ?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai untuk pengesahan Ketidakpatuhan kehadiran</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table"  style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Pilih</th>
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama Kakitangan</th>
                                <th class="text-center">Tarikh</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Alasan/Sebab</th>
                                <th class="text-center">Pengesahan</th>
                            </tr>
                        </thead>
                        <?php if ($lulus) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'login-form',
                                        'options' => ['class' => 'form-horizontal'],
                                    ])
                            ?>
                            <?php foreach ($lulus as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?= $form->field($senarai, 'id[]')->checkbox(['value' => $senarai->id, 'label' => '', 'class' => 'checkId']); ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->kakitangan->CONm; ?></td>
                                    <td class="text-center"><?php echo $senarai->tarikh; ?></td>
                                    <td class="text-center"><?php echo $senarai->statusAll; ?></td>
                                    <td><?php echo $senarai->remark; ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["keselamatan/pengesahan", 'id' => $senarai->id]); ?></td>
                                </tr>
                            <?php } ?>

                            <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>
                            <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Terima Alasan/Sebab', ['class' => 'btn btn-primary']) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
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
