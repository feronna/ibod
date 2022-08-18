<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;
?>

<?= Yii::$app->controller->renderPartial('/smo/_menu'); ?>

<?= Html::a('<i class="fa fa-undo"></i>&nbsp; Kembali ke senarai', ['list-assigned'], ['class' => 'btn btn-primary']) ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle">&nbsp;<strong>Butiran Maklumbalas</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Yii::$app->controller->renderPartial('/smo/view-k1', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>

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
                            <th class="text-center" style="width: 60%;">Ulasan</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center" colspan="2">Tindakan</th>
                        </tr>
                    </thead>
                    <?php if ($responList) { ?>
                        <?php foreach ($responList as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td><?= $v->ulasan ?></td>
                                <td><?= $v->respon_type ?></td>
                                <td colspan="2" class="text-center">
                                    <?= $v->bio->CONm ?>
                                    <br>
                                    <?= $v->create_dt ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-comments-o">&nbsp;<strong>Tindakan</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'action' => ['smo/respon-kj'], 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

                <?php echo $form->errorSummary($respon); ?>

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12"><?= Html::activeLabel($respon, 'respon_type'); ?>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Sila pilih untuk tindakan seterusnya"></i>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="radio" id="checkbox1" value=1 name="Respon[respon_type]" />&nbsp; Menjawab terus kepada pemaklumbalas
                        <br>
                        <input type="radio" id="checkbox2" value=2 name="Respon[respon_type]" />&nbsp; Perlu tindakan susulan
                    </div>
                </div>

                <div class="field_ulasan" style="display:hide">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"><?= Html::activeLabel($respon, 'ulasan'); ?>
                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Perincian"></i>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?= $form->field($respon, 'ulasan')->widget(TinyMce::class, [
                                'options' => ['rows' => 15],
                                'language' => 'en',
                                'clientOptions' => [
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                ]
                            ])->label(false); ?>
                        </div>
                    </div>
                </div>

                <div class="field_respon_kpd" style="display:hide">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12"><?= Html::activeLabel($respon, 'responKpd'); ?>
                            <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Aspek Penilaian"></i> -->
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php // Usage with ActiveForm and model
                            echo $form->field($respon, 'responKpd')->widget(Select2::class, [
                                'data' => ArrayHelper::map($listStaffs, 'ICNO', 'CONm'),
                                'options' => ['placeholder' => '-- PILIH PEGAWAI --'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group field_ulasan">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= $form->field($respon, 'icno')->label(false)->hiddenInput(['value' => $icno]); ?>
                        <?= $form->field($respon, 'main_id')->label(false)->hiddenInput(['value' => $model->id]); ?>
                        <?= $form->field($respon, 'redirectUrl')->label(false)->hiddenInput(['value' => $redirectUrl]); ?>
                        <?= Html::a('<i class="fa fa-undo"></i>&nbsp; Back', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php
$script = <<< JS
$(document).ready(function(){

    $(".field_respon_kpd").hide();
    $(".field_ulasan").hide();

    $('#checkbox2').click(function(){
        $(".field_respon_kpd").show();
        $(".field_ulasan").show();
    });

    $('#checkbox1').click(function(){
        $(".field_respon_kpd").hide();
        $(".field_ulasan").show();
    });

}); 
JS;
$this->registerJs($script, View::POS_END);
?>