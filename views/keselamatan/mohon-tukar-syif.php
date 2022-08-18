<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
use app\widgets\TopMenuWidget;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i></i> Sila Pilih Tarikh Syif :</strong></h2>

                <div class="clearfix"></div>
            </div>
            <?php
            Yii::$app->session->setFlash('info', 'Sila Pilih Tarikh Syif Yang Anda Kehendaki untuk Membuat Permohonan Pertukaran. Tarikh Tersebut Hendaklah Dibuat TIGA hari sebelum Tarikh Yang Dipilih');
            ?>
            <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
            <div class="x_content">

                <?= Html::beginForm(['tukar-syif'], 'GET'); ?>


                <?php
                echo '<label class="control-label">Tarikh syif</label>';
                echo DatePicker::widget([
                    'name' => 'date',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                    'value' => '',
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
                <br>

                <br>
                <div class="form-group" align="right">

                    <button class="btn btn-primary" type="reset">Set Semula</button>
                    <?= Html::submitButton('<i class="fa fa-plane"></i> Hantar', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
                    <?= Html::endForm(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
