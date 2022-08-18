<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Keselamatan\TblKesalahan;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pengesahan Ketidakpatuhan kehadiran</strong></h2>
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
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model->staff, 'CONm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Syif
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'syif')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => true]); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-control col-md-4 col-sm-6 col-xs-12 disabled">
                        <?php echo Yii::$app->formatter->asDate($model->date, 'long'); ?></div>
                    <!--date('D', strtotime($date));-->
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Hari
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12 ">
                    <div class="form-control col-md-4 col-sm-6 col-xs-12 disabled">
                        <?php echo date('l', strtotime($model->date)); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Dimuat Naik
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12 ">
       
                        <?php
                        if (!empty($model->namafile) && $model->namafile != 'deleted') {
                            echo '<u>' . $model->displayLink . '</u>';
                            echo '&nbsp&nbsp&nbsp&nbsp';
                        } else {
                            echo 'Tiada fail yang diupload';
                        }
                        ?>
                            <a href="#" data-toggle="tooltip" title="Klik Nama Fail untuk Muat turun!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>

         
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Ketidakpatuhan
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-control col-md-4 col-sm-6 col-xs-12 disabled"><?= $model->statusH ?></div>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => true])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengesahan <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php
                    echo $form->field($model, 'status')->label(false)
                            ->dropDownList(
                                    ['APPROVED' => 'DITERIMA', 'REJECTED' => 'DITOLAK'], // Flat array ('id'=>'label')
                                    ['prompt' => '--Sila Pilih Status Pengesahan--']    // options
                    );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Pengesahan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'app_remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar Pengesahan', ['class' => 'btn btn-success']) ?>
                    <?= Html::button('<i class="fa fa-list"></i>&nbsp;Senarai Kesalahan', ['value' => Url::to(['keselamatan/record-rollcall', 'icno' => $model->anggota_icno]), 'class' => 'mapBtn btn btn-warning', 'id' => 'modalButton']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>

<?php
$script = <<< JS

          $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
              
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>
