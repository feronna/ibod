<?php
$js = <<< JS
$( document ).ready(function() {
    $('.pjax-delete-aktiviti').on('click', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('delete-url')
        var result = confirm('Are you sure you want to delete this item?');                                
        if(result) {
            $.ajax({
                url: deleteUrl,
                type: 'post',
                error: function(xhr, status, error) {
                    alert('There was an error with your request.' + xhr.responseText);
                }
            }).done(function(data) {
                $.pjax.reload({
                    container: '#pjax_aktiviti_lain',
                    url: 'pjax-aktiviti-lain?lppid=$lppid&kategori=$kategori',
                });
            });
        }
    });
});

$(document).on('ready pjax:success', function() {
    $('.pjax-delete-aktiviti').on('click', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('delete-url')
        var result = confirm('Are you sure you want to delete this item?');                                
        if(result) {
            $.ajax({
                url: deleteUrl,
                type: 'post',
                error: function(xhr, status, error) {
                    alert('There was an error with your request.' + xhr.responseText);
                }
            }).done(function(data) {
                $.pjax.reload({
                    container: '#pjax_aktiviti_lain',
                    url: 'pjax-aktiviti-lain?lppid=$lppid&kategori=$kategori',
                });
            });
        }
    });
});

$("#login-form").on("beforeSubmit",function(e){
    // alert('test');

    // $("#buttonBhg1").prop('disabled', true);
    // $("#resetBhg1").prop('disabled', true);
    // e.preventDefault();
    // $("#login-form").css({pointerEvents:'none'});

    var form = $(this);
    // var formData = form.serialize();
    var formData = new FormData($('#login-form')[0]);
    console.log(formData);

    $.ajax({
        url: form.attr("action"),
        type: 'post',
        data: formData,
        success: function (data) {
            if(data.success){
            $.pjax.reload({
                container: '#pjax_aktiviti_lain',
                url: 'pjax-aktiviti-lain?lppid=$lppid&kategori=$kategori',
            });

            $('#reset_form').click();
            }
        },
        error: function () {
            alert("Something went wrong. Please contact the System Administrator.");
        },
        cache: false,
        contentType: false,
        processData: false,
    });

    // return true;
}).on('submit', function(e){
    e.preventDefault();

});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);
$this->registerCss('
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
');

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\elnpt\TblPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\elnpt\elnpt2\RefAspekSkor;

$arry = [];
if ($kategori == 2) {
    $arry = [
        'utama' => 'Penyelia utama/ tunggal',
        'bersama' => 'Penyelia bersama',
    ];
} else if ($kategori == 3) {
    $arry = [
        'ketua' => 'Ketua',
        'ahli' => 'Ahli',
    ];
} else if ($kategori == 5) {
    $arry = [
        'ketua' => 'Ketua',
        'exco' => 'Exco',
        'ahli' => 'Ahli Biasa',
    ];
}

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => ['tambah-aktiviti-lain?lppid=' . $lppid . '&kategori=' . $kategori], 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aktiviti / Kursus</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?=
                        $form->field($model, 'title')->textInput([])->label(false);
                        ?>
                    </div>
                </div>

                <?php if ($kategori == 1) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <?=
                            $form->field($model, 'jenis')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'OER' => 'OER',
                                    'SULAM' => 'SULAM',
                                    'Microcredentials' => 'Microcredentials',
                                    'MOOC' => 'MOOC',
                                    'Mobiliti Pelajar' => 'Mobiliti Pelajar',
                                ],
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...',
                                    //                                'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    'id' => 'jenis_carian_' . $kategori,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($kategori != 1) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <?=
                            $form->field($model, 'peranan')->label(false)->widget(Select2::classname(), [
                                'data' => $arry,
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...',
                                    //                                'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    'id' => 'peranan_carian_' . $kategori,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                <?php } ?>

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
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'reset_form']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'id' => 'submit']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <?=
                    \kartik\grid\GridView::widget([
                        'id' => 'aktiviti_lain',
                        'emptyText' => 'Tiada Rekod',
                        'striped' => false,
                        'summary' => '',
                        'dataProvider' => $dataProvider,
                        'pjax' => true,
                        'pjaxSettings' => [
                            'options' => [
                                'id' => 'pjax_aktiviti_lain',
                            ],
                        ],
                        'showFooter' => false,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'AKTIVITI',
                                'headerOptions' => ['class' => 'column-title text-center'],
                                // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                'value' => function ($model, $key, $index) {
                                    return $model->title;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => ($kategori == 1) ?  'JENIS' : 'PERANAN',
                                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                'value' => function ($model, $key, $index) use ($kategori) {
                                    return ($kategori == 1) ?  $model->jenis : $model->peranan;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'DOKUMEN SOKONGAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) use ($lppid) {
                                        return Html::a(
                                            "<i class='fa fa-file' aria-hidden='true'></i>",
                                            Url::to(['elnpt3/view-file', 'hashfile' => $model->filehash, 'lppid' => $lppid]),
                                            ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']
                                        ) .
                                            '<sub><b>' . ((strlen($model['verified_by']) != 0 && !is_null($model['verified_by'])) ? '<span class="label label-success">Verified</span>' : '<span class="label label-default">Unverified</span>') . '</b></sub>';
                                        // return $model->id;
                                    },
                                ],
                                // 'visibleButtons' => [
                                //     'view' => function ($model, $key, $index) use ($lpp) {
                                //         return ($model['ver_by'] == 'SMP UMS')  ? false : true;
                                //     }
                                // ]
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model, $key) use ($lppid) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                            'class' => 'btn btn-default btn-sm pjax-delete-aktiviti',
                                            'delete-url' =>  Url::to(['elnpt3/padam-aktiviti-lain', 'id' => $model->id, 'lppid' =>  $lppid]),
                                            // 'data' => [
                                            //     'confirm' => 'Are you sure you want to delete this item?',
                                            //     'method' => 'post',
                                            // ],
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>