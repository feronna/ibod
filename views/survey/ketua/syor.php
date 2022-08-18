<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\survey\TblVotes;
?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-briefcase"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h3 style="font-weight: bold;">Maklumat Aktiviti</h3>
                <?php
                echo DetailView::widget([
                    'model' => $aktiviti,
                    'attributes' => [
                        'nama:html',    // description attribute in HTML
                        [                      // the owner name of the model
                            'attribute' => 'dept_id',
                            'value' => $aktiviti->jfpib->fullname,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'adminpos_id',
                            'value' => $aktiviti->adminPosition->ref_position_name,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'program_id',
                            'value' => $aktiviti->programText,
                        ],               // title attribute (in plain text)
                    ],
                ]);
                ?>
                <div class="ln_solid"></div>
                <h3 style="font-weight: bold;">Maklumat Calon</h3>
                <table class="table table-striped table-sm jambo_table table-bordered" witdh="100px">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" colspan="2">Maklumat Calon</th>
                            <!-- <th class="text-center">Jumlah Survey</th> -->
                        </tr>

                    </thead>
                    <tr>
                        <td class="text-center" style="text-align:center" width="70px">
                            <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($model->icno)) ?>.jpeg" class="text-center" style="width: 70px">
                        </td>
                        <td>
                            <strong>Nama</strong> : <?php echo $model->kakitangan->CONm; ?><br>
                            <strong>UMSPER</strong> : <?php echo $model->kakitangan->COOldID; ?><br>
                            <strong>Jawatan</strong> : <?php echo $model->kakitangan->jawatan->fname; ?><br>
                            <strong>Jawatan Pentadbiran</strong> : <?php echo $model->kakitangan->CONm; ?>
                        </td>
                        <!-- <td class="text-center">
                            <p style="margin-top: 10px;font-size:50px;font-weight:bold;">
                                <?= TblVotes::totalVoteCalon($model->id); ?>
                            </p>
                        </td> -->
                    </tr>
                </table>

                <div class="ln_solid"></div>

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
                <?= $form->errorSummary($model); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan / <i><?= Html::activeLabel($model, 'catatan'); ?></i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'syor')->textarea(['rows' => 4])->label(false); ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['result', 'key' => hash('sha256', $model->aktiviti_id)], ['class' => 'btn btn-danger']) ?>
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-warning', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('Submit&nbsp;<i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>