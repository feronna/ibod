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
use kartik\widgets\FileInput;
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Projek ID</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($pnp, 'projek_id')->textInput([
                                //                                'placeholder' => 'Jam Kredit',
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Projek</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'tajuk_projek')->textInput([
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
                                'data' => ArrayHelper::map(TblPenyelidikan::find()
                                    ->select(['distinct(Membership)'])
                                    //                                    ->where(['like', 'KodSesi_Sem', '2019'])
                                    //                                    ->groupBy(['SMP07_KodMP'])
                                    ->all(), 'Membership', 'Membership'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pembiaya</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'pembiaya')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblPenyelidikan::find()
                                    ->select(['distinct(GrantTypeDecs)'])
                                    //                                    ->where(['like', 'KodSesi_Sem', '2019'])
                                    //                                    ->groupBy(['SMP07_KodMP'])
                                    ->all(), 'GrantTypeDecs', 'GrantTypeDecs'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Pembiaya</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'kategori_pembiaya')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'GERAN UNIVERSITI' => 'GERAN UNIVERSITI', 'GERAN LUAR (TEMPATAN)' => 'GERAN LUAR (TEMPATAN)',
                                    'GERAN LUAR (ANTARABANGSA)' => 'GERAN LUAR (ANTARABANGSA)'
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Biaya (RM)</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'jumlah_biaya')->textInput([
                                //                                'placeholder' => 'Jam Kredit',
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $pnp,
                                'attribute' => 'mula',
                                //                        'template' => '{input}{addon}',
                                'type' => DatePicker::TYPE_INPUT,
                                'options' => ['placeholder' => 'Tarikh Mula'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $pnp,
                                'attribute' => 'tamat',
                                //                        'template' => '{input}{addon}',
                                'type' => DatePicker::TYPE_INPUT,
                                'options' => ['placeholder' => 'Tarikh Tamat'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'status')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblPenyelidikan::find()
                                    ->select(['distinct(ResearchStatus)'])
                                    //                                    ->where(['like', 'KodSesi_Sem', '2019'])
                                    //                                    ->groupBy(['SMP07_KodMP'])
                                    ->all(), 'ResearchStatus', 'ResearchStatus'),
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