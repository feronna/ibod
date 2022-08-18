<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai menunggu perakuan bekerja dari rumah/Work from Home(WFH)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table" style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">Pilih</th>
                                <th class="column-title text-center">BIL</th>
                                <th class="column-title text-center">NAMA</th>
                                <th class="column-title text-center">GRED</th>
                                <th class="column-title text-center">JFPIB</th>
                                <th class="column-title text-center">TARIKH</th>
                                <th class="column-title text-center">TEMPOH</th>
                                <th class="column-title text-center">CATATAN</th>
                                <th class="column-title text-center">TARIKH / MASA PERMOHONAN</th>
                                <th class="column-title text-center">STATUS</th>
                                <th class="column-title text-center">TINDAKAN</th>
                            </tr>
                        </thead>
                        <?php if ($peraku) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'options' => ['class' => 'form-horizontal'],
                            ])
                            ?>
                            <?php foreach ($peraku as $senarai) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $form->field($senarai, 'id[]')->checkbox(['value' => $senarai->id, 'label' => '', 'class' => 'checkId']); ?></td>
                                    <td class="text-center" style="text-align:center"><?php echo $bil++ ?></td>
                                    <td class="text-center"><?php echo $senarai->kakitangan->CONm; ?></td>
                                    <td class="text-center"><?php echo $senarai->kakitangan->jawatan->gred; ?></td>
                                    <td class="text-center"><?php echo $senarai->kakitangan->department->shortname; ?></td>
                                    <td class="text-center"><?php echo $senarai->full_date; ?></td>
                                    <td class="text-center"><?php echo $senarai->tempoh; ?></td>
                                    <td class="text-center"><?php echo $senarai->remark; ?></td>
                                    <td class="text-center"><?php echo $senarai->entry_dt; ?></td>
                                    <td class="text-center"><?php echo $senarai->status; ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["kehadiran/wfh-peraku-tindakan", 'id' => $senarai->id]); ?></td>
                                </tr>
                            <?php } ?>

                            <button type="button" class="checkall btn btn-default"><i class="fa fa-edit"></i>&nbsp;Select All</button>
                            <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;PERAKU PERMOHONAN WFH', ['class' => 'btn btn-success']) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="11" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
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