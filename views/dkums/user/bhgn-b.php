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
    <li class="breadcrumb-item active" aria-current="page">Bahagian B</li>
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
                <?= $this->render('_skala_bhgn_b') ?>
                <p>
                    Skala ini terdiri daripada beberapa perkataan yang menggambarkan perasaan dan emosi yang berbeza. Nyatakan tahap persetujuan anda terhadap setiap pernyataan dengan menggunakan skala 1-5. Sila berfikiran terbuka dan jujur dalam memberikan jawapan anda.
                    <br>
                    <i style='color:green;'>This scale consists of a number of words that describe different feelings and emotions. Using the 1-5 scale below, indicate your agreement with each item. Please be open and honest in your responding.</i>
                    <br><br>
                    Secara umumnya, bagaimana perasaan anda bekerja di Universiti Malaysia Sabah?
                    <br>
                    <i style='color:green;'>Generally, how do you feel working here in Universiti Malaysia Sabah?</i>
                </p>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'bhgn-b',
                    'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']
                ]);
                ?>
                <?php echo GridView::widget([
                    'summary' => '',
                    'dataProvider' => $questions,
                    'columns' => [
                        [
                            'label' => 'No.',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width:5%'],
                            'attribute' => 'number',
                        ],
                        [
                            'label' => "Pernyataan / Statement",
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
                                $data = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
                                return $form->field($model1, "$model->bhgn$model->number")->radioButtonGroup($data, ['class' => '', 'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
                ?>

                <div class="ln_solid"></div>
                <div class="form-group text-center">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Sebelumnya / Back', Url::to(['bhgn-a']), ['class' => 'btn btn-warning']) ?>
                    &nbsp;
                    <?= Html::submitButton('<i class="fa fa-arrow-right"></i> Seterusnya / Next', ['class' => 'btn btn-primary']); ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>