<?php

$js = <<< JS
$("#login-form").on("beforeSubmit",function(e){
    $("#test1").show();
    $("#test2").hide();
    e.preventDefault();
    return true;
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use app\models\lppums\v2\RefAspek;
use app\models\lppums\v2\RefMonths;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\spinner\Spinner;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <?php

            echo '<div id="test1" style="display:none;">';
            echo Spinner::widget(['preset' => 'medium', 'align' => 'center', 'caption' => '<br>Borang sedang diproses, sila tunggu sebentar.']);
            echo '<div class="clearfix"></div>';
            echo '</div>';

            ?>

            <div class="panel-body" id="test2">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-right', 'data-pjax' => true]]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'month')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefMonths::find()
                                ->select('month, UPPER(slabel) as slabel')
                                // ->where(['=', 'MONTH(CURDATE())', new \yii\db\Expression('month')])
                                // ->orWhere(['=', 'MONTH(CURDATE()) - 1', new \yii\db\Expression('month')])
                                ->orderBy(['month' => SORT_ASC])
                                ->all(), 'month', 'slabel'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih Bulan',
                                'id' => 'jenis_bulan',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'ringkasan')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'Penganjur' => 'Penganjur/Jemputan',
                                'Peserta' => 'Peserta',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih Peranan',
                                'id' => 'peranan',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ringkasan Aktiviti</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($model, 'sasaran_kerja')->textArea(['maxlength' => 300, 'placeholder' => 'Nyatakan ringkasan aktiviti', 'style' => 'resize: none;'])->label(false);
                        ?>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pencapaian Sebenar</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($model, 'capai')->textArea(['maxlength' => 300, 'placeholder' => 'Nyatakan pencapaian', 'style' => 'resize: none;'])->label(false);
                        ?>
                    </div>
                </div> -->

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile"><?= ($doc->isNewRecord) ? 'Muat Naik Dokumen Sokongan: ' : 'Dokumen Sokongan: ' ?><span class="required" style="color:red;"><?= ($doc->isNewRecord) ? '*' : '' ?></span></span><br /><sub>Limit saiz fail 5MB<br />Hanya format png dan pdf diterima</sub>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                        if (!($doc->isNewRecord)) {
                            echo $form->field($doc, 'file')->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                                    'showUpload' => false,
                                    'overwriteInitial' => true,
                                    'initialPreview' => [
                                        Url::to(Yii::$app->FileManager->DisplayFile($doc->filehash), true),
                                    ],
                                    'initialPreviewAsData' => true,
                                    'initialCaption' => $doc->file_name,
                                ],
                            ])->label(false);
                        } else {
                            echo $form->field($doc, 'file')->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                                    'showUpload' => false,
                                    'overwriteInitial' => true,
                                ]
                            ])->label(false);
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-8 col-xs-12">
                        <div class="pull-right">
                            <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                            <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Kemaskini', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>