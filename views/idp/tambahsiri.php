<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;
//use kartik\select2\Select2;
use kartik\widgets\Select2;
//use yii\bootstrap\ActiveForm;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\myidp\IdpCampus;

echo $this->render('/idp/_topmenu');

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v3.3.1/css/all.css">
    <style>
        #myBtn {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Fixed/sticky position */
            bottom: 20px;
            /* Place the button at the bottom of the page */
            right: 30px;
            /* Place the button 30px from the right */
            z-index: 99;
            /* Make sure it does not overlap */
            border: none;
            /* Remove borders */
            outline: none;
            /* Remove outline */
            background-color: grey;
            /* Set a background color */
            color: white;
            /* Text color */
            cursor: pointer;
            /* Add a mouse pointer on hover */
            padding: 15px;
            /* Some padding */
            border-radius: 10px;
            /* Rounded corners */
            font-size: 18px;
            /* Increase font size */
        }

        #myBtn:hover {
            background-color: #555;
            /* Add a dark-grey background on hover */
        }
    </style>
</head>
<button onclick="topFunction()" id="myBtn" title="Go to top">&uarr;</button>
<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    function checkDate() {
        var startDate = new Date(document.getElementById("StartDate").value);
        var endDate = new Date(document.getElementById("EndDate").value);

        if ((Date.parse(endDate) < Date.parse(startDate))) {
            alert("RALAT! Tarikh akhir kursus haruslah selepas tarikh mula. Sila isi kembali.");
            document.getElementById("EndDate").value = "";
        }
    }

    $(function() {

        $('.mapBtn').click(function() {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });



    });
</script>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>
                    <h3><span class="label label-danger" style="color: white">Tambah Siri</span>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                    </h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <?= $form->field($modelSiriLatihan, 'kursusLatihanID')->hiddenInput(['value' =>  $id])->label(false) ?>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Siri : </label>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <?= $form->field($modelSiriLatihan, 'siri')->textInput()->input('readOnlyTextInput', ['readOnly' => true, 'value' => $modelSiriLatihan->getSiriAmount($id) + 1])->label(false) ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Lokasi : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'lokasi')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Mula: </label>
                    <div class="col-md-3 col-sm-3 col-xs-10">
                        <?=
                        DatePicker::widget([
                            'model' => $modelSiriLatihan,
                            'attribute' => 'tarikhMula',
                            'template' => '{input}{addon}',
                            'options' => [
                                'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                'onchange' => 'checkDate()',
                                'id' => 'StartDate',
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'startDate' => '2021-01-01',
                                'endDate' => '2022-12-31',
                            ]
                        ]);
                        ?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Akhir: </label>
                    <div class="col-md-3 col-sm-3 col-xs-10">
                        <?=
                        DatePicker::widget([
                            'model' => $modelSiriLatihan,
                            'attribute' => 'tarikhAkhir',
                            'template' => '{input}{addon}',
                            'options' => [
                                'class' => 'form-control col-lg-4 col-md-7 col-xs-12',
                                'onchange' => 'checkDate()',
                                'id' => 'EndDate',
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'startDate' => '2021-01-01',
                                'endDate' => '2022-12-31',
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Penceramah (Staf UMS): </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?=
                        //                            $form->field($modelCeramah, 'penceramahID')->label(false)->widget(Select2::classname(),
                        //                                [
                        //                                    'data' => $allStaf,
                        //                                    'options' => [
                        //                                        'placeholder' => 'Sila Pilih',
                        //                                        ],
                        //                                    'pluginOptions' => [
                        //                                        'allowClear' => true,
                        //                                        'multiple' => true,
                        //                                        ],
                        //                                    //'theme' => Select2::THEME_CLASSIC,
                        //                                ]); 



                        // With a model and without ActiveForm
                        Select2::widget([
                            'name' => 'momo',
                            'data' => $allStaf,
                            'options' => ['placeholder' => 'Sila pilih penceramah ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Penceramah (Bukan Staf UMS): </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?=
                        // With a model and without ActiveForm
                        Select2::widget([
                            'name' => 'addPenceramahLuar',
                            'data' => $allPenceramahLuar,
                            'options' => ['placeholder' => 'Sila pilih...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <!--                </div>
                <div>-->
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Kampus : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?php

                        //use app\models\IdpCampus;
                        $campus = IdpCampus::find()
                            ->orderBy("campus_name")
                            ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData = ArrayHelper::map($campus, 'campus_id', 'campus_name');

                        echo $form->field($modelSiriLatihan, 'kampusID')->dropDownList(
                            $listData,
                            ['prompt' => 'Select...']
                        )->label(false)  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Kuota : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'kuota')->textInput(['maxlength' => true, 'type' => 'number', 'min' => '1'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Pautan Latihan Atas Talian : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'linkZoom')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Pautan Bahan Kursus (Google Drive) : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                        <?= $form->field($modelSiriLatihan, 'linkBahan')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => '1']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <?php $formk = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['tambahsiri?id=' . $modelSiriLatihan->siriLatihanID],
                    'options' => ['class' => 'form-horizontal form-label-left'],
                ]);
                ?>
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">

                                    <div class="latihan-form">
                                        <div class="col-md-12">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h2>Borang Daftar Penceramah Baru</h2>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">NO KP/ NO Pasport: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?= $formk->field($model2, 'penceramah_id')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Nama: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?= $formk->field($model2, 'penceramah_name')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Biodata: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?= $formk->field($model2, 'penceramah_bio')->textarea(['rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Emel: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?= $formk->field($model2, 'email')->textInput(['maxlength' => true, 'type' => 'email'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">No Tel Pejabat: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?= $formk->field($model2, 'office_number')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">No Tel Bimbit: <span class="required" style="color:red;">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?= $formk->field($model2, 'mobile_number')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <!--                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik Bahan Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                        //echo $form->field($model2, 'file[]')->fileInput(['multiple' => true])->label(false);
                        ?>
                    </div>
                </div> -->
                                                    <div class="card-footer text-right">
                                                        <?= Html::resetButton('Batal', ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => '2']) ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <!--                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <? Html::submitButton(Yii::t('app', 'Hantar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>'), ['class' => 'btn btn-primary', 'name' => 'submit', 'value' => '1']) ?>
                                        <?php //Html::submitButton('HANTAR', ['name' => 'submit', 'value' => 'submit_1']) 
                                        ?>
                                    </div>
                                </div>-->
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>