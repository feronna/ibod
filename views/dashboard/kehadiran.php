<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use kartik\spinner\Spinner;
use aryelds\sweetalert\SweetAlert;
// use app\models\umsshield\SmartHadirDailyLog;

error_reporting(0);
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
        font-size: 14px;
        color: red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>
<?php
if (!$model->isNewRecord) {
    if ($pendingNoti != 0) {
        echo SweetAlert::widget([
            'options' => [
                'title' => "Reminder",
                'text' => "You have $pendingNoti pending tasks. Please check your Staff/Officer Menu",
                'type' => SweetAlert::TYPE_INFO,
                'animation' => 'slide-from-top',
                //        'showCancelButton' => true,
                //        'confirmButtonColor' => "#DD6B55",
                'confirmButtonText' => "Ok",
                'closeOnConfirm' => true,
            ],
        ]);
    }
} else {
    try {
        $statusshield = \app\models\umsshield\SelfRisk::status(Yii::$app->user->getId());
        $shield = \app\models\umsshield\SelfRisk::viewstatus(Yii::$app->user->getId());
        // $preVac = \app\models\umsshield\PreVacAssessment::viewstatus(Yii::$app->user->getId());
        // $smartHadir = SmartHadirDailyLog::checkQr(Yii::$app->user->getId());

        if ($statusshield != 4 && $statusshield != 6) {
            echo SweetAlert::widget([
                'options' => $shield,
                'callbackJs' => new \yii\web\JsExpression('function(isConfirm){
                var pending = ' . $pendingNoti . ';
                if (isConfirm && pending > 0) { 
                    swal("Reminder", "You have "+pending+" pending tasks. Please check your Staff/Officer Menu", "info");
                } else{
                    swal.close();
                }
            }')
            ]);
        } else {

            if ($pendingNoti != 0) {
                echo SweetAlert::widget([
                    'options' => [
                        'title' => "Reminder",
                        'text' => "You have $pendingNoti pending tasks. Please check your Staff/Officer Menu",
                        'type' => SweetAlert::TYPE_INFO,
                        'animation' => 'slide-from-top',
                        //        'showCancelButton' => true,
                        //        'confirmButtonColor' => "#DD6B55",
                        'confirmButtonText' => "Ok",
                        'closeOnConfirm' => true,
                    ],
                ]);
            }

            // if ($preVac) {
            //     echo SweetAlert::widget([
            //         'options' => $preVac,
            //         'callbackJs' => new \yii\web\JsExpression('function(isConfirm){
            //             var pending = ' . $pendingNoti . ';
            //             if (isConfirm && pending > 0) { 
            //                 swal("Reminder", "You have "+pending+" pending tasks. Please check your Staff/Officer Menu", "info");
            //             } else{
            //                 swal.close();
            //             }
            //         }')
            //     ]);
            // }
        }
    } catch (\Exception $e) {
    }
}
?>
<div class="col-md-5 col-sm-5 col-xs-12 col-lg-5">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-clock-o"></i>&nbsp;Attendance</h2>
            <ul class="nav navbar-right panel_toolbox ">
                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content text-center">

            <?php if ($wp_id) { ?>

                <h2><?php //echo $wfh; 
                    ?><strong><?php echo $model_wp->jenis_wp; ?></strong></h2>
                <?= $model_wp->displayWp ?>
                <h2><?php echo date('l, jS \of F Y'); ?></h2>
                <h1 class="text-center align-center" style="padding-bottom: 0px;">
                    <p style="font-size: 28px;font-weight: bold;font-style: oblique;" id="clock"></p>
                </h1>
                <!--<button class="btn-sm" onClick="">asdas</button>-->
                <div style="padding-bottom: 6px;">
                    <?php echo $wfh; ?>
                </div>
                <div id="zone">
                    <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                </div>

                <hr>
                <?php $form = ActiveForm::begin(['action' => [$link], 'options' => ['method' => 'post']]) ?>
                <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>

                <?php if ($model->isNewRecord) { ?>

                    <?= Html::submitButton('<i class="fa fa-sign-in"></i><br>Clock In<br>-', ['class' => 'btn btn-lg btn-success', 'name' => 'clock_in', 'data' => ['confirm' => 'Are you sure to Clock In?']]) ?>
                    <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock Out<br> $time_out", ['site/index'], ['class' => 'btn btn-lg btn-danger disabled']) ?>
                <?php } else { ?>
                    <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock In<br> $time_in", ['site/index'], ['class' => 'btn btn-lg btn-success disabled']) ?>
                    <?= Html::submitButton("<i class='fa fa-sign-in'></i><br>Clock Out<br>$time_out", ['class' => 'btn btn-lg btn-danger', 'name' => 'clock_out', 'data' => ['confirm' => 'Are you sure to Clock Out?']]) ?>
                <?php } ?>

                <?php ActiveForm::end(); ?>
            <?php } else { ?>
                <h3 class="text-center">Oh no, You don't have any working hours yet</h3>
                <hr>
                <span class="tag">Please inform your respective attendance supervisor at the administration office.</span>

            <?php } ?>
            <?php if ($curr_total_hours) { ?>
                <p>Current Working Hours : <strong><?= $curr_total_hours ?> Hrs</strong></p>
                <div class="widget_summary" style="width:100px">
                    <div class="w_center w_55">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="<?= $hour_complete ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $hour_complete ?>%;">
                                <!--<span class="sr-only">60% Complete</span>-->
                            </div>
                        </div>
                    </div>
                    <div class="w_right w_20">
                        <span style="font-size:inherit">&nbsp;<?= $hour_complete ?>%</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php }  ?>
            <hr style="margin:0">
            <p id="demo"> </p>
            <a href="https://www.google.com/maps" class="btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Check Location</a>
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

            document.getElementById("tblrekod-latlng").value = position.coords.latitude + ',' + position.coords.longitude;
        
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