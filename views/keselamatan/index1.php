<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
use app\models\keselamatan\TblRekod;
use app\widgets\TopMenuWidget;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

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

<!--Overtime clockin-->
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2>Halaman Utama</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-3">
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
                <div style="background-color:lightblue" class="col-xs-12 col-md-3">
                    <br>

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
    <div class="col-md-5 col-sm-5 col-xs-12 col-lg-5">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i>&nbsp;Lebihan Masa Berjadual</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content text-center">

                <?php if ($ot_id && $ot_id != 1) { ?>

                    <h2><strong><?php echo $model_ot->jenis_shifts; ?></strong></h2>
                    <?php if ($model_ot->id == 15) { ?>
                        <h5>Start : <strong>7.00 AM - 9.00 AM</strong> <i class="fa fa-arrow-right"></i> End : <strong>4.00 PM - 6.00 PM</strong></h5>
                        <h5>(Working Hours : <strong>9 JAM </strong>)</h5>  
                    <?php } else { ?>
                        <h5>Start : <strong><?= $model_ot->masaMasuk ?></strong> <i class="fa fa-arrow-right">

                            </i> End : <strong><?= $model_ot->masaKeluar ?></strong></h5>
                    <?php } ?>
                    <h2><?php echo date('l, jS \of F Y'); ?></h2>

                    <h1 class="text-center align-center"><p class="text-monospace" id="clock"></p></h1>
                    <div id="zone">
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
                    <h3 class="text-center">Anda Tidak Mempunyai Lebihan Masa Berjadual Pada Hari Ini</h3>
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
                        <td><div class="tile-stats" style="margin : 0px ;width:50px; height: 30px; background-color:  <?= $color; ?>"></div></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-exclamation-triangle"></i>&nbsp;Status KetidakPatuhan</strong></td>
                        <td><?= $statusAllOt ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-clock-o"></i>&nbsp;Masa Bekerja<br>[Jam:Minit]</strong></td>
                        <td><?= $total_hours_ot ?></td>
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
                        <td colspan="2"  style="font-size:11px; color:green; padding: 5px">* Warna Kad akan berubah <strong>setiap 4hb pada bulan seterusnya</strong> bergantung dengan rekod kehadiran pada bulan lepas.</td>
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

        document.getElementById("tblrekodot-latlng").value = position.coords.latitude + ',' + position.coords.longitude;

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

