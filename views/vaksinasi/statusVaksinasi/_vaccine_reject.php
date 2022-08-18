<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblvaksinasi;
use kartik\popover\PopoverX;

$js = <<<js
    $(document).ready(function(){

        
        ////////sebab belum vaksin/////////////////
        var val1 = $("#status_vaksin").val();
        switch(parseInt(val1)) {
            case 0:
                $(".sebab_belum_terima").show();
                $(".sudah_terima").hide();
                break;
            default:
                $(".sebab_belum_terima").hide();
                $(".sudah_terima").show();
                $("#sbt").val(0);
                $(".lsbt").hide();
                break;
        }
        $('#status_vaksin').on('select2:close', function(e) {
            var val1 = $('#status_vaksin').val();
            switch(parseInt(val1)) {
                case 0:
                    $(".sebab_belum_terima").show();
                    $(".sudah_terima").hide();
                    $('#dos1').val(0);
                    $('#dos2').val(0);
                    break;
                default:
                    $(".sebab_belum_terima").hide();
                    $(".sudah_terima").show();
                    $("#sbt").val(0);
                    $(".lsbt").hide();
                    break;
            }
            $('#status_vaksin').val(val1);
        }); 

        ////////lampiran sebab belum vaksin/////////////////
        var val1 = $("#sbt").val();
        switch(parseInt(val1)) {
            case 1:
            case 2:
                $(".lsbt").show();
                break;
            default:
                $(".lsbt").hide();
                break;
        }

        $('#sbt').on('select2:close', function(e) {
            var val1 = $('#sbt').val();
            switch(parseInt(val1)) {
                case 1:
                case 2:
                    $(".lsbt").show();
                    break;
                default:
                    $(".lsbt").hide();
                    break;
            }
            $('#sbt').val(val1);
        }); 



    });
js;
$this->registerJs($js);



?>

<?php
$content =  Html::img('@web/uploads/hronline/vaksinasi/SijilDigitalVaksinasi.jpeg', ['class' => 'pull-left img-responsive']);

?>


<div class="tblvaksinasi-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h4><?= "KEMASKINI MAKLUMAT VAKSINASI" ?></h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            </br>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Belum Terima: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'sebab_belum_terima')->label(false)->widget(Select2::classname(), [
                        'data' => ["1" => "Tidak Layak", "2" => "Menolak", "3"=>"Belum Dapat Temujanji"],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12','id'=>'sbt'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Muatnaik Lampiran Sokongan: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if ($model->isNewRecord ? $msg = 'Sila muatnaik lampiran sokongan daripada doktor.' : ($model->lampiran ? $msg =  Yii::$app->FileManager->NameFile($model->lampiran) : $msg = 'Sila muatnaik lampiran sokongan daripada doktor.'));
                    echo $form->field($model, 'lampiran_')->fileInput()->label($msg); ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>Sila muatnaik dokumen/surat sokongan daripada doktor berkaitan pengambilan vaksin Covid-19.</text>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true,'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12',])->label(false) ?>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::a('Kembali', ['view-status-vaksinasi'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>