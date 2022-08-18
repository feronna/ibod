<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<!--<div class="col-md-12"> -->
<div class="x_panel">
    <div class="x_title">
        <h2><strong>Ulasan Pegawai Medan</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model1, 'verifier_comment')->textarea(['placeholder' => "Masukkan Ulasan Pegawai Medan,Ruangan Ini Wajib Diisi. Laporan Tidak Akan Disahkan sekiranya ditinggalkan kosong",'maxlength' => true, 'rows' => 4])->label(false);

            // ->textare()->textarea('verifier_comment', ['placeholder' => "Masukkan Ulasan Pegawai Medan"],['class' => 'control-label','required'=>true])->label(false); ?>
            
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <br>

    </div>
</div>
<!--</div>-->

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