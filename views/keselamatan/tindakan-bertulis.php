<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
?>


<!--<div class="col-md-12"> -->
<div class="x_panel">
    <div class="x_title">
        <h2><strong>Tindakan Bertulis/Lisan</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-label-left disable-submit-buttons']]); ?>
    
        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">Sila Pilih Tarikh :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    DatePicker::widget([
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
                $date = Yii::$app->getRequest()->getQueryParam('date_start');
                ?>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 't_bertulis')->checkbox(array(
                        'label' => 'Tindakan Bertulis ',
                        'labelOptions' => array('style' => 'padding:5px;'),
                        'disabled' => false
                    ));
                ?>
                <?=
                    $form->field($model, 't_lisan')->checkbox(array(
                        'label' => 'Tindakan Lisan ',
                        'labelOptions' => array('style' => 'padding:5px;'),
                        'disabled' => false
                    ));
                ?>


            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">Sila Masukkan Sebab Tindakan Anda:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
            <?= $form->field($model, 'comment')->textarea(['placeholder' => "Masukkan Justifikasi/Sebab Tindakan - Kesalahan Anggota",'maxlength' => true, 'rows' => 4])->label(false);?>
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