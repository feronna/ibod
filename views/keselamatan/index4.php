<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
use app\models\keselamatan\TblRekod;
?>
<?=
TopMenuWidget::widget(['top_menu' => [61,67,208,209,210], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId()),
//        'items' => [
//                                            [
//                                                'label' =>app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())
//                                            ],
//                                        ],]
]]); ?>
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



<?php
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
?>



<!--<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>-->
<!--        1. Majlis Aspirasi Pendaftar 2019 (MAP2019) akan diadakan pada 2 April 2019(Selasa) @ Dewan Resital, FKSW Bermula Jam 8.00 pagi.
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2. Mohon semua pegawai untuk mengesahkan Catatan Ketidakpatuhan staf masing-masing sebelum 4hb April 2019. 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                3. Anda digalakkan menggunakan Komputer dipejabat masing-masing semasa merekod masa masuk dan keluar pejabat [Clock In/Clock Out].
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                4. Anda wajib Menggunakan WIFI/Internet yang disediakan oleh pihak UMS [STAFF-UMS / EDUROAM].
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                5. Sila pastikan semua tindakan [Ketidakpatuhan/Permohonan WBB] dibuat sebelum atau pada hari terakhir pada setiap bulan.-->

<!--    </p>
</marquee>-->

<div class="row">
    <div class="col-md-5 col-sm-5 col-xs-12 col-lg-5">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i>&nbsp;Kehadiran Lebih Masa Berjadual</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content text-center">

                <?php if ($wp_id) { ?>

                    <h2><strong><?php echo $model_wp->details; ?></strong></h2>
                    <?php if ($model_wp->id == 15) { ?>
                        <h5>Start : <strong>7.00 AM - 9.00 AM</strong> <i class="fa fa-arrow-right"></i> End : <strong>4.00 PM - 6.00 PM</strong></h5>
                        <h5>(Working Hours : <strong>9 JAM </strong>)</h5>  
                    <?php } else { ?>
                        <h5>Start : <strong><?= $model_wp->masaMasuk ?></strong> <i class="fa fa-arrow-right">

                            </i> End : <strong><?= $model_wp->masaKeluar ?></strong></h5>
                    <?php } ?>
                    <h2><?php echo date('l, jS \of F Y'); ?></h2>
                    <h1 class="text-center align-center"><p class="text-monospace" id="clock"></p></h1>
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
                    <h3 class="text-center">You don't have any working hours yet</h3>
                    <hr>
                    <?= Html::a('Click to apply', ['kehadiran/wbb'], ['class' => 'btn btn-warning btn-block']) ?>

                <?php } ?>

            </div>
        </div>
    </div>

    <div class="col-md-7 col-sm-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i> Details</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!--<div class="table-responsive">-->

                <table class="table table-bordered table-info table-condensed table-hover table-striped">
                    <tr>
                        <td><strong><i class="fa fa-file-o"></i>&nbsp;Card Colour Status</strong></td>
                        <td><div class="tile-stats" style="margin : 0px ;width:50px; height: 30px; background-color:  <?= $color; ?>"></div></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-exclamation-triangle"></i>&nbsp;Non-compliance status</strong></td>
                        <td><?= $statusAll ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-clock-o"></i>&nbsp;Working hours<br>[Hours:Minutes]</strong></td>
                        <td><?= $total_hours ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-address-book-o"></i>&nbsp;IP Address</strong></td>
                        <td><?= $current_ip ?></td>
                    </tr>

                    <tr>
                        <td><strong><i class="fa fa-globe"></i>&nbsp;Location</strong></td>
                        <td>
                            <p id="demo"> </p>
                            <a href="https://www.google.com/maps" class="btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Check Location</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="font-size:11px; color:green; padding: 5px">* Attendance’s Card Colour Status will change <strong>every 4th of following month</strong> based on previous month attendance record.</td>
                    </tr>
                </table>
                <!--</div>-->
            </div>
        </div>
    </div>

</div>

