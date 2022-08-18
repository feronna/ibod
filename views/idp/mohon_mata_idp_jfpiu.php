<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\myidp\Kategori;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpRefPeringkat;
//use kartik\daterange\DateRangePicker;
use dosamigos\datepicker\DateRangePicker;

$this->title = Yii::t('app', 'Permohonan Mata IDP (Berkumpulan)');

echo $this->render('/idp/_topmenu');
echo $this->render('/idp/contact');
?>
<style>
    a:link {
        color: green;
        background-color: transparent;
        text-decoration: none;
    }

    a:visited {
        color: indigo;
        background-color: transparent;
        text-decoration: none;
    }

    a:hover {
        color: red;
        background-color: transparent;
        text-decoration: underline;
    }

    a:active {
        color: yellow;
        background-color: transparent;
        text-decoration: underline;
    }
</style>

<div class="rpt-tbl-aduan-create">
    <!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($this->title) ?></h2>
                </div>
                </br>

                <div class="rpt-tbl-aduan-form">

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                    <form class="needs-validation" novalidate>

                        <div class="x_content">

                            <div class="col-md-10 col-sm-10 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kursus / Latihan / Program</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'namaProgram')->textarea(array('rows' => 12, 'cols' => 5, 'class' => 'form-control', 'placeholder' => 'Sila isi tajuk kursus / latihan / program di sini...', 'disabled' => false))->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Penganjur</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        $form->field($model, 'jenisPenganjur')->label(false)->widget(
                                            Select2::classname(),
                                            [
                                                'data' => [
                                                    '1' => 'Agensi Luar (External Agencies)',
                                                    '2' => 'UMS (JAFPIB/Persatuan/Kesatuan/Kelab)'
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih',
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penganjur</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?= $form->field($model, 'namaPenganjur')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php // Client validation of date-ranges when using with ActiveForm
                                        // $form = ActiveForm::begin([
                                        //     'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
                                        // ]);
                                        // echo '<label class="form-label">';
                                        // echo DatePicker::widget([
                                        //     'model' => $model,
                                        //     'attribute' => 'tarikhMula',
                                        //     'attribute2' => 'tarikhTamat',
                                        //     'options' => ['placeholder' => 'Tarikh mula'],
                                        //     'options2' => ['placeholder' => 'Tarikh tamat'],
                                        //     'type' => DatePicker::TYPE_RANGE,
                                        //     'form' => $form,
                                        //     'pluginOptions' => [
                                        //         'format' => 'yyyy-mm-dd',
                                        //         'autoclose' => true,
                                        //     ]
                                        // ]);

                                        // ActiveForm::end();
                                        ?>
                                        <?= $form->field($model, 'tarikhMula')->widget(DateRangePicker::className(), [
                                            'attributeTo' => 'tarikhTamat',
                                            'labelTo' => 'hingga',
                                            'form' => $form, // best for correct client validation
                                            'language' => 'en',
                                            'size' => 'ms',
                                            'options' => [
                                                'placeholder' => 'Tarikh mula'
                                            ],
                                            'optionsTo' => [
                                                'placeholder' => 'Tarikh tamat'
                                            ],
                                            'clientOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd',
                                                'todayHighlight' => true,
                                                'orientation' => 'bottom'
                                                //'minView' => 0, /** don't know what this is for */
                                                //'daysOfWeekDisabled' => false
                                                //'daysOfWeekDisabled' => '0,6'
                                            ]
                                        ])->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Surat Jemputan Menghadiri Latihan (1)</label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($model, 'file1')->fileInput()->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Surat Kelulusan Menghadiri Latihan (2)</label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($model, 'file2')->fileInput()->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Sijil Atau Bukti Penyertaan (3)</label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($model, 'file3')->fileInput()->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi Peserta Akademik<span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php

                                        $kompetensi_aka = Kategori::find()
                                            ->where(['academic' => '1'])
                                            ->orderBy("kategori_id")
                                            ->all();

                                        $listData = ArrayHelper::map($kompetensi_aka, 'kategori_id', 'kategori_nama');

                                        echo $form->field($model, 'kompetensiPohon2')->label(false)->widget(Select2::classname(), [
                                            'data' => $listData,
                                            'options' => ['placeholder' => 'Sila Pilih'],
                                        ]);

                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi Peserta Pentadbiran<span class="required"></span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php

                                        $kompetensi_pen = Kategori::find()
                                            ->where(['admin' => '1'])
                                            ->orderBy("kategori_id")
                                            ->all();

                                        $listData = ArrayHelper::map($kompetensi_pen, 'kategori_id', 'kategori_nama');

                                        echo $form->field($model, 'kompetensiPohon')->label(false)->widget(Select2::classname(), [
                                            'data' => $listData,
                                            'options' => ['placeholder' => 'Sila Pilih'],
                                        ]);

                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sila Pilih Cara Tambah Peserta</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?=
                                        Select2::widget(
                                            [
                                                'name' => 'key-in-options',
                                                'data' => [
                                                    '0' => 'Sila Pilih',
                                                    '1' => 'Muatnaik fail Excel',
                                                    '2' => 'Key-in nama peserta'
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Sila Pilih Cara Tambah Peserta',
                                                    'onchange' => 'javascript:if ($(this).val() == "1"){
                                                                            $("#muatnaik").show();
                                                                            $("#taip").hide();
                                                                        } else if ($(this).val() == "2") {
                                                                            $("#taip").show();
                                                                            $("#muatnaik").hide();
                                                                         } else {
                                                                            $("#taip").hide();
                                                                            $("#muatnaik").hide();
                                                                         }'
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ]
                                        );
                                        ?>

                                    </div>
                                </div>

                                <div class="form-group" id="muatnaik" hidden>
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Muatnaik Peserta : </label>
                                    <div class="col-md-4 col-sm-4 col-xs-10">
                                        <?= $form->field($modelImport, 'fileImport')->fileInput()->label(false); ?>
                                    </div>
                                    <p align="right">
                                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/jfpiu_attendance_format.xlsx'); ?>" target="_blank">
                                            <u>Format fail. Sila muat turun&nbsp;</u>
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </a>
                                    </p>
                                </div>

                                <div class="form-group" id="taip" hidden>
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Key-in Nama Peserta : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-10">
                                        <?=
                                        // With a model and without ActiveForm
                                        Select2::widget([
                                            'name' => 'momo',
                                            //'value' => $pemohon,
                                            'id' => 'first',
                                            'data' => $allStaf,
                                            'options' => [
                                                'placeholder' => 'Tambah peserta selain anda ...'
                                            ],
                                            'pluginOptions' => [
                                                //                            'tags' => true,
                                                //                            'maximumInputLength' => 10,
                                                'allowClear' => true,
                                                'multiple' => true,
                                            ],
                                        ]);

                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <p align="right">
                                            <button class="btn btn-primary" type="submit">Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>

                                            <?= Html::resetButton('Batal', ['class' => 'btn btn-primary']) ?>
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                    <?php ActiveForm::end(); ?>

                </div>


            </div>
        </div>
    </div>
    <!-- </div> -->
</div>