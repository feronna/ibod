<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<!--<div class="col-md-12"> -->
<div class="x_panel">
    <div class="x_title">
        <h2><strong>KemasKini Kesalahan</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'THBLMT')->checkbox(array(
                    'label' => 'Tidak Hadir Baris Lebih Masa Tambahan (THBLMT)',
                    'labelOptions' => array('style' => 'padding:5px;'),
                    'disabled' => false
                ));
                ?>
              

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