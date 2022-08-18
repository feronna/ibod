<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\myidp\Kategori;
use dosamigos\datepicker\DatePicker;
use app\models\myidp\RefJenisAktiviti;
//use dosamigos\datetimepicker\DateTimePicker;

// widget with default options
echo Dialog::widget();

echo $this->render('/idp/_topmenu');
error_reporting(0);

?>
<script>
    function checkDate() {

        var startDate = new Date(document.getElementById("StartDate").value);

        //    var checkDate = new Date();

        var endDate = new Date(document.getElementById("EndDate").value);
        //    if ((Date.parse(startDate)-2592000000 <= Date.parse(checkDate))) {
        //        alert("HARAP MAAF! Tarikh mula kursus haruslah lebih daripada 30 hari daripada tarikh sekarang.");
        //        document.getElementById("StartDate").value = "";
        //    }

        if ((Date.parse(endDate) <script Date.parse(startDate))) {
            alert("RALAT! Tarikh akhir kursus haruslah selepas tarikh mula. Sila isi kembali.");
            document.getElementById("EndDate").value = "";
        }
    }
</script>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Permohonan Mata IDP Kakitangan<h3><span class="label label-success" style="color: white">JAFPIB</span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <?php //$form = ActiveForm::begin(['action' => 'mohon', 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); 
                ?>
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Kursus :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'namaProgram')->textarea(array('rows' => 6, 'cols' => 5))->label(false); ?>
                    </div>
                </div>
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Anjuran :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'jenisPenganjur')->label(false)->widget(
                            Select2::classname(),
                            [
                                'data' => [
                                    '1' => 'Anjuran Agensi Luar',
                                    '2' => 'Anjuran Dalaman UMS'
                                ],
                                'options' => [
                                    'placeholder' => 'Sila Pilih...',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'id' => 'jenis_penganjur'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                                'theme' => Select2::THEME_CLASSIC,
                            ]
                        );
                        ?>
                    </div>
                </div>
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Penganjur :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'namaPenganjur')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=

                        //                      DateTimePicker::widget([
                        //                            'model' => $model,
                        //                            'attribute' => 'tarikhMula',
                        //                            'language' => 'my',
                        //                            'size' => 'ms',
                        //                            'clientOptions' => [
                        //                                'autoclose' => true,
                        //                                //'format' => 'dd MM yyyy - HH:ii P',
                        //                                'format' => 'dd MM yyyy - HH:ii P',
                        //                                'todayBtn' => true
                        //                            ]
                        //                      ]);       


                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'tarikhMula',
                            'template' => '{input}{addon}',
                            'options' => [
                                'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                'onchange' => 'checkDate()',
                                'id' => 'StartDate',
                                'required' => true,
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'startDate' => '2022-01-01',
                                'endDate' => '2022-12-31',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=

                        //                        DateTimePicker::widget([
                        //                            'model' => $model,
                        //                            'attribute' => 'tarikhTamat',
                        //                            'language' => 'my',
                        //                            'size' => 'ms',
                        //                            'clientOptions' => [
                        //                                'autoclose' => true,
                        //                                'format' => 'dd MM yyyy - HH:ii P',
                        //                                'todayBtn' => true
                        //                            ]
                        //                      ]);


                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'tarikhTamat',
                            'template' => '{input}{addon}',
                            'options' => [
                                'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                'onchange' => 'checkDate()',
                                'id' => 'EndDate',
                                'required' => true,
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'startDate' => '2022-01-01',
                                'endDate' => '2022-12-31',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <!--                <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Hari : <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?
                                //$model->daysKursus.' hari';
                                //Html::textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.'])
                                ?>
                            </div>
                        </div>-->
                <div class="form-group b">
                    <!--                <div class="form-group" >-->
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kompetensi :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        //                            $form->field($model, 'kompetensiPohon')->label(false)->widget(Select2::classname(),
                        //                                [
                        //                                    'data' => [
                        //                                        '1' => 'Kompetensi Khusus',
                        //                                        '2' => 'Kompetensi Umum'
                        //                                        ],
                        //                                    'options' => [
                        //                                        'placeholder' => 'Sila Pilih',
                        //                                        'id' => 'kompetensi',
                        //                                        ],
                        //                                    'pluginOptions' => [
                        //                                        'allowClear' => true,
                        //                                        ],
                        //                                    'theme' => Select2::THEME_CLASSIC,
                        //                                ]); 

                        //use app\models\KlusterKursus;
                        $kompetensi = Kategori::find()
                            ->orderBy("kategori_id")
                            ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData = ArrayHelper::map($kompetensi, 'kategori_id', 'kategori_nama');

                        echo $form->field($model, 'kompetensiPohon')->label(false)->widget(Select2::classname(), [
                            'data' => $listData,
                            'options' => ['placeholder' => 'Sila Pilih'],
                            'theme' => Select2::THEME_CLASSIC,
                        ]);

                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peserta : </label>
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

                        //                    Select2::widget([
                        //                        'name' => 'selection',
                        //                        'data' => $allStaf,
                        //                        'options' => ['placeholder' => 'Sila pilih...'],
                        //                        'pluginOptions' => [
                        //                            'allowClear' => true,
                        //                            'multiple' => true,
                        //                        ],
                        //                    ]);

                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Muatnaik Peserta : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelImport, 'fileImport')->fileInput()->label(false); ?>
                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/jfpiu_attendance_format.xlsx'); ?>" target="_blank"><u>FORMAT UNTUK MUAT NAIK <i class="fa fa-download" aria-hidden="true"></i></u></a>
                    </div>
                </div>
                <div class="form-group d">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Salinan Surat Jemputan Menghadiri Latihan (1) :
                        <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                        <span class="required" style="color:red;"><?php //Yii::$app->session->getFlash('Gagal'); 
                                                                    ?></span>
                        <?php

                        echo $form->field($model, 'file1')->fileInput()->label(false);

                        ?>
                    </div>
                    <span data-toggle="tooltip"><i class="fa fa-info-circle fa-lg"></i></span>
                </div>
                <div class="form-group d">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Salinan Surat Kelulusan Menghadiri Latihan (2) :
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                        <span class="required" style="color:red;"><?php //Yii::$app->session->getFlash('Gagal'); 
                                                                    ?></span>
                        <?php
                        echo $form->field($model, 'file2')->fileInput()->label(false);
                        ?>
                    </div>
                    <span data-toggle="tooltip"><i class="fa fa-info-circle fa-lg"></i></span>
                </div>
                <div class="form-group d">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Salinan Sijil Penyertaan (3) :
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                        <span class="required" style="color:red;"><?php //Yii::$app->session->getFlash('Gagal'); 
                                                                    ?></span>
                        <?php
                        echo $form->field($model, 'file3')->fileInput()->label(false);
                        ?>
                    </div>
                    <span data-toggle="tooltip"><i class="fa fa-info-circle fa-lg"></i></span>
                </div>
                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <?= Html::submitButton(
                                Yii::t('app', 'Simpan <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>'),
                                [
                                    'class' => 'btn btn-primary',
                                    //'format' => 'html',
                                    'name' => 'submit',
                                    'value' => '1',
                                    //'data' => ['confirm' => 'Simpan permohonan anda?'],
                                ]
                            ) ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p align="right">
                            <?= Html::submitButton(
                                Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'),
                                [
                                    'class' => 'btn btn-primary',
                                    //'format' => 'html',
                                    'name' => 'submit',
                                    'value' => '2',
                                    //'data' => ['confirm' => 'Hantar permohonan anda?'],
                                ]
                            ) ?></p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>