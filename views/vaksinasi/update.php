<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblvaksinasi;
use kartik\popover\PopoverX;

$js = <<<js
    $(document).ready(function(){

        ////////sebab belum mendaftar/////////////////
        var val1 = $("#daftar").val();
        switch(parseInt(val1)) {
            case 0:
                $(".sebab").show();
                break;
            default:
                $(".sebab").hide();
                break;
        }
        $('#daftar').on('select2:close', function(e) {
            var val1 = $('#daftar').val();
            switch(parseInt(val1)) {
                case 0:
                    $(".sebab").show();
                    break;
                default:
                    $(".sebab").hide();
                    break;
            }
            $('#daftar').val(val1);
        }); 

        ////////sebab tidak menerima vaksin/////////////////
        var val1 = $("#vaksin").val();
        switch(parseInt(val1)) {
            case 0:
                $(".sebabxvaksin").show();
                break;
            default:
                $(".sebabxvaksin").hide();
                break;
        }
        $('#vaksin').on('select2:close', function(e) {
            var val1 = $('#vaksin').val();
            switch(parseInt(val1)) {
                case 0:
                    $(".sebabxvaksin").show();
                    break;
                default:
                    $(".sebabxvaksin").hide();
                    break;
            }
            $('#vaksin').val(val1);
        }); 
        
    });
js;
$this->registerJs($js);



?>

<?php
$content =  Html::img('@web/uploads/hronline/keluarga/mysj.png', ['class' => 'pull-left img-responsive']);

?>


<div class="tblvaksinasi-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h4><?= "KEMASKINI MAKLUMAT VAKSINASI" ?></h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ID MySejahtera: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'mysj_id')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    <?=
                    PopoverX::widget([
                        'header' => 'ID dalam applikasi MySejahtera',
                        'size' => PopoverX::SIZE_X_SMALL,
                        'placement' => PopoverX::ALIGN_BOTTOM,
                        'content' => $content,
                        'toggleButton' => ['label' => 'Rujukan', 'class' => 'btn btn-default'],
                    ]);
                    ?>
                </div>
            </div>
            </br>
            <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12 "> Ada ID MySejahtera: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                // $form->field($model, 'mysj_id_st')->label(false)->widget(Select2::classname(), [
                //     'data' => ["1" => "ADA", "0" => "TIDAK ADA"],
                //     'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12',],
                //     'pluginOptions' => [
                //         'allowClear' => true
                //     ],
                // ]);
                ?>
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sudah Mendaftar Vaksin: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'daftar_st')->label(false)->widget(Select2::classname(), [
                        'data' => ["1" => "YA", "0" => "BELUM"],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'daftar'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group sebab">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Belum Mendaftar: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'sebab_1')->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12',])->label(false) ?>

                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bersetuju Menerima Vaksin: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'setuju_st')->label(false)->widget(Select2::classname(), [
                        'data' => ["1" => "SETUJU", "0" => "TIDAK SETUJU"],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'vaksin'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group sebabxvaksin">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Tidak Menerima Vaskin: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'sebab_2')->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <?= $from ? '' : Html::a('Kembali', ['view'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>