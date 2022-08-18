<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\dkums\YearSettings;
?>

<div class="x_title">
    <h2>Carian</h2>
    <div class="clearfix"></div>
</div>
<?php $form = ActiveForm::begin([
    'action' => $action,
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]
]); ?>
<div class="form-group ">

    <div class="col-md-3 col-sm-3 col-xs-12">
        <?php echo
        $form->field($carian, 'tahun')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(YearSettings::find()->all(), 'tahun', 'tahun'),
            'options' => ['placeholder' => '-- PILIH TAHUN --', 'class' => 'form-control col-md-4 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div class=" col-md-2 col-lg-2 col-xs-12 col-sm-12">
        <?php echo
        $form->field($carian, 'fasa')->label(false)->widget(Select2::classname(), [
            'data' => [1 => 1, 2 => 2],
            'options' => ['placeholder' => '-- PILIH FASA --', 'class' => 'form-control col-md-4 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>


    <div class=" col-md-1 col-sm-1 col-xs-12">
        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary',]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>