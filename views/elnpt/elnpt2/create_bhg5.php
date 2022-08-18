<?php
$js = <<< JS
$("#login-form").on("beforeSubmit",function(e){
    
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($sidang, 'kategori')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'KOLOKIUM' => 'Kolokium',
                                    'PERSIDANGAN' => 'Persidangan',
                                    'SEMINAR' => 'Seminar',
                                ],
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...',



                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Projek</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($sidang, 'nama_projek')->textInput([])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($sidang, 'peranan')->label(false)->widget(Select2::classname(), [






























                                'data' => ArrayHelper::map(app\models\elnpt\elnpt2\RefAspekSkor::find()->where(['bahagian' => 5, 'aspek_id' => 16])->all(), 'desc', 'desc'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...',



                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Penyertaan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($sidang, 'tahap')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'FAKULTI' => 'Fakulti',
                                    'UNIVERSITI' => 'Universiti',
                                    'NEGERI' => 'Negeri',
                                    'KEBANGSAAN' => 'Kebangsaan',
                                    'ANTARABANGSA' => 'Antarabangsa',
                                ],
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...',



                                ],
                                'pluginOptions' => [
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
                        if (!($doc->isNewRecord)) {




                            echo $form->field($doc, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['pdf', 'jpg', 'png'],

                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'overwriteInitial' => true,
                                    'initialPreviewAsData' => true,



                                    'initialPreview' => [
                                        Yii::$app->FileManager->DisplayFile($doc->filehash)
                                    ],
                                    'fileActionSettings' => [
                                        'showRemove' => false,

                                    ]
                                ]
                            ])->label(false);
                        } else {

                            echo $form->field($doc, 'file')->widget(kartik\widgets\FileInput::classname(), [
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