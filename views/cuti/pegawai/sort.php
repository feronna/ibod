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
                <h2><strong>Senarai Permohonan GCR dan CBTH Mengikut JFPIB</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table" style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">JFPIB</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <?php if ($query) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'options' => ['class' => 'form-horizontal'],
                            ])
                            ?>
                            <?php foreach ($query as $senarai) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?php echo $senarai->department->fullname; ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-eye">', ["cuti/pegawai/gcr-list-bsm",'dept'=>$senarai->dept_id]); ?></td>

                                </tr>
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