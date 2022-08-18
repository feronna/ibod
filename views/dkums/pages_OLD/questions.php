<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\form\ActiveForm;
use app\models\bfi\Questions;

/* @var $this yii\web\View */
/* @var $model app\models\OkuRespons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-th-large"></i>&nbsp;<strong><?= $this->title ?></strong></h3>
    </div>



    <?php
    $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']
    ]);
    ?>
    <div class="box-body">
        <?= $this->render('_skala') ?>
        <hr>
        <p>
            <strong>
                <i>I see myself as someone who:</i><br>
                Saya melihat diri sebagai seseorang yang:
            </strong>
        </p>

        <?php echo GridView::widget([
            'summary' => '',
            'dataProvider' => Questions::getProvider(),
            'columns' => [
                [
                    'label' => 'No.',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:5%'],
                    'attribute' => 'id',
                ],
                [
                    'label' => 'Item',
                    'headerOptions' => ['class' => ''],
                    //'contentOptions' => ['style'=>'width:75%'],
                    'attribute' => 'pernyataan',
                    'format' => 'html'
                ],
                [
                    'label' => 'SKALA',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:50%'],
                    'value' => function ($model) use ($form, $model1, $disabled) {
                        $data = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
                        return $form->field($model1, "item$model->id")->radioButtonGroup($data, ['class' => '', 'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary', 'disabled' => $disabled]]])->label(false);
                    },
                    'format' => 'raw'
                ],
            ],
        ]);
        ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Papar Keputusan&nbsp;<i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Loading..']]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>