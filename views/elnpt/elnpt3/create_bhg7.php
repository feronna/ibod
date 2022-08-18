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
                        $form->field($pnp, 'kategori')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'Pentadbiran (Lantikan NC & ke atas)' => 'Pentadbiran (Lantikan NC & ke atas)',
                                'Pentadbiran (Lantikan Dekan/Pengarah/Timbalan Dekan/ Timbalan Pengarah)' => 'Pentadbiran (Lantikan Dekan/Pengarah/Timbalan Dekan/ Timbalan Pengarah)',
                                'Pentadbiran (Lantikan Ketua Program/ Penyelaras Gugusan)' => 'Pentadbiran (Lantikan Ketua Program/ Penyelaras Gugusan)',
                                'Pentadbiran (Ketua Jabatan/ Ketua Unit)' => 'Pentadbiran (Ketua Jabatan/ Ketua Unit)',
                                'Pentadbiran (Lantikan lain-lain)' => 'Pentadbiran (Lantikan lain-lain)',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Berelaun ?</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($pnp, 'isElaun')->widget(\kartik\checkbox\CheckboxX::classname(), [
                            // 'autoLabel' => true,
                            // 'labelSettings' => [
                            //     'label' => 'Tidak menerima APC dalam tempoh 1 tahun dari tahun penilaian',
                            //     'position' => \kartik\checkbox\CheckboxX::LABEL_RIGHT
                            // ],
                            'pluginOptions' => [
                                'threeState' => false,
                            ]
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Jawatankuasa</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($pnp, 'nama_jawatan')->textInput([
                            //                                'placeholder' => 'Jam Kredit',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($pnp, 'peranan')->label(false)->widget(Select2::classname(), [
                            //     'data' => ['JAWATAN BERELAUN DI UNIVERSITI' => 'JAWATAN BERELAUN DI UNIVERSITI',
                            // 'PENGERUSI' => 'PENGERUSI',
                            // 'TIMBALAN PENGERUSI' => 'TIMBALAN PENGERUSI',
                            // 'PENASIHAT' => 'PENASIHAT',
                            // 'PENYELARAS' => 'PENYELARAS',
                            // 'AHLI' => 'AHLI'],
                            'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian' => 7, 'aspek_id' => 23])->all(), 'desc', 'desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Lantikan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($pnp, 'tahap_lantikan')->label(false)->widget(Select2::classname(), [
                            // 'data' => ['PROGRAM' => 'PROGRAM', 'FAKULTI' => 'FAKULTI', 
                            //     'UNIVERSITI' => 'UNIVERSITI', 'DAERAH' => 'DAERAH'
                            //     , 'NEGERI' => 'NEGERI'
                            //     , 'KEBANGSAAN' => 'KEBANGSAAN'
                            //      , 'ANTARABANGSA' => 'ANTARABANGSA'],
                            'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian' => 7, 'aspek_id' => 24])->all(), 'desc', 'desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
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
                            // echo Html::a(Yii::$app->FileManager->NameFile($doc->filehash));
                            // echo '&nbsp&nbsp&nbsp&nbsp';
                            // if ($pnp->id) {
                            //     echo Html::a('Padam', ['deletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';
                            echo $form->field($doc, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
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
                                        Yii::$app->FileManager->DisplayFile($doc->filehash)
                                    ],
                                    'fileActionSettings' => [
                                        'showRemove' => false,
                                        // 'showZoom' => false
                                    ]
                                ]
                            ])->label(false);
                            // }
                        } else {
                            // echo $form->field($doc, 'file')->fileInput()->label(false);
                            echo $form->field($doc, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                'options' => [
                                    'accept' => 'application/pdf, image/jpg, image/png',
                                    'multiple' => false,
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
                        // echo $doc->filehash;
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