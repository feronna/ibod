<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use aryelds\sweetalert\SweetAlert;
use app\models\KeluarPejabat;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRekodOt;

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


<?= $this->render('/keselamatan/_topmenu') ?>

<?php
if ($pendingNoti != 0) {
    echo SweetAlert::widget([
        'options' => [
            'title' => "Peringatan",
            'text' => "Anda Mempunyai $pendingNoti Catatan yang Perlu Dibuat. Sila Periksa Menu Anggota Anda",
            'type' => SweetAlert::TYPE_INFO,
            'animation' => 'slide-from-top',
            //        'showCancelButton' => true,
            //        'confirmButtonColor' => "#DD6B55",
            'confirmButtonText' => "Ok",
            'closeOnConfirm' => true,
        ],
    ]);
} else {
    try {
        $statusshield = \app\models\umsshield\SelfRisk::status(Yii::$app->user->getId());
        $shield = \app\models\umsshield\SelfRisk::viewstatus(Yii::$app->user->getId());
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
        }
    } catch (\Exception $e) {
    }
}
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Halaman Clock In</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div style="background-color:lightblue" class="col-xs-12 col-md-3">
                        <br>

                        <?php
                        $resume = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'clock-o',
                                'header' => 'Hakiki',
                                'text' => '',
                                'number' => 'Hakiki',
                            ]
                        );
                        echo Html::a($resume, ['keselamatan/index']);
                        ?>

                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $jawatan_semasa = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'clock-o',
                                'header' => 'Lebih Masa',
                                'text' => '',
                                'number' => 'LM',
                            ]
                        );
                        echo Html::a($jawatan_semasa, ['keselamatan/index1']);
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $jadual_temuduga = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'clock-o',
                                'header' => 'Pengganti/LMT',
                                'text' => '',
                                'number' => 'LMT',
                            ]
                        );
                        echo Html::a($jadual_temuduga, ['keselamatan/index2']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5 col-sm-5 col-xs-12 col-lg-5">

        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i>&nbsp;Kehadiran Hakiki</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content text-center">

                <?php if ($wp_id != 1 && $wp_id != 2 && $wp_id != 40 && $wp_id != NULL) { ?>


                    <h2><?php echo $wfh; ?>&nbsp;<strong><?php echo $model_wp->jenis_shifts; ?></strong></h2>

                    <h5>Start : <strong><?= $model_wp->masaMasuk ?></strong> <i class="fa fa-arrow-right"></i> End : <strong><?= $model_wp->masaKeluar ?></strong></h5>

                    <h2><?php echo date('l, jS \of F Y'); ?></h2>
                    <h1 class="text-center align-center">
                        <p class="text-monospace" id="clock"></p>
                    </h1>
                    <div id="zone">
                        <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                    </div>
                    <hr>
                    <?php $form = ActiveForm::begin(['action' => [$link], 'options' => ['method' => 'post']]) ?>
                    <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>

                    <?php if ($timediff > 14400) { ?>
                        <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock In<br> $time_in", ['site/index'], ['class' => 'btn btn-lg btn-success disabled']) ?>
                        <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock Out<br> $time_out", ['site/index'], ['class' => 'btn btn-lg btn-danger disabled']) ?>

                        <h6 class="text-center red">Anda Telah Lewat Melebihi 4 Jam!</h6>
                    <?php } else { ?>
                        <?php if ($model->isNewRecord) { ?>

                            <?= Html::submitButton('<i class="fa fa-sign-in"></i><br>Clock In<br>-', ['class' => 'btn btn-lg btn-success', 'name' => 'clock_in', 'data' => ['confirm' => 'Are you sure to Clock In?']]) ?>
                            <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock Out<br> $time_out", ['site/index'], ['class' => 'btn btn-lg btn-danger disabled']) ?>
                        <?php } else { ?>
                            <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock In<br> $time_in", ['site/index'], ['class' => 'btn btn-lg btn-success disabled']) ?>
                            <?= Html::submitButton("<i class='fa fa-sign-in'></i><br>Clock Out<br>$time_out", ['class' => 'btn btn-lg btn-danger', 'name' => 'clock_out', 'data' => ['confirm' => 'Are you sure to Clock Out?']]) ?>
                        <?php } ?>
                    <?php } ?>



                    <?php ActiveForm::end(); ?>

                <?php } else { ?>
                    <h3 class="text-center">Anda Tidak Mempunyai Jadual Pada Hari Ini</h3>
                    <hr>
                    <span class="tag">Tolong Maklumkan Kepada Pegawai Bertugas Sekiranya Ada Kesilapan Yang Berlaku.</span>

                <?php } ?>
                <?php if ($curr_total_hours) { ?>
                    <p>Jumlah Masa Berkerja Sekarang : <strong><?= $curr_total_hours ?> Hrs</strong></p>

                <?php } ?>

            </div>
        </div>
    </div>

    <div class="col-md-7 col-sm-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i> Maklumat</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!--<div class="table-responsive">-->

                <table class="table table-bordered table-info table-condensed table-hover table-striped">
                    <tr>
                        <td><strong><i class="fa fa-tachometer"></i>&nbsp;Peratusan Jam Berkerja</strong></td>
                        <td>
                            <div class="widget_summary">
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="<?= $hour_complete ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $hour_complete ?>%;">
                                            <!--<span class="sr-only">60% Complete</span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">
                                    <span>&nbsp;<?= $hour_complete ?>%</span>
                                </div>
                                <div class="clearfix"></div>
                                <br>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-file-o"></i>&nbsp;Status Warna Kad</strong></td>
                        <td>
                            <div class="tile-stats" style="margin : 0px ;width:50px; height: 30px; background-color:  <?= $color; ?>"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-exclamation-triangle"></i>&nbsp;Status KetidakPatuhan</strong></td>
                        <td><?= $statusAll ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-clock-o"></i>&nbsp;Masa Bekerja<br>[Jam:Minit]</strong></td>
                        <td><?= $total_hours ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-address-book-o"></i>&nbsp;Alamat IP</strong></td>
                        <td><?= $current_ip ?></td>
                    </tr>

                    <tr>
                        <td><strong><i class="fa fa-globe"></i>&nbsp;Lokasi</strong></td>
                        <td>
                            <p id="demo"> </p>
                            <a href="https://www.google.com/maps" class="btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Periksa Lokasi</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size:11px; color:green; padding: 5px">* Warna Kad akan berubah <strong>setiap 4hb pada bulan seterusnya</strong> bergantung dengan rekod kehadiran pada bulan lepas.</td>
                    </tr>
                </table>
                <!--</div>-->
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
        
//        $.when().then(function( x ) {
//            $("#tidakpatuh").load('$url_tidakpatuh');
//            $("#approve").load('$url_approve');
//          });
        

    });

JS;
$this->registerJs($script, View::POS_END);
?>