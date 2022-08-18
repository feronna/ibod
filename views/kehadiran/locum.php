<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
?>

<style>
    ul {
        list-style-type: none;
        padding: 0;
    }

    .html-marquee {
        height: auto;
        width: inherit;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i>&nbsp;Locum Attendance</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content text-center">


                <h2><?php echo date('l, jS \of F Y'); ?></h2>
                <h1 class="text-center align-center"><p class="text-monospace" id="clock"></p></h1>

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]) ?>
                <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-6 col-xs-12"><?= $model->getAttributeLabel('remark'); ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo $form->field($model, 'remark')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => $model->isNewRecord ? false : true]); ?>
                    </div>
                </div>
                <p id="demo"> </p>
                <div class="ln_solid"></div>

                <div class="form-group">
                    <?php if ($model->isNewRecord) { ?>
                        <?=
                        Html::submitButton('<i class="fa fa-sign-in"></i>&nbsp;Clock In', ['class' => 'btn btn-success', 'data' => [
                                'confirm' => 'Are you sure clock in?',
                            ],])
                        ?>
                    <?php } else { ?>
                        <?=
                        Html::submitButton('<i class="fa fa-sign-out"></i>&nbsp;Clock out', ['class' => 'btn btn-danger', 'data' => [
                                'confirm' => 'Are you sure clock out?',
                            ],])
                        ?>
                    <?php } ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;Your Records for this Month</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content text-center">
                <?php Pjax::begin(); ?>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'formatDate',
                        'day',
                        'formatTimeIn',
                        'formatTimeOut',
                        'remark',
                    ],
                    'hover' => true,
                    'condensed' => true,
                ]);
                ?>
                <?php Pjax::end(); ?>


            </div>
        </div>
    </div>
</div>


<?php
$script = <<< JS
        
       $(document).ready(function () {
        var x = document.getElementById("demo");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
                    "<br>Longitude: " + position.coords.longitude;

            document.getElementById("tbllocums-latlng").value = position.coords.latitude + ',' + position.coords.longitude;
        
            $("#zone").load('$url_zone', {
                latlng: position.coords.latitude + ',' + position.coords.longitude,
            });
        
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }

        getLocation();
       
        var myVar = setInterval(function () {
            myTimer();
        }, 1000);

        function myTimer() {
            var d = new Date();
            document.getElementById("clock").innerHTML = d.toLocaleTimeString();
        }
        

    });

JS;
$this->registerJs($script, View::POS_END);
?>

