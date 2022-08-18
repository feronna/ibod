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

$tmp = ArrayHelper::map(RefAspek::find()->select('id, UPPER(aspek_label) as aspek_label, hrm.lppums_bahagian.bahagian as test')
    ->leftJoin(['hrm.lppums_bahagian'], 'hrm.lppums_bahagian.bahagian_id = hrm.lppums_v2_ref_aspek.bahagian_id')
    ->where(['<>', 'id', 14])
    // ->orderBy([new \yii\db\Expression('FIELD (test, 1,3,2)'), 'aspek_order' => SORT_ASC])
    ->orderBy(['test' => SORT_DESC, 'aspek_label' => SORT_ASC])
    // ->indexBy('test')
    ->asArray()
    ->all(), 'id', 'aspek_label', 'test');
// print_r($tmp);
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aspek</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'aspek_id')->label(false)->widget(Select2::classname(), [
                            'data' => $tmp,
                            // 'data' => [
                            //     'asd' => [
                            //         'a' => 'a',
                            //         'b' => 'b',

                            //     ]
                            // ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih Aspek',
                                'id' => 'jenis_aspek',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ringkasan Aktiviti/Projek</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($model, 'ringkasan')->textArea(['maxlength' => 300, 'placeholder' => 'Nyatakan ringkasan', 'style' => 'resize: none;'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sasaran Kerja</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($model, 'sasaran_kerja')->textArea(['maxlength' => 300, 'placeholder' => 'Nyatakan sasaran kerja', 'style' => 'resize: none;'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pencapaian Sebenar</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($model, 'capai')->textArea(['maxlength' => 300, 'placeholder' => 'Nyatakan pencapaian', 'style' => 'resize: none;'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile"><?= ($doc->isNewRecord) ? 'Muat Naik Dokumen Sokongan: ' : 'Dokumen Sokongan: ' ?><span class="required" style="color:red;"><?= ($doc->isNewRecord) ? '*' : '' ?></span><br /><sub>Limit saiz fail 5MB<br />Hanya format png dan pdf diterima</sub>
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