<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Pengenalan</li>
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
                <p>
                    Soal selidik ini mengandungi 47 pernyataan.
                    Baca dengan teliti dan jawab secara spontan dalam tempoh 5-10 minit.
                    Tiada jawapan yang betul atau salah.
                    Jawapan pertama yang terlintas di fikiran anda selalunya jawapan yang tepat untuk anda.
                </p>
                <p style="color: green">
                    <i>
                        This questionnaire contains 47 statements.
                        Read carefully and answer spontaneously within 5-10 minutes.
                        There is no correct or wrong answer.
                        The first answer that comes to your mind is always the right answer for you.
                    </i>
                </p>

                <p>
                    Data anda adalah sulit dan tidak berkaitan dengan prestasi anda.
                    Soal selidik ini dibuat bertujuan untuk membantu pengurusan universiti meningkatkan kualiti perkhidmatan tadbir urus terutamanya berkaitan kebajikan kakitangan.
                    Oleh itu, maklum balas ikhlas anda sangat diperlukan.
                </p>

                <p style="color: green">
                    <i>
                        Your data is confidential and is not related to your performance.
                        The questionnaire is aimed at helping the university’s management to improve the quality of governance services especially on the welfare of staff.
                        Therefore, your sincere feedback is needed.
                    </i>
                </p>

                <div class="ln_solid"></div>
                <?php
                $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ],
                    ],
                    'options' => ['class' => 'form-horizontal form-label-left']
                ]);
                ?>
                <?= $form->field($model, 'create_dt')->hiddenInput(['value' => $dt])->label(false); ?>


                <div class="form-group">
                    <div class="text-center">
                        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Seterusnya', ['class' => 'btn btn-success ']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>