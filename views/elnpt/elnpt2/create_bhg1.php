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
use yii\helpers\ArrayHelper;
use app\models\elnpt\RefPnpKursus;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\FileInput;

$curr_year = $lpp->tahun;

$semester = [
    // '1-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '1 - ' . ($curr_year - 1) . '/' . ($curr_year) . '',
    '2-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '2-' . ($curr_year - 1) . '/' . ($curr_year) . '',
    '3-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '3-' . ($curr_year - 1) . '/' . ($curr_year) . '',
    '1-' . ($curr_year) . '/' . ($curr_year + 1) . '' => '1-' . ($curr_year) . '/' . ($curr_year + 1) . '',
    // '2-' . ($curr_year) . '/' . ($curr_year + 1) . '' => '2 - ' . ($curr_year) . '/' . ($curr_year + 1) . '',
    // '3-' . ($curr_year) . '/' . ($curr_year + 1) . '' => '3 - ' . ($curr_year) . '/' . ($curr_year + 1) . '',
    'Nursing' => [
        '1-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '1-' . ($curr_year - 1) . '/' . ($curr_year) . '',
    ]
];

if ($lpp->jfpiu == 138) {
    // array_merge($semester, [
    //     'Rotation 1' => 'Rotation 1',
    //     'Rotation 2' => 'Rotation 2',
    //     'Rotation 3' => 'Rotation 3',
    //     'Rotation 4' => 'Rotation 4',
    //     'Rotation 5' => 'Rotation 5',
    //     'Rotation 6' => 'Rotation 6',
    // ]);
    $semester = $semester + [
    '[R1-2020/2021]' => 'Rotation 1',
    '[R2-2020/2021]' => 'Rotation 2',
    '[R3-2020/2021]' => 'Rotation 3',
    '[R4-2020/2021]' => 'Rotation 4',
    '[R5-2020/2021]' => 'Rotation 5',
    '[R6-2020/2021]' => 'Rotation 6',
];
}
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Kursus</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($pnp, 'kod_kursus')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefPnpKursus::find()
                                ->select(['distinct(KodSubjek)'])
                                //                                    ->where(['like', 'KodSesi_Sem', '2019'])
                                //                                    ->groupBy(['SMP07_KodMP'])
                                ->all(), 'KodSubjek', 'KodSubjek'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                'id' => 'ppp'
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kursus</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($pnp, 'nama_kursus')->label(false)->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            //                            'data' => ArrayHelper::map(RefPnpKursus::find()
                            //                                    ->select('distinct(SMP07_KodMP) as id, NamaKursus as name')
                            ////                                    ->select(['SMP07_KodMP'])
                            ////                                    ->where(['like', 'KodSesi_Sem', '2019'])
                            ////                                    ->groupBy(['SMP07_KodMP'])
                            //                                    ->all(), 'NamaKursus', 'NamaKursus'),
                            'options' => ['id' => 'subcat1-id', 'placeholder' => 'Carian ...'],
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                //'placeholder' => 'Pilih PPP',
                                'depends' => ['ppp'],
                                'url' => Url::to(['/elnpt/pnp-kursus-list']),
                                //                                'params' => ['input-type-1', 'input-type-2']
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Skop Tugas</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($pnp, 'skop_tugas')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                // 0 => 'TIADA', 
                                'Pensyarah' => 'Pensyarah',
                                'Penyelaras' => 'Penyelaras',
                                'Pensyarah_Penyelaras' => 'Pensyarah & Penyelaras',
                                'Tutor' => 'Tutor',
                            ],
                            'hideSearch' => true,
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengendalian</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($pnp, 'status_pengendalian')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                // 0 => 'TIADA', 
                                'DIKENDALIKAN OLEH SAYA SEORANG SAHAJA' => 'DIKENDALIKAN OLEH SAYA SEORANG SAHAJA',
                                'DIKENDALIKAN OLEH 2 ORANG' => 'DIKENDALIKAN OLEH 2 ORANG',
                                'DIKENDALIKAN OLEH 3 ORANG' => 'DIKENDALIKAN OLEH 3 ORANG',
                                'DIKENDALIKAN OLEH 4 ORANG' => 'DIKENDALIKAN OLEH 4 ORANG',
                                'DIKENDALIKAN OLEH 5 ORANG' => 'DIKENDALIKAN OLEH 5 ORANG',
                                'DIKENDALIKAN OLEH LEBIH 5 ORANG' => 'DIKENDALIKAN OLEH LEBIH 5 ORANG',
                            ],
                            'hideSearch' => true,
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Penglibatan Tutor / Demonstrator</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($pnp, 'penglibatan')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'TIADA' => 'TIADA',
                                'ADA' => 'ADA',
                            ],
                            'hideSearch' => true,
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesi / Semester</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($tblPnp, 'semester')->label(false)->widget(Select2::classname(), [
                            'data' => $semester,
                            'hideSearch' => true,
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile"><?= ($doc->isNewRecord) ? 'Muat Naik Dokumen Sokongan: ' : 'Dokumen Sokongan: ' ?><span class="required" style="color:red;"><?= ($doc->isNewRecord) ? '*' : '' ?></span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                        if (!($doc->isNewRecord)) {
                            // echo Html::a(Yii::$app->FileManager->NameFile($doc->filehash));
                            // echo '&nbsp&nbsp&nbsp&nbsp';
                            // if ($pnp->id) {
                            //     echo Html::a('Padam', ['deletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';

                            // echo $form->field($doc, 'file')->widget(FileInput::classname(), [
                            //     'options' => [
                            //         'accept' => 'application/pdf, image/jpg, image/png',
                            //         'multiple' => false,
                            //     ],
                            //     'pluginOptions' => [
                            //         'allowedFileExtensions' => ['pdf', 'jpg', 'png'],
                            //         // 'showCaption' => true,
                            //         'showRemove' => false,
                            //         'showUpload' => false,
                            //         'overwriteInitial' => true,
                            //         'initialPreviewAsData' => true,
                            //         // 'initialPreviewFileType' => 'pdf',
                            //         // 'browseLabel' => '',
                            //         // 'removeLabel' => '',
                            //         'initialPreview' => [
                            //             Yii::$app->FileManager->DisplayFile($doc->filehash)
                            //         ],
                            //         'fileActionSettings' => [
                            //             'showRemove' => false,
                            //             // 'showZoom' => false
                            //         ]
                            //     ]
                            // ])->label(false);

                            echo Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(Yii::$app->FileManager->DisplayFile($doc->filehash), true), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']);

                            // }
                        } else {
                            // echo $form->field($doc, 'file')->fileInput()->label(false);
                            echo $form->field($doc, 'file')->widget(FileInput::classname(), [
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