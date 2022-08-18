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
                            $form->field($inovasi, 'kategori')->label(false)->widget(Select2::classname(), [
                                // 'data' => [
                                //     'KOLOKIUM' => 'KOLOKIUM',
                                //     'PERSIDANGAN' => 'PERSIDANGAN',
                                //     'SEMINAR' => 'SEMINAR',
                                // ],
                                'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian' => 8, 'aspek_id' => 25])->all(), 'desc', 'desc'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Projek</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($inovasi, 'nama_projek')->textInput([
                                //                                'placeholder' => 'Jam Kredit',
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($inovasi, 'peranan')->label(false)->widget(Select2::classname(), [
                                // 'data' => ['Ketua' => 'Ketua',
                                //     'Ahli' => 'Ahli Biasa',
                                //     'Pembentang' => 'Pembentang',
                                //     'Pengerusi Sesi' => 'Pengerusi Sesi',
                                //     'Keynote Speaker' => 'Keynote Speaker',
                                //     'Panel' => 'Panel',
                                //     'Pengerusi Viva Voce' => 'Pengerusi Viva Voce',
                                //     'Peserta' => 'Peserta',
                                //     'Reviewer' => 'Reviewer',
                                //     'Editor' => 'Editor',
                                //     'Berjawatan' => 'Ahli Berjawatan',
                                //     'Setiausaha' => 'Setiausaha', 
                                //     'Bendahari' => 'Bendahari', 
                                //     'Timbalan Pengerusi' => 'Timbalan Pengerusi', 
                                //     'Timbalan Setiausaha' => 'Timbalan Setiausaha',
                                //     'Examiner' => 'Examiner',
                                //     'Penceramah' => 'Penceramah',
                                //     'Penilai Tesis' => 'Penilai Tesis',
                                //     'Perunding' => 'Perunding',
                                //     'Penilai Permohonan' => 'Penilai Permohonan Geran Penyelidikan',
                                //     'Anugerah PNP' => 'Penerima Anugerah Pengajaran & Pembelajaran',
                                //     'Anugerah Penyeliaan' => 'Penerima Anugerah Penyeliaan',
                                //     'Anugerah Penyelidikan' => 'Penerima Anugerah Penyelidikan',
                                //     'Anugerah Penerbitan' => 'Penerima Anugerah Penerbitan',
                                //     'Anugerah SNI' => 'Penerima Anugerah Persidangan Dan Inovasi',
                                //     'Ketua Panel' => 'Ketua Panel',
                                //     'Ketua Perunding' => 'Ketua Perunding',
                                //     'Ketua Penilai Geran' => 'Ketua Penilai Geran',
                                //     'Ketua Editor Jurnal' => 'Ketua Editor Jurnal',
                                //     ],
                                'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian' => 8, 'aspek_id' => 26])->all(), 'desc', 'desc'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Penyertaan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($inovasi, 'tahap_penyertaan')->label(false)->widget(Select2::classname(), [
                                // 'data' => [
                                //     'ANTARABANGSA' => 'ANTARABANGSA',
                                //     'KEBANGSAAN' => 'KEBANGSAAN',
                                //     'NEGERI' => 'NEGERI',
                                //     'UNIVERSITI' => 'University / Fakulti',
                                //     ],
                                'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian' => 8, 'aspek_id' => 27])->all(), 'desc', 'desc'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bil Penerima Impak</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($inovasi, 'bil_impak')->textInput([
                                //                                'placeholder' => 'Jam Kredit',
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Amaun Geran</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($inovasi, 'amaun')->textInput([
                                //                                'placeholder' => 'Jam Kredit',
                            ])->label(false);
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
            </div>

            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>
</div>