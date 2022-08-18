<?php
$js = <<< JS
$("#login-form").on("beforeSubmit",function(e){
    // alert('test');
    $("#buttonBhg1").prop('disabled', true);
    $("#resetBhg1").prop('disabled', true);
    e.preventDefault();
    $("#login-form").css({pointerEvents:'none'});
    return true;
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\elnpt\TblPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\elnpt\elnpt2\RefAspekSkor;
use app\models\elnpt\TblPenyeliaan;
use app\models\elnpt\simulation\RefPeribadiPelajar;
use yii\db\Expression;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['name-list']);

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="panel-body">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No Matrik</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'nomatrik_pljr')->label(false)->widget(Select2::classname(), [
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                'id' => 'pljr_matrik',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalPljr")'),
                                'allowClear' => true,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $url,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term, page:params.page || 1}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Penyeliaan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'tahap_penyeliaan')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblPenyeliaan::find()
                                ->select('distinct(KodTahapPenyeliaan) as KodTahapPenyeliaan, TahapPenyeliaanBI as TahapPenyeliaanBI')
                                ->all(), 'KodTahapPenyeliaan', 'TahapPenyeliaanBI'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                'id' => 'pljr_selia',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalPljr")'),
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Penyeliaan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'status_penyeliaan')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblPenyeliaan::find()
                                ->select('distinct(KodStatusPengajian) as KodStatusPengajian, StatusPengajianBI as StatusPengajianBI')
                                ->all(), 'KodStatusPengajian', 'StatusPengajianBI'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                'id' => 'pljr_status',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalPljr")'),
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Level Pengajian</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'level_pengajian')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '4' => 'Sarjana (Kerja Kursus)',
                                '5' => 'Sarjana Muda (Projek Tahun Akhir)',
                                '6' => 'Sarjana Muda (Latihan Industri/ Latihan Amali/ Praktikum/ PUPUK)',
                                '7' => 'Sarjana Klinikal CM/ MM',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                'id' => 'pljr_level',
                            ],
                            'pluginOptions' => [
                                'dropdownParent' => new JsExpression('$("#modalPljr")'),
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen Sokongan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                        if (!($model->isNewRecord)) {
                            // echo Html::a(Yii::$app->FileManager->NameFile($model->filehash));
                            // echo '&nbsp&nbsp&nbsp&nbsp';
                            // if ($pnp->id) {
                            //     echo Html::a('Padam', ['deletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';
                            echo $form->field($model, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
                                    'id' => 'file_' . $kategori,
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                                    // 'showCaption' => true,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'overwriteInitial' => true,
                                    'initialPreviewAsData' => true,
                                    // 'initialPreviewFileType' => 'pdf',
                                    // 'browseLabel' => '',
                                    // 'removeLabel' => '',
                                    'initialPreview' => [
                                        Yii::$app->FileManager->DisplayFile($model->filehash)
                                    ],
                                    'fileActionSettings' => [
                                        'showRemove' => false,
                                        // 'showZoom' => false
                                    ]
                                ]
                            ])->label(false);
                            // }
                        } else {
                            // echo $form->field($model, 'file')->fileInput()->label(false);
                            echo $form->field($model, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
                                    'id' => 'file_' . $kategori,
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                                    // 'showCaption' => true,
                                    // 'showRemove' => true,
                                    'showUpload' => false,
                                    'overwriteInitial' => true,
                                ]
                            ])->label(false);
                        }
                        // echo $model->filehash;
                        ?>
                    </div>
                    <!--<span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>-->
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'resetBhg1']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'id' => 'buttonBhg1']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>