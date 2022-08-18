<?php

use app\models\hronline\Tblprcobiodata;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use yii\helpers\Url;
// as a widget
?>



<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tambah Kelayakan Klinik Panel</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'anggota_icno')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Sila pilih nama', 'default' => 0],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan<span class="required">*</span>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
             

                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>


            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>
</div>

<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Periksa Nama Anggota</strong></h2>

            <ul class="nav navbar-right panel_toolbox collapse">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <?php
        Yii::$app->session->setFlash('info', 'Sila Pastikan Semua Nama Anggota adalah sama seperti dalam jadual.Sekiranya Tidak Sama sila Tekan Butang "Periksa Semula" dan Muat Naik Semula Setelah Membetulkan UMSPER Tersebut.');
        ?>
        <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
        <div class="x_content">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: navy; color: white;">
                        <tr class="headings">
                            <th class="column-title">Bil </th>
                            <th class="column-title">ICNO</th>
                            <th class="column-title">Nama</th>
                            <th class="column-title">Syif</th>
                            <th class="column-title">Jenis Syif</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mod as $models) { ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?= $models->anggota_icno; ?></td>
                                <td><?= $models->staff->CONm; ?></td>
                                <td><?= $models->syif; ?></td>
                                <td><?= $models->type; ?></td>


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
       
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>