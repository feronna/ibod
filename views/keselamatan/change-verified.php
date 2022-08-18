<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\widgets\ActiveForm;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

    <div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Admin</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= Html::dropDownList('syif', $syif, ['A' => 'A', 'B' => 'B', 'C' => 'C'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>


                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                        DatePicker::widget([
                            'name' => 'date',
                            'value' => $todaydt,
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>

                </div>
            </div>
   
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success','data' => ['confirm' => 'Anda Pasti?? Anda Tidak akan Dapat Mengubah Tindakan Ini?']]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
