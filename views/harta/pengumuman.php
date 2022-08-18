<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// as a widget

?>

<div class="col-md-12">


    <?php echo $this->render('/harta/_menu'); ?>


</div>

<div class="col-md-12 col-sm-12 col-xs-12" align="left"> 

    <?= Html::a('<i class="fa fa-bullhorn" aria-hidden="true"></i> NOTIFIKASI STAF', ['notifistaf'], ['class' => 'btn btn-primary btn-md'])
    ?>


</div>

<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Pengumuman</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p style="color: green">
                * Semua kakitangan UMS akan dapat notifikasi
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::input('text', 'title', '', ['class' => 'form-control col-md-7 col-xs-12', 'required' => true]) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nota :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::textarea('content', '',  ['class' => 'form-control col-md-7 col-xs-12', 'rows' => 10, 'required' => true]) ?>
                </div>
            </div>



            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'id' => 'submit' ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

</script>