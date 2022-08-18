<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kehadiran\RefWp;
use dosamigos\datepicker\DatePicker;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;

?>
<!--<div class="col-md-12">--> 
<div class="x_panel">
    <div class="x_title">
        <h5><i class="fa fa-pencil"></i>&nbsp;UPDATE SHIFT FOR <strong><?= $staffname; ?></strong> 
            <div class="pull-right"><i class="fa fa-calendar"></i>&nbsp;<strong><?= TblRekod::viewBulan($bulan) . ' ' . $tahun?></strong></div></h5>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>



        <?php foreach ($models as $index => $model) { ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id"><?php echo date("d/m/Y (l)", strtotime($model->tarikh)) ?> :
                </label>

                <div class="col-md-4 col-sm-4 col-xs-6">

                    <?=
                    $form->field($model, "[$index]shift_id")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($wp, 'id', 'jenis_shifts'),
                        'options' => ['placeholder' => '-- Select Shift --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    <?php //yii\helpers\VarDumper::dump($v,1,true);  ?>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <?php echo $form->field($model, "[$index]tarikh")->textInput(['readonly' => true])->label(false); ?>
                </div>
            </div>




            <?php //echo $form->field($model, "[$k]tarikh")->label(false);  ?>
        <?php } ?>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp; Save Shift', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>