<!--Overtime clockin-->
    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12 col-lg-5">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-clock-o"></i>&nbsp;Lebihan Masa</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content text-center">

                    <?php if ($ot_id) { ?>

                        <h2><strong><?php echo $model_ot->details; ?></strong></h2>
                        <?php if ($model_ot->id == 15) { ?>
                            <h5>Start : <strong>7.00 AM - 9.00 AM</strong> <i class="fa fa-arrow-right"></i> End : <strong>4.00 PM - 6.00 PM</strong></h5>
                            <h5>(Working Hours : <strong>9 JAM </strong>)</h5>  
                        <?php } else { ?>
                            <h5>Start : <strong><?= $model_ot->masaMasuk ?></strong> <i class="fa fa-arrow-right">

                                </i> End : <strong><?= $model_ot->masaKeluar ?></strong></h5>
                        <?php } ?>
                        <h2><?php echo date('l, jS \of F Y'); ?></h2>

                        <h1 class="text-center align-center"><p class="text-monospace" id="clock2"></p></h1>
                        <div id="zone2">
                            <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                        </div>                    <hr>
                        <?php $form = ActiveForm::begin(['action' => [$link2], 'options' => ['method' => 'post']]) ?>
                        <?= $form->field($model2, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>

                        <?php if ($model2->isNewRecord) { ?>

                            <?= Html::submitButton('<i class="fa fa-sign-in"></i><br>Clock In<br>-', ['class' => 'btn btn-lg btn-success', 'name' => 'clock_in', 'data' => ['confirm' => 'Are you sure to Clock In?']]) ?>
                            <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock Out<br> $time_out_ot", ['site/index'], ['class' => 'btn btn-lg btn-danger disabled']) ?>
                        <?php } else { ?>
                            <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock In<br> $time_in_ot", ['site/index'], ['class' => 'btn btn-lg btn-success disabled']) ?>
                            <?= Html::submitButton("<i class='fa fa-sign-in'></i><br>Clock Out<br>$time_out_ot", ['class' => 'btn btn-lg btn-danger', 'name' => 'clock_out', 'data' => ['confirm' => 'Are you sure to Clock Out?']]) ?>
                        <?php } ?>

                        <?php ActiveForm::end(); ?>

                    <?php } else { ?>
                        <h3 class="text-center">You don't have any working hours yet</h3>
                        <hr>
                        <?= Html::a('Click to apply', ['kehadiran/wbb'], ['class' => 'btn btn-warning btn-block']) ?>

                    <?php } ?>

                </div>
            </div>
        </div>


    <!--<div class="row">
        
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-line-chart"></i> Attendance Performance</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="approve"><?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bar-chart"></i> Non-compliance Statistic</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="tidakpatuh"><?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?></div>
                </div>
            </div>
        </div>
    </div>-->


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
        if($ot_id && $ot_id!= 1){

            document.getElementById("tblrekod-latlng").value = position.coords.latitude + ',' + position.coords.longitude;
                    document.getElementById("tblrekodot-latlng").value = position.coords.latitude + ',' + position.coords.longitude;

            $("#zone").load('$url_zone', {
                latlng: position.coords.latitude + ',' + position.coords.longitude,
            });
            $("#zone2").load('$url_zone2', {
                latlng: position.coords.latitude + ',' + position.coords.longitude,
            });
      
        }
        else{

          $("#zone").load('$url_zone', {
                latlng: position.coords.latitude + ',' + position.coords.longitude,
            });
              
         $("#zone2").load('$url_zone2', {
                latlng: position.coords.latitude + ',' + position.coords.longitude,
            });
            
        }
      
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
       
        var myVar1 = setInterval(function () {
            myTimer1();
        }, 1000);

        function myTimer() {
            var d = new Date();
            document.getElementById("clock").innerHTML = d.toLocaleTimeString();
        }

        function myTimer1() {
            var e = new Date();
            document.getElementById("clock2").innerHTML = e.toLocaleTimeString();
        }
        
//        $.when().then(function( x ) {
//            $("#tidakpatuh").load('$url_tidakpatuh');
//            $("#approve").load('$url_approve');
//          });
        

    });

JS;
    $this->registerJs($script, View::POS_END);
    ?>

