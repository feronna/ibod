<?php

use app\models\cuti\Layak;
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
            <div style='padding: 15px;' class="table-bordered">
                    <font><u><strong>RUJUKAN /<i> REFERENCE</i></u> </strong></font><br><br>

                    <span class="label label-default">ENTRY</span> : Permohonan Baru / <i>New Application</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <span class="label label-primary">CHECKED</span> : Penyelia Cuti JFPIB Telah Menyemak Permohonan / <i> Application Has Been Checked by Leave Supervisor </i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <span class="label label-info">VERIFIED</span> : Permohonan Telah Diperaku Oleh Ketua Jabatan/Dekan / <i>Application Has Been Verified by Head Of Department/Dean</i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <span class="label label-success">APPROVED</span> : Permohonan Diluluskan / <i> Application Has Been Approved</i>

            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table" style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama Kakitangan</th>
                                <th class="text-center">Tarikh Mohon</th>
                                <th class="text-center">GCR di Mohon</th>
                                <th class="text-center">CBTH di Mohon</th>
                                <th class="text-center">Status Permohonan</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <?php if ($model) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'options' => ['class' => 'form-horizontal'],
                            ])
                            ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->kakitangan->CONm; ?></td>
                                    <td class="text-center"><?php echo $senarai->tarikhmohon; ?></td>
                                    <td class="text-center"><?php echo $senarai->gcr_applied; ?></td>
                                    <td class="text-center"><?php echo $senarai->cbth_applied; ?></td>
                                    <td class="text-center"><?php echo $senarai->status; ?></td>
                                    <td class="text-center"> 
                                    <?php if ($senarai->status == "ENTRY" || $senarai->status == "CHECKED") { ?>
                                    <span class="badge" style="background-color :pink"><u>
                                                

                                                    <?= Html::a(
                                                        'Cancel',
                                                        ["cuti/supervisor/reset-gcr", 'id' =>  $senarai->id],
                                                        ['class' => 'text', 'data' => ['confirm' => 'Are You Sure To Cancel This Application?']]
                                                    ) ?> </u></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>

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