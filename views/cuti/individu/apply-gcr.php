<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\cuti\GcrApplication;
use app\models\cuti\Layak;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

//english title
// $this->title = $model_jenis->jenis_cuti_catatan . ' (' . $model_jenis->jenis_cuti_nama . ')';
?>
<div class="x_panel">

    <div class="x_content">

        <div class="table-responsive">
            <?=
                DetailView::widget([
                    'model' => $biodata,
                    'attributes' => [
                        [
                            'label' => 'Nama / Name',
                            'attribute' => 'CONm',
                        ],

                        [
                            'label' => 'UMSPER',
                            'attribute' => 'COOldID',
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                        ],
                        [
                            'label' => 'Jawatan / Position',
                            'attribute' => 'jawatan.fname',
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                        ],
                        [
                            'label' => 'JFPIB',
                            'attribute' => 'department.fullname',
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                        ],



                    ],
                ])
            ?>
        </div>
    </div>

    <div class="x_content">

        <div class="clearfix">

            <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                <thead>
                    <!-- <tr class="headings"> -->
                    <th class="column-title text-center">Kelayakan Cuti / <i> Entitlement</i></th>
                    <th class="column-title text-center">Jumlah Cuti Rehat / <i> Total Leave</i></th>
                    <th class="column-title text-center">Jumlah Cuti Digunakan / <i>Leave Used</i></th>
                    <th class="column-title text-center">Baki Akhir Cuti Rehat / <i> Leave Balance</i></th>

                    <!-- </tr> -->
                </thead>
                <!-- <div class="tile-stats" style="padding:10px"> -->

                <tr class='text-center'>
                    <td class='text-center'><?php echo $layak->layak_cuti ?></td>
                    <td class='text-center'><?php echo $layak->layak_bawa_lepas + $layak->layak_cuti + $layak->layak_selaras ?></td>
                    <td class='text-center'><?php echo ($layak->layak_bawa_lepas + $layak->layak_cuti) - (Layak::getBakiOld($id, $layak->layak_mula, $layak->layak_tamat)) ?></td>
                    <td class='text-center'><?php echo Layak::getBakiOld($id, $layak->layak_mula, $layak->layak_tamat) ?></td>

                </tr>



            </table>
        </div>
        <!-- <div style='padding: 15px;' class="table-bordered">
                <font>BCTL</font> : Baki Cuti Tahun Lepas &nbsp;&nbsp;&nbsp;&nbsp;
                <font>CBTH</font> : Cuti Bawa Tahun Hadapan &nbsp;&nbsp;&nbsp;&nbsp;
                <font>GCR</font> : Ganti Cuti Rehat

            </div> -->
        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Semakan Oleh / <i>Checked By</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Penyelia Cuti Yang Memperaku"></i>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'semakan_by')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($sick_leave_verifier, 'akses_cuti_icno', function ($sick_leave_verifier) {
                            return $sick_leave_verifier->slverifier->CONm;
                        }),
                        'options' => ['placeholder' => 'Penyelia Cuti', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
        </div>
        <?php
$model->gcr_applied= 0;
$model->cbth_applied= 0;
?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> Layak GCR Maksimum / <i> Max GCR that can be Applied</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pegawai Meluluskan Cuti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo GcrApplication::getGcr($layak->layak_id) ?>" disabled="true">
                <!-- <p style="color: green">*Sila berhubung dengan <strong>Penyelia Rekod</strong> anda jika terdapat perubahan bagi pegawai <strong>memperaku/melulus</strong></p> -->
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> Layak CBTH Maksimum / <i> Max CBTH that can be Applied</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pegawai Meluluskan Cuti"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo GcrApplication::getCbth($layak->layak_id) ?>" disabled="true">
                <!-- <p style="color: green">*Sila berhubung dengan <strong>Penyelia Rekod</strong> anda jika terdapat perubahan bagi pegawai <strong>memperaku/melulus</strong></p> -->
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'gcr_applied'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="GCR"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'gcr_applied')->textInput(['rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'cbth_applied'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="CBTH"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'cbth_applied')->textInput(['rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'agreement'); ?>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="CBTH"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'agreement')->checkbox(array('required'=>'required','label' => 'Sila Pastikan Permohonan Gantian Cuti Rehat (GCR) atau Cuti Bawa Tahun Hadapan (CBTH) Adalah Muktamad Kerana Permohonan Hanya Boleh Dibuat Sekali Sahaja.')); ?>
            </div>
        </div>
        <!-- Selepas Permohonan Dihantar, Semua Permohonan Cuti Rehat Dalam Negara dan Cuti Rehat Negara Akan Dibekukan -->
            
        <div style='padding: 15px;' class="table-bordered">
                <font>INFO</font> : Baki Cuti Yang Tidak Di Tuntut Akan Dilupuskan Selepas Permohonan Anda Di Luluskan &nbsp;&nbsp;&nbsp;&nbsp;
              

            </div>
      <br>



        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/pilih'], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['confirm' => '    You will not be able to edit this application after submitting'
                ,'disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
Modal::begin([
    'header' => '<span class="fa fa-pencil"></span>&nbsp;<strong>Senarai Cuti</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>