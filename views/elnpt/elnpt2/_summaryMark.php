<?php

$js = <<<js
$('#calculator_form').on('beforeSubmit', function (e) {
    var data = JSON.stringify($(this).serializeArray());
    var partialviewcontainer = $("#test_test");
    $.ajax({
        url: 'calculator-lnpt',
        type: 'POST',
        data: {
            tmp: data,
        },
        success: function (data) {
            if(data) {
                // krajeeDialog.alert("Sila berhubung dengan PPP anda untuk membuat Subject Verification sebelum penilaian bermula.")
                partialviewcontainer.html(data);
                $('html,body').scrollTop(0);
            } 
        },
        error: function(jqXHR, errMsg) {
            alert(errMsg);
        }
     });
     return false; // prevent default submit
});
js;
$this->registerJs($js);

\yiister\gentelella\assets\Asset::register($this);

use app\models\elnpt\elnpt2\RefGred;
use app\models\elnpt\simulation\RefCalcFapi;
use app\models\elnpt\simulation\TblCalcData;
use app\models\elnpt\simulation\TblCalcInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;
?>

<div id='test_test'>

    <?php $form = ActiveForm::begin([
        'id' => 'calculator_form',
        // 'action' => ['elnpt2/calculator-lnpt'],
    ]); ?>

    <div class="row">
        <div class="col-xs-12 col-md-3 col-lg-3">
            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'gred')->label('Gred Jawatan')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefGred::find()->where(['id' => [
                            1, 2, 3, 4, 5, 15, 20, 21,
                            11, 12, 14, 26, 13,
                            6, 7, 8, 9, 10,
                        ]])->orderBy(['kump_gred' => SORT_ASC])->all(), 'kump_gred', 'kump_gred'),
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Gred',
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

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'gugusan')->label('Gugusan')->widget(Select2::classname(), [
                        'data' => [1 => 'Sains', 2 => 'Sastera'],
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Gugusan',
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

            <div class="clearfix"></div>



            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'isElaun')->label('Pentadbir')->widget(Select2::classname(), [
                        'data' => [1 => 'Pentadbir', 0 => 'Bukan Pentadbir'],
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Jenis',
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

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'fapi')->label('FAPI')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefCalcFapi::find()->orderBy(['label' => SORT_ASC])->all(), 'id', 'label'),
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Fapi',
                            //'class' => 'form-control col-md-7 col-xs-12',
                            'id' => 'fapi',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'pluginEvents' => [
                            "change" => "function() {
                                                    var myurl = 'assign-inputs?id=' + $(this).val();
                                                    $.ajax({
                                                        url: myurl,
                                                        type: 'POST',
                                                        success: function (data) {
                                                            if(data) {
                                                                $('#peratusMax').val(data.limpahan);
                                                                $('#saiz').val(data.saiz);
                                                                $('#k1_k2').val(data.k1_k2);
                                                                $('#k3_k4').val(data.k3_k4);
                                                                $('#k5').val(data.k5);
                                                                $('#k6').val(data.k6);
                                                            } 
                                                        },
                                                        error: function(jqXHR, errMsg) {
                                                            alert(errMsg);
                                                        }
                                                     });
                                                }",
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'jawatan')->label('Jawatan Pentadbiran Berelaun')->widget(Select2::classname(), [
                        'data' => array_combine(array_keys(TblCalcInput::jawatanPentadbiran()), array_keys(TblCalcInput::jawatanPentadbiran())),
                        'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Pilih Jawatan',
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

        </div>
        <div class="col-xs-12 col-md-3 col-lg-3">

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'peratusMax')->label('Peratus Limpahan (%)')->textInput(['id' => 'peratusMax', 'type' => 'number', 'step' => '0.01', 'placeholder' => '33.33', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'bilpelajar')->label('Saiz Kelas Untuk Mendapat 1 Mata')->textInput(['id' => 'saiz', 'type' => 'number', 'step' => '0.01', 'placeholder' => '0', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'pemberatK1')->label('PENGAJARAN & PENYELIAAN (%)')->textInput(['id' => 'k1_k2', 'type' => 'number', 'step' => '0.01', 'placeholder' => '40', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'pemberatK2')->label('PENYELIDIKAN & PENERBITAN (%)')->textInput(['id' => 'k3_k4', 'type' => 'number', 'step' => '0.01', 'placeholder' => '40', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'pemberatK3')->label('PERKHIDMATAN (%)')->textInput(['id' => 'k5', 'type' => 'number', 'step' => '0.01', 'placeholder' => '20', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'pemberatK4')->label('KLINIKAL (%)')->textInput(['id' => 'k6', 'type' => 'number', 'step' => '0.01', 'placeholder' => '0', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    $form->field($calcInput, 'sahsiah')->label('SAHSIAH (10%)')->textInput(['type' => 'number', 'step' => '0.01', 'placeholder' => '0', 'class' => 'form-control', 'min' => '0']);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6">
            <?=
            '<h2>RINGKASAN MARKAH</h2>' .
                \yii\widgets\DetailView::widget([
                    'model' => $arry,

                    'attributes' => [
                        [
                            'label' => 'FAPI',
                            'attribute' => 'fapi',
                            'captionOptions' => ['style' => 'width:50%'],
                        ],
                        [
                            'label' => 'GRED JAWATAN',
                            'attribute' => 'gred',
                            'captionOptions' => ['style' => 'width:50%'],
                        ],
                        [
                            'label' => 'GUGUSAN',
                            'attribute' => 'gugusan',
                            'captionOptions' => ['style' => 'width:50%'],
                        ],
                        [
                            'label' => 'MARKAH PENGAJARAN & PENYELIAAN',
                            'attribute' => '1_2',
                            'captionOptions' => ['style' => 'width:50%'],
                        ],
                        [
                            'label' => 'MARKAH PENYELIDIKAN & PENERBITAN',
                            'attribute' => '3_4',
                        ],
                        [
                            'label' => 'MARKAH PERKHIDMATAN',
                            'attribute' => '5',
                        ],
                        [
                            'label' => 'MARKAH KLINIKAL',
                            'attribute' => '6',
                        ],
                        [
                            'label' => 'JUMLAH MARKAH KOMPONEN PROFESIONAL',
                            'attribute' => 'jumlah_komponen',
                            'format'    => 'html',
                        ],
                        [
                            'label' => 'JUMLAH MARKAH KOMPONEN PROFESIONAL (90%)',
                            'attribute' => 'jumlah_komponen_pro',
                            'format'    => 'html',
                        ],
                        [
                            'label' => 'JUMLAH MARKAH KOMPONEN SAHSIAH (10%)',
                            'attribute' => 'jumlah_komponen_sahsiah',
                            'format'    => 'html',
                        ],
                        [
                            'label' => 'MARKAH KESELURUHAN',
                            'attribute' => 'markah_seluruh',
                            'format'    => 'html',
                        ],
                        [
                            'label' => 'KATEGORI PENCAPAIAN',
                            'attribute' => 'kategori',
                            'format'    => 'html',
                        ],
                    ]
                ])
            ?>
        </div>

    </div>

    <hr>

    <div class="table-responsive">
        <?=
        GridView::widget([
            'id' => 'tmp1',
            'striped' => false,
            'emptyText' => 'Tiada Rekod',
            'summary' => '',
            'dataProvider' => $dataProvider,
            'showFooter' => false,
            // 'export' => false,
            'toolbar' => [],
            'panel' => [
                'after' =>  '<div class="float-right float-end pull-right">' . Html::submitButton('Calculate', ['class' => 'btn btn-primary']) . '</div><div class="clearfix"></div>',
                // 'heading' => '<i class="fas fa-book"></i>  Library',
                'type' => 'primary',
                // 'before' => '<div style="padding-top: 7px;"><em>* Resize table columns just like a spreadsheet by dragging the column edges.</em></div>',
            ],
            'columns' => [
                // [
                //     'class' => 'yii\grid\SerialColumn',
                //     'header' => 'BIL',
                //     'headerOptions' => ['class' => 'text-center col-md-1'],
                //     'contentOptions' => ['class' => 'text-center'],
                // ],
                [
                    'header' => 'KATEGORI',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        switch ($model->kategori) {
                            case 1:
                                return '<strong>PENGAJARAN</strong>';
                            case 2:
                                return '<strong>PENYELIAAN</strong>';
                            case 3:
                                return '<strong>PENYELIDIKAN</strong>';
                            case 4:
                                return '<strong>PENERBITAN</strong>';
                            case 5:
                                return '<strong>PERKHIDMATAN</strong>';
                            case 6:
                                return '<strong>KLINIKAL</strong>';
                        }
                    },
                    'group' => true,
                    'groupedRow' => true,
                    'format' => 'html',
                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'header' => 'HAKIKI',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                    'value' => function ($model) {
                        return $model->isHakiki ? 'Hakiki' : 'Selain Hakiki';
                    },
                    'group' => true,
                    // 'groupOddCssClass' => '',  // configure odd group cell css class
                    // 'groupEvenCssClass' => '', // configure even group cell css class
                ],
                [
                    'header' => 'BIL',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                    'value' => function ($model) {
                        return $model->bil;
                    },
                    'group' => true,
                    'groupOddCssClass' => '',  // configure odd group cell css class
                    'groupEvenCssClass' => '', // configure even group cell css class
                ],
                [
                    'label' => 'AKTIVITI',
                    'headerOptions' => ['class' => 'column-title text-center'],
                    'contentOptions' => ['style' => 'vertical-align:middle'],
                    'value' => function ($model, $key, $index) use ($form, $inputs) {
                        // return $model->aktiviti ?? $form->field($inputs[$index], "[$index]jenis")->label(false)->textInput([]);
                        return
                            $model->aktiviti ?? $form->field($inputs[$index], "[$index]jenis")->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    '1.' => [
                                        1 => 'a) Buku ilmiah - Berindeks (Scopus/ WOS)',
                                        2 => 'b) Buku ilmiah - Tidak berindeks',
                                    ],
                                    '2.' => [
                                        3 => 'a) Q1',
                                        4 => 'b) Q2',
                                        5 => 'c) Q3',
                                        6 => 'd) Q4',
                                    ],
                                    '3.' => [
                                        7 => 'a) Bab dalam buku - Berindeks (Scopus/ WOS)',
                                        8 => 'b) Bab dalam buku - Tidak berindeks',
                                    ],
                                    9 => '4. Artikel jurnal - Indeks Scopus/ WoS/ ERA ',
                                    10 => '5. Artikel jurnal - Indeks MyCite',
                                    11 => '6. Prosiding Scopus',
                                    12 => '7. Lain-lain penerbitan',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Artikel sebagai co-author',
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    // 'id' => 'jenis_carian_' . $index,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width' => '50%',
                                ],
                            ]);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'INPUT/BIL UNIT',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model, $key, $index) use ($form, $inputs) {
                        return  $form->field($inputs[$index], "[$index]order_no")->label(false)->hiddenInput(['value' => $model->order_no]) . '' . $form->field($inputs[$index], "[$index]nilai_mata")->label(false)->hiddenInput(['value' => $model->nilai_mata_id]) . '' . $form->field($inputs[$index], "[$index]kategori")->label(false)->hiddenInput(['value' => $model->kategori]) . '' . $form->field($inputs[$index], "[$index]aktiviti_id")->label(false)->hiddenInput(['value' => $model->id]) . '' . $form->field($inputs[$index], "[$index]bil")->textInput(['type' => 'number', 'step' => (TblCalcData::integerOnly($index) ?  '0.01' : '1'), 'style' => 'text-align: center;', 'placeholder' => 0, 'min' => '0'])->label(false);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'MATA DIPEROLEH',
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align: middle; font-weight:bold'],
                    'value' => function ($model, $key, $index) use ($form, $inputs) {
                        return ($inputs[$index]->mata ?? 0);
                    },
                    // 'format' => 'html',
                    'format' => ['decimal', 2],
                ],
            ],
        ]);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>