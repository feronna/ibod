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
    <li class="breadcrumb-item active" aria-current="page">Bahagian D</li>
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
                <?= $this->render('_skala_bhgn_d') ?>
                <p>
                    Berikut merupakan sembilan pernyataan tentang bagaimana perasaan anda di tempat kerja. Sila baca setiap pernyataan dengan berhati-hati dan pilih salah satu perasaan yang berkaitan dengan pekerjaan anda. Jika anda tidak pernah merasa perasaan tersebut, tandakan ‘0’ pada ruangan yang disediakan. Jika anda pernah mengalami perasaan ini, tandakan nombor 1 hingga 6 untuk menggambarkan berapa kerap anda mengalami perasaan tersebut.
                    <br><br>
                    <i style='color:green;'>The following nine statements are about how you feel at work. Please read each statement carefully and decide if you ever feel this way about your job. If you have never had this feeling, cross the ‘0’ (zero) in the space after the statement. If you have had this feeling, indicate how often you feel it by crossing the number (from 1 to 6) that best describes how frequently you feel that way.<br>
                    </i>
                </p>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'bhgn-d',
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
                                $data = [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6];
                                return $form->field($model1, "$model->bhgn$model->number")->radioButtonGroup($data, ['class' => '', 'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
                ?>

                <div class="ln_solid"></div>
                <div class="form-group text-center">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Sebelumnya / Back', Url::to(['bhgn-c']), ['class' => 'btn btn-warning']) ?>
                    &nbsp;
                    <?= Html::submitButton('<i class="fa fa-arrow-right"></i> Seterusnya / Next', ['class' => 'btn btn-primary']); ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>