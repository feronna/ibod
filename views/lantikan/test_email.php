<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use app\models\hronline\Gelaran;
use app\models\hronline\Agama;
use app\models\hronline\Bangsa;
use app\models\hronline\Etnik;
use app\models\hronline\JenisDarah;
use app\models\hronline\Jantina;
use app\models\hronline\TarafPerkahwinan;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\StatusWarganegara;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\StatusUniform;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\StatusLantikan;
use app\models\hronline\GredJawatan;
use app\models\hronline\StatusSandangan;
use app\models\hronline\JenisLantikan;
use app\models\hronline\Kampus;
use dosamigos\datepicker\DatePicker;


$js = <<<js



$(document).ready(function(){


    var temp = '';
    var email = '';
    var t_i = 0;
    var cur_i = 0;
    var cur_i_t = 0;


    $("#namas").keyup(function(e){
        
        var emel = $("#nama").val();
        var j = emel.length;
        var i = emel.length - 1;

        if(e.keyCode == 8 || e.keyCode == 46){
            alert('this is backspace');
        }
        if(e.keyCode == 32){
            alert('this is spacebar');
        }


        if(t_i === 0){
            temp = '';
        }

        if(t_i === i){
            if((emel.charAt(i) !== '@') && (emel.charAt(i) !== ' ')){
                temp = temp + emel.charAt(i);
            }
            //alert('masuk') ;
        
            t_i = t_i + 1;
        }else if(t_i > i){ 
            temp = temp.slice(0,j);

            t_i = i + 1;
        }else if(t_i < i){

            t_i = i;
        }else{
            alert( i + ' / ' + t_i) ;
            t_i = i;
        }

        // alert(temp + ' ' + i + ' ' + t_i) ;
        alert('email : ' + temp);


        
        

        
        
    });

    
    


});
js;

$this->registerJs($js);

?>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>


<div class="tblprcobiodata-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel" style="background-color:#b4bdcc;color:black;">
        <div class="x_title">
            <h2>Test Email Suggestion</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No. KP / Paspot: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true, 'id' => 'ic'])->label(false) ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 nama">
                    <?= $form->field($model, 'CONm')->textInput(['maxlength' => true, 'id' => 'nama'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mel Dicadangkan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 ">
                    <?= $form->field($model, 'COEmail')->textInput(['maxlength' => true, 'id' => 'emels'])->label(false) ?>

                </div>
                <?= Html::submitButton('Jana Email', ['name' => 'janaemail', 'value' => 'janaemail', 'class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>

            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>