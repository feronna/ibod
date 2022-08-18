<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
?>

<?= $this->render('/saman/_menu') ?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pembayaran Saman</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Saman :
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->NOSAMAN ?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kenderaan :
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->saman->NO_KENDERAAN ?>" disabled="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Saman (RM):
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->AMOUNT_PENDING ?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Saman Kunci (RM):
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->AMNKUNCI ?>" disabled="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh dan Masa Saman Di Masukkan:
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->INSERTDATE ?>" disabled="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Pembayaran:
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php

                    echo $form->field($model, 'AMOUNT_PAID')->label(false);
                       
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Pembayaran Kunci:
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php

                    echo $form->field($model, 'AMNKUNCI_PAID')->label(false);
                       
                    ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pembayaran<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php

                    echo $form->field($model, 'STATUS')->label(false)
                        ->dropDownList(
                            ['PENDING' => 'Menunggu Pembayaran', 'PAID' => 'Pembayaran Telah Dibuat','BATAL' => 'DIBATALKAN'], // Flat array ('id'=>'label')
                            ['prompt' => '--Sila Pilih Status Pembayaran--']
                            // options
                        );
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'CATATAN')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['saman/saman-status'], ['class' => 'btn btn-warning']) ?>

                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <!--form-->

        </div>
    </div>
</div>