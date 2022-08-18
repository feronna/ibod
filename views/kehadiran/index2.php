<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
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



<?php
if ($pendingNoti != 0) {
    echo SweetAlert::widget([
        'options' => [
            'title' => "Peringatan Mesra",
            'text' => "Anda mempunyai $pendingNoti tindakan yang belum selesai, sila semak semula pada  menu tindakan Individu/Pegawai. Harap Maklum",
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



<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>
<!--        1. Majlis Aspirasi Pendaftar 2019 (MAP2019) akan diadakan pada 2 April 2019(Selasa) @ Dewan Resital, FKSW Bermula Jam 8.00 pagi.
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2. Mohon semua pegawai untuk mengesahkan Catatan Ketidakpatuhan staf masing-masing sebelum 4hb April 2019. 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                3. Anda digalakkan menggunakan Komputer dipejabat masing-masing semasa merekod masa masuk dan keluar pejabat [Clock In/Clock Out].
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                4. Anda wajib Menggunakan WIFI/Internet yang disediakan oleh pihak UMS [STAFF-UMS / EDUROAM].
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                5. Sila pastikan semua tindakan [Ketidakpatuhan/Permohonan WBB] dibuat sebelum atau pada hari terakhir pada setiap bulan.-->

    </p>
</marquee>



<div class="row">
    <div class="col-md-5 col-sm-5 col-xs-12 col-lg-5">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i>&nbsp;Rekod Kehadiran</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content text-center">

                <?php if ($wp_id) { ?>

                    <h2><strong><?php echo $model_wp->jenis_wp; ?></strong></h2>
                    <?php if ($model_wp->id == 5) { ?>
                    <h5>Start : <strong>7.00 AM - 9.00 AM</strong> <i class="fa fa-arrow-right"></i> End : <strong>4.00 PM - 6.00 PM</strong></h5>
                    <h5>(TEMPOH BEKERJA SEHARI : <strong>9 JAM </strong>)</h5>  
                    <?php } else { ?>
                        <h5>Start : <strong><?= $model_wp->masaMasuk ?></strong> <i class="fa fa-arrow-right"></i> End : <strong><?= $model_wp->masaKeluar ?></strong></h5>
                    <?php } ?>
                    <h2><?php echo date('l, jS \of F Y'); ?></h2>
                    <h1 class="text-center align-center"><p class="text-monospace" id="clock"></p></h1>
                    <hr>
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>

                    <?php if ($model->isNewRecord) { ?>

                        <?= Html::submitButton('<i class="fa fa-sign-in"></i><br>Clock In<br>-', ['class' => 'btn btn-lg btn-success', 'name' => 'clock_in']) ?>
                        <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock Out<br> $time_out", ['site/index'], ['class' => 'btn btn-lg btn-danger disabled']) ?>
                    <?php } else { ?>
                        <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock In<br> $time_in", ['site/index'], ['class' => 'btn btn-lg btn-success disabled']) ?>
                        <?= Html::submitButton("<i class='fa fa-sign-in'></i><br>Clock Out<br>$time_out", ['class' => 'btn btn-lg btn-danger', 'name' => 'clock_out']) ?>
                    <?php } ?>

                    <?php ActiveForm::end(); ?>

                <?php } else { ?>
                    <h3 class="text-center">Anda belum mempunyai waktu jam bekerja</h3>
                    <hr>
                    <?= Html::a('Mohon WBB', ['kehadiran/wbb'], ['class' => 'btn btn-warning btn-block']) ?>

                <?php } ?>

            </div>
        </div>
    </div>

    <div class="col-md-7 col-sm-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i> Maklumat Kehadiran</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!--<div class="table-responsive">-->

                <table class="table table-bordered table-info table-condensed table-hover table-striped">
                    <tr>
                        <td><strong><i class="fa fa-file-o"></i>&nbsp;Status Warna Kad</strong></td>
                        <td><div class="tile-stats" style="margin : 0px ;width:50px; height: 30px; background-color:  <?= $color; ?>"></div></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-exclamation-triangle"></i>&nbsp;Status Ketidakpatuhan</strong></td>
                        <td><?= $statusAll ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-clock-o"></i>&nbsp;Jum.Jam Bekerja<br>[Jam:Minit]</strong></td>
                        <td><?= $total_hours ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-address-book-o"></i>&nbsp;IP Address</strong></td>
                        <td><?= $current_ip ?></td>
                    </tr>

                    <tr>
                        <td><strong><i class="fa fa-globe"></i>&nbsp;Lokasi</strong></td>
                        <td>
                            <div id="zone">
                                <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                            </div>
                            <p id="demo"> </p>
                            <a href="https://www.google.com/maps" class="btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Check Location</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="font-size:11px; color:green; padding: 5px">* Warna kad kehadiran akan berubah setiap <strong>4hb pada setiap bulan</strong> berdasarkan ketidakpatuhan pada bulan terdahulu.</td>
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


    });

JS;
$this->registerJs($script, View::POS_END);
?>

