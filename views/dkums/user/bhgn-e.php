<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\form\ActiveForm;


?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Pengenalan', Url::to(['intro'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian A', Url::to(['bhgn-a'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian B', Url::to(['bhgn-b'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian C', Url::to(['bhgn-c'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian D', Url::to(['bhgn-d'])) ?></li>
        <li class="breadcrumb-item active" aria-current="page">Bahagian E</li>
    </ol>
</nav>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-home"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= $this->render('_skala_bhgn_e') ?>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'bhgn-a',
                    'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']
                ]);
                ?>


                <?php echo GridView::widget([
                    'summary' => '',
                    'dataProvider' => $questions,
                    'columns' => [
                        [
                            'label' => "Pernyataan",
                            'headerOptions' => ['class' => ''],
                            //'contentOptions' => ['style'=>'width:75%'],
                            'attribute' => 'statement',
                            'format' => 'html'
                        ],
                        [
                            'label' => 'Skala / Scale',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width:50%'],
                            'value' => function ($model) use ($form, $model1) {
                                $data = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10];
                                return $form->field($model1, "$model->bhgn$model->number")->radioButtonGroup($data, ['class' => '', 'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
                ?>

                <div class="ln_solid"></div>
                <div class="form-group text-center">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Sebelumnya / Back', Url::to(['bhgn-d']), ['class' => 'btn btn-warning']) ?>
                    &nbsp;
                    <?= Html::submitButton('<i class="fa fa-arrow-right"></i> Seterusnya / Next', ['class' => 'btn btn-primary']); ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>