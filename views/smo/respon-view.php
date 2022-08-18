<?php

use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;

?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-comments-o">&nbsp;<strong>Respon</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center">Bil</th>
                            <th class="text-center">Ulasan</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <?php if ($responList) { ?>
                        <?php foreach ($responList as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><?= $v->ulasan ?></td>
                                <td>
                                    <?= $v->bio->CONm ?>
                                    <br>
                                    <?= $v->create_dt ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'action' => ['smo/respon-kj'], 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

                    <?php echo $form->errorSummary($respon); ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <?= $form->field($respon, 'ulasan')->widget(TinyMce::class, [
                                'options' => ['rows' => 10],
                                'language' => 'en',
                                'clientOptions' => [
                                    'menubar' => 'false',
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "bold italic | bullist numlist outdent indent"
                                ]
                            ])->label(false); ?>
                             <?= Html::error($respon, 'ulasan'); ?>
                        </td>
                        <td>
                            <?= $form->field($respon, 'icno')->label(false)->hiddenInput(['value' => $icno]); ?>
                            <?= $form->field($respon, 'main_id')->label(false)->hiddenInput(['value' => $model->id]); ?>
                            <?= $form->field($respon, 'redirectUrl')->label(false)->hiddenInput(['value' => $redirectUrl]); ?>
                            <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Respon', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                        </td>
                    </tr>
                    <?php ActiveForm::end(); ?>
                </table>
            </div>
        </div>
    </div>
</div>