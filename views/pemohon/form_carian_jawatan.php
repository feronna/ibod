<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2; 
?>

<div class="tblprcobiodata-search"> 
    <?php
    $form = ActiveForm::begin([
                'action' => ['carian-iklan'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
                'fieldConfig' => ['autoPlaceholder' => true,
                ],
    ]);
    ?>
    <div class="col-md-7 col-sm-7 col-xs-7"></div>
    <div class="col-md-4 col-sm-4 col-xs-4">
        <?=
        $form->field($iklan, 'jawatan_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
            'options' => ['placeholder' => 'Pilih Jawatan'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
 
    <div class="col-md-1 col-sm-1 col-xs-">
        <div class="form-group">
            <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
        </div>
    </div> 
    <?php ActiveForm::end(); ?> 
</div>
