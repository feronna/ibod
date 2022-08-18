<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

error_reporting(0);

$js = <<<js
    $(document).ready(function(){

        ////////ulasan or upload/////////////////
        var val1 = $("#action").val();
        switch(parseInt(val1)) {
            case 1:
                $(".upload").show();
                $(".ulasan").hide();
                break;
            case 2:
                $(".upload").hide();
                $(".ulasan").show();
                break;
            default:
                $(".upload").hide();
                $(".ulasan").hide();
                break;
        }
        $('#action').on('select2:close', function(e) {
            var val1 = $('#action').val();
            switch(parseInt(val1)) {
                case 1:
                    $(".upload").show();
                    $(".ulasan").hide();
                    break;
                case 2:
                    $(".upload").hide();
                    $(".ulasan").show();
                    break;
                default:
                    $(".upload").hide();
                    $(".ulasan").hide();
                    break;
            }
            $('#action').val(val1);
        }); 
        
    });
js;
$this->registerJs($js);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<!--$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','method' => 'get']]) ?>-->
<h5> <strong><center>EVIDENCE/OUTPUT/SUBMITTED</center></strong> </h5>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">


            <div class="x_content">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"> ACTION<span class="required">*</span>
                </label>


                <div class="col-md-6 col-sm-6 col-xs-6">

                    <?=
                    $form->field($model, 'result')->label(false)->widget(Select2::classname(), [
                        'data' => ["1" => "YES", "2" => "NO"],
                        'options' => ['placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            'id'=>'action',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div><br>


            </div>

            <div class="form-group ulasan" align="center">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">JUSTIFICATION <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

<?= $form->field($model, 'comment')->textArea(['maxlength' => true, 'rows' => 6])->label(false); ?>


                </div>
            </div>



            <div class="form-group upload"  align="center">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">UPLOAD EVIDENCE <span class="required">*</span><br>
                    <small style="color:red"><i>Please attach any related evidence</i><br>MAX SIZE: UP TO 3MB ONLY</small>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?php
if ($model->namafile) {
    ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                           href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->namafile), true); ?>" target="_blank" ><u>Download Document</u></a>
                    <?php } else {
                        ?>
                           <?= $form->field($model, 'file')->fileInput()->label(false); ?> </td>

                            <?php }
                            ?><br>
<!--                    <label class="control-label col-md-4 col-sm-4 col-xs-16">JUSTIFICATION <span class="required">*</span>
                    </label>-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
<?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>